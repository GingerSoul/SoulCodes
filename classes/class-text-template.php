<?php

use GingerSoul\SoulCodes\Template_Interface;

/**
 * Simply outputs its template, without regard for context.
 */
class Text_Template implements Template_Interface {

	/**
	 * @var string
	 */
	protected $template;

	/**
	 * @since [*next-version*]
	 *
	 * @param string $template
	 */
	public function __construct( $template ) {
		$this->template = $template;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function render( $context ) {
		return $this->template;
	}
}
