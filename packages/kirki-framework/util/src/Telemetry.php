<?php
/**
 * Telemetry implementation for Kirki.
 *
 * @package     Kirki
 * @category    Core
 * @author      Ari Stathopoulos (@aristath)
 * @copyright   Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license     https://opensource.org/licenses/MIT
 * @since       3.0.36
 */

namespace Kirki\Util;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Telemetry implementation.
 */
final class Telemetry {

	/**
	 * An array of all control types.
	 *
	 * @static
	 * @access private
	 * @since 4.0
	 * @var array
	 */
	private static $types = [];


	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0.36
	 */
	public function __construct() {

		// Early exit if telemetry is disabled.
		if ( ! apply_filters( 'kirki_telemetry', true ) ) {
			return;
		}

		add_action( 'kirki_field_init', [ $this, 'field_init' ], 10, 2 );
		add_action( 'init', [ $this, 'init' ] );
		add_action( 'admin_notices', [ $this, 'admin_notice' ] );
	}

	/**
	 * Additional actions that run on init.
	 *
	 * @access public
	 * @since 3.0.36
	 * @return void
	 */
	public function init() {
		$this->dismiss_notice();
		$this->consent();

		// This is the last thing to run. No impact on performance or anything else.
		add_action( 'wp_footer', [ $this, 'maybe_send_data' ], 99999 );
	}

	/**
	 * Maybe send data.
	 *
	 * @access public
	 * @since 3.0.36
	 * @return void
	 */
	public function maybe_send_data() {

		// Check if the user has consented to the data sending.
		if ( ! get_option( 'kirki_telemetry_optin' ) ) {
			return;
		}

		// Only send data once/month. We use an option instead of a transient
		// because transients in some managed hosting environments don't properly update
		// due to their caching implementations.
		$sent = get_option( 'kirki_telemetry_sent' );
		if ( ! $sent || $sent < time() - MONTH_IN_SECONDS ) {
			$this->send_data();
			update_option( 'kirki_telemetry_sent', time() );
		}
	}

	/**
	 * Sends data.
	 *
	 * @access private
	 * @since 3.0.36
	 * @return void
	 */
	private function send_data() {

		// Ping remote server.
		wp_remote_post(
			'https://wplemon.com/?action=kirki-stats',
			[
				'method'   => 'POST',
				'blocking' => false,
				'body'     => array_merge(
					[
						'action' => 'kirki-stats',
					],
					$this->get_data()
				),
			]
		);
	}

	/**
	 * The admin-notice.
	 *
	 * @access private
	 * @since 3.0.36
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
			<p style="max-width: 76em;"><?php _e( 'Sharing anonymous data helps improve both the theme you are using and the Kirki framework. <strong>The data is completely anonymous and we will never collect any identifiable information about you or your website.</strong>', 'kirki' ); // phpcs:ignore WordPress.Security.EscapeOutput ?></p>
			<table class="data-to-send hidden">
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
						<td><?php esc_html_e( 'Field Types Used', 'kirki' ); ?></td>
						<td><code><?php echo esc_html( implode( ',', $data['fieldTypes'] ) ); ?></code></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2">
							<?php
							printf(
								/* translators: %1$s: URL to the server plugin code. %2$s: URL to the stats page. */
								__( 'We believe in complete transparency. You can see the code used on our server <a href="%1$s" rel="nofollow">here</a>, and the results of the statistics we\'re gathering on <a href="%2$s" rel="nofollow">this page</a>.', 'kirki' ), // phpcs:ignore WordPress.Security.EscapeOutput
								'https://github.com/aristath/kirki-telemetry-server',
								'https://wplemon.com/kirki-telemetry-statistics/'
							);
							?>
						</th>
					</tr>
				</tfoot>
			</table>
			<p class="actions">

				<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'kirki-consent-notice', 'telemetry' ) ) ); ?>" class="button button-primary consent"><?php esc_html_e( 'I agree', 'kirki' ); ?></a>
				<a href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'kirki-hide-notice', 'telemetry' ) ) ); ?>" class="button button-secondary dismiss"><?php esc_html_e( 'No thanks', 'kirki' ); ?></a>
				<a class="button button-link details details-show"><?php esc_html_e( 'Show me the data', 'kirki' ); ?></a>
				<a class="button button-link details details-hide hidden"><?php esc_html_e( 'Collapse data', 'kirki' ); ?></a>
			</p>
			<script>
			jQuery( '.kirki-telemetry a.details' ).on( 'click', function() {
				jQuery( '.kirki-telemetry .data-to-send' ).toggleClass( 'hidden' );
				jQuery( '.kirki-telemetry a.details-show' ).toggleClass( 'hidden' );
				jQuery( '.kirki-telemetry a.details-hide' ).toggleClass( 'hidden' );
			});
			</script>
		</div>
		<?php

		$this->table_styles();
	}

	/**
	 * Builds and returns the data or uses cached if data already exists.
	 *
	 * @access private
	 * @since 3.0.36
	 * @return array
	 */
	private function get_data() {
		// Get the theme.
		$theme = wp_get_theme();

		// Format the PHP version.
		$php_version = phpversion( 'tidy' );
		if ( ! $php_version ) {
			$php_version = array_merge( explode( '.', phpversion() ), [ 0, 0 ] );
			$php_version = "{$php_version[0]}.{$php_version[1]}";
		}

		$this->get_field_types();

		// Build data and return the array.
		return [
			'phpVer'      => $php_version,
			'themeName'   => $theme->get( 'Name' ),
			'themeAuthor' => $theme->get( 'Author' ),
			'themeURI'    => $theme->get( 'ThemeURI' ),
			'fieldTypes'  => self::$types,
		];
	}

	/**
	 * Get the field-types used.
	 *
	 * @access private
	 * @since 3.0.36
	 * @return array
	 */
	public function get_field_types() {
		$types  = [];
		$fields = [];

		// Compatibility with v3 API.
		if ( class_exists( '\Kirki\Compatibility\Kirki' ) ) {
			$fields = \Kirki\Compatibility\Kirki::$fields;
		}
		foreach ( $fields as $field ) {
			if ( isset( $field['type'] ) ) {
				self::$types[] = $field['type'];
			}
		}
	}

	/**
	 * Runs when a field gets added.
	 * Adds fields to this object so their styles can later be generated.
	 *
	 * @access public
	 * @since 1.0
	 * @param array  $args   The field args.
	 * @param Object $object The field object.
	 * @return void
	 */
	public function field_init( $args, $object ) {
		if ( ! isset( $args['type'] ) && isset( $object->type ) ) {
			$args['type'] = $object->type;
		}
		if ( isset( $args['type'] ) ) {
			self::$types[] = $args['type'];
		}
	}

	/**
	 * Dismisses the notice.
	 *
	 * @access private
	 * @since 3.0.36
	 * @return void
	 */
	private function dismiss_notice() {

		// Check if this is the request we want.
		if ( isset( $_GET['_wpnonce'] ) && isset( $_GET['kirki-hide-notice'] ) ) {
			if ( 'telemetry' === sanitize_text_field( wp_unslash( $_GET['kirki-hide-notice'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
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
	 * @since 3.0.36
	 * @return void
	 */
	private function consent() {

		// Check if this is the request we want.
		if ( isset( $_GET['_wpnonce'] ) && isset( $_GET['kirki-consent-notice'] ) ) {
			if ( 'telemetry' === sanitize_text_field( wp_unslash( $_GET['kirki-consent-notice'] ) ) ) { // phpcs:ignore WordPress.Security.NonceVerification
				// Check the wp-nonce.
				if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) ) ) {
					// All good, we can save the option to dismiss this notice.
					update_option( 'kirki_telemetry_optin', true );
				}
			}
		}
	}

	/**
	 * Prints the table styles.
	 *
	 * Normally we'd just use the .widefat CSS class for the table,
	 * however apparently there's an obscure bug in WP causing this: https://github.com/aristath/kirki/issues/2067
	 * This CSS is a copy of some styles from common.css in wp-core.
	 *
	 * @access private
	 * @since 3.0.37
	 * @return void
	 */
	private function table_styles() {
		?>
		<style>
			/* .widefat - main style for tables */
			.data-to-send { border-spacing: 0; width: 100%; clear: both; }
			.data-to-send * { word-wrap: break-word; }
			.data-to-send a, .data-to-send button.button-link { text-decoration: none; }
			.data-to-send td, .data-to-send th { padding: 8px 10px; }
			.data-to-send thead th, .data-to-send thead td { border-bottom: 1px solid #e1e1e1; }
			.data-to-send tfoot th, .data-to-send tfoot td { border-top: 1px solid #e1e1e1; border-bottom: none; }
			.data-to-send .no-items td { border-bottom-width: 0; }
			.data-to-send td { vertical-align: top; }
			.data-to-send td, .data-to-send td p, .data-to-send td ol, .data-to-send td ul { font-size: 13px; line-height: 1.5em; }
			.data-to-send th, .data-to-send thead td, .data-to-send tfoot td { text-align: left; line-height: 1.3em; font-size: 14px; }
			.data-to-send th input, .updates-table td input, .data-to-send thead td input, .data-to-send tfoot td input { margin: 0 0 0 8px; padding: 0; vertical-align: text-top; }
		</style>
		<?php
	}
}
