<?php

/**
 * Add the required script.
 */
function kirki_required_script() {

	$controls = apply_filters( 'kirki/controls', array() );

	if ( isset( $controls ) ) {

		foreach ( $controls as $control ) {

			if ( isset( $control['required'] ) && ! is_null( $control['required'] && is_array( $control['required'] ) ) ) {

				foreach ( $control['required'] as $id => $value ) : ?>

					<script>
						jQuery(document).ready(function($) {
							<?php if ( isset( $id ) && isset( $value ) ) : ?>
							 	<?php if ( $value == get_theme_mod( $id ) ) : ?>
									$( '[id="customize-control-<?php echo $control['setting']; ?>"]' ).fadeIn(300);
								<?php else : ?>
									$( '[id="customize-control-<?php echo $control['setting']; ?>"]' ).fadeOut(300);
								<?php endif; ?>
							<?php endif; ?>

							$( "#input_<?php echo $id; ?> input" ).each(function(){
								$(this).click(function(){
									if ( $(this).val() == "<?php echo $value; ?>" ) {
										$( '[id="customize-control-<?php echo $control['setting']; ?>"]' ).fadeIn(300);
									} else {
										$( '[id="customize-control-<?php echo $control['setting']; ?>"]' ).fadeOut(300);
									}
								});
								if ( $(this).val() == "<?php echo $value; ?>" ) {
										$( '[id="customize-control-<?php echo $control['setting']; ?>"]' ).fadeIn(300);
									} else {
										$( '[id="customize-control-<?php echo $control['setting']; ?>"]' ).fadeOut(300);
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
add_action( 'customize_controls_print_footer_scripts', 'kirki_required_script' );
