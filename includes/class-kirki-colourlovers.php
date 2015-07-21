<?php
/**
 * Retrieve colors from the Colourlovers API.
 *
 * @package     Kirki
 * @category    Addon
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Colourlovers' ) ) {
	return;
}

class Kirki_Colourlovers {

	/**
	 * Returns an array properly formatted for use by the Kirki_Palette control.
	 *
	 * @param 	$palettes_nr	int		the number of palettes we want to get
	 * @return array
	 */
	public static function get_palettes( $palettes_nr = 5 ) {

		$palettes = self::parse();
		$palettes = array_slice( $palettes, 0, $palettes_nr );

		$i = 0;
		foreach ( $palettes as $palette ) {
			$palettes[ $i ] = array();
			foreach ( $palette as $key => $value ) {
				$palettes[ $i ][ $key ] = Kirki_Color::sanitize_hex( $value );
			}
			$i++;
		}

		return $palettes;

	}

	/**
	 * Get the palettes from an XML file and parse them.
	 *
	 * @param string|null $xml
	 */
	public static function parse( $xml = null ) {

		/**
		 * Parse the XML file.
		 * XML copied from http://www.colourlovers.com/api/palettes/top?numResults=100
		 */
		$xml_url  = ( is_null( $xml ) ) ? trailingslashit( kirki_url() ).'assets/xml/colourlovers-top.xml' : $xml;
		$feed_xml = simplexml_load_file( $xml_url );

		$palettes = array();
		foreach ( $feed_xml->palette as $result ) {
			$palettes[] = (array) $result->colors->hex;
		}

		return $palettes;

	}

}
