<?php
/**
 * Metabox template for displaying recommended plugins.
 *
 * @package Kirki
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="recommended-plugins-metabox">

	<ul class="kirki-recommended-list">

		<?php

			$recommended_plugins = array(
				array(
					'title'       => __( 'Customizer Reset - Export & Import', 'kirki' ),
					'description' => __( 'Reset, Export & Import your WordPress customizer settings with a simple click of a button.', 'kirki' ),
					'banner'      => 'https://ps.w.org/customizer-reset/assets/banner-772x250.jpg',
					'link'        => admin_url( 'plugin-install.php?s=customizer+reset+export+import&tab=search&type=term' ),
					'repo'        => true,
					'constant'    => 'CUSTOMIZER_RESET_PLUGIN_VERSION',
				),
				array(
					'title'       => __( 'Ultimate Dashboard', 'kirki' ),
					'description' => __( 'Ultimate Dashboard is the #1 plugin to customize your WordPress Dashboard.', 'kirki' ),
					'banner'      => 'https://ps.w.org/ultimate-dashboard/assets/banner-1544x500.jpg',
					'link'        => admin_url( 'plugin-install.php?s=ultimate+dashboard&tab=search&type=term' ),
					'repo'        => true,
					'constant'    => 'ULTIMATE_DASHBOARD_PLUGIN_URL',
				),
				array(
					'title'       => __( 'Better Admin Bar', 'kirki' ),
					'description' => __( 'Quickly access all important areas of your WordPress website & provide your clients with the user experience they deserve.', 'kirki' ),
					'banner'      => 'https://ps.w.org/better-admin-bar/assets/banner-772x250.jpg',
					'link'        => 'https://betteradminbar.com/',
					'repo'        => false,
					'constant'    => 'SWIFT_CONTROL_PRO_PLUGIN_VERSION',
				),
				array(
					'title'       => __( 'WP Video Popup', 'kirki' ),
					'description' => __( 'Add beautiful WordPress video lightbox popups to your website without sacrificing performance.', 'kirki' ),
					'banner'      => 'https://ps.w.org/responsive-youtube-vimeo-popup/assets/banner-772x250.jpg',
					'link'        => admin_url( 'plugin-install.php?s=wp+video+popup&tab=search&type=term' ),
					'repo'        => true,
					'constant'    => 'WP_VIDEO_POPUP_PLUGIN_VERSION',
				),
			);

			foreach ( $recommended_plugins as $recommended_plugin ) {

				?>

				<li class="heatbox">
					<a href="<?php echo esc_url( $recommended_plugin['link'] ); ?>" target="_blank">
						<img src="<?php echo esc_html( $recommended_plugin['banner'] ); ?>" alt="<?php echo esc_html( $recommended_plugin['title'] ); ?>">
					</a>
					<div class="kirki-recommended-content">
						<h3>
							<?php echo esc_html( $recommended_plugin['title'] ); ?>
						</h3>
						<p>
							<?php echo esc_html( $recommended_plugin['description'] ); ?>
						</p>
					</div>
					<div class="kirki-recommended-status">
						<?php if ( defined( $recommended_plugin['constant'] ) ) : ?>
							<div class="kirki-recommended-status-action">
								<a href="<?php echo admin_url( 'plugins.php' ); ?>" class="button button-larger disabled"><?php _e( 'Installed', 'kirki' ); ?></i></a>
							</div>
							<div class="kirki-recommended-status-icon green">
								<strong><?php _e( 'Installed', 'kirki' ); ?></strong> <i class="dashicons dashicons-yes-alt"></i>
							</div>
						<?php else : ?>
							<div class="kirki-recommended-status-action">
								<a href="<?php echo esc_url( $recommended_plugin['link'] ); ?>" target="_blank" class="button button-primary button-larger">
									<?php
									if ( $recommended_plugin['repo'] ) {
										_e( 'Install', 'kirki' );
									} else {
										_e( 'Learn More', 'kirki' );
									}
									?>
								</a>
							</div>
							<div class="kirki-recommended-status-icon">
								<strong><?php _e( 'Not Installed', 'kirki' ); ?></strong> <i class="dashicons dashicons-dismiss"></i>
							</div>
						<?php endif; ?>
					</div>
				</li>

				<?php

			}

			?>

	</ul>

</div>
