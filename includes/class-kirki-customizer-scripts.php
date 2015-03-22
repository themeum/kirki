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

		$controls = Kirki_Controls::get_controls();

		if ( isset( $controls ) ) {

			foreach ( $controls as $control ) {

				if ( isset( $control['required'] ) && ! is_null( $control['required'] && is_array( $control['required'] ) ) ) {

					foreach ( $control['required'] as $id => $value ) : ?>

						<script>
							jQuery(document).ready(function($) {
								<?php if ( isset( $id ) && isset( $value ) ) : ?>
								 	<?php if ( $value == get_theme_mod( $id ) ) : ?>
										$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeIn(300);
									<?php else : ?>
										$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeOut(300);
									<?php endif; ?>
								<?php endif; ?>

								$( "#input_<?php echo $id; ?> input" ).each(function(){
									$(this).click(function(){
										if ( $(this).val() == "<?php echo $value; ?>" ) {
											$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeIn(300);
										} else {
											$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeOut(300);
										}
									});
									if ( $(this).val() == "<?php echo $value; ?>" ) {
											$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeIn(300);
										} else {
											$( '[id="customize-control-<?php echo $control['settings']; ?>"]' ).fadeOut(300);
										}
								});
							});
						</script>
						<?php

					endforeach;

				}

			}

		}

	}

}
$customizer_scripts = new Kirki_Customizer_Scripts();
