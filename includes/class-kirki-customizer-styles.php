<?php

class Kirki_Customizer_Styles extends Kirki {

	function __construct() {
		add_action( 'customize_controls_print_styles', array( $this, 'custom_css' ), 999 );
		add_action( 'customize_controls_print_styles', array( $this, 'customizer_styles' ) );
	}


	/**
	 * Enqueue the stylesheets required.
	 */
	function customizer_styles() {

		$config = $this->config;

		$kirki_url = isset( $config['url_path'] ) ? $config['url_path'] : KIRKI_URL;

		wp_enqueue_style( 'kirki-customizer-css', $kirki_url . 'assets/css/customizer.css', NULL, '0.5' );
		wp_enqueue_style( 'hint-css', $kirki_url . 'assets/css/hint.css', NULL, '1.3.3' );
		wp_enqueue_style( 'kirki-customizer-ui',  $kirki_url . 'assets/css/jquery-ui-1.10.0.custom.css', NULL, '1.10.0' );

	}


	/**
	 * Add custom CSS rules to the head, applying our custom styles
	 */
	function custom_css() {

		$color   = $this->get_admin_colors();
		$config = $this->config;

		$color_font    = false;
		$color_active  = isset( $config['color_active'] )  ? $config['color_active']  : $color['colors'][3];
		$color_light   = isset( $config['color_light'] )   ? $config['color_light']   : $color['colors'][2];
		$color_select  = isset( $config['color_select'] )  ? $config['color_select']  : $color['colors'][3];
		$color_accent  = isset( $config['color_accent'] )  ? $config['color_accent']  : $color['icon_colors']['focus'];
		$color_back    = isset( $config['color_back'] )    ? $config['color_back']    : false;

		if ( $color_back ) {
			$color_font = ( 170 > kirki_get_brightness( $color_back ) ) ? '#f2f2f2' : '#222';
		}

		?>

		<style>
		.wp-core-ui .button.tooltip {
			background: <?php echo $color_select; ?>;
			color: #fff;
		}

		.image.ui-buttonset label.ui-button.ui-state-active {
			background: <?php echo $color_select; ?>;
		}

		<?php if ( $color_back ) : ?>

			.wp-full-overlay-sidebar,
			#customize-info .accordion-section-title,
			#customize-info .accordion-section-title:hover,
			#customize-theme-controls .accordion-section-title,
			#customize-theme-controls .control-section .accordion-section-title {
				background: <?php echo $color_back; ?>;
				<?php if ( $color_font ) : ?>color: <?php echo $color_font; ?>;<?php endif; ?>
			}
			<?php if ( $color_font ) : ?>
				#customize-theme-controls .control-section .accordion-section-title:focus,
				#customize-theme-controls .control-section .accordion-section-title:hover,
				#customize-theme-controls .control-section.open .accordion-section-title,
				#customize-theme-controls .control-section:hover .accordion-section-title {
					color: <?php echo $color_font; ?>;
				}
				<?php endif; ?>

			<?php if ( 170 > Kirki_Color::get_brightness( $color_back ) ) : ?>
				.control-section.control-panel>.accordion-section-title:after {
					background: #111;
					color: #f5f5f5;
					border-left: 1px solid #000;
				}
				#customize-theme-controls .control-section.control-panel>h3.accordion-section-title:focus:after,
				#customize-theme-controls .control-section.control-panel>h3.accordion-section-title:hover:after {
					background: #222;
					color: #fff;
					border: 1px solid #222;
				}

				.control-panel-back,
				.customize-controls-close {
					background: #111 !important;
					border-right: 1px solid #111 !important;
				}
				.control-panel-back:before,
				.control-panel-back:after,
				.customize-controls-close:before,
				.customize-controls-close:after {
					color: #f2f2f2 !important;
				}
				.control-panel-back:focus:before,
				.control-panel-back:hover:before,
				.customize-controls-close:focus:before,
				.customize-controls-close:hover:before {
					background: #000;
					color: #fff;
				}
				#customize-header-actions {
					border-bottom: 1px solid #111;
				}
			<?php endif; ?>

		<?php endif; ?>

		.ui-state-default,
		.ui-widget-content .ui-state-default,
		.ui-widget-header .ui-state-default,
		.ui-state-active.ui-button.ui-widget.ui-state-default {
			background-color: <?php echo $color_active; ?>;
			border: 1px solid rgba(0,0,0,.05);
		}

		.ui-button.ui-widget.ui-state-default {
			background-color: #f2f2f2;
		}

		#customize-theme-controls .accordion-section-title {
			border-bottom: 1px solid rgba(0,0,0,.1);
		}

		#customize-theme-controls .control-section .accordion-section-title:focus,
		#customize-theme-controls .control-section .accordion-section-title:hover,
		#customize-theme-controls .control-section.open .accordion-section-title,
		#customize-theme-controls .control-section:hover .accordion-section-title {
			background: <?php echo $color_active; ?>;
		}
		ul.ui-sortable li.kirki-sortable-item {
			border: 1px solid <?php echo $color_active; ?>;
		}

		.Switch span.On,
		ul.ui-sortable li.kirki-sortable-item .visibility {
			color: <?php echo $color_active; ?>;
		}

		#customize-theme-controls .control-section.control-panel.current-panel:hover .accordion-section-title{
			background: none;
		}

		.Switch.Round.On .Toggle,
		#customize-theme-controls .control-section.control-panel.current-panel .accordion-section-title:hover{
			background: <?php echo $color_active; ?>;
		}

		.wp-core-ui .button-primary {
			background: <?php echo $color_active; ?>;
		}

		.wp-core-ui .button-primary.focus,
		.wp-core-ui .button-primary.hover,
		.wp-core-ui .button-primary:focus,
		.wp-core-ui .button-primary:hover {
			background: <?php echo $color_select; ?>;
		}

		.wp-core-ui .button-primary-disabled,
		.wp-core-ui .button-primary.disabled,
		.wp-core-ui .button-primary:disabled,
		.wp-core-ui .button-primary[disabled] {
			background: <?php echo $color_light; ?> !important;
			color: <?php echo $color_select; ?> !important;
		}

		.customize-control input[type="text"]:focus {
			border-color: <?php echo $color_active; ?>;
		}

		.wp-core-ui.wp-customizer .button,
		.press-this.wp-core-ui .button,
		.press-this input#publish,
		.press-this input#save-post,
		.press-this a.preview {
			background-color: <?php echo $color_accent; ?>;
		}

		.wp-core-ui.wp-customizer .button:hover,
		.press-this.wp-core-ui .button:hover,
		.press-this input#publish:hover,
		.press-this input#save-post:hover,
		.press-this a.preview:hover {
			background-color: <?php echo $color_accent; ?>;
		}
		</style>
		<?php
	}

	/**
	 * Get the admin color theme
	 */
	function get_admin_colors() {

		// Get the active admin theme
		global $_wp_admin_css_colors;

		// Get the user's admin colors
		$color = get_user_option( 'admin_color' );
		// If no theme is active set it to 'fresh'
		if ( empty( $color ) || ! isset( $_wp_admin_css_colors[$color] ) ) {
			$color = 'fresh';
		}

		$color = (array) $_wp_admin_css_colors[$color];

		return $color;

	}

}
