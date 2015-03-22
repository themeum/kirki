<?php

class Kirki_Customizer_postMessage {

	function __construct() {
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'postmessage' ), 21 );
	}

	/**
	 * Try to automatically generate the script necessary for postMessage to work.
	 * Something like this will have to be added to the control arguments:
	 *

	'transport' => 'postMessage',
	'js_vars'   => array(
			'element'  => 'body',
			'type'     => 'css',
			'property' => 'color',
		),
	 *
	 */
	function postmessage() {

		$controls = kirki_get_controls();

		$script = '';

		foreach ( $controls as $control ) {

			if ( isset( $control['transport']  ) && isset( $control['js_vars'] ) && 'postMessage' == $control['transport'] ) {

				$script .= '<script type="text/javascript">jQuery(document).ready(function( $ ) {';
				$script .= 'wp.customize("' . $control['settings'] . '",function( value ) {';

				if ( isset( $control['js_vars']['type'] ) && 'css' == $control['js_vars']['type'] ) {
					$script .= 'value.bind(function(to) {';
					$script .= '$("' . $control['js_vars']['element'] . '").css("' . $control['js_vars']['property'] . '", to ? to : "" );';
					$script .= '});';
				}

				$script .= '});});</script>';

			}

		}

		echo $script;

	}

}
$postmessage = new Kirki_Customizer_postMessage();
