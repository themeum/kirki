<?php
/**
 * Changes the styling of the customizer
 * based on the settings set using the kirki/config filter.
 * For documentation please see
 * https://github.com/aristath/kirki/wiki/Styling-the-Customizer
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_Customizer_Styling {

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		add_action( 'customize_controls_print_styles', array( $this, 'custom_css' ), 99 );
	}

	/**
	 * Add custom CSS rules to the head, applying our custom styles.
	 *
	 * @access public
	 */
	public function custom_css() {

		$config = apply_filters( 'kirki/config', array() );
		?>
		<style>
		.wp-full-overlay-sidebar,
		#customize-controls .customize-info .accordion-section-title,
		#customize-controls .panel-meta.customize-info .accordion-section-title:hover,
		#customize-theme-controls .accordion-section-title,
		.customize-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title:hover {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				background: <?php echo esc_attr( $config['color_back'] ); ?>;
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $text_color = ( 60 > $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness + 60 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness - 60 )->toCSS( $color_obj->mode ); ?>
				color: <?php echo esc_attr( $text_color ); ?>
			<?php endif; ?>
		}

		#customize-theme-controls .control-section-themes .accordion-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title:hover {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $text_color = ( 60 > $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness + 60 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness - 60 )->toCSS( $color_obj->mode ); ?>
				color: <?php echo esc_attr( $text_color ); ?>
			<?php endif; ?>
		}

		#customize-controls .control-section .accordion-section-title:focus,
		#customize-controls .control-section .accordion-section-title:hover,
		#customize-controls .control-section.open .accordion-section-title,
		#customize-controls .control-section:hover > .accordion-section-title,
		.customize-panel-back:focus,
		.customize-panel-back:hover,
		.customize-section-back:focus,
		.customize-section-back:hover {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $hover_color = ( 90 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 3 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 3 )->toCSS( $color_obj->mode ); ?>
				background: <?php echo esc_attr( $hover_color ); ?>;
			<?php endif; ?>
			<?php if ( isset( $config['color_accent'] ) ) : ?>
				color: <?php echo esc_attr( $config['color_accent'] ); ?>;
				border-left-color: <?php echo esc_attr( $config['color_accent'] ); ?>;
			<?php endif; ?>
		}

		#customize-controls .customize-info,
		#customize-header-actions,
		.customize-section-title {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 4 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 4 )->toCSS( $color_obj->mode ); ?>
				border-bottom-color: <?php echo esc_attr( $border_color ); ?>;
			<?php endif; ?>
		}

		.wp-full-overlay-sidebar .wp-full-overlay-header,
		.customize-controls-close,
		.expanded .wp-full-overlay-footer {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 15 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 15 )->toCSS( $color_obj->mode ); ?>
				<?php $bg_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 5 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 5 )->toCSS( $color_obj->mode ); ?>
				<?php $text_color = ( 60 > $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness + 60 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness - 60 )->toCSS( $color_obj->mode ); ?>
				color: <?php echo esc_attr( $text_color ); ?>;
				background-color: <?php echo esc_attr( $bg_color ); ?>;
				border-color: <?php echo esc_attr( $border_color ); ?>;
			<?php endif; ?>
		}

		.customize-controls-close:hover {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				background-color: <?php echo esc_attr( $config['color_back'] ); ?>;
			<?php endif; ?>
			<?php if ( isset( $config['color_accent'] ) ) : ?>
				color: <?php echo esc_attr( $config['color_accent'] ); ?>;
				border-color: <?php echo esc_attr( $config['color_accent'] ); ?>;
			<?php endif; ?>
		}

		#accordion-section-themes+.control-section,
		#customize-theme-controls .control-section:last-of-type.open,
		#customize-theme-controls .control-section:last-of-type > .accordion-section-title,
		#customize-theme-controls .control-section.open {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 4 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 4 )->toCSS( $color_obj->mode ); ?>
				border-bottom-color: <?php echo esc_attr( $border_color ); ?>;
				border-top-color: <?php echo esc_attr( $border_color ); ?>;
			<?php endif; ?>
		}

		#customize-theme-controls .accordion-section-title {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 4 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 4 )->toCSS( $color_obj->mode ); ?>
				border-bottom-color: <?php echo esc_attr( $border_color ); ?>;
			<?php endif; ?>
			border-bottom-color: <?php echo esc_attr( $border_color ); ?>;
			border-left-color: <?php echo esc_attr( $border_color ); ?>;
		}

		#customize-theme-controls .control-section-themes .accordion-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title:hover {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 4 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 4 )->toCSS( $color_obj->mode ); ?>
				border-bottom-color: <?php echo esc_attr( $border_color ); ?>;
			<?php endif; ?>
			border-top-color: <?php echo esc_attr( $border_color ); ?>;
			border-bottom-color: <?php echo esc_attr( $border_color ); ?>;
		}

		#customize-theme-controls .accordion-section-title:after {
			<?php if ( isset( $config['color_back'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_back'] ); ?>
				<?php $arrows_color = ( 50 > $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness + 30 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness - 30 )->toCSS( $color_obj->mode ); ?>
				color: <?php echo esc_attr( $arrows_color ); ?>;
			<?php endif; ?>
		}

		#customize-theme-controls .control-section .accordion-section-title:focus:after,
		#customize-theme-controls .control-section .accordion-section-title:hover:after,
		#customize-theme-controls .control-section.open .accordion-section-title:after,
		#customize-theme-controls .control-section:hover>.accordion-section-title:after {
			<?php if ( isset( $config['color_accent'] ) ) : ?>
				color: <?php echo esc_attr( $config['color_accent'] ); ?>;
			<?php endif; ?>
		}

		.wp-core-ui .button-primary {
			<?php if ( isset( $config['color_accent'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_accent'] ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness -15 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 15 )->toCSS( $color_obj->mode ); ?>
				<?php $text_color = ( 60 > $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness + 60 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness - 60 )->toCSS( $color_obj->mode ); ?>
				background-color: <?php echo esc_attr( $config['color_accent'] ); ?>;
				border-color: <?php echo esc_attr( $border_color ); ?>;
				box-shadow: 0 1px 0 <?php echo esc_attr( $border_color ); ?>;
				-webkit-box-shadow: 0 1px 0 <?php echo esc_attr( $border_color ); ?>;
				text-shadow: 0 -1px 1px <?php echo esc_attr( $border_color ); ?>, 1px 0 1px <?php echo esc_attr( $border_color ); ?>, 0 1px 1px <?php echo esc_attr( $border_color ); ?>, -1px 0 1px <?php echo esc_attr( $border_color ); ?>;
				color: <?php echo esc_attr( $text_color ); ?>;
			<?php endif; ?>
		}

		.wp-core-ui .button-primary.focus,
		.wp-core-ui .button-primary.hover,
		.wp-core-ui .button-primary:focus,
		.wp-core-ui .button-primary:hover {
			<?php if ( isset( $config['color_accent'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_accent'] ); ?>
				<?php $color_obj = ( 90 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 3 ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 3 ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 15 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 15 )->toCSS( $color_obj->mode ); ?>
				<?php $text_color = ( 60 > $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness + 60 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness - 60 )->toCSS( $color_obj->mode ); ?>
				background-color: <?php echo esc_attr( $color_obj->toCSS( $color_obj->mode ) ); ?>;
				border-color: <?php echo esc_attr( $border_color ); ?>;
				box-shadow: 0 1px 0 <?php echo esc_attr( $border_color ); ?>;
				-webkit-box-shadow: 0 1px 0 <?php echo esc_attr( $border_color ); ?>;
				text-shadow: 0 -1px 1px <?php echo esc_attr( $border_color ); ?>, 1px 0 1px <?php echo esc_attr( $border_color ); ?>, 0 1px 1px <?php echo esc_attr( $border_color ); ?>, -1px 0 1px <?php echo esc_attr( $border_color ); ?>;
				color: <?php echo esc_attr( $text_color ); ?>;
			<?php endif; ?>
		}

		.wp-core-ui .button-primary-disabled,
		.wp-core-ui .button-primary.disabled,
		.wp-core-ui .button-primary:disabled,
		.wp-core-ui .button-primary[disabled] {
			<?php if ( isset( $config['color_accent'] ) ) : ?>
				<?php $color_obj = ariColor::newColor( $config['color_accent'] ); ?>
				<?php $color_obj = ( 35 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness - 30 ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 30 ); ?>
				<?php $border_color = ( 50 < $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness -15 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness + 15 )->toCSS( $color_obj->mode ); ?>
				<?php $text_color = ( 60 > $color_obj->lightness ) ? $color_obj->getNew( 'lightness', $color_obj->lightness + 60 )->toCSS( $color_obj->mode ) : $color_obj->getNew( 'lightness', $color_obj->lightness - 60 )->toCSS( $color_obj->mode ); ?>
				background-color: <?php echo esc_attr( $color_obj->toCSS( $color_obj->mode ) ); ?> !important;
				border-color: <?php echo esc_attr( $border_color ); ?> !important;
				box-shadow: 0 1px 0 <?php echo esc_attr( $border_color ); ?> !important;
				-webkit-box-shadow: 0 1px 0 <?php echo esc_attr( $border_color ); ?> !important;
				text-shadow: 0 -1px 1px <?php echo esc_attr( $border_color ); ?>, 1px 0 1px <?php echo esc_attr( $border_color ); ?>, 0 1px 1px <?php echo esc_attr( $border_color ); ?>, -1px 0 1px <?php echo esc_attr( $border_color ); ?> !important;
				color: <?php echo esc_attr( $text_color ); ?> !important;
			<?php endif; ?>
		}
		<?php if ( isset( $config['color_back'] ) ) : ?>
			.wp-full-overlay-footer .devices {
				background: none;
				background: transparent;
				box-shadow: none;
				-webkit-box-shadow: none;
			}
		<?php endif; ?>
		<?php if ( isset( $config['width'] ) ) : ?>
			.wp-full-overlay-sidebar {
			  width: <?php echo esc_attr( $config['width'] ); ?>;
			}
			.expanded .wp-full-overlay-footer {
				<?php if ( false === strpos( $config['width'], 'calc' ) ) : ?>
					width: calc(<?php echo esc_attr( $config['width'] ); ?> - 1px);
				<?php else : ?>
					width: <?php echo esc_attr( $config['width'] ); ?>
				<?php endif; ?>
			}

			.wp-full-overlay.expanded {
				margin-left: <?php echo esc_attr( $config['width'] ); ?>;
			}
			.wp-full-overlay.collapsed .wp-full-overlay-sidebar {
				margin-left: -<?php echo esc_attr( $config['width'] ); ?>;
			}
		<?php endif; ?>

		</style>
		<?php

	}
}
