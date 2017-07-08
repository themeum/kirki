<?php
/**
 * A utility class for Kirki.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.9
 */

/**
 * Utility class.
 */
class Kirki_Util {

	/**
	 * Constructor.
	 *
	 * @since 3.0.9
	 * @access public
	 */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'acf_pro_compatibility' ) );
		add_filter( 'http_request_args', array( $this, 'http_request' ), 10, 2 );
		/* add_filter( 'option_active_plugins', array( $this, 'is_plugin_active' ) ); */
	}

	/**
	 * Changes select2 version in ACF.
	 * Fixes a plugin conflict that was causing select fields to crash
	 * because of a version mismatch between ACF's and Kirki's select2 scripts.
	 * Props @hellor0bot
	 *
	 * @see https://github.com/aristath/kirki/issues/1302
	 * @access public
	 * @since 3.0.0
	 */
	public function acf_pro_compatibility() {
		if ( is_customize_preview() ) {
			add_filter( 'acf/settings/enqueue_select2', '__return_false', 99 );
		}
	}

	/**
	 * Determine if Kirki is installed as a plugin.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return bool
	 */
	public static function is_plugin() {

		$is_plugin = false;
		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Get all plugins.
		$plugins = get_plugins();
		$_plugin = '';
		foreach ( $plugins as $plugin => $args ) {
			if ( ! $is_plugin && isset( $args['Name'] ) && ( 'Kirki' === $args['Name'] || 'Kirki Toolkit' === $args['Name'] ) ) {
				$is_plugin = true;
				$_plugin   = $plugin;
			}
		}

		// No need to proceed any further if Kirki wasn't found in the list of plugins.
		if ( ! $is_plugin ) {
			return false;
		}

		// Extra logic in case the plugin is installed but not activated.
		// Make sure the is_plugins_loaded function is loaded.
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( $_plugin && ! is_plugin_active( $_plugin ) ) {
			return false;
		}
		return $is_plugin;
	}

	/**
	 * Build the variables.
	 *
	 * @static
	 * @access public
	 * @since 3.0.9
	 * @return array Formatted as array( 'variable-name' => value ).
	 */
	public static function get_variables() {

		$variables = array();

		// Loop through all fields.
		foreach ( Kirki::$fields as $field ) {

			// Check if we have variables for this field.
			if ( isset( $field['variables'] ) && $field['variables'] && ! empty( $field['variables'] ) ) {

				// Loop through the array of variables.
				foreach ( $field['variables'] as $field_variable ) {

					// Is the variable ['name'] defined? If yes, then we can proceed.
					if ( isset( $field_variable['name'] ) ) {

						// Sanitize the variable name.
						$variable_name = esc_attr( $field_variable['name'] );

						// Do we have a callback function defined? If not then set $variable_callback to false.
						$variable_callback = ( isset( $field_variable['callback'] ) && is_callable( $field_variable['callback'] ) ) ? $field_variable['callback'] : false;

						// If we have a variable_callback defined then get the value of the option
						// and run it through the callback function.
						// If no callback is defined (false) then just get the value.
						$variables[ $variable_name ] = Kirki::get_option( $field['settings'] );
						if ( $variable_callback ) {
							$variables[ $variable_name ] = call_user_func( $field_variable['callback'], Kirki::get_option( $field['settings'] ) );
						}
					}
				}
			}
		}

		// Pass the variables through a filter ('kirki/variable') and return the array of variables.
		return apply_filters( 'kirki/variable', $variables );

	}

	/**
	 * Plugin is active.
	 *
	 * @since 3.0.0
	 * @access public
	 * @param array $plugins An array of active plugins.
	 * @return array Active plugins.
	 */
	public function is_plugin_active( $plugins ) {
		global $pagenow;
		$exclude = array(
			'plugins.php',
			'plugin-install.php',
		);
		$referer = ( isset( $_SERVER ) && isset( $_SERVER['HTTP_REFERER'] ) ) ? esc_url_raw( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';
		$refered = false;
		foreach ( $exclude as $exception ) {
			if ( false !== strpos( $referer, $exception ) ) {
				$refered = true;
			}
		}
		if ( is_array( $plugins ) && ! in_array( $pagenow, $exclude, true ) && ! $refered ) {
			$exists = false;
			foreach ( $plugins as $plugin ) {
				if ( false !== strpos( $plugin, 'kirki.php' ) ) {
					$exists = true;
				}
			}
			if ( ! $exists ) {
				$plugins[] = 'kirki/kirki.php';
			}
		}
		return $plugins;
	}

	/**
	 * HTTP Request injection.
	 *
	 * @access public
	 * @since 3.0.0
	 * @param array  $r The request params.
	 * @param string $url The request URL.
	 * @return array
	 */
	public function http_request( $r = array(), $url = '' ) {
		// Early exit if installed as a plugin or not a request to wordpress.org,
		// or finally if we don't have everything we need.
		if ( self::is_plugin() || false === strpos( $url, 'wordpress.org' ) || ( ! isset( $r['body'] ) || ! isset( $r['body']['plugins'] ) || ! isset( $r['body']['translations'] ) || ! isset( $r['body']['locale'] ) || ! isset( $r['body']['all'] ) ) ) {
			return $r;
		}

		// Inject data.
		$plugins = json_decode( $r['body']['plugins'], true );
		if ( isset( $plugins['plugins'] ) ) {
			$exists = false;
			foreach ( $plugins['plugins'] as $plugin ) {
				if ( isset( $plugin['Name'] ) && 'Kirki Toolkit' === $plugin['Name'] ) {
					$exists = true;
				}
			}
			if ( ! $exists && defined( 'KIRKI_PLUGIN_FILE' ) ) {
				$plugins['plugins']['kirki/kirki.php'] = get_plugin_data( KIRKI_PLUGIN_FILE );
			}
			$r['body']['plugins'] = json_encode( $plugins );
			return $r;
		}
		return $r;
	}
}
