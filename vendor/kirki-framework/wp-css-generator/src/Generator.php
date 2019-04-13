<?php
/**
 * Compile Styles.
 *
 * @package   kirki-framework/wp-css-compiler
 * @author    Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Compiler;

/**
 * Css Compiler.
 *
 * @since 1.0
 */
class Generator {

	/**
	 * Get styles from array.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param array $css_array The styles array.
	 *                         [media-query][element][property][values]
	 * @return string
	 */
	public static function from_array( $css_array ) {
		$final_css = '';
		foreach ( $css_array as $media_query => $styles ) {

			// If we have a media-query, open it.
			$final_css .= ( 'global' !== $media_query ) ? $media_query . '{' : '';

			// Loop elements inside the media-query.
			foreach ( $styles as $style => $style_array ) {
				$css_for_style = '';

				// Loop properties inside the element.
				foreach ( $style_array as $property => $value ) {

					if ( is_string( $value ) && '' !== $value ) {
	
						// If have have a value directly here as a string then use it.
						$css_for_style .= $property . ':' . $value . ';';
					} elseif ( is_array( $value ) ) {

						// If we have multiple values, loop and use them.
						foreach ( $value as $subvalue ) {
							if ( is_string( $subvalue ) && '' !== $subvalue ) {
								$css_for_style .= $property . ':' . $subvalue . ';';
							}
						}
					}
				}

				// If we have styles from the above loop, add them.
				if ( '' !== $css_for_style ) {
					$final_css .= $style . '{' . $css_for_style . '}';
				}
			}

			// Close the media-query.
			$final_css .= ( 'global' !== $media_query ) ? '}' : '';
		}
		return $final_css;
	}
}