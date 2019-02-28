<?php
/**
 * Config_Aware_Trait trait.
 *
 * @package SoulCodes
 */

namespace GingerSoul\SoulCodes;

use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

/**
 * Functionality for awareness of configuration via a container.
 *
 * @since [*next-version*]
 *
 * @package SoulCodes
 */
trait Config_Aware_Trait {

	/**
	 * The container of services and configuration used by the plugin.
	 *
	 * @since [*next-version*]
	 *
	 * @var ContainerInterface
	 */
	protected $config;

	/**
	 * Retrieves a config value.
	 *
	 * @since [*next-version*]
	 *
	 * @param string $key The key of the config value to retrieve.
	 *
	 * @throws NotFoundExceptionInterface If config for the specified key is not found.
	 * @throws ContainerExceptionInterface If problem retrieving config.
	 *
	 * @return mixed The config value.
	 */
	public function get_config( $key ) {
		return $this->_get_config_container()->get( $key );
	}

	/**
	 * Checks whether configuration for the specified key exists.
	 *
	 * @param string $key The key to check the configuration for.
	 *
	 * @throws ContainerExceptionInterface If problem checking.
	 *
	 * @return bool True if config for the specified key exists; false otherwise.
	 */
	public function has_config( $key ) {
		return $this->_get_config_container()->has( $key );
	}

	/**
	 * Assigns a configuration container for this instance.
	 *
	 * @since [*next-version*]
	 *
	 * @param ContainerInterface $ccontainer The container that holds configuration.
	 */
	protected function _set_config_container( ContainerInterface $ccontainer ) {
		$this->config = $ccontainer;
	}

	/**
	 * Retrieves the configuration container for this instance.
	 *
	 * @since [*next-version*]
	 *
	 * @return ContainerInterface The container that holds configuration.
	 */
	protected function _get_config_container() {
		return $this->config;
	}
}
