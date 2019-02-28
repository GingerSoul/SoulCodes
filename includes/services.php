<?php
/**
 * Declares project configuration.
 *
 * @package SoulCache
 */

use GingerSoul\SoulCodes\PHP_Template;
use GingerSoul\SoulCodes\Plugin;
use GingerSoul\SoulCodes\Template_Block;
use Psr\Container\ContainerInterface;

return function ( $base_path, $base_url ) {
	return [
		'version'          => '[*next-version*]',
		'base_path'        => $base_path,
		'base_dir'         => function ( ContainerInterface $c ) {
			return dirname( $c->get( 'base_path' ) );
		},
		'base_url'         => $base_url,
		'js_path'          => '/assets/js',
		'templates_dir'    => '/templates',
		'translations_dir' => '/languages',
		'text_domain'      => 'soulcodes',

		'plugin'           => function ( ContainerInterface $c ) {
			return new Plugin( $c );
		},

		/*
		 * Makes templates.
		 *
		 * @since [*next-version*]
		 */
		'template_factory' => function ( ContainerInterface $c ) {
			return function ( $path ) {
				return new PHP_Template( $path );
			};
		},

		/*
		 * Makes blocs.
		 *
		 * @since [*next-version*]
		 */
		'block_factory'    => function ( ContainerInterface $c ) {
			return function ( PHP_Template $template, $context ) {
				return new Template_Block( $template, $context );
			};
		},

		/*
		 * List of handlers to run.
		 *
		 * @since [*next-version*]
		 */
		'handlers'         => function ( ContainerInterface $c ) {
			return [];
		},
	];
};
