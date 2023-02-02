<?php
/**
 * Metabox template for displaying pro extensions.
 *
 * @package Page Builder Framework
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );
?>

<div class="heatbox pro-extensions-metabox">

	<h2>
		<?php _e( 'PRO Extensions', 'kirki' ); ?>
		<a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf" target="_blank" style="float: right;"><?php _e( 'Upgrade Now', 'kirki' ); ?></a>
	</h2>

	<ul class="pro-extensions-list">

		<?php

			$premium_features = array(
				array(
					'title'       => __( 'Transparent Header', 'kirki' ),
					'description' => __( 'Create a customizable Transparent Header with just a few clicks.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Sticky Navigation', 'kirki' ),
					'description' => __( 'Create a beautiful & fully customizable Sticky Navigation in seconds.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/premium/?video=stickynav&utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf#premium',
				),
				array(
					'title'       => __( 'White Label Settings', 'kirki' ),
					'description' => __( 'Your theme, your branding. Fully white label Page Builder Framework & the Premium Add-On.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/white-label/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Advanced Typography', 'kirki' ),
					'description' => __( 'Customize fonts and add Typekit- & Custom Fonts to your website.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/advanced-typography/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Adjustable Breakpoints', 'kirki' ),
					'description' => __( 'Set custom responsive breakpoints for tablets, desktops & mobiles for a pixel perfect design.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/custom-responsive-breakpoints/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Advanced WooCommerce Features', 'kirki' ),
					'description' => __( 'Take full control over the design of your online store with more advanced WooCommerce features.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/free-woocommerce-theme/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf#premium',
				),
				array(
					'title'       => __( 'Mega Menu', 'kirki' ),
					'description' => __( 'Easily create an advanced mega menu with up to 4 rows.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/mega-menu/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
				),
				array(
					'title'       => __( 'Call to Action Button', 'kirki' ),
					'description' => __( 'Add a customizable Call to Action Button to your navigation with just a few clicks.', 'kirki' ),
					'link'        => 'https://wp-pagebuilderframework.com/docs/call-to-action-button/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf',
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
					<?php _e( 'Check out all the Premium Add-On features.', 'kirki' ); ?>
				</p>
			</div>
			<div class="pro-extensions-list-icon">
				<a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=theme_settings&utm_campaign=wpbf" target="_blank" class="button button-larger button-primary"><?php _e( 'Learn More', 'kirki' ); ?></a>
			</div>
		</li>

	</ul>

</div>
