<?php

/*
 * TODO
 */


/**
 * Try to automatically generate the script necessary for postMessage to work.
 * Something like this will have to be added to the control arguments:
 *
 * 'transport' => 'postMessage',
 * 'js_vars'   => array(
 * 		'element'  => 'body',
 * 		'type'     => 'css',
 * 		'property' => 'color',
 * 	),
 *
 */
function kirki_auto_postmessage() { ?>

	<?php $controls = apply_filters( 'kirki/controls', array() ); ?>

	<?php foreach ( $controls as $control ) : ?>
		<?php if ( 'postMessage' == @$control['transport'] && @$control['js_vars'] ) : ?>
			<script type="text/javascript">
				jQuery(document).ready(function( $ ) {
					wp.customize("<?php echo $control['setting']; ?>",function( value ) {

						value.bind(function(to) {
							$("<?php echo $control['js_vars']['element']; ?>").<?php echo $control['js_vars']['type']; ?>("<?php echo $control['js_vars']['property']; ?>", to ? to : '' );
						});
					});
				});
			</script>
		<?php endif; ?>
	<?php endforeach;

}
add_action( 'customize_controls_print_footer_scripts', 'kirki_auto_postmessage', 21);
