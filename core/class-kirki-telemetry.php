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

		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_notices', array( $this, 'admin_notice' ) );
	}

	/**
	 * Additional actions that run on init.
	 *
	 * @access public
	 * @since 3.0.34
	 * @return void
	 */
	public function init() {
		$this->dismiss_notice();
		$this->consent();
		$this->maybe_send_data();
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
		// TODO: Enable this before merging
		// $sent = get_site_transient( 'kirki_telemetry_sent' );
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
		// TODO: ADD URL.
		$url = add_query_arg( $data, 'https://localhost/?action=kirki-stats' );

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

		// Early exit if the user has dismissed the consent, or if they have opted-in.
		if ( get_option( 'kirki_telemetry_no_consent' ) || get_option( 'kirki_telemetry_optin' ) ) {
			return;
		}
		$data = $this->get_data();
		?>
		<div class="notice notice-info kirki-telemetry">
			<h3><strong><?php esc_html_e( 'Help us improve Kirki.', 'kirki' ); ?></strong></h3>
			<p><?php esc_html_e( 'Gathering usage data about the theme you are using allows us to know which themes and field-types are most-used with the Kirki framework.', 'kirki' ); ?><br><?php esc_html_e( 'This will allow us to work closer with theme developers to improve both the theme you use and the Kirki framework.', 'kirki' ); ?></p>
			<p><strong><?php esc_html_e( 'The data is completely anonymous and we will never collect any identifyable information about you or your website.'); ?></strong></p>
			<table class="data-to-send hidden widefat">
				<thead>
					<tr>
						<th colspan="2"><?php esc_html_e( 'Data that will be sent', 'kirki' ); ?></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="min-width: 200px;"><?php esc_html_e( 'PHP Version', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( $data['phpVer'] ); ?></code></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'ID', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( $data['siteID'] ); ?></code></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Theme Name', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( $data['themeName'] ); ?></code></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Theme Author', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( $data['themeAuthor'] ); ?></code></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Theme URI', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( $data['themeURI'] ); ?></code></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Theme Version', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( $data['themeVersion'] ); ?></code></td>
					</tr>
					<tr>
						<td><?php esc_html_e( 'Field Types Used', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( $data['fieldTypes'] ); ?></code></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2">
							<?php
							printf(
								/* translators: %1$s: URL to the server plugin code. %2$s: URL to the stats page. */
								__( 'We believe in complete transparency. You can see the code used on our server <a href="%1$s" rel="nofollow">here</a>, and the results of the statistics we\'re gathering on <a href="%2$s" rel="nofollow">this page</a>.', 'kirki' ),
								// TODO: ADD URL.
								'',
								// TODO: ADD URL.
								''
							);
							?>
						</th>
					</tr>
				</tfoot>
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

		// Format the PHP version.
		$php_version = phpversion( 'tidy' );
		if ( ! $php_version ) {
			$php_version = array_merge( explode( '.', phpversion() ), array( 0, 0 ) );
			$php_version = "{$php_version[0]}.{$php_version[1]}";
		}

		// Build data and return the array.
		return array(
			'phpVer'       => $php_version,
			'siteID'       => md5( home_url() ),
			'themeName'    => $theme->get( 'Name' ),
			'themeAuthor'  => $theme->get( 'Author' ),
			'themeURI'     => $theme->get( 'ThemeURI' ),
			'themeVersion' => $theme->get( 'Version' ),
			'fieldTypes'   => $this->get_field_types(),
		);
	}

	/**
	 * Get the field-types used.
	 *
	 * @access private
	 * @since 3.0.36
	 * @return array
	 */
	public function get_field_types() {
		$types = array();
		foreach ( Kirki::$fields as $field ) {
			if ( isset( $field['type'] ) ) {
				$types[] = $field['type'];
			}
		}
		return '["' . implode( '","',  array_unique( $types ) ) . '"]';
	}

	/**
	 * Dismisses the notice.
	 *
	 * @access private
	 * @since 3.0.34
	 * @return void
	 */
	private function dismiss_notice() {

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

	/**
	 * Dismisses the notice.
	 *
	 * @access private
	 * @since 3.0.34
	 * @return void
	 */
	private function consent() {

		// Check if this is the request we want.
		if ( isset( $_GET['_wpnonce'] ) && isset( $_GET['kirki-consent-notice'] ) ) {
			if ( 'telemetry' === sanitize_text_field( wp_unslash( $_GET['kirki-consent-notice'] ) ) ) {
				// Check the wp-nonce.
				if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) ) ) {
					// All good, we can save the option to dismiss this notice.
					update_option( 'kirki_telemetry_optin', true );
				}
			}
		}
	}
}
