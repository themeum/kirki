<?php
/**
 * This file adds a custom section in the customizer that recommends the installation of the Kirki plugin.
 * It can be used as-is in themes (drop-in).
 *
 * @package kirki-helpers
 */

if ( ! class_exists( 'Kirki' ) ) {

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
			 * Render the section.
			 *
			 * @access protected
			 */
			protected function render() {
				// Determine if the plugin is not installed, or just inactive.
				$plugins   = get_plugins();
				$installed = false;
				foreach ( $plugins as $plugin ) {
					if ( 'Kirki' === $plugin['Name'] || 'Kirki Toolkit' === $plugin['Name'] ) {
						$installed = true;
					}
				}
				// Get the plugin-installation URL.
				$plugin_install_url = add_query_arg(
					array(
						'action' => 'install-plugin',
						'plugin' => 'kirki',
					),
					self_admin_url( 'update.php' )
				);
				$plugin_install_url = wp_nonce_url( $plugin_install_url, 'install-plugin_kirki' );
				$classes = 'cannot-expand accordion-section control-section control-section-themes control-section-' . $this->type;
				?>
				<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $classes ); ?>" style="border-top:none;border-bottom:1px solid #ddd;padding:7px 14px 16px 14px;text-align:right;">
					<?php if ( ! $installed ) : ?>
						<p style="text-align:left;margin-top:0;"><?php esc_attr_e( 'A plugin is required to take advantage of this theme\'s features in the customizer.', 'textdomain' ); ?></p>
						<a class="install-now button-primary button" data-slug="kirki" href="<?php echo esc_url_raw( $plugin_install_url ); ?>" aria-label="<?php esc_attr_e( 'Install Kirki Toolkit now', 'textdomain' ); ?>" data-name="Kirki Toolkit">
							<?php esc_html_e( 'Install Now', 'textdomain' ); ?>
						</a>
					<?php else : ?>
						<p style="text-align:left;margin-top:0;"><?php esc_attr_e( 'You have installed Kirki. Activate it to take advantage of this theme\'s features in the customizer.', 'textdomain' ); ?></p>
						<a class="install-now button-secondary button change-theme" data-slug="kirki" href="<?php echo esc_url_raw( self_admin_url( 'plugins.php' ) ); ?>" aria-label="<?php esc_attr_e( 'Activate Kirki Toolkit now', 'textdomain' ); ?>" data-name="Kirki Toolkit">
							<?php esc_html_e( 'Activate Now', 'textdomain' ); ?>
						</a>
					<?php endif; ?>
				</li>
				<?php
			}
		}
	}

	if ( ! function_exists( 'kirki_installer_register' ) ) {
		/**
		 * Registers the section, setting & control for the kirki installer.
		 *
		 * @param object $wp_customize The main customizer object.
		 */
		function kirki_installer_register( $wp_customize ) {
			$wp_customize->add_section( new Kirki_Installer_Section( $wp_customize, 'kirki_installer', array(
				'title'      => '',
				'capability' => 'install_plugins',
				'priority'   => 0,
			) ) );
			$wp_customize->add_setting( 'kirki_installer_setting', array(
				'sanitize_callback' => '__return_true',
			) );
			$wp_customize->add_control( 'kirki_installer_control', array(
				'section'    => 'kirki_installer',
				'settings'   => 'kirki_installer_setting',
			) );

		}
		add_action( 'customize_register', 'kirki_installer_register' );
	}
}
