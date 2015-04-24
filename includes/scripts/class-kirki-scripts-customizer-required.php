<?php

class Kirki_Scripts_Customizer_Required extends Kirki_Scripts_Enqueue_Script {

	/**
	 * Add the required script.
	 */
	function customize_controls_print_footer_scripts() {

		// Get an array of all our fields
		$fields = Kirki::fields()->get_all();
		// Get the config options
		$config = Kirki::config()->get_all();

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
					if ( 'option' == $config['options_type'] && '' != $config['option_name'] ) {
						$dependency['setting'] = $config['option_name'] . '[' . $dependency['setting'] . ']';
					}
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
					$controller = '#customize-control-' . $fields[$dependency['setting']]['id'] . ' input';
					$common_controller= '';
					// Se the controller for select-type controls
					if ( 'select' == $type ) {
						$controller = '#customize-control-' . $fields[$dependency['setting']]['id'] . ' select';
					}
					// Set the controller for radio-type controls
					elseif ( 'radio' == $type ) {
						$controller = '#customize-control-' . $fields[$dependency['setting']]['id'] . ' input[value="' . $dependency['value'] . '"]';
						$common_controller = '#customize-control-' . $fields[$dependency['setting']]['id'] . ' input';
					}

					// The target element
					$target = '#customize-control-' . $field['id'];
					// if this is a background control then make sure we target all sub-controls
					if ( 'background' == $field['type'] ) {
						$target  = '#customize-control-' . $control['settings'] . '_color, ';
						$target .= '#customize-control-' . $control['settings'] . '_image, ';
						$target .= '#customize-control-' . $control['settings'] . '_repeat, ';
						$target .= '#customize-control-' . $control['settings'] . '_size, ';
						$target .= '#customize-control-' . $control['settings'] . '_position, ';
						$target .= '#customize-control-' . $control['settings'] . '_attach';
					}

					// If no operator has been defined, fallback to '=='
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
					$value = kirki_get_option( $dependency['setting'] );
					switch ( $dependency['operator'] ) {
						case '==' :
							$show = ( $dependency['value'] == $value ) ? true : $show;
							break;
						case '!=' :
							$show = ( $dependency['value'] != $value ) ? true : $show;
							break;
						case '>=' :
							$show = ( $dependency['value'] >= $value ) ? true : $show;
							break;
						case '<=' :
							$show = ( $dependency['value'] <= $value ) ? true : $show;
							break;
						case '>' :
							$show = ( $dependency['value'] > $value )  ? true : $show;
							break;
						case '<' :
							$show = ( $dependency['value'] < $value )  ? true : $show;
							break;
						default :
							$show = ( $dependency['value'] == $value ) ? true : $show;

					}

					// if initial status is hidden then hide the control
					if ( false == $show ) {
						$script .= '$("' . $target . '").hide();';
					}

					// Create the actual script
					$script .= "$('" . (( 'radio' != $type ) ? $controller : $common_controller) . "').";
					$script .= ( 'checkbox' == $type ) ? 'click' : 'change';
					$script .= '(function(){';
					$script .= "if ($('" . $controller . "').";
					$script .= ( 'select' != $type ) ? 'is(":checked") ) {' : 'val() ' . $dependency['operator'] . ' "' . $dependency['value'] . '") {';
					$script .= "$('" . $target . "')" . $action_1 . ';';
					$script .= '} else {';
					$script .= "$('" . $target . "')" . $action_2 . ';';
					$script .= '}});';
					$script .= ( 'checkbox' != $type ) ? "$('" . $controller . "')".'.trigger("change");' : '';

				}

			}

		}

		// If there's a script then echo it wrapped.
		if ( ! empty( $script ) ) {
			echo Kirki_Scripts_Registry::prepare( $script );
		}

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function wp_footer() {}

}
