<?php

/**
 * Apply custom backgrounds to our page.
 */
function kirki_background_css() {

	$controls = apply_filters( 'kirki/controls', array() );
	$config   = apply_filters( 'kirki/config', array() );

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {

			if ( 'background' == $control['type'] ) {

				// Apply custom CSS if we've set the 'output'.
				if ( ! is_null( $control['output'] ) ) {

					$bg_color    = kirki_sanitize_hex( get_theme_mod( $control['setting'] . '_color', $control['default']['color'] ) );
					$bg_image    = get_theme_mod( $control['setting'] . '_image', $control['default']['image'] );
					$bg_repeat   = get_theme_mod( $control['setting'] . '_repeat', $control['default']['repeat'] );
					$bg_size     = get_theme_mod( $control['setting'] . '_size', $control['default']['size'] );
					$bg_attach   = get_theme_mod( $control['setting'] . '_attach', $control['default']['attach'] );
					$bg_position = get_theme_mod( $control['setting'] . '_position', $control['default']['position'] );
					$bg_opacity  = get_theme_mod( $control['setting'] . '_opacity', $control['default']['opacity'] );

					if ( false != $control['default']['opacity'] ) {

						$bg_position = get_theme_mod( $control['setting'] . '_opacity', $control['default']['opacity'] );

						// If we're using an opacity other than 100, then convert the color to RGBA.
						if ( 100 != $bg_opacity ) {
							$bg_color = kirki_get_rgba( $bg_color, $bg_opacity );
						}

					}

					// HTML Background
					$styles = $control['output'] . '{';

						$styles .= 'background-color:' . $bg_color . ';';

						if ( '' != $bg_image ) {
							$styles .= 'background-image: url("' . $bg_image . '");';
							$styles .= 'background-repeat: ' . $bg_repeat . ';';
							$styles .= 'background-size: ' . $bg_size . ';';
							$styles .= 'background-attachment: ' . $bg_attach . ';';
							$styles .= 'background-position: ' . str_replace( '-', ' ', $bg_position ) . ';';
						}

					$styles .= '}';
				}

				wp_add_inline_style( $config['stylesheet_id'], $styles );

			}

		}
	}

}
add_action( 'wp_enqueue_scripts', 'kirki_background_css', 150 );
