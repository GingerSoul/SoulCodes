<?php
/**
 * DI_Container class.
 *
 * @package SoulCodes
 */

namespace GingerSoul\SoulCodes;

use Exception;

/**
 * Represents a block that wraps a template.
 *
 * Useful for associating a template with a context, to avoid having to specify data for rendering at render time.
 *
 * @since [*next-version*]
 *
 * @package SoulCodes
 */
class Template_Block {

	/**
	 * The template for this block to render.
	 *
	 * @since [*next-version*]
	 *
	 * @var PHP_Template
	 */
	protected $template;

	/**
	 * The context to render the template with.
	 *
	 * @since [*next-version*]
	 *
	 * @var array
	 */
	protected $context;

	/**
	 * Template_Block constructor.
	 *
	 * @since [*next-version*]
	 *
	 * @param PHP_Template $template The template that this block will render.
	 * @param array        $context The context for the template.
	 */
	public function __construct( PHP_Template $template, array $context ) {
		$this->template = $template;
		$this->context  = $context;
	}

	/**
	 * Renders the internal block with pre-determined context.
	 *
	 * @since [*next-version*]
	 *
	 * @return string The rendered block.
	 */
	public function __toString() {
		try {
			return $this->template->render( $this->context );
		} catch ( Exception $e ) {
			return $e->getMessage() . PHP_EOL . $e->getTraceAsString();
		}
	}
}
