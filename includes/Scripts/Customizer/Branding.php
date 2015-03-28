<?php

namespace Kirki\Scripts\Customizer;

use Kirki;

class Branding extends \Kirki {

	function __construct() {
		add_action( 'customize_controls_print_scripts', array( $this, 'script' ), 999 );
	}

	/**
	 * If we've specified an image to be used as logo,
	 * replace the default theme description with a div that will include our logo.
	 */
	function script() {

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

}
$branding = new Branding();
