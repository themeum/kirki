<?php
/**
 * Metabox template for displaying ultimate dashboard promotion.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox pro-extensions-metabox">

	<h2>
		<?php _e( 'Ultimate Dashboard - Features', 'kirki' ); ?>
		<a href="https://ultimatedashboard.io/?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki" target="_blank" class="button-link is-right-side">
			<?php _e( "Learn more", 'kirki' ); ?>
		</a>
	</h2>

	<ul class="pro-extensions-list">

		<?php

			$premium_features = array(
				array(
					'title'       => __( 'Custom Dashboard Widgets', 'kirki' ),
					'description' => __( 'Replace the default WordPress widgets with your own to give the WordPress dashboard a more meaningful use.', 'kirki' ),
					'pro'         => false,
				),
				array(
					'title'       => __( 'Customize the WordPress Login', 'kirki' ),
					'description' => __( 'Customize & rebrand the WordPress login screen with full control directly within the WordPress customizer.', 'kirki' ),
					'pro'         => false,
				),
				array(
					'title'       => __( 'Login Redirects', 'kirki' ),
					'description' => __( 'Change the WordPress login URL, redirect non-logged in users trying to access the wp-admin URL & set up redirects after login for all user roles.', 'kirki' ),
					'pro'         => false,
				),
				array(
					'title'       => __( 'Custom Admin Pages', 'kirki' ),
					'description' => __( 'Create Custom Admin Pages (Top-Level & Sub-Menu) with HTML & CSS.', 'kirki' ),
					'pro'         => false,
				),
				array(
					'title'       => __( 'Admin Menu & Admin Bar Editor', 'kirki' ),
					'description' => __( 'Rearrange & hide menu & sub menu items from the WordPress admin area & admin bar.', 'kirki' ),
					'pro'         => true,
				),
				array(
					'title'       => __( 'White Label WordPress', 'kirki' ),
					'description' => __( 'Fully white label the WordPress admin area and apply your own branding.', 'kirki' ),
					'pro'         => true,
				),
				array(
					'title'       => __( 'Page Builder Support', 'kirki' ),
					'description' => __( 'Replace the entire WordPress dashboard with your saved Elementor, Beaver Builder or Brizy Layout or use it along with our Ultimate Dashboard widgets.', 'kirki' ),
					'pro'         => true,
				),
			);

			foreach ( $premium_features as $premium_feature ) {

				?>

				<li>
					<div class="pro-extensions-list-content">
						<h3>
							<?php echo esc_html( $premium_feature['title'] ); ?>
						</h3>
						<div class="tooltip">
							<i class="dashicons dashicons-editor-help"></i>
							<p><?php echo esc_html( $premium_feature['description'] ); ?></p>
						</div>
					</div>
					<div class="pro-extensions-list-icon">
						<?php echo $premium_feature['pro'] ? '<strong>PRO</strong>' : ''; ?>
						<i class="dashicons dashicons-yes-alt"></i>
					</div>
				</li>

				<?php

			}

			?>

		<li>
			<div class="pro-extensions-list-content">
				<h3>
					<strong><?php _e( 'And much more!', 'kirki' ); ?></strong>
				</h3>
				<p>
					<?php _e( 'Install Ultimate Dashboard or <a href="https://ultimatedashboard.io/?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki" target="_blank">learn more</a>.', 'kirki' ); ?>
				</p>
			</div>
			<div class="pro-extensions-list-icon">
				<button type="button" class="button button-larger button-primary kirki-install-udb">
					<?php _e( 'Install Ultimate Dashboard (FREE)', 'kirki' ); ?>
				</button>
			</div>
		</li>

	</ul>

</div>
