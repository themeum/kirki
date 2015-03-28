<?php

namespace Kirki\Scripts\Customizer;

use Kirki;

class Required extends \Kirki {

	function __construct() {
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'required_script' ) );
	}

	/**
	 * Add the required script.
	 */
	function required_script() {

		$controls = Kirki::controls()->get_all();

		// Early exit if no controls are defined
		if ( empty( $controls ) ) {
			return;
		}

		$script = '';

		foreach ( $controls as $control ) {

			$required = ( isset( $control['required'] ) ) ? $control['required'] : false;
			$setting  = $control['settings'];

			// No need to proceed if 'required' is not defined.
			// if ( ! $required ) {
			// 	return;
			// }

			$show = true;
			foreach ( $required as $dependency ) {
				// Get the initial status
				if ( '==' == $dependency['operator'] ) {
					$show = ( $show && ( $dependency['value'] == kirki_get_option( $setting ) ) ) ? true : false;
				} elseif ( '!=' == $dependency['operator'] ) {
					$show = ( $show && ( $dependency['value'] != kirki_get_option( $setting ) ) ) ? true : false;
				} elseif ( '>=' == $dependency['operator'] ) {
					$show = ( $show && ( $dependency['value'] >= kirki_get_option( $setting ) ) ) ? true : false;
				} elseif ( '<=' == $dependency['operator'] ) {
					$show = ( $show && ( $dependency['value'] <= kirki_get_option( $setting ) ) ) ? true : false;
				} elseif ( '>' == $dependency['operator'] ) {
					$show = ( $show && ( $dependency['value'] > kirki_get_option( $setting ) ) ) ? true : false;
				} elseif ( '<' == $dependency['operator'] ) {
					$show = ( $show && ( $dependency['value'] < kirki_get_option( $setting ) ) ) ? true : false;
				}

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

				// if initial status is hidden then hide the control
				if ( ! $show ) {
					$script .= '$("' . $target . '").hide();';
				}

				$script .= '$("' . $controller . '").';
				$script .= ( 'checkbox' == $type ) ? 'click' : 'change';
				$script .= '(function(){';
				$script .= 'if ($("' . $controller . '").';
				$script .= ( 'checkbox' == $type ) ? 'is(":checked") ) {' : 'val() ' . $dependency['operator'] . ' "' . $dependency['value'] . '") {';
				$script .= '$("' . $target . '").show();';
				$script .= '} else {';
				$script .= '$("' . $target . '").hide();';
				$script .= '}});';
				$script .= ( 'checkbox' != $type ) ? '$("' . $controller . '").trigger("change");' : '';
			}
		}

		// If there's a script then echo it wrapped.
		if ( ! empty( $script ) ) {
			echo '<script>jQuery(document).ready(function($) {' . $script . '});</script>';
		}

	}

}
$customizer_scripts = new Required();
