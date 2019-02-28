<?php
/**
 * Get_Template_Capable_Trait trait.
 *
 * @package SoulCodes
 */

namespace GingerSoul\SoulCodes;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

/**
 * Functionality for retrieving templates
 *
 * @package SoulCodes
 */
trait Get_Template_Capable_Trait {


	/**
	 * Gets the template for the specified key.
	 *
	 * @since [*next-version*]
	 *
	 * @param string $template The template key.
	 *
	 * @throws RuntimeException If template could not be retrieved.
	 *
	 * @return PHP_Template The template for the key.
	 */
	protected function get_template( $template ) {
		try {
			$path_factory     = $this->get_config( 'template_path_factory' );
			$path             = $path_factory( "$template.php" );
			$template_factory = $this->get_config( 'template_factory' );
		} catch ( Exception $e ) {
			throw new RuntimeException( vsprintf( 'Could not retrieve template "%1$s"', [ $template ] ), 0, $e );
		}

		return $template_factory( $path );
	}

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
	abstract public function get_config( $key );
}
