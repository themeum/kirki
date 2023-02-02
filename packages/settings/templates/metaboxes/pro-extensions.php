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
		<a href="https://kirki.org/extensions/?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki" target="_blank" style="float: right;"><?php _e( 'Upgrade Now', 'kirki' ); ?></a>
	</h2>

	<ul class="pro-extensions-list">

		<?php

			$premium_features = array(
				array(
					'title'       => __( 'Kirki Tabs', 'kirki' ),
					'description' => __( 'Tabs are the easiest way to better organize your WordPress Customizer controls.', 'kirki' ),
					'link'        => 'https://kirki.org/downloads/tabs?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki',
				),
				array(
					'title'       => __( 'Kirki Input Slider', 'kirki' ),
					'description' => __( 'The Input Slider is a hybrid field, combining a slider & input field into one universal control.', 'kirki' ),
					'link'        => 'https://kirki.org/downloads/input-slider?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki',
				),
				array(
					'title'       => __( 'Kirki Responsive Control', 'kirki' ),
					'description' => __( 'The Responsive Controls extension allows you to turn controls into responsive controls.', 'kirki' ),
					'link'        => 'https://kirki.org/downloads/responsive-controls?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki',
				),
				array(
					'title'       => __( 'Kirki Headline & Dividers', 'kirki' ),
					'description' => __( 'The Headlines & Dividers extension is a powerful tool to better structure your customizer controls.', 'kirki' ),
					'link'        => 'https://kirki.org/downloads/headlines-dividers?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki',
				),
				array(
					'title'       => __( 'Kirki Margin & Padding', 'kirki' ),
					'description' => __( 'Unlike the Dimensions control, the Padding & Margin control consists of 4 numeric input fields which share the same unit (px, %, em, etc.) across the board.', 'kirki' ),
					'link'        => 'https://kirki.org/downloads/margin-padding?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki',
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
				<a href="https://wp-pagebuilderframework.com/premium/?utm_source=repository&utm_medium=settings_page&utm_campaign=kirki" target="_blank" class="button button-larger button-primary"><?php _e( 'Learn More', 'kirki' ); ?></a>
			</div>
		</li>

	</ul>

</div>
