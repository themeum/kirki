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
