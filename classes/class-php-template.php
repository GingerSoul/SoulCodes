<?php
/**
 * PHP_Template class.
 *
 * @package SoulCodes
 */

namespace GingerSoul\SoulCodes;
use Dhii\I18n\FormatTranslatorInterface;
use Dhii\I18n\StringTranslatorConsumingTrait;

/**
 * Represents a template.
 *
 * @since [*next-version*]
 *
 * @package SoulCodes
 */
class PHP_Template implements Template_Interface {

    /* @since [*next-version*] */
    use StringTranslatorConsumingTrait;

	/**
	 * Path to the template file.
	 *
	 * @since [*next-version*]
	 *
	 * @var string
	 */
	protected $template_path;

    /**
     * The translator associated with this instance.
     *
     * @since [*next-version*]
     *
     * @var FormatTranslatorInterface
     */
	protected $translator;

	/**
	 * PHP_Template constructor.
	 *
	 * @param string $template_path The path to the template file.
	 */
	public function __construct( $template_path, FormatTranslatorInterface $translator ) {
		$this->template_path = $template_path;
		$this->translator = $translator;
	}

	/**
	 * {@inheritdoc}
	 *
	 * @since [*next-version*]
	 */
	public function render( $context ) {
		ob_start();

		$c = $this->get_context_function( $context );
		$t = $this->get_translate_function();
		include $this->get_template_path();

		$output = ob_get_clean();

		return $output;
	}

	/**
	 * Retrieves the path to the template file.
	 *
	 * @since [*next-version*]
	 *
	 * @return string The path to the template file.
	 */
	protected function get_template_path() {
		return (string) $this->template_path;
	}

	/**
	 * Retrieves a function that will get context variables.
	 *
	 * @since [*next-version*]
	 *
	 * @param array $context The context for which to get the function.
	 *
	 * @return callable The function that will retrieve context variables.
	 */
	protected function get_context_function( $context ) {
		return function ( $key, $default = null ) use ( $context ) {
			if ( ! array_key_exists( $key, $context ) ) {
				return $default;
			}

			return $context[ $key ];
		};
	}

    /**
     * Retrieves a function that does translation.
     *
     * This function accepts the following parameters:
     *  - $string - Required. The string to translate. May contain `sprintf()` style placeholders.
     *  - $args - Optional. The values to interpolate into the placeholders.
     *  - $context - Optional. The context for the translation.
     *
     * @since [*next-version*]
     *
     * @return callable The function which performs translation.
     */
	protected function get_translate_function()
    {
        return function ($string, $args = [], $context = null) {
            return $this->__($string, $args, $context);
        };
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _getTranslator()
    {
        return $this->translator;
    }
}
