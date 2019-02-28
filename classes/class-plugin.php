<?php
/**
 * Plugin class.
 *
 * @package SoulCodes
 */

namespace GingerSoul\SoulCodes;

use Exception;

/**
 * Plugin's main class.
 *
 * @since [*next-version*]
 *
 * @package SoulCodes
 */
class Plugin extends Handler {

	/**
	 * Runs the plugin.
	 *
	 * @since [*next-version*]
	 *
	 * @throws Exception If problem running.
	 *
	 * @return mixed
	 */
	public function run() {
		$result   = parent::run();
		$handlers = (array) $this->get_config( 'handlers' );

		foreach ( $handlers as $_handler ) {
			/* @var $_handler Handler */
			$_handler->run();
		}

		return $result;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	protected function hook() {
		add_action(
			'plugins_loaded',
			function () {
				$this->load_translations();
			}
		);
	}

	/**
	 * Loads the plugin translations.
	 *
	 * @since [*next-version*]
	 *
	 * @throws Exception If problem loading.
	 */
	protected function load_translations() {
		$base_dir         = $this->get_config( 'base_dir' );
		$translations_dir = trim( $this->get_config( 'translations_dir' ), '/' );
		$rel_path         = basename( $base_dir );

		load_plugin_textdomain( 'product-code-for-woocommerce', false, "$rel_path/$translations_dir" );
	}
}
