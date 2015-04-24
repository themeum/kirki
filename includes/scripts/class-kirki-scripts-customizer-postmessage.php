<?php

/**
* Try to automatically generate the script necessary for postMessage to work.
* Something like this will have to be added to the control arguments:
*
* 	'transport' => 'postMessage',
* 	'js_vars'   => array(
* 		array(
* 			'element'  => 'body',
* 			'function' => 'css',
* 			'property' => 'color',
* 		),
* 		array(
* 			'element'  => '#content',
* 			'function' => 'css',
* 			'property' => 'background-color',
* 		),
* 		array(
* 			'element'  => 'body',
* 			'function' => 'html',
* 		)
* 	)
*
*/
class Kirki_Scripts_Customizer_PostMessage extends Kirki_Scripts_Enqueue_Script {

	public function wp_footer() {

		global $wp_customize;
		// Early exit if we're not in the customizer
		if ( ! isset( $wp_customize ) ) {
			return;
		}

		// Get an array of all the fields
		$fields = Kirki::fields()->get_all();
		$script = '';
		// Parse the fields and create the script.
		foreach ( $fields as $field ) {
			if ( isset( $field['transport']  ) && ! is_null( $field['js_vars'] ) && 'postMessage' == $field['transport'] ) {
				foreach ( $field['js_vars'] as $js_vars ) {
					$script .= 'wp.customize( \'' . $field['settings'] . '\', function( value ) {';
					$script .= 'value.bind( function( newval ) {';
					if ( 'html' == $js_vars['function'] ) {
						$script .= '$( \'' . esc_js( $js_vars["element"] ) . '\' ).html( newval );';
					} elseif ( 'css' == $js_vars['function'] ) {
						$script .= '$(\'' . esc_js( $js_vars["element"] ) . '\').css(\'' . esc_js( $js_vars["property"] ) . '\', newval );';
					}
					$script .= '}); });';
				}
			}
		}

		if ( '' != $script ) {
			echo Kirki_Scripts_Registry::prepare( $script );
		}

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function customize_controls_print_footer_scripts() {}

}
