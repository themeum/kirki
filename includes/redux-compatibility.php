<?php

// No need to proceed if Redux exists.
if ( class_exists( 'Redux' ) ) {
	return;
}

class Redux {

	public static function setArgs( $opt_name = '', $args = array() ) {
		Kirki::add_config( $opt_name, array(
			'option_type' => 'option',
			'option_name' => $args['opt_name'],
		) );
	}

	public static function setSection( $opt_name = '', $args = array() ) {
		Kirki::setSection( $opt_name, $args );
	}

	public static function setHelpTab() {}

	public static function setHelpSidebar() {}

}
