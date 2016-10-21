<?php

if ( ! function_exists( 'xtkirki_autoload_classes' ) ) {
	/**
	 * The XTKirki class autoloader.
	 * Finds the path to a class that we're requiring and includes the file.
	 */
	function xtkirki_autoload_classes( $class_name ) {
		$paths = array();
		if ( 0 === stripos( $class_name, 'XTKirki' ) ) {

			$path     = dirname( __FILE__ ) . '/includes/';
			$filename = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';

			$paths[] = $path . $filename;
			$paths[] = dirname( __FILE__ ) . '/includes/lib/' . $filename;

			$substr   = str_replace( 'XTKirki_', '', $class_name );
			$exploded = explode( '_', $substr );
			$levels   = count( $exploded );

			$previous_path = '';
			for ( $i = 0; $i < $levels; $i++ ) {
				$paths[] = $path . $previous_path . strtolower( $exploded[ $i ] ) . '/' . $filename;
				$previous_path .= strtolower( $exploded[ $i ] ) . '/';
			}

			foreach ( $paths as $path ) {
				$path = wp_normalize_path( $path );
				if ( file_exists( $path ) ) {
					include_once $path;
					return;
				}
			}

		}

	}
	// Run the autoloader
	spl_autoload_register( 'xtkirki_autoload_classes' );
}
