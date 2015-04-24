<?php

/**
 * This is just an abstract class that enqueues scripts.
 * Other classes can extend this and skip the __construct since it's all handled here.
 */
abstract class Kirki_Scripts_Enqueue_Script extends Kirki_Scripts_Registry {

	function __construct() {
		add_action( 'customize_controls_print_scripts', array( $this, 'customize_controls_print_scripts' ), 999 );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ) );
		add_action( 'wp_footer', array( $this, 'wp_footer' ), 21 );
	}

	public abstract function customize_controls_print_scripts();

	public abstract function customize_controls_enqueue_scripts();

	public abstract function customize_controls_print_footer_scripts();

	public abstract function wp_footer();

}
