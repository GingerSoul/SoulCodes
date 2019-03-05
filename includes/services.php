<?php
/**
 * Declares project configuration.
 *
 * @package SoulCache
 */

use Dhii\Wp\I18n\FormatTranslator;
use GingerSoul\SoulCodes\PHP_Template;
use GingerSoul\SoulCodes\Plugin;
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

		'user_shortcodes'         => function ( ContainerInterface $c ) {
			$shortcodes = [
				[
					'post_name'    => 'test-1',
					'post_content' => 'Hello, world!',
				],
				[
					'post_name'    => 'test-2',
					'post_content' => 'Ajajajaja!',
				],
			];
			$make       = $c->get( 'wp_post_factory' );

			return array_map(
				function ( $data ) use ( $make ) {
					return $make( $data );
				},
				$shortcodes
			);
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
	];
};
