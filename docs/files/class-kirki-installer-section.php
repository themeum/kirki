<?php
/**
 * This file adds a custom section in the customizer that recommends the installation of the Kirki plugin.
 * It can be used as-is in themes (drop-in).
 *
 * @package kirki-helpers
 */

if ( ! function_exists( 'kirki_installer_register' ) ) {
	/**
	 * Registers the section, setting & control for the kirki installer.
	 *
	 * @param object $wp_customize The main customizer object.
	 */
	function kirki_installer_register( $wp_customize ) {

		// Early exit if Kirki exists.
		if ( class_exists( 'Kirki' ) ) {
			return;
		}

		if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Kirki_Installer_Section' ) ) {
			/**
			 * Recommend the installation of Kirki using a custom section.
			 *
			 * @see WP_Customize_Section
			 */
			class Kirki_Installer_Section extends WP_Customize_Section {

				/**
				 * Customize section type.
				 *
				 * @access public
				 * @var string
				 */
				public $type = 'kirki_installer';

				/**
				 * The plugin install URL.
				 *
				 * @access private
				 * @var string
				 */
				public $plugin_install_url;

				/**
				 * Render the section.
				 *
				 * @access protected
				 */
				protected function render() {

					// Don't proceed any further if the user has dismissed this.
					if ( $this->is_dismissed() ) {
						return;
					}

					// Determine if the plugin is not installed, or just inactive.
					$plugins   = get_plugins();
					$installed = false;
					foreach ( $plugins as $plugin ) {
						if ( 'Kirki' === $plugin['Name'] || 'Kirki Toolkit' === $plugin['Name'] ) {
							$installed = true;
						}
					}
					$plugin_install_url = $this->get_plugin_install_url();
					$classes            = 'cannot-expand accordion-section control-section control-section-themes control-section-' . $this->type;
					?>
					<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $classes ); ?>" style="border-top:none;border-bottom:1px solid #ddd;padding:7px 14px 16px 14px;text-align:right;">
						<?php if ( ! $installed ) : ?>
							<?php $this->install_button(); ?>
						<?php else : ?>
							<?php $this->activate_button(); ?>
						<?php endif; ?>
						<?php $this->dismiss_button(); ?>
					</li>
					<?php
				}

				/**
				 * Check if the user has chosen to hide this.
				 *
				 * @static
				 * @access public
				 * @since 1.0.0
				 * @return bool
				 */
				public static function is_dismissed() {
					// Get the user-meta.
					$user_id   = get_current_user_id();
					$user_meta = get_user_meta( $user_id, 'dismiss-kirki-recommendation', true );

					return ( true === $user_meta || '1' === $user_meta || 1 === $user_meta );
				}

				/**
				 * Adds the install button.
				 *
				 * @since 1.0.0
				 * @return void
				 */
				protected function install_button() {
					?>
					<p style="text-align:left;margin-top:0;">
						<?php esc_attr_e( 'Please install the Kirki plugin to take full advantage of this theme\s customizer capabilities', 'textdomain' ); ?>
					</p>
					<a class="install-now button-primary button" data-slug="kirki" href="<?php echo esc_url_raw( $this->get_plugin_install_url() ); ?>" aria-label="<?php esc_attr_e( 'Install Kirki Toolkit now', 'textdomain' ); ?>" data-name="Kirki Toolkit">
						<?php esc_html_e( 'Install Now', 'textdomain' ); ?>
					</a>
					<?php
				}

				/**
				 * Adds the install button.
				 *
				 * @since 1.0.0
				 * @return void
				 */
				protected function activate_button() {
					?>
					<p style="text-align:left;margin-top:0;">
						<?php esc_attr_e( 'You have installed Kirki. Activate it to take advantage of this theme\'s features in the customizer.', 'textdomain' ); ?>
					</p>
					<a class="activate-now button-primary button" data-slug="kirki" href="<?php echo esc_url_raw( self_admin_url( 'plugins.php' ) ); ?>" aria-label="<?php esc_attr_e( 'Activate Kirki Toolkit now', 'textdomain' ); ?>" data-name="Kirki Toolkit">
						<?php esc_html_e( 'Activate Now', 'textdomain' ); ?>
					</a>
					<?php
				}

				/**
				 * Adds the dismiss button and script.
				 *
				 * @since 1.0.0
				 * @return void
				 */
				protected function dismiss_button() {

					// Create the nonce.
					$ajax_nonce = wp_create_nonce( 'dismiss-kirki-recommendation' );

					// Show confirmation dialog on dismiss?
					$show_confirm = true;
					?>
					<a class="kirki-installer-dismiss button-secondary button" data-slug="kirki" href="#" aria-label="<?php esc_attr_e( 'Don\'t show this again', 'textdomain' ); ?>" data-name="<?php esc_attr_e( 'Dismiss', 'textdomain' ); ?>">
						<?php esc_attr_e( 'Don\'t show this again', 'textdomain' ); ?>
					</a>

					<script type="text/javascript">
					jQuery( document ).ready( function() {
						jQuery( '.kirki-installer-dismiss' ).on( 'click', function( event ) {

							event.preventDefault();

							<?php if ( $show_confirm ) : ?>
								if ( ! confirm( '<?php esc_attr_e( 'Are you sure? Dismissing this message will hide the installation recommendation and you will have to manually install and activate the plugin in the future.', 'textdomain' ); ?>' ) ) {
									return;
								}
							<?php endif; ?>

							jQuery.post( ajaxurl, {
								action: 'kirki_installer_dismiss',
								security: '<?php echo esc_attr( $ajax_nonce ); ?>',
							}, function( response ) {
								jQuery( '#accordion-section-kirki_installer' ).remove();
							} );
						} );
					} );
					</script>
					<?php
				}

				/**
				 * Get the plugin install URL.
				 *
				 * @access private
				 * @return string
				 */
				private function get_plugin_install_url() {
					if ( ! $this->plugin_install_url ) {
						// Get the plugin-installation URL.
						$this->plugin_install_url = add_query_arg(
							array(
								'action' => 'install-plugin',
								'plugin' => 'kirki',
							),
							self_admin_url( 'update.php' )
						);
						$this->plugin_install_url = wp_nonce_url( $this->plugin_install_url, 'install-plugin_kirki' );
					}
					return $this->plugin_install_url;
				}
			}
		}

		// Early exit if the user has dismissed the notice.
		if ( is_callable( array( 'Kirki_Installer_Section', 'is_dismissed' ) ) && Kirki_Installer_Section::is_dismissed() ) {
			return;
		}

		$wp_customize->add_section(
			new Kirki_Installer_Section(
				$wp_customize, 'kirki_installer', array(
					'title'      => '',
					'capability' => 'install_plugins',
					'priority'   => 0,
				)
			)
		);
		$wp_customize->add_setting(
			'kirki_installer_setting', array(
				'sanitize_callback' => '__return_true',
			)
		);
		$wp_customize->add_control(
			'kirki_installer_control', array(
				'section'  => 'kirki_installer',
				'settings' => 'kirki_installer_setting',
			)
		);

	}
}
add_action( 'customize_register', 'kirki_installer_register', 999 );

if ( ! function_exists( 'kirki_installer_dismiss' ) ) {
	/**
	 * Handles dismissing the plgin-install/activate recommendation.
	 * If the user clicks the "Don't show this again" button, save as user-meta.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function kirki_installer_dismiss() {
		check_ajax_referer( 'dismiss-kirki-recommendation', 'security' );
		$user_id = get_current_user_id();
		if ( update_user_meta( $user_id, 'dismiss-kirki-recommendation', true ) ) {
			echo 'success! :-)';
			wp_die();
		}
		echo 'failed :-(';
		wp_die();
	}
}
add_action( 'wp_ajax_kirki_installer_dismiss', 'kirki_installer_dismiss' );
