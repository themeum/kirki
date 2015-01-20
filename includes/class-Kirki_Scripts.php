<?php

class Kirki_Scripts {

	function __construct() {
		add_action( 'customize_controls_print_styles', array( $this, 'scripts' ) );
		add_action( 'customize_controls_print_styles', array( $this, 'googlefonts' ) );
		add_action( 'customize_controls_print_scripts', array( $this, 'custom_js' ), 999 );
		add_action( 'customize_controls_print_styles', array( $this, 'custom_css' ), 999 );
		// TODO: This is not perfect under ANY circumstances.
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'postmessage' ), 21 );

		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_styles' ) );
	}

	/**
	 * Enqueue the stylesheets and scripts required.
	 */
	function scripts() {

		global $kirki;
		$options = $kirki->get_config();

		$kirki_url = isset( $options['url_path'] ) ? $options['url_path'] : KIRKI_URL;

		wp_enqueue_style( 'kirki-customizer-css', $kirki_url . 'assets/css/customizer.css', NULL, '0.5' );
		wp_enqueue_style( 'hint-css', $kirki_url . 'assets/css/hint.css', NULL, '1.3.3' );
		wp_enqueue_style( 'kirki-customizer-ui',  $kirki_url . 'assets/css/jquery-ui-1.10.0.custom.css', NULL, '1.10.0' );

		// wp_enqueue_script( 'kirki_customizer_js', $kirki_url . 'assets/js/customizer.js');
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tooltip' );

	}

	/**
	 * Add a dummy, empty stylesheet if no stylesheet_id has been defined and we need one.
	 */
	function frontend_styles() {

		global $kirki;
		$config   = $kirki->get_config();
		$controls = $kirki->get_controls();

		foreach( $controls as $control ) {
			if ( isset( $control['output'] ) ) {
				$uses_output = true;
			}
		}

		if ( isset( $uses_output ) && ! isset( $config['stylesheet_id'] ) ) {
			wp_enqueue_style( 'kirki-styles', $kirki_url . 'assets/css/kirki-styles.css', NULL, NULL );
		}

	}

	/**
	 * Use the Roboto font on the customizer.
	 */
	function googlefonts() { ?>
		<link href='//fonts.googleapis.com/css?family=Roboto:100,400|Roboto+Slab:700,400&subset=latin,cyrillic-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
		<?php
	}


	/**
	 * If we've specified an image to be used as logo, replace the default theme description with a div that will have our logo as background.
	 */
	function custom_js() {

		$options = apply_filters( 'kirki/config', array() ); ?>

		<?php if ( isset( $options['logo_image'] ) ) : ?>
			<script>
			jQuery(document).ready(function($) {
				"use strict";

				$( 'div#customize-info' ).replaceWith( '<div class="kirki-customizer"></div>' );
			});
			</script>
		<?php endif;

	}

	/**
	* Get the admin color theme
	*/
	public static function admin_colors() {

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

	/**
	* Add custom CSS rules to the head, applying our custom styles
	*/
	function custom_css() {

		global $kirki;

		$color   = self::admin_colors();
		$options = $kirki->get_config();

		$color_font    = false;
		$color_active  = isset( $options['color_active'] )  ? $options['color_active']  : $color['colors'][3];
		$color_light   = isset( $options['color_light'] )   ? $options['color_light']   : $color['colors'][2];
		$color_select  = isset( $options['color_select'] )  ? $options['color_select']  : $color['colors'][3];
		$color_accent  = isset( $options['color_accent'] )  ? $options['color_accent']  : $color['icon_colors']['focus'];
		$color_back    = isset( $options['color_back'] )    ? $options['color_back']    : false;

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
		#customize-theme-controls .control-section.control-panel.current-panel:hover .accordion-section-title{
			background: none;
		}

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

		<?php if ( isset( $options['logo_image'] ) ) : ?>
			div.kirki-customizer {
				background: url("<?php echo $options['logo_image']; ?>") no-repeat left center;
			}
		<?php endif; ?>
		</style>
		<?php
	}

	/**
	* Try to automatically generate the script necessary for postMessage to work.
	* Something like this will have to be added to the control arguments:
	*
	* 'transport' => 'postMessage',
	* 'js_vars'   => array(
	* 		'element'  => 'body',
	* 		'type'     => 'css',
	* 		'property' => 'color',
	* 	),
	*
	*/
	function postmessage() {

		global $kirki;
		$controls = $kirki->get_controls();

		$script = '';

		foreach ( $controls as $control ) {

			if ( isset( $control['transport']  ) && isset( $control['js_vars'] ) && 'postMessage' == $control['transport'] ) {

				$script .= '<script type="text/javascript">jQuery(document).ready(function( $ ) {';
				$script .= 'wp.customize("' . $control['setting'] . '",function( value ) {';

				if ( isset( $control['js_vars']['type'] ) && 'css' == $control['js_vars']['type'] ) {
					$script .= 'value.bind(function(to) {';
					$script .= '$("' . $control['js_vars']['element'] . '").css("' . $control['js_vars']['property'] . '", to ? to : "" );';
					$script .= '});';
				}

				$script .= '});});</script>';

			}

		}

		echo $script;

	}

}
