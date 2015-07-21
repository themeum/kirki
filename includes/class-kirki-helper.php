<?php
/**
 * Helper methods
 *
 * @package     Kirki
 * @category    Core
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
if ( class_exists( 'Kirki_Helper' ) ) {
	return;
}

class Kirki_Helper {

	/**
	 * Helper function
	 *
	 * removes an item from an array
	 */
	public function array_delete( $idx, $array ) {

		// Early exit and return null if $array is not an array.
		if ( ! is_array( $array ) ) {
			return null;
		}

		unset( $array[ $idx ] );
		return array_values( $array );

	}

	/**
	 * Returns the attachment object
	 *
	 * @var 	string		URL to the image
	 * @return 	string		numeric ID of the attachement.
	 */
	public static function get_image_id( $url ) {

		global $wpdb;
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url ) );
		return $attachment[0];

	}

	/**
	 * Returns an array of the attachment's properties.
	 *
	 * @var 	string		URL to the image
	 * @return 	array		array()
	 */
	public static function get_image_from_url( $url ) {

		$image_id = self::get_image_id( $url );
		$image    = wp_get_attachment_image_src( $image_id, 'full' );

		return array(
			'url'       => $image[0],
			'width'     => $image[1],
			'height'    => $image[2],
			'thumbnail' => $image[3],
		);

	}

	/**
	 * Helper function that gets posts and fomats them in a way so they can be used in select fields etc.
	 */
	public static function get_posts( $args ) {

		// Get the posts
		$posts = get_posts( $args );

		// properly format the array.
		$items = array();
		foreach ( $posts as $post ) {
			$items[ $post->ID ] = $post->post_title;
		}

		return $items;

	}

}
