<?php
/**
 * Generates & echo the styles when using the AJAx method.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 */

// Do not allow directly accessing this file.
if ( ! class_exists( 'Kirki' ) ) {
	die( 'File can\'t be accessed directly' );
}

// Make sure we set the correct MIME type.
header( 'Content-Type: text/css' );

// Echo the styles.
$configs = Kirki::$config;
foreach ( $configs as $config_id => $args ) {
	if ( true === $args['disable_output'] ) {
		continue;
	}

	$styles = Kirki_Modules_CSS::loop_controls( $config_id );
	$styles = apply_filters( "kirki_{$config_id}_dynamic_css", $styles );

	// Some people put weird stuff in their CSS, KSES tends to be greedy.
	$styles = str_replace( '<=', '&lt;=', $styles );

	$styles = wp_kses_post( $styles );

	// @codingStandardsIgnoreStart

	// Why both KSES and strip_tags? Because we just added some '>'.
	// kses replaces lone '>' with &gt;.
	echo strip_tags( str_replace( '&gt;', '>', $styles ) );
	// @codingStandardsIgnoreStop
}
