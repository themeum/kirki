<?php
/**
 * Helper methods
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Helper' ) ) {
	class Kirki_Helper {

		/**
		 * Recursive replace in arrays.
		 *
		 * @param $array    array
		 * @param $array1   array
		 *
		 * @return array
		 */
		public static function array_replace_recursive( $array, $array1 ) {
			if ( function_exists( 'array_replace_recursive' ) ) {
				return array_replace_recursive( $array, $array1 );
			}
			// handle the arguments, merge one by one
			$args  = func_get_args();
			$array = $args[0];
			if ( ! is_array( $array ) ) {
				return $array;
			}
			$count = count( $args );
			for ( $i = 1; $i < $count; $i++ ) {
				if ( is_array( $args[ $i ] ) ) {
					$array = self::recurse( $array, $args[ $i ] );
				}
			}
			return $array;
		}

		/**
		 * @return array
		 */
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
				require_once( ABSPATH . '/wp-admin/includes/file.php' );
				WP_Filesystem();
			}
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

		public static function get_terms( $taxonomies ) {

			$items = array();

			// Get the post types
			$terms = get_terms( $taxonomies );
			// Build the array
			foreach ( $terms as $term ) {
				$items[ $term->term_id ] = $term->name;
			}

			return $items;

		}

		public static function get_dashicons() {

			$admin_menu = array(
				'menu',
				'admin-site',
				'dashboard',
				'admin-post',
				'admin-media',
				'admin-links',
				'admin-page',
				'admin-comments',
				'admin-appearance',
				'admin-plugins',
				'admin-users',
				'admin-tools',
				'admin-settings',
				'admin-network',
				'admin-home',
				'admin-generic',
				'admin-collapse',
				'filter',
				'admin-customizer',
				'admin-multisite',
			);

			$welcome_screen = array(
				'welcome-write-blog',
				'welcome-add-page',
				'welcome-view-site',
				'welcome-widgets-menus',
				'welcome-comments',
				'welcome-learn-more',
			);

			$post_formats = array(
				'format-aside',
				'format-image',
				'format-gallery',
				'format-video',
				'format-status',
				'format-quote',
				'format-chat',
				'format-audio',
				'camera',
				'images-alt',
				'images-alt2',
				'video-alt',
				'video-alt2',
				'video-alt3',
			);

			$media = array(
				'media-archive',
				'media-audio',
				'media-code',
				'media-default',
				'media-document',
				'media-interactive',
				'media-spreadsheet',
				'media-text',
				'media-video',
				'playlist-audio',
				'playlist-video',
				'controls-play',
				'controls-pause',
				'controls-forward',
				'controls-skipforward',
				'controls-back',
				'controls-skipback',
				'controls-repeat',
				'controls-volumeon',
				'controls-volumeoff',
			);

			$image_editing = array(
				'image-crop',
				'image-rotate',
				'image-rotate-left',
				'image-rotate-right',
				'image-flip-vertical',
				'image-flip-horizontal',
				'image-filter',
				'undo',
				'redo',
			);

			$tinymce = array(
				'editor-bold',
				'editor-italic',
				'editor-ul',
				'editor-ol',
				'editor-quote',
				'editor-alignleft',
				'editor-aligncenter',
				'editor-alignright',
				'editor-insertmore',
				'editor-spellcheck',
				'editor-expand',
				'editor-contract',
				'editor-kitchensink',
				'editor-underline',
				'editor-justify',
				'editor-textcolor',
				'editor-paste-word',
				'editor-paste-text',
				'editor-removeformatting',
				'editor-video',
				'editor-customchar',
				'editor-outdent',
				'editor-indent',
				'editor-help',
				'editor-strikethrough',
				'editor-unlink',
				'editor-rtl',
				'editor-break',
				'editor-code',
				'editor-paragraph',
				'editor-table',
			);

			$posts = array(
				'align-left',
				'align-right',
				'align-center',
				'align-none',
				'lock',
				'unlock',
				'calendar',
				'calendar-alt',
				'visibility',
				'hidden',
				'post-status',
				'edit',
				'trash',
				'sticky',
			);

			$sorting = array(
				'external',
				'arrow-up',
				'arrow-down',
				'arrow-right',
				'arrow-left',
				'arrow-up-alt',
				'arrow-down-alt',
				'arrow-right-alt',
				'arrow-left-alt',
				'arrow-up-alt2',
				'arrow-down-alt2',
				'arrow-right-alt2',
				'arrow-left-alt2',
				'sort',
				'leftright',
				'randomize',
				'list-view',
				'exerpt-view',
				'grid-view',
			);

			$social = array(
				'share',
				'share-alt',
				'share-alt2',
				'twitter',
				'rss',
				'email',
				'email-alt',
				'facebook',
				'facebook-alt',
				'googleplus',
				'networking',
			);

			$wordpress_org = array(
				'hammer',
				'art',
				'migrate',
				'performance',
				'universal-access',
				'universal-access-alt',
				'tickets',
				'nametag',
				'clipboard',
				'heart',
				'megaphone',
				'schedule',
			);

			$products = array(
				'wordpress',
				'wordpress-alt',
				'pressthis',
				'update',
				'screenoptions',
				'info',
				'cart',
				'feedback',
				'cloud',
				'translation',
			);

			$taxonomies = array(
				'tag',
				'category',
			);

			$widgets = array(
				'archive',
				'tagcloud',
				'text',
			);

			$notifications = array(
				'yes',
				'no',
				'no-alt',
				'plus',
				'plus-alt',
				'minus',
				'dismiss',
				'marker',
				'star-filled',
				'star-half',
				'star-empty',
				'flag',
				'warning',
			);

			$misc = array(
				'location',
				'location-alt',
				'vault',
				'shield',
				'shield-alt',
				'sos',
				'search',
				'slides',
				'analytics',
				'chart-pie',
				'chart-bar',
				'chart-line',
				'chart-area',
				'groups',
				'businessman',
				'id',
				'id-alt',
				'products',
				'awards',
				'forms',
				'testimonial',
				'portfolio',
				'book',
				'book-alt',
				'download',
				'upload',
				'backup',
				'clock',
				'lightbulb',
				'microphone',
				'desktop',
				'tablet',
				'smartphone',
				'phone',
				'index-card',
				'carrot',
				'building',
				'store',
				'album',
				'palmtree',
				'tickets-alt',
				'money',
				'smiley',
				'thumbs-up',
				'thumbs-down',
				'layout',
			);

			return array(
				'admin-menu'     => $admin_menu,
				'welcome-screen' => $welcome_screen,
				'post-formats'   => $post_formats,
				'media'          => $media,
				'image-editing'  => $image_editing,
				'tinymce'        => $tinymce,
				'posts'          => $posts,
				'sorting'        => $sorting,
				'social'         => $social,
				'wordpress_org'  => $wordpress_org,
				'products'       => $products,
				'taxonomies'     => $taxonomies,
				'widgets'        => $widgets,
				'notifications'  => $notifications,
				'misc'           => $misc,
			);

		}

	}

}
