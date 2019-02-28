<?php

use GingerSoul\SoulCodes\Handler;
use GingerSoul\SoulCodes\Template_Interface;

/**
 * Handler class.
 *
 * @package SoulCodes
 */
class Handler_User_Shortcodes extends Handler {

	/**
	 * @since [*next-version*]
	 */
	protected function hook() {
		add_action(
			'init',
			function () {
				$this->register_shortcodes();
			}
		);
	}

	/**
	 * @since [*next-version*]
	 */
	protected function register_shortcodes() {
		$shortcodes = $this->get_shortcodes();

		foreach ( $shortcodes as $shortcode ) {
			$this->register_shortcode( $shortcode );
		}
	}


	/**
	 * Registers a shortcode to be rendered.
	 *
	 * @since [*next-version*]
	 *
	 * @param $shortcode WP_Post The post that describes the shortcode.
	 */
	protected function register_shortcode( WP_Post $shortcode ) {
		$name     = $shortcode->post_name;
		$template = $shortcode->post_content;

		add_shortcode( $name, $this->get_shortcode_callback( $template ) );
	}


	/**
	 * Retrieves a shortcode handler callback.
	 *
	 * The callback will provide standard args to the template, which will then get rendered.
	 *
	 * @since [*next-version*]
	 *
	 * @param string $template_text The template text to render by the callback.
	 *
	 * @return callable A callable that can handle a WP shortcode.
	 * See {@link https://codex.wordpress.org/Function_Reference/add_shortcode#Notes add_shortcode()}.
	 */
	protected function get_shortcode_callback( $template_text ) {
		return function ( $attributes, $content, $name ) use ( $template_text ) {
			if ( empty( $attributes ) ) {
				$attributes = [];
			};

			$template = $this->get_shortcode_template( $template_text );
			$data     = [
				'shortcode_name'       => $name,
				'shortcode_attributes' => $attributes,
				'shortcode_content'    => $content,
			];

			return $template->render( $data );
		};
	}


	/**
	 * Retrieves a template instance that represents the specified template.
	 *
	 * @since [*next-version*]
	 *
	 * @return Template_Interface A template that will render the specified content.
	 */
	protected function get_shortcode_template( $template ) {
		$make = $this->get_config( 'text_template_factory' );

		return $make( $template );
	}


	/**
	 * Retrieves a list of user-created shortcodes.s
	 *
	 * @since [*next-version*]
	 *
	 * @return WP_Post[] The set of shortcodes created by the users.
	 */
	protected function get_shortcodes() {
		$shortcodes = $this->get_config( 'user_shortcodes' );
		assert( is_array( $shortcodes ) );

		return $shortcodes;
	}
}
