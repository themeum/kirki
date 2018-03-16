<?php
/**
 * Handles admin notices.
 *
 * This is necessary to show notices for PHP versions incompatibilities
 * and old WP versions incompatibilities.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.26
 */

/**
 * The Kirki_Admin_Notices class.
 *
 * @since 3.0.26
 */
class Kirki_Admin_Notices {

	/**
	 * Arguments for this instance.
	 *
	 * @access private
	 * @since 3.0.26
	 * @var array
	 */
	private $args = array();

	/**
	 * The API remote server.
	 *
	 * @access private
	 * @since 3.0.26
	 * @var string
	 */
	private $remote_api = 'http://wpmu.test/?api=kirki';

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.26
	 */
	public function __construct() {

		if ( ! function_exists( 'wp_get_current_user' ) ) {
			require_once ABSPATH . 'wp-includes/pluggable.php';
		}

		// Add notices only to superadmins.
		if ( is_super_admin() ) {
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		}
	}

	/**
	 * Set the arguments.
	 *
	 * @access private
	 * @since 3.0.26
	 * @return void
	 */
	private function get_args() {
		global $wp_version;

		$path = parse_url( Kirki::$url );
		return array(
			'p' => PHP_VERSION,
			'w' => $wp_version,
			'r' => $path['path'],
			'u' => md5( site_url() . LOGGED_IN_KEY . get_current_user_id() ),
			'k' => KIRKI_VERSION,
		);
	}

	/**
	 * Check for notices.
	 *
	 * @access public
	 * @since 3.0.26
	 */
	private function get_notices() {
		$notices = get_transient( 'kirki_admin_notices' );
		$notices = false;
		if ( false === $notices ) {
			$args = wp_parse_args(
				$this->get_args(),
				array(
					'action'  => 'get_notices',
					'timeout' => 5,
				)
			);
			$url = add_query_arg( $args, $this->remote_api );

			// Get response from API.
			$response = wp_remote_get( $url );

			// If an error is found, don't try for another 24 hours.
			if ( is_wp_error( $response ) ) {
				set_transient( 'kirki_admin_notices', true, DAY_IN_SECONDS );
				return;
			}

			// Parse response.
			$notices = wp_remote_retrieve_body( $response );

			// If an error is found, don't try for another 24 hours.
			if ( is_wp_error( $response ) ) {
				set_transient( 'kirki_admin_notices', true, DAY_IN_SECONDS );
				return;
			}
			set_transient( 'kirki_admin_notices', $notices, DAY_IN_SECONDS );
		}
		return json_decode( $notices, true );
	}

	/**
	 * Add notices.
	 *
	 * @access public
	 * @since 3.0.26
	 */
	public function admin_notices() {
		$notices = $this->get_notices();
		var_dump( $notices );
		if ( ! is_array( $notices ) ) {
			return;
		}
		foreach ( $notices as $notice ) {
			$class  = 'notice';
			$type   = isset( $notice['type'] ) ? $notice['type'] : 'warning';
			$class .= ' notice-' . $type;
			$class .= ( ! isset( $notice['is-dismissible'] ) || $notice['is-dismissible'] ) ? ' is-dismissible' : '';
			$id     = ( isset( $notice['id'] ) ) ? $notice['id'] : '';
			echo '<div id="kirki-notice-' . esc_attr( $id ) . '" class="' . esc_attr( $class ) . '">' . wp_kses_post( $notice['content'] ) . '</div>';
			?>
			<script>
			( function() {
				jQuery( function() {
					jQuery( '#kirki-notice-<?php echo esc_attr( $id ); ?> button.notice-dismiss' ).click( function( e ) {
						console.log("NOW");
						e.preventDefault();
						jQuery( 'head' ).append( '<style src="<?php echo esc_url_raw( $this->get_dismiss_url( $id ) ); ?>">' );
					} );
				} );
			}() );
			</script>
			<?php
		}
	}

	/**
	 * Dismiss a notice.
	 *
	 * @access public
	 * @since 3.0.26
	 */
	public function get_dismiss_url( $id ) {
		$ags            = $this->get_args();
		$args['id']     = $id;
		$args['action'] = 'dismiss_notice';
		return add_query_arg( $args, $this->remote_api );
	}
}
