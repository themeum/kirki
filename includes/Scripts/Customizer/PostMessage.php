<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;

class PostMessage extends EnqueueScript {

	/**
	 * Try to automatically generate the script necessary for postMessage to work.
	 * Something like this will have to be added to the control arguments:
	 *

	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => 'body',
			'function' => 'css',
			'property' => 'color',
		),
		array(
			'element'  => '#content',
			'function' => 'css',
			'property' => 'background-color',
		),
		array(
		'element'  => 'body',
		'function' => 'html',
		)
	)
	 *
	 */
	public function wp_footer() {

		global $wp_customize;
		// Early exit if we're not in the customizer
		if ( ! isset( $wp_customize ) ) {
			return;
		}
		?>

		<?php $fields = Kirki::controls()->get_all(); ?>

		<script type="text/javascript">
			( function( $ ) {
				<?php foreach ( $fields as $field ) : ?>
					<?php if ( isset( $field['transport']  ) && isset( $field['js_vars'] ) && 'postMessage' == $field['transport'] ) : ?>
						<?php foreach ( $field['js_vars'] as $js_vars ) : ?>
							wp.customize( '<?php echo $field["settings"]; ?>', function( value ) {
								value.bind( function( newval ) {
									<?php if ( 'html' == $js_vars['function'] ) : ?>
										$( '<?php echo esc_js( $js_vars["element"] ); ?>' ).html( newval );
									<?php elseif ( 'css' == $js_vars['function'] ) : ?>
										$('<?php echo esc_js( $js_vars["element"] ); ?>').css('<?php echo esc_js( $js_vars["property"] ); ?>', newval );
									<?php endif; ?>
								} );
							} );
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			} )( jQuery );
		</script>
		<?php

	}

	public function customize_controls_print_scripts() {}

	public function customize_controls_enqueue_scripts() {}

	public function customize_controls_print_footer_scripts() {}

}
