<?php
/**
 * Allows overriding the "kirki" textdomain from a theme.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// if ( ! isset( ))
// If kirki is a plugin and not inside a theme,
// then there's no need to proceed any further.
if ( Kirki_Util::is_plugin() ) {
	return;
}

if ( ! function_exists( 'kirki_override_load_textdomain' ) ) {
	/**
	 * Allows overriding the "kirki" textdomain from a theme.
	 *
	 * @since 3.0.0
	 * @param bool   $override Whether to override the text domain. Default false.
	 * @param string $domain   Text domain. Unique identifier for retrieving translated strings.
	 * @return bool
	 */
	function kirki_override_load_textdomain( $override, $domain ) {

		// Check if the domain is "kirki".
		if ( 'kirki' === $domain ) {
			global $l10n;

			// Get the theme's textdomain.
			$theme = wp_get_theme();
			$theme_textdomain = $theme->get( 'TextDomain' );

			// If the theme's textdomain is loaded, assign the theme's translations
			// to the "kirki" textdomain.
			if ( isset( $l10n[ $theme_textdomain ] ) ) {
				// @codingStandardsIgnoreLine
				$l10n[ $domain ] = $l10n[ $theme_textdomain ];
			}

			// Always override.  We only want the theme to handle translations.
			$override = true;
		}
		return $override;
	}
}
add_filter( 'override_load_textdomain', 'kirki_override_load_textdomain', 10, 2 );
