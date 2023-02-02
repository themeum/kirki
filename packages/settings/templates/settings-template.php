<?php
/**
 * Settings page template.
 *
 * @package Kirki
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

return function () {
	?>

	<div class="wrap heatbox-wrap kirki-settings-page">

		<div class="heatbox-header heatbox-has-tab-nav heatbox-margin-bottom">

			<div class="heatbox-container heatbox-container-center">

				<div class="logo-container">

					<div>
						<span class="title">
							<?php _e( 'Kirki Customizer Framework', 'kirki' ); ?>
							<span class="version"><?php echo esc_html( KIRKI_VERSION ); ?></span>
						</span>
						<p class="subtitle"><?php _e( 'The #1 Customizer Toolkit for WordPress Theme Developers.', 'kirki' ); ?></p>
					</div>

					<div>
						<img src="<?php echo esc_url( KIRKI_PLUGIN_URL ); ?>/assets/images/kirki-logo-rounded.png">
					</div>

				</div>

				<nav>
					<ul class="heatbox-tab-nav">
						<li class="heatbox-tab-nav-item kirki-settings-panel active">
							<a href="#settings"><?php _e( 'Settings', 'kirki' ); ?></a>
						</li>
						<li class="heatbox-tab-nav-item kirki-extensions-panel">
							<a href="#extensions"><?php _e( 'Extensions', 'kirki' ); ?></a>
						</li>
					</ul>
				</nav>

			</div>

		</div>

		<div class="heatbox-container heatbox-container-center heatbox-column-container">

			<div class="heatbox-main heatbox-panel-wrapper">

				<!-- Faking H1 tag to place admin notices -->
				<h1 style="display: none;"></h1>

				<div class="heatbox-admin-panel kirki-settings-panel">
					<?php
					require __DIR__ . '/metaboxes/clear-font-cache.php';
					?>

					<div class="featured-products-banner">
						<img src="<?php echo esc_url( KIRKI_PLUGIN_URL ); ?>/assets/images/featured-plugin-banner.jpg" alt="Featured products">
					</div>
				</div>

				<div class="heatbox-admin-panel kirki-extensions-panel">
					<?php
					require __DIR__ . '/metaboxes/kirki-pro.php';
					?>
				</div>

			</div>

			<div class="heatbox-sidebar">
				<?php
				require __DIR__ . '/metaboxes/documentation.php';
				?>
			</div>

			<div class="heatbox-divider"></div>

		</div>

		<div class="heatbox-container heatbox-container-wide heatbox-container-center kirki-featured-products">

			<h2><?php _e( 'Check out our other free WordPress products!', 'kirki' ); ?></h2>

			<ul class="products">
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/better-admin-bar/" target="_blank">
						<img src="<?php echo esc_url( KIRKI_PLUGIN_URL ); ?>/assets/images/swift-control.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'Better Admin Bar', 'kirki' ); ?></h3>
						<p class="subheadline"><?php _e( 'Replace the boring WordPress Admin Bar with this!', 'kirki' ); ?></p>
						<p><?php _e( 'Better Admin Bar is the plugin that make your clients love WordPress. It drastically improves the user experience when working with WordPress and allows you to replace the boring WordPress admin bar with your own navigation panel.', 'kirki' ); ?></p>
						<a href="https://wordpress.org/plugins/better-admin-bar/" target="_blank" class="button"><?php _e( 'View Features', 'kirki' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank">
						<img src="<?php echo esc_url( KIRKI_PLUGIN_URL ); ?>/assets/images/ultimate-dashboard.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'Ultimate Dashboard', 'kirki' ); ?></h3>
						<p class="subheadline"><?php _e( 'The #1 plugin to customize your WordPress dashboard.', 'kirki' ); ?></p>
						<p><?php _e( 'Ultimate Dashboard is a clean & lightweight plugin that was made to optimize the user experience for clients inside the WordPress admin area.', 'kirki' ); ?></p>
						<a href="https://wordpress.org/plugins/ultimate-dashboard/" target="_blank" class="button"><?php _e( 'View Features', 'kirki' ); ?></a>
					</div>
				</li>
				<li class="heatbox">
					<a href="https://wordpress.org/themes/kirki/" target="_blank">
						<img src="<?php echo esc_url( KIRKI_PLUGIN_URL ); ?>/assets/images/kirki.jpg">
					</a>
					<div class="heatbox-content">
						<h3><?php _e( 'Page Builder Framework', 'kirki' ); ?></h3>
						<p class="subheadline"><?php _e( 'A modern, fast & minimalistic theme designed for the new WordPress Era.', 'kirki' ); ?></p>
						<p><?php _e( 'The theme was designed specifically to work with WordPress page builders, like Elementor, Beaver Builder & Brizy.', 'kirki' ); ?></p>
						<a href="https://wordpress.org/themes/kirki/" target="_blank" class="button"><?php _e( 'View Features', 'kirki' ); ?></a>
					</div>
				</li>
			</ul>

			<p class="credit"><?php _e( 'Made with ❤ in Aschaffenburg, Germany', 'kirki' ); ?></p>

		</div>

	</div>

	<?php
};
