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

	public static function array_replace_recursive( $array, $array1 ) {
		// handle the arguments, merge one by one
		$args  = func_get_args();
		$array = $args[0];
		if ( ! is_array( $array ) ) {
			return $array;
		}
		for ( $i = 1; $i < count( $args ); $i++ ) {
			if ( is_array( $args[ $i ] ) ) {
				$array = self::recurse( $array, $args[ $i ] );
			}
		}
		return $array;
	}

	public static function recurse( $array, $array1 ) {
		foreach ( $array1 as $key => $value ) {
			// create new key in $array, if it is empty or not an array
			if ( ! isset( $array[ $key ] ) || ( isset( $array[ $key ] ) && ! is_array( $array[ $key ] ) ) ) {
				$array[ $key ] = array();
			}

			// overwrite the value in the base array
			if ( is_array( $value ) ) {
				$value = self::recurse( $array[ $key ], $value );
			}
			$array[ $key ] = $value;
		}
		return $array;
	}

	/**
	 * Initialize the WP_Filesystem
	 */
	public static function init_filesystem() {
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();
		}
	}

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

	public static function array_flatten( array $array ) {
		$flat  = array(); // initialize return array
		$stack = array_values( $array );
		while ( $stack ) { // process stack until done
			$value = array_shift( $stack );
			if ( is_array( $value ) ) { // a value to further process
				$stack = array_merge( array_keys( $value ), $stack );
			} else { // a value to take
				$flat[] = $value;
			}
		}
		return $flat;
	}

	/**
	 * Returns the attachment object
	 *
	 * @var 	string		URL to the image
	 * @return 	string		numeric ID of the attachement.
	 */
	public static function get_image_id( $url ) {
		return url_to_postid( $url );
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

	public static function get_taxonomies() {

		$items = array();

		// Get the taxonomies
		$taxonomies = get_taxonomies( array( 'public' => true ) );
		// Build the array
		foreach ( $taxonomies as $taxonomy ) {
			$id           = $taxonomy;
			$taxonomy     = get_taxonomy( $taxonomy );
			$items[ $id ] = $taxonomy->labels->name;
		}

		return $items;

	}

	public static function get_post_types() {

		$items = array();

		// Get the post types
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		// Build the array
		foreach ( $post_types as $post_type ) {
			$items[ $post_type->name ] = $post_type->labels->name;
		}

		return $items;

	}


}
