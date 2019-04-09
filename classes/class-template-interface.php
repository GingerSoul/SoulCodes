<?php
/**
 * Template_Interface interface.
 *
 * @package SoulCodes
 */

namespace GingerSoul\SoulCodes;

/**
 * Represents a template.
 *
 * @since [*next-version*]
 *
 * @package SoulCodes
 */
interface Template_Interface {
	/**
	 * Renders this template with the given context.
	 *
	 * @param array $context The data to render the template with.
	 *
	 * @return string The rendered template.
	 */
	public function render( $context);
}
