<?php
/**
 * Telemetry implementation for Kirki.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.34
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Telemetry implementation.
 */
final class Kirki_Telemetry {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.34
	 */
	public function __construct() {

		// Early exit if telemetry is disabled.
		if ( ! apply_filters( 'kirki_telemetry', true ) ) {
			return;
		}

		$this->dismiss_notice();

		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
	}

	/**
	 * Maybe send data.
	 *
	 * @access public
	 * @since 3.0.34
	 * @return void
	 */
	public function maybe_send_data() {

		// Check if the user has consented to the data sending.
		if ( ! get_option( 'kirki_telemetry_optin' ) ) {
			return;
		}

		// Only send data once/month.
		$sent = get_site_transient( 'kirki_telemetry_sent' );
		if ( ! $sent ) {
			$this->send_data();
			set_site_transient( 'kirki_telemetry_sent', time(), MONTH_IN_SECONDS );
		}
	}

	/**
	 * Sends data.
	 *
	 * @access private
	 * @since 3.0.34
	 * @return void
	 */
	private function send_data() {

		// The data.
		$data = array_merge(
			array(
				'action' => 'kirki-stats',
			),
			$this->get_data()
		);

		// Build the URL with the arguments.
		$url = add_query_arg( $data, 'https://wpmu.io/?action=kirki-stats' );

		// Ping remote server.
		wp_remote_get( $url );
	}

	/**
	 * The admin-notice.
	 *
	 * @access private
	 * @since 3.0.34
	 * @return void
	 */
	public function admin_notice() {

		// Early exit if the user has dismissed the consent.
		if ( get_option( 'kirki_telemetry_no_consent', false ) ) {
			return;
		}
		$data = $this->get_data();
		?>
		<div class="notice notice-info kirki-telemetry">
			<p><strong><?php esc_html_e( 'Help Kirki improve with usage tracking.', 'kirki' ); ?></strong></p>
			<p><?php esc_html_e( 'Gathering usage data about the theme you are using allows us to know which themes are most-used and work closer with developers of your theme to improve both the theme you use and the Kirki framework. We will never collect any personal information about you or your site.', 'kirki' ); ?></p>
			<table class="data-to-send hidden widefat">
				<thead>
					<tr>
						<th colspan="2"><?php esc_html_e( 'Data that will be sent', 'kirki' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>PHP Version</td>
						<td><code><?php echo esc_attr( $data['phpVer'] ); ?></code></td>
					</tr>
					<tr>
						<td>ID</td>
						<td><code><?php echo esc_attr( $data['siteID'] ); ?></code></td>
					</tr>
					<tr>
						<td>Theme Name</td>
						<td><code><?php echo esc_attr( $data['themeName'] ); ?></code></td>
					</tr>
					<tr>
						<td>Theme Author</td>
						<td><code><?php echo esc_attr( $data['themeAuthor'] ); ?></code></td>
					</tr>
					<tr>
						<td>Theme URI</td>
						<td><code><?php echo esc_attr( $data['themeURI'] ); ?></code></td>
					</tr>
					<tr>
						<td>Theme Version</td>
						<td><code><?php echo esc_attr( $data['themeVersion'] ); ?></code></td>
					</tr>
				</tbody>
			</table>
			<p class="actions">

				<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'kirki-consent-notice', 'telemetry' ) ) ); ?>" class="button button-primary consent"><?php esc_html_e( 'I agree', 'kirki' ); ?></a>
				<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'kirki-hide-notice', 'telemetry' ) ) ); ?>" class="button button-secondary dismiss"><?php esc_html_e( 'No thanks', 'kirki' ); ?></a>
				<a class="button button-link alignright details"><?php esc_html_e( 'Show me the data you send', 'kirki' ); ?></a>
			</p>
			<script>
			jQuery( '.kirki-telemetry a.consent' ).on( 'click', function() {

			});
			jQuery( '.kirki-telemetry a.dismiss' ).on( 'click', function() {

			});
			jQuery( '.kirki-telemetry a.details' ).on( 'click', function() {
				jQuery( '.kirki-telemetry .data-to-send' ).removeClass( 'hidden' );
				jQuery( '.kirki-telemetry a.details' ).hide();
			});
			</script>
		</div>
		<?php
	}

	/**
	 * Builds and returns the data or uses cached if data already exists.
	 *
	 * @access private
	 * @since 3.0.34
	 * @return array
	 */
	private function get_data() {
		// Get the theme.
		$theme = wp_get_theme();

		// Build data and return the array.
		return array(
			'phpVer'       => PHP_VERSION,
			'siteID'       => md5( home_url() ),
			'themeName'    => $theme->get( 'Name' ),
			'themeAuthor'  => $theme->get( 'Author' ),
			'themeURI'     => $theme->get( 'ThemeURI' ),
			'themeVersion' => $theme->get( 'Version' ),
		);
	}

	/**
	 * Dismisses the notice.
	 *
	 * @access public
	 * @since 3.0.34
	 * @return void
	 */
	public function dismiss_notice() {

		if ( ! function_exists( 'wp_verify_nonce' ) ) {
			require_once ABSPATH . WPINC . '/pluggable.php';
		}

		// Check if this is the request we want.
		if ( isset( $_GET['_wpnonce'] ) && isset( $_GET['kirki-hide-notice'] ) ) {
			if ( 'telemetry' === sanitize_text_field( wp_unslash( $_GET['kirki-hide-notice'] ) ) ) {
				// Check the wp-nonce.
				if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) ) ) {
					// All good, we can save the option to dismiss this notice.
					update_option( 'kirki_telemetry_no_consent', true );
				}
			}
		}
	}
}
