<?php

/**
 * This file contains all the deprecated functions
 */

function kirki_sanitize_hex( $color ) {
	Kirki_Color::sanitize_hex( $color );
}

function kirki_get_rgb( $hex, $implode = false ) {
	Kirki_Color::get_rgb( $hex, $implode );
}

function kirki_get_rgba( $hex = '#fff', $opacity = 100 ) {
	Kirki_Color::get_rgba( $hex, $opacity );
}

function kirki_get_brightness( $hex ) {
	Kirki_Color::get_brightness( $hex );
}

if ( ! class_exists( 'Kirki_Fonts' ) ) {

	class Kirki_Fonts {

		public static function get_all_fonts() {
			$font_registry = Kirki::fonts();
			return $font_registry->get_all_fonts();
		}

		public static function get_font_choices() {
			$font_registry = Kirki::fonts();
			return $font_registry->get_font_choices();
		}

		public static function is_google_font( $font ) {
			$font_registry = Kirki::fonts();
			return $font_registray->is_google_font( $font );
		}

		public static function get_google_font_uri( $fonts, $weight = 400, $subset = 'all' ) {
			$font_registry = Kirki::fonts();
			return $font_registry->get_google_font_uri( $fonts, $weight, $subset );
		}

		public static function get_google_font_subsets() {
			$font_registry = Kirki::fonts();
			return $font_registry->get_google_font_subsets();
		}

		public static function choose_google_font_variants( $font, $variants = array() ) {
			$font_registry = Kirki::fonts();
			return $font_registry->choose_google_font_variants( $font, $variants );
		}

		public static function get_standard_fonts() {
			$font_registry = Kirki::fonts();
			return $font_registry->get_standard_fonts();
		}

		public static function get_font_stack( $font ) {
			$font_registry = Kirki::fonts();
			return $font_registry->get_font_stack( $font );
		}

		public static function sanitize_font_choice( $value ) {
			$font_registry = Kirki::fonts();
			return $font_registry->sanitize_font_choice( $value );
		}

		public static function get_google_fonts() {
			$font_registry = Kirki::fonts();
			return $font_registry->get_google_fonts();
		}

	}

}
