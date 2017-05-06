<?php
/**
 * Adds search functionality to easier locate fields.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds script for Search.
 */
class Kirki_Modules_Search {

	/**
	 * An array containing field identifieds and their labels/descriptions.
	 *
	 * @access private
	 * @since 3.0.0
	 * @var array
	 */
	private $search_content = array();

	/**
	 * The class constructor
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function __construct() {

		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ) );

	}

	/**
	 * Parses fields and adds their labels and descriptions to the
	 * object's $search_content property.
	 *
	 * @access private
	 * @since 3.0.0
	 */
	private function parse_fields() {

		$fields = Kirki::$fields;
		foreach ( $fields as $field ) {
			$id = str_replace( '[', '-', str_replace( ']', '', $field['settings'] ) );
			$this->search_content[] = array(
				'id'          => $id,
				'label'       => ( isset( $field['label'] ) && ! empty( $field['label'] ) ) ? esc_html( $field['label'] ) : '',
				'description' => ( isset( $field['description'] ) && ! empty( $field['description'] ) ) ? esc_html( $field['description'] ) : '',
			);
		}
	}

	/**
	 * Enqueue scripts.
	 *
	 * @access public
	 * @since 3.0.0
	 */
	public function customize_controls_print_footer_scripts() {

		$this->parse_fields();

		$vars = array(
			'fields' => $this->search_content,
			'button' => '<a class="kirki-customize-controls-search" href="#"><span class="screen-reader-text">' . esc_attr__( 'Search', 'kirki' ) . '</span></a>',
			'form'   => '<div class="kirki-search-form-wrapper hidden"><input type="text" id="kirki-search"></div><div class="kirki-search-results"></div>',
		);

		wp_enqueue_script( 'fuse', trailingslashit( Kirki::$url ) . 'modules/search/fuse.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'kirki-search', trailingslashit( Kirki::$url ) . 'modules/search/search.js', array( 'jquery', 'fuse' ) );
		wp_localize_script( 'kirki-search', 'kirkiFieldsSearch', $vars );
		wp_enqueue_style( 'kirki-search', trailingslashit( Kirki::$url ) . 'modules/search/search.css', null );

	}
}
