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
						

							$( "#input_<?php echo $id; ?> input" ).each(function(){
								$(this).click(function(){
									if ( $(this).val() == "<?php echo $value; ?>" ) {
										$("#customize-control-<?php echo $control['setting']; ?>").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_color").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_image").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_repeat").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_size").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_position").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_attach").fadeIn(300);
									} else {
										$("#customize-control-<?php echo $control['setting']; ?>").fadeOut(300);
										$("#customize-control-<?php echo $control['setting']; ?>_color").fadeOut(300);
										$("#customize-control-<?php echo $control['setting']; ?>_image").fadeOut(300);
										$("#customize-control-<?php echo $control['setting']; ?>_repeat").fadeOut(300);
										$("#customize-control-<?php echo $control['setting']; ?>_size").fadeOut(300);
										$("#customize-control-<?php echo $control['setting']; ?>_position").fadeOut(300);
										$("#customize-control-<?php echo $control['setting']; ?>_attach").fadeOut(300);
									}
								
								});
								
							
							})	;
							//alert ($('#input_<?php echo $id; ?> input:checked').val());
							if ( $('#input_<?php echo $id; ?> input:checked').val() == "<?php echo $value; ?>" ) {
								
										$("#customize-control-<?php echo $control['setting']; ?>").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_color").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_image").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_repeat").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_size").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_position").fadeIn(300);
										$("#customize-control-<?php echo $control['setting']; ?>_attach").fadeIn(300);

									} else {
                                 //alert ("failure");								
								$("#customize-control-<?php echo $control['setting']; ?>").fadeOut(300);
								$("#customize-control-<?php echo $control['setting']; ?>_color").fadeOut(300);
								$("#customize-control-<?php echo $control['setting']; ?>_image").fadeOut(300);
								$("#customize-control-<?php echo $control['setting']; ?>_repeat").fadeOut(300);
								$("#customize-control-<?php echo $control['setting']; ?>_size").fadeOut(300);
								$("#customize-control-<?php echo $control['setting']; ?>_position").fadeOut(300);
								$("#customize-control-<?php echo $control['setting']; ?>_attach").fadeOut(300);
									}
								
						});
					</script>
					<?php

				endforeach;

			}

		}

	}

}
add_action( 'customize_controls_print_scripts', 'kirki_required_script', 999 );
