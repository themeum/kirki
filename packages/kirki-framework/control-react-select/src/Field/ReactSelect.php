<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-select
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Field;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class ReactSelect extends Field {

	/**
	 * The field type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-select';

	/**
	 * Defines if this is a multi-select or not.
	 * If value is > 1, then the maximum number of selectable options
	 * is the number defined here.
	 *
	 * @access protected
	 * @since 1.0
	 * @var integer
	 */
	protected $multiple = 1;

	/**
	 * Placeholder text.
	 *
	 * @access protected
	 * @since 1.0
	 * @var string|false
	 */
	protected $placeholder = false;

	/**
	 * The control class-name.
	 *
	 * @access protected
	 * @since 0.1
	 * @var string
	 */
	protected $control_class = '\Kirki\Control\ReactSelect';

	/**
	 * Whether we should register the control class for JS-templating or not.
	 *
	 * @access protected
	 * @since 0.1
	 * @var bool
	 */
	protected $control_has_js_template = true;

	/**
	 * Filter arguments before creating the setting.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_setting_args( $args, $wp_customize ) {
		if ( $args['settings'] === $this->args['settings'] ) {
			$args = parent::filter_setting_args( $args, $wp_customize );

			$args['multiple'] = isset( $args['multiple'] ) ? absint( $args['multiple'] ) : 1;

			// Set the sanitize-callback if none is defined.
			if ( ! isset( $args['sanitize_callback'] ) || ! $args['sanitize_callback'] ) {
				$args['sanitize_callback'] = 2 > $args['multiple'] ? 'sanitize_text_field' : function( $value ) {
					$value = (array) $value;
					foreach ( $value as $key => $subvalue ) {
						$value[ $key ] = sanitize_text_field( $subvalue );
					}
					return $value;
				};
			}
		}
		return $args;
	}

	/**
	 * Filter arguments before creating the control.
	 *
	 * @access public
	 * @since 0.1
	 * @param array                $args         The field arguments.
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return array
	 */
	public function filter_control_args( $args, $wp_customize ) {
		if ( $args['settings'] === $this->args['settings'] ) {
			$args = parent::filter_control_args( $args, $wp_customize );

			$args['multiple'] = isset( $args['multiple'] ) ? absint( $args['multiple'] ) : 1;
			$args['multiple'] = 1 === $args['multiple'] ? 1 : 999;
			$args['type']     = 'kirki-react-select';
		}
		return $args;
	}
}
