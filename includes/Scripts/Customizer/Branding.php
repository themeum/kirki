<?php

namespace Kirki\Scripts\Customizer;

use Kirki;
use Kirki\Scripts\EnqueueScript;

class Branding extends EnqueueScript {

	/**
	 * If we've specified an image to be used as logo,
	 * replace the default theme description with a div that will include our logo.
	 */
	public function customize_controls_print_scripts() {

		$options = Kirki::config()->get_all(); ?>

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

	public function customize_controls_enqueue_scripts() {}

	public function customize_controls_print_footer_scripts() {}

	public function wp_footer() {}

}
