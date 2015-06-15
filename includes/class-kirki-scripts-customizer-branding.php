<?php

class Kirki_Scripts_Customizer_Branding extends Kirki_Scripts_Enqueue_Script {

	/**
	 * If we've specified an image to be used as logo,
	 * replace the default theme description with a div that will include our logo.
	 */
	public function customize_controls_print_scripts() {

		$config = apply_filters( 'kirki/config', array() );
		$script = '';
		if ( ( isset( $config['logo_image'] ) && '' != $config['logo_image'] ) || ( isset( $config['description'] ) && '' != $config['description'] ) ) {

			if ( isset( $config['logo_image'] ) && '' != $config['logo_image'] ) {
				$script .= '$( \'div#customize-info .preview-notice\' ).replaceWith( \'<img src="' . $config['logo_image'] . '">\' );';
			}
			if ( isset( $config['description'] ) && '' != $config['description'] ) {
				$script .= '$( \'div#customize-info .accordion-section-content\' ).replaceWith( \'<div class="accordion-section-content"><div class="theme-description">' . $config['description'] . '</div></div>\' );';
			}

		}

		if ( '' != $script ) {
			echo Kirki_Scripts_Registry::prepare( $script );
		}

	}

	public function customize_controls_enqueue_scripts() {}

	public function customize_controls_print_footer_scripts() {}

	public function wp_footer() {}

}
