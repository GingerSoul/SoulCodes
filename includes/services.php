<?php
/**
 * Declares project configuration.
 *
 * @package SoulCache
 */

use Dhii\Wp\I18n\FormatTranslator;
use GingerSoul\SoulCodes\PHP_Template;
use GingerSoul\SoulCodes\Plugin;
use GingerSoul\SoulCodes\Post_Query_Builder;
use GingerSoul\SoulCodes\Query_Builder_Interface;
use GingerSoul\SoulCodes\Template_Block;
use Psr\Container\ContainerInterface;

return function ( $base_path, $base_url ) {
	return [
		'version'                 => '[*next-version*]',
		'base_path'               => $base_path,
		'base_dir'                => function ( ContainerInterface $c ) {
			return dirname( $c->get( 'base_path' ) );
		},
		'base_url'                => $base_url,
		'js_path'                 => '/assets/js',
		'templates_dir'           => '/templates',
		'translations_dir'        => '/languages',
		'text_domain'             => 'soulcodes',

		'plugin'                  => function ( ContainerInterface $c ) {
			return new Plugin( $c );
		},

		/*
		 * Makes templates.
		 *
		 * @since [*next-version*]
		 */
		'template_factory'        => function ( ContainerInterface $c ) {
		    $translator = $c->get('translator');

			return function ( $path ) use ($translator) {
				return new PHP_Template( $path, $translator );
			};
		},

        'template_path_factory'      => function ( ContainerInterface $c ) {
            $base_dir      = rtrim( $c->get( 'base_dir' ), '\\/' );
            $templates_dir = trim( $c->get( 'templates_dir' ), '\\/' );

            return function ( $name ) use ( $base_dir, $templates_dir ) {
                $name = trim( $name, '\\/' );

                return "$base_dir/$templates_dir/$name";
            };
        },

		/*
		 * Makes blocs.
		 *
		 * @since [*next-version*]
		 */
		'block_factory'           => function ( ContainerInterface $c ) {
			return function ( PHP_Template $template, $context ) {
				return new Template_Block( $template, $context );
			};
		},

		/*
		 * List of handlers to run.
		 *
		 * @since [*next-version*]
		 */
		'handlers'                => function ( ContainerInterface $c ) {
			return [
				$c->get( 'handler_user_shortcodes' ),
			];
		},

		'handler_user_shortcodes' => function ( ContainerInterface $c ) {
			return new Handler_User_Shortcodes( $c );
		},

        'user_shortcodes_post_type' => 'user_shortcode',

		'user_shortcodes'         => function ( ContainerInterface $c ) {
		    $builder = $c->get('user_shortcodes_query_builder');
		    assert($builder instanceof Query_Builder_Interface);

		    return $builder->get()->get_posts();
		},

		'wp_post_factory'         => function ( ContainerInterface $c ) {
			/**
			 * @param array $data The data for the post.
			 *
			 * @return WP_Post A new post instance.
			 */
			return function ( $data ) use ( $c ) {
				$defaults = [
					'filter'        => 'raw',
					'post_author'   => 1,
					'post_type'     => 'post',
					'post_date'     => function ( $data ) {
						return current_time( 'mysql' );
					},
					'post_date_gmt' => function ( $data ) {
						return current_time( 'mysql', true );
					},
					'post_status'   => 'publish',
					'post_name'     => function ( $data ) {
						return uniqid( 'post-' );
					},
					'ID'            => function () {
						return rand( 1, 9999 ) * -1;
					},
				];

				$merge = $c->get( 'object_merger' );
				assert( is_callable( $merge ) );

				$data = $merge( $data, $defaults, false );

				return new WP_Post( (object) $data );
			};
		},

		'object_merger'           => function ( ContainerInterface $c ) {
			/**
			 * Merges 2 arrays.
			 *
			 * If a value in $b is a callable, it will be resolved, receiving the current
			 * merge result array.
			 *
			 * @param array $a The target of the merge.
			 * @param array $b The source of the data.
			 * @param bool $is_overwrite If true, all keys from $b will be put in $a.
			 *                           Otherwise, only the keys that don't exist in $a will be merged.
			 *
			 * @return array An array containing results of the merge.
			 */
			return function ( $a, $b, $is_overwrite = true ) {

				foreach ( $b as $key => $value ) {
					if ( ! $is_overwrite || ! isset( $a[ $key ] ) ) {
						continue;
					}

					if ( is_callable( $value ) ) {
						$value = $value( $a );
					}

					$a[ $key ] = $value;
				}

				return $a;
			};
		},

		/*
		 * Creates text templates.
		 */
		'text_template_factory'   => function ( ContainerInterface $c ) {
			return function ( $text ) {
				return new Text_Template( $text );
			};
		},

        'translator' => function ( ContainerInterface $c ) {
		    return new FormatTranslator( $c->get( 'text_domain' ) );
        },

        /*
         * A function that creates queries.
         */
        'wp_query_factory' => function ( ContainerInterface $c ) {
		    return function ($args) {
		        return new WP_Query($args);
            };
        },

        /*
         * A function that creates query builders.
         */
        'wp_query_builder_factory' => function ( ContainerInterface $c ) {
            $query_factory = $c->get('wp_query_factory');

            return function ($defaults) use ($query_factory) {
                return new Post_Query_Builder($query_factory, $defaults);
            };
        },

        /*
         * A builder of queries used to retrieve user shortcodes.
         */
        'user_shortcodes_query_builder' => function ( ContainerInterface $c ) {
            $make = $c->get('wp_query_builder_factory');

            return $make([
                'post_type' => $c->get('user_shortcodes_post_type'),
                'post_status' => 'any',
            ]);
        },
	];
};
