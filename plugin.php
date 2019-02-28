<?php
/**
 * SoulCodes.
 *
 * @package SoulCodes
 * @wordpress-plugin
 *
 * Plugin Name: SoulCodes
 * Description: A WP plugin that allows creation and management of shortcodes via a GUI.
 * Version: [*next-version*]
 * Author: GingerSoul
 * Author URI: https://github.com/GingerSoul
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: soulcodes
 * Domain Path: /languages
 */

namespace GingerSoul\SoulCodes;

define( 'SOULCODES_BASE_PATH', __FILE__ );
define( 'SOULCODES_BASE_DIR', dirname( SOULCODES_BASE_PATH ) );


/**
 * Retrieves the plugin singleton.
 *
 * @since 0.1
 *
 * @return null|Plugin
 */
function plugin() {
	static $instance = null;

	if ( is_null( $instance ) ) {
		$bootstrap = require SOULCODES_BASE_DIR . '/bootstrap.php';

		$instance = $bootstrap( SOULCODES_BASE_PATH, plugins_url( '', SOULCODES_BASE_PATH ) );
	}

	return $instance;
}

plugin()->run();
