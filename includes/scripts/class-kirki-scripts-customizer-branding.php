<?php

class Kirki_Scripts_Customizer_Branding extends Kirki_Scripts_Enqueue_Script {

	/**
	 * If we've specified an image to be used as logo,
	 * replace the default theme description with a div that will include our logo.
	 */
	public function customize_controls_print_scripts() {

		$options = Kirki::config()->get_all();
		$script = '';
		if ( '' != $options['logo_image'] || '' != $options['description'] ) {

			if ( '' != $options['logo_image'] ) {
				$script .= '$( \'div#customize-info .preview-notice\' ).replaceWith( \'<img src="' . $options['logo_image'] . '">\' );';
			}
			if ( '' != $options['description'] ) {
				$script .= '$( \'div#customize-info .accordion-section-content\' ).replaceWith( \'<div class="accordion-section-content"><div class="theme-description">' . $options['description'] . '</div></div>\' );';
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
