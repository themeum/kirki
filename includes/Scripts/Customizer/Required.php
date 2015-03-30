<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;

class Required extends EnqueueScript {

	/**
	 * Add the required script.
	 */
	function customize_controls_print_footer_scripts() {

		$controls = Kirki::controls()->get_all();

		// Early exit if no controls are defined
		if ( empty( $controls ) ) {
			return;
		}

		$script = '';

		foreach ( $controls as $control ) {

			$required = ( isset( $control['required'] ) ) ? $control['required'] : false;
			$setting  = $control['settings'];

			if ( $required ) {

				$show = false;
				foreach ( $required as $dependency ) {
					// Find the type of the dependency control
					foreach ( $controls as $control ) {
						if ( $dependency['setting'] == $control['settings'] ) {
							$type = $control['type'];
						}
					}

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
					$target = '#customize-control-' . $setting;

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
					if ( '==' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] == kirki_get_option( $setting ) ) ) ? true : $show;
					} elseif ( '!=' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] != kirki_get_option( $setting ) ) ) ? true : $show;
					} elseif ( '>=' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] >= kirki_get_option( $setting ) ) ) ? true : $show;
					} elseif ( '<=' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] <= kirki_get_option( $setting ) ) ) ? true : $show;
					} elseif ( '>' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] > kirki_get_option( $setting ) ) ) ? true : $show;
					} elseif ( '<' == $dependency['operator'] ) {
						$show = ( $show && ( $dependency['value'] < kirki_get_option( $setting ) ) ) ? true : $show;
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
			echo '<script>jQuery(document).ready(function($) {' . $script . '});</script>';
		}

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
