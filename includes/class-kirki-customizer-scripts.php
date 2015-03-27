<?php

class Kirki_Customizer_Scripts extends Kirki {

	function __construct() {

		add_action( 'customize_controls_print_scripts', array( $this, 'custom_js' ), 999 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customizer_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'required_script' ) );

	}

	/**
	 * If we've specified an image to be used as logo,
	 * replace the default theme description with a div that will include our logo.
	 */
	function custom_js() {

		$options = apply_filters( 'kirki/config', array() ); ?>

		<?php if ( isset( $options['logo_image'] ) || isset( $options['description'] ) ) : ?>
			<script>jQuery(document).ready(function($) { "use strict";
				<?php if ( isset( $options['logo_image'] ) ) : ?>
					$( 'div#customize-info .preview-notice' ).replaceWith( '<img src="<?php echo $options['logo_image']; ?>">' );
				<?php endif; ?>
				<?php if ( isset( $options['description'] ) ) : ?>
					$( 'div#customize-info .accordion-section-content' ).replaceWith( '<div class="accordion-section-content"><div class="theme-description"><?php echo $options['description']; ?></div></div>' );
				<?php endif; ?>
			});</script>
		<?php endif;

	}

	/**
	 * Enqueue the scripts required.
	 */
	function customizer_scripts() {

		$config = $this->config;

		$kirki_url = isset( $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

		wp_enqueue_script( 'kirki_customizer_js', $kirki_url . 'assets/js/customizer.js', array( 'jquery', 'customize-controls' ) );
		wp_enqueue_script( 'serialize-js', $kirki_url . 'assets/js/serialize.js');
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tooltip' );

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

		foreach ( $controls as $control ) {

			$required = ( isset( $control['required'] ) ) ? $control['required'] : false;
			$setting  = $control['settings'];

			// N oneed to proceed if 'required' is not defined.
			// if ( ! $required ) {
			// 	return;
			// }

			echo '<script>';

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

					echo 'jQuery(document).ready(function($) {
						';

					// Initial status is hidden
					if ( ! $show ) {
						echo '$("#customize-control-' . $setting . '").hide();';
					}

					echo '
						$("#customize-control-' . $dependency['setting'] . ' input").change(function(){
							if ($("#customize-control-' . $dependency['setting'] . ' input").val() ' . $dependency['operator'] . ' ' . $dependency['value'] . ') {
								$("#customize-control-' . $setting . '").show();
							} else {
								$("#customize-control-' . $setting . '").hide();
							}
						});
						$("#customize-control-' . $dependency['setting'] . ' input").trigger("change");
					});';
				}
			echo '</script>';
		}
	}
}
$customizer_scripts = new Kirki_Customizer_Scripts();
