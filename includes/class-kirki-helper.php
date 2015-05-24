<?php

class Kirki_Helper {

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

}
