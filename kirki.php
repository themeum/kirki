<?php
/*
Plugin Name: Kirki Framework
Plugin URI: http://wpmu.io
Description: An options framework using and extending the WordPress Customizer
Author: Aristeides Stathopoulos
Author URI: http://aristeides.com
Version: 0.2
*/


/**
 * Include the necessary files
 */
function kirki_customizer_include_files() {

	include_once( dirname( __FILE__ ) . '/includes/controls/checkbox.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/color.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/image.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/radio.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/select.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/sliderui.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/text.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/textarea.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/upload.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/number.php' );
	include_once( dirname( __FILE__ ) . '/includes/controls/multicheck.php' );

}
add_action( 'customize_register', 'kirki_customizer_include_files', 1 );


/**
 * Build the controls
 */
function kirki_customizer_controls( $wp_customize ) {

	$controls = apply_filters( 'kirki/controls', array() );

	if ( isset( $controls ) ) {
		foreach ( $controls as $control ) {

			// Add settings
			$wp_customize->add_setting( $control['setting'], array(
				'default'    => $control['default'],
				'type'       => 'theme_mod',
				'capability' => 'edit_theme_options'
			) );

			// Checkbox controls
			if ( 'checkbox' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Checkbox_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Color Controls
			} elseif ( 'color' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Color_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => isset( $control['priority'] ) ? $control['priority'] : '',
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Image Controls
			} elseif ( 'image' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Image_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Radio Controls
			} elseif ( 'radio' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Radio_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'mode'        => isset( $control['mode'] ) ? $control['mode'] : 'radio', // Can be 'radio', 'image' or 'buttonset'.
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Select Controls
			} elseif ( 'select' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Select_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Slider Controls
			} elseif ( 'slider' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Sliderui_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Text Controls
			} elseif ( 'text' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Text_Control( $wp_customize, $control['setting'], array(
						'label'       => isset( $control['label'] ) ? $control['label'] : '',
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Text Controls
			} elseif ( 'textarea' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Textarea_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Upload Controls
			} elseif ( 'upload' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Upload_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);

			// Number Controls
			} elseif ( 'number' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Number_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
					) )
				);

			// Multicheck Controls
			} elseif ( 'multicheck' == $control['type'] ) {

				$wp_customize->add_control( new Kirki_Customize_Multicheck_Control( $wp_customize, $control['setting'], array(
						'label'       => $control['label'],
						'section'     => $control['section'],
						'settings'    => $control['setting'],
						'priority'    => $control['priority'],
						'choices'     => $control['choices'],
						'description' => isset( $control['description'] ) ? $control['description'] : null,
						'subtitle'    => isset( $control['subtitle'] ) ? $control['subtitle'] : '',
						'separator'   => isset( $control['separator'] ) ? $control['separator'] : false,
						'required'    => isset( $control['required'] ) ? $control['required'] : array(),
					) )
				);
			}
		}
	}
}
add_action( 'customize_register', 'kirki_customizer_controls', 99 );


/**
 * Enqueue the stylesheets and scripts required.
 */
function kirki_enqueue_customizer_controls_styles() {

	$options = apply_filters( 'kirki/config', array() );

	$kirki_url = isset( $options['url_path'] ) ? $options['url_path'] : plugin_dir_url( __FILE__ );

	wp_register_style( 'kirki-customizer-css', $kirki_url . 'assets/css/customizer.css', NULL, NULL, 'all' );
	wp_register_style( 'kirki-customizer-ui',  $kirki_url . 'assets/css/jquery-ui-1.10.0.custom.css', NULL, NULL, 'all' );
	wp_enqueue_style( 'kirki-customizer-css' );
	wp_enqueue_style( 'kirki-customizer-ui' );

	wp_enqueue_script( 'kirki_customizer_js', $kirki_url . 'assets/js/customizer.js');
	wp_enqueue_script( 'tipsy', $kirki_url . 'assets/js/tooltipsy.min.js', array( 'jquery' ) );

}
add_action( 'customize_controls_print_styles', 'kirki_enqueue_customizer_controls_styles' );


/**
 * Use the Roboto font on the customizer.
 */
function kirki_googlefonts_styling() { ?>
	<link href='http://fonts.googleapis.com/css?family=Roboto:100,400|Roboto+Slab:700,400&subset=latin,cyrillic-ext,greek,vietnamese,latin-ext,cyrillic' rel='stylesheet' type='text/css'>
	<?php
}
add_action( 'customize_controls_print_styles', 'kirki_googlefonts_styling' );


/**
 * Add custom CSS rules to the head, applying our custom styles
 */
function kirki_custom_css() {

	$options = apply_filters( 'kirki/config', array() );

	$color_active = isset( $options['color_active'] ) ? $options['color_active'] : '#1abc9c';
	$color_accent = isset( $options['color_accent'] ) ? $options['color_accent'] : '#FF5740';
	$color_light  = isset( $options['color_light'] ) ? $options['color_light'] : '#8cddcd';
	$color_select = isset( $options['color_select'] ) ? $options['color_select'] : '#34495e';
	$color_back = isset( $options['color_back'] ) ? $options['color_back'] : '#222';
	?>

	<style>
		.wp-core-ui .button.tooltip {
			background: <?php echo $color_active; ?>;
		}

		.image.ui-buttonset label.ui-button.ui-state-active {
			background: <?php echo $color_accent; ?>;
		}

		.wp-full-overlay-sidebar {
			background: <?php echo $color_back; ?>;
		}

		#customize-info .accordion-section-title, #customize-info .accordion-section-title:hover {
			background: <?php echo $color_back; ?>;
		}

		#customize-theme-controls .accordion-section-title {
			background: <?php echo $color_back; ?>;
		}

		#customize-theme-controls .accordion-section-title {
			border-bottom: 1px solid <?php echo $color_back; ?>;
		}

		#customize-theme-controls .control-section .accordion-section-title {
			background: <?php echo $color_back; ?>;
		}

		#customize-theme-controls .control-section .accordion-section-title:focus,
		#customize-theme-controls .control-section .accordion-section-title:hover,
		#customize-theme-controls .control-section.open .accordion-section-title,
		#customize-theme-controls .control-section:hover .accordion-section-title {
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
add_action( 'customize_controls_print_styles', 'kirki_custom_css', 999 );

/**
 * If we've specified an image to be used as logo, replace the default theme description with a div that will have our logo as background.
 */
function kirki_custom_js() {

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
add_action( 'customize_controls_print_scripts', 'kirki_custom_js', 999 );
