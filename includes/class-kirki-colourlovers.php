<?php

class Kirki_Colourlovers {

	public static function get_palettes( $palettes_nr = 5, $order_by = 'none', $xml = '' ) {

		$palettes = self::parse( $xml );
		$palettes = array_slice( $palettes, 0, $palettes_nr );

		$final_palettes = array();

		foreach ( $palettes as $palette ) {
			$final_palettes[] = self::order_by( $palette, $order_by );
		}

		return $final_palettes;

	}

	public static function parse( $xml = null ) {

		// XML copied from http://www.colourlovers.com/api/palettes/top?numResults=100
		$root = ( '' != $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;
		$xml_url  = ( is_null( $xml ) ) ? trailingslashit( $root ) . 'assets/xml/colourlovers-top.xml' : $xml;
		$feed_xml = simplexml_load_file( $xml_url );
		$palettes = array();

		foreach( $feed_xml->palette as $result ) {
			$id       = $result->id;
			$content  = $result->content;
			$title    = $result->title;
			$badgeurl = $result->badgeUrl;
			$imageurl = $result->imageUrl;
			$palette  = (array) $result->colors->hex;

			$palettes[] = $palette;

		}

		return $palettes;

	}

	public static function order_by( $palette = array(), $order = 'none' ) {

		$palette = ( empty( $palette ) ) ? array() : $palette;

		if ( 'none' == $order ) {

			$palette = array(
				Kirki_Color::sanitize_hex( $palette[0] ),
				Kirki_Color::sanitize_hex( $palette[1] ),
				Kirki_Color::sanitize_hex( $palette[2] ),
				Kirki_Color::sanitize_hex( $palette[3] ),
				Kirki_Color::sanitize_hex( $palette[4] ),

			);

		} elseif ( 'brightness' == $order ) {

			// Get the ligtness of all the colors in our palette and arrange them according to it.
			$colors_array_0b = $palette;
			$brightest_0_key = Kirki_Color::brightest_color( $colors_array_0b, 'key' );
			$brightest_0_val = Kirki_Color::brightest_color( $colors_array_0b, 'value' );

			$colors_array_1b = kirki_array_delete( $brightest_0_key, $colors_array_0b );
			$brightest_1_key = Kirki_Color::brightest_color( $colors_array_1b, 'key' );
			$brightest_1_val = Kirki_Color::brightest_color( $colors_array_1b, 'value' );

			$colors_array_2b = kirki_array_delete( $brightest_1_key, $colors_array_1b );
			$brightest_2_key = Kirki_Color::brightest_color( $colors_array_2b, 'key' );
			$brightest_2_val = Kirki_Color::brightest_color( $colors_array_2b, 'value' );

			$colors_array_3b = kirki_array_delete( $brightest_2_key, $colors_array_2b );
			$brightest_3_key = Kirki_Color::brightest_color( $colors_array_3b, 'key' );
			$brightest_3_val = Kirki_Color::brightest_color( $colors_array_3b, 'value' );

			$colors_array_4b = kirki_array_delete( $brightest_3_key, $colors_array_3b );
			$brightest_4_key = Kirki_Color::brightest_color( $colors_array_4b, 'key' );
			$brightest_4_val = Kirki_Color::brightest_color( $colors_array_4b, 'value' );

			$palette = array(
				Kirki_Color::sanitize_hex( $brightest_0_val ),
				Kirki_Color::sanitize_hex( $brightest_1_val ),
				Kirki_Color::sanitize_hex( $brightest_2_val ),
				Kirki_Color::sanitize_hex( $brightest_3_val ),
				Kirki_Color::sanitize_hex( $brightest_4_val ),
			);

		} elseif ( 'saturation' == $order ) {

			// Get the saturation of all the colors in our palette and arrange them according to it.
			$colors_array_0s      = $palette;
			$most_saturated_0_key = Kirki_Color::most_saturated_color( $colors_array_0s, 'key' );
			$most_saturated_0_val = Kirki_Color::most_saturated_color( $colors_array_0s, 'value' );

			$colors_array_1s      = kirki_array_delete( $most_saturated_0_key, $colors_array_0s );
			$most_saturated_1_key = Kirki_Color::most_saturated_color( $colors_array_1s, 'key' );
			$most_saturated_1_val = Kirki_Color::most_saturated_color( $colors_array_1s, 'value' );

			$colors_array_2s      = kirki_array_delete( $most_saturated_1_key, $colors_array_1s );
			$most_saturated_2_key = Kirki_Color::most_saturated_color( $colors_array_2s, 'key' );
			$most_saturated_2_val = Kirki_Color::most_saturated_color( $colors_array_2s, 'value' );

			$colors_array_3s      = kirki_array_delete( $most_saturated_2_key, $colors_array_2s );
			$most_saturated_3_key = Kirki_Color::most_saturated_color( $colors_array_3s, 'key' );
			$most_saturated_3_val = Kirki_Color::most_saturated_color( $colors_array_3s, 'value' );

			$colors_array_4s      = kirki_array_delete( $most_saturated_3_key, $colors_array_3s );
			$most_saturated_3_key = Kirki_Color::most_saturated_color( $colors_array_4s, 'key' );
			$most_saturated_4_val = Kirki_Color::most_saturated_color( $colors_array_4s, 'value' );

			$palette = array(
				Kirki_Color::sanitize_hex( $most_saturated_0_val ),
				Kirki_Color::sanitize_hex( $most_saturated_1_val ),
				Kirki_Color::sanitize_hex( $most_saturated_2_val ),
				Kirki_Color::sanitize_hex( $most_saturated_3_val ),
				Kirki_Color::sanitize_hex( $most_saturated_4_val ),
			);

		} elseif ( 'intensity' == $order ) {

			// Get the intensity of all the colors in our palette and arrange them according to it.
			$colors_array_0i    = $palette;
			$most_intense_0_key = Kirki_Color::most_intense_color( $colors_array_0i, 'key' );
			$most_intense_0_val = Kirki_Color::most_intense_color( $colors_array_0i, 'value' );

			$colors_array_1i    = kirki_array_delete( $most_intense_0_key, $colors_array_0i );
			$most_intense_1_key = Kirki_Color::most_intense_color( $colors_array_1i, 'key' );
			$most_intense_1_val = Kirki_Color::most_intense_color( $colors_array_1i, 'value' );

			$colors_array_2i    = kirki_array_delete( $most_intense_1_key, $colors_array_1i );
			$most_intense_2_key = Kirki_Color::most_intense_color( $colors_array_2i, 'key' );
			$most_intense_2_val = Kirki_Color::most_intense_color( $colors_array_2i, 'value' );

			$colors_array_3i    = kirki_array_delete( $most_intense_2_key, $colors_array_2i );
			$most_intense_3_key = Kirki_Color::most_intense_color( $colors_array_3i, 'key' );
			$most_intense_3_val = Kirki_Color::most_intense_color( $colors_array_3i, 'value' );

			$colors_array_4i    = kirki_array_delete( $most_intense_3_key, $colors_array_3i );
			$most_intense_3_key = Kirki_Color::most_intense_color( $colors_array_4i, 'key' );
			$most_intense_4_val = Kirki_Color::most_intense_color( $colors_array_4i, 'value' );

			$palette = array(
				Kirki_Color::sanitize_hex( $most_intense_0_val ),
				Kirki_Color::sanitize_hex( $most_intense_1_val ),
				Kirki_Color::sanitize_hex( $most_intense_2_val ),
				Kirki_Color::sanitize_hex( $most_intense_3_val ),
				Kirki_Color::sanitize_hex( $most_intense_4_val ),
			);

		} elseif ( 'dullness' == $order ) {

			// Get the lightness and "dullness" of all the colors in our palette and arrange them according to it.
			$colors_array_0d   = $palette;
			$bright_dull_0_key = Kirki_Color::brightest_dull_color( $colors_array_0d, 'key' );
			$bright_dull_0_val = Kirki_Color::brightest_dull_color( $colors_array_0d, 'value' );

			$colors_array_1d   = kirki_array_delete( $bright_dull_0_key, $colors_array_0d );
			$bright_dull_1_key = Kirki_Color::brightest_dull_color( $colors_array_1d, 'key' );
			$bright_dull_1_val = Kirki_Color::brightest_dull_color( $colors_array_1d, 'value' );

			$colors_array_2d   = kirki_array_delete( $bright_dull_1_key, $colors_array_1d );
			$bright_dull_2_key = Kirki_Color::brightest_dull_color( $colors_array_2d, 'key' );
			$bright_dull_2_val = Kirki_Color::brightest_dull_color( $colors_array_2d, 'value' );

			$colors_array_3d   = kirki_array_delete( $bright_dull_2_key, $colors_array_2d );
			$bright_dull_3_key = Kirki_Color::brightest_dull_color( $colors_array_3d, 'key' );
			$bright_dull_3_val = Kirki_Color::brightest_dull_color( $colors_array_3d, 'value' );

			$colors_array_4d   = kirki_array_delete( $bright_dull_3_key, $colors_array_3d );
			$bright_dull_3_key = Kirki_Color::brightest_dull_color( $colors_array_4d, 'key' );
			$bright_dull_4_val = Kirki_Color::brightest_dull_color( $colors_array_4d, 'value' );

			$palette = array(
				Kirki_Color::sanitize_hex( $bright_dull_0_val ),
				Kirki_Color::sanitize_hex( $bright_dull_1_val ),
				Kirki_Color::sanitize_hex( $bright_dull_2_val ),
				Kirki_Color::sanitize_hex( $bright_dull_3_val ),
				Kirki_Color::sanitize_hex( $bright_dull_4_val ),
			);

		}

		return $palette;

	}

}
