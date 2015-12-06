<?php

if ( ! function_exists( 'kirki_autoload_classes' ) ) {
	/**
	 * The Kirki class autoloader.
	 * Finds the path to a class that we're requiring and includes the file.
	 */
	function kirki_autoload_classes( $class_name ) {
		$paths    = array();
		$includes = dirname( __FILE__ ) . '/includes/';

		if ( 0 === stripos( $class_name, 'Kirki' ) ) {

			$path     = $includes;
			$filename = 'class-' . strtolower( str_replace( '_', '-', $class_name ) ) . '.php';

			$paths[] = $path . $filename;
			$paths[] = $includes . 'lib/' . $filename;

			$classname_no_prefix = str_replace( 'Kirki_', '', $class_name );

			$filename_parts = explode( '_', str_replace( 'Kirki_', '', $classname_no_prefix ) );
			$count_parts    = count( $filename_parts );
			foreach ( $filename_parts as $key => $value ) {
				$paths[] = $includes . strtolower( $value ) . '/' . $filename;
				if ( isset( $filename_parts[ $key - 1 ] ) ) {
					$paths[] = $includes . strtolower( $filename_parts[ $key - 1 ] ) . '/' . strtolower( $filename_parts[ $key ] ) . '/' . $filename;
					$paths[] = $includes . strtolower( $filename_parts[ $key - 1 ] ) . '-' . strtolower( $filename_parts[ $key ] ) . '/' . $filename;
				}
				if ( isset( $filename_parts[ $key - 2 ] ) ) {
					$paths[] = $includes . strtolower( $filename_parts[ $key - 2 ] ) . '/' . strtolower( $filename_parts[ $key - 1 ] ) . '/' . strtolower( $filename_parts[ $key ] ) . '/' . $filename;
				}
				if ( isset( $filename_parts[ $key - 3 ] ) ) {
					$paths[] = $includes . strtolower( $filename_parts[ $key - 3 ] ) . '/' . strtolower( $filename_parts[ $key - 2 ] ) . '/' . strtolower( $filename_parts[ $key - 1 ] ) . '/' . strtolower( $filename_parts[ $key ] ) . '/' . $filename;
				}
			}

			foreach ( $paths as $path ) {
				if ( file_exists( $path ) ) {
					include $path;
					return;
				}
			}

		}

	}
	// Run the autoloader
	spl_autoload_register( 'kirki_autoload_classes' );
}
