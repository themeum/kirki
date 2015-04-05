<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;
use Kirki\Scripts\ScriptRegistry;

class Required extends EnqueueScript {

	/**
	 * Add the required script.
	 */
	function customize_controls_print_footer_scripts() {

		$fields = Kirki::fields()->get_all();

		// Early exit if no controls are defined
		if ( empty( $fields ) ) {
			return;
		}

		$script = '';

		foreach ( $fields as $field ) {

			$required = ( isset( $field['required'] ) ) ? $field['required'] : false;

			if ( $required ) {

				$show = false;
				foreach ( $required as $dependency ) {
					// Find the type of the dependency control
					$type = $fields[$dependency['setting']]['type'];

					// If "operator" is not set then set it to "=="
					if ( ! isset( $dependency['operator'] ) ) {
						$dependency['operator'] = '==';
					}
					$dependency['operator'] = esc_js( $dependency['operator'] );

					// Set the control type
					$type = ( 'dropdown-pages' == $type )  ? 'select'   : $type;
					$type = ( 'radio-image' == $type )     ? 'radio'    : $type;
					$type = ( 'radio-buttonset' == $type ) ? 'radio'    : $type;
					$type = ( 'toggle' == $type )          ? 'checkbox' : $type;
					$type = ( 'switch' == $type )          ? 'checkbox' : $type;

					// Set the controller used in the script
					$controller = '#customize-control-' . $dependency['setting'] . ' input';
					if ( 'select' == $type ) {
						$controller = '#customize-control-' . $dependency['setting'] . ' select';
					} elseif ( 'radio' == $type ) {
						$controller = '#customize-control-' . $dependency['setting'] . ' input[value="' . $dependency['value'] . '"]';
					}

					// The target element
					$target = '#customize-control-' . $field['settings'];
					// if this is a background control then make sure we target all sub-controls
					if ( 'background' == $field['type'] ) {
						$target  = '#customize-control-' . $control['settings'] . '_color, ';
						$target .= '#customize-control-' . $control['settings'] . '_image, ';
						$target .= '#customize-control-' . $control['settings'] . '_repeat, ';
						$target .= '#customize-control-' . $control['settings'] . '_size, ';
						$target .= '#customize-control-' . $control['settings'] . '_position, ';
						$target .= '#customize-control-' . $control['settings'] . '_attach';
					}

					if ( ! isset( $dependency['operator'] ) ) {
						$dependency['operator'] = '==';
					}

					$action_1 = '.show()';
					$action_2 = '.hide()';
					// Allow checking both checked and unchecked checkboxes
					if ( 'checkbox' == $type ) {
						if ( 0 == $dependency['value'] && '==' == $dependency['operator'] ) {
							$action_1 = '.hide()';
							$action_2 = '.show()';
							$show = true;
						}
						if ( 1 == $dependency['value'] && '!=' == $dependency['operator'] ) {
							$action_1 = '.hide()';
							$action_2 = '.show()';
						}
					}

					// Get the initial status
					$value = kirki_get_option( $field['settings'] );
					if ( '==' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] == $value ) ) ? true : $show;
					} elseif ( '!=' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] != $value ) ) ? true : $show;
					} elseif ( '>=' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] >= $value ) ) ? true : $show;
					} elseif ( '<=' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] <= $value ) ) ? true : $show;
					} elseif ( '>' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] > $value ) ) ? true : $show;
					} elseif ( '<' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] < $value ) ) ? true : $show;
					}

					// if initial status is hidden then hide the control
					if ( false == $show ) {
						$script .= '$("' . $target . '").hide();';
					}

					$script .= '$("' . $controller . '").';
					$script .= ( 'checkbox' == $type ) ? 'click' : 'change';
					$script .= '(function(){';
					$script .= 'if ($("' . $controller . '").';
					$script .= ( 'checkbox' == $type ) ? 'is(":checked") ) {' : 'val() ' . $dependency['operator'] . ' "' . $dependency['value'] . '") {';
					$script .= '$("' . $target . '")' . $action_1 . ';';
					$script .= '} else {';
					$script .= '$("' . $target . '")' . $action_2 . ';';
					$script .= '}});';
					$script .= ( 'checkbox' != $type ) ? '$("' . $controller . '").trigger("change");' : '';
				}
			}
		}

		// If there's a script then echo it wrapped.
		if ( ! empty( $script ) ) {
			echo ScriptRegistry::prepare( $script );
		}

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
