<?php
/**
 * This is just an abstract class that enqueues scripts.
 * Other classes can extend this and skip the __construct since it's all handled here.
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
if ( class_exists( 'Kirki_Customizer_Scripts_Enqueue' ) ) {
	return;
}

abstract class Kirki_Customizer_Scripts_Enqueue extends Kirki_Scripts_Registry {

	public function __construct() {

		add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ), 999 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ), 21 );

	}

	/**
	 * @return void
	 */
	abstract public function generate_script( $args = array() );

	/**
	 * @return void
	 */
	abstract public function customize_controls_print_scripts();

	/**
	 * @return void
	 */
	abstract public function customize_controls_enqueue_scripts();

	/**
	 * @return void
	 */
	abstract public function customize_controls_print_footer_scripts();

	/**
	 * @return void
	 */
	abstract public function wp_footer();

}
