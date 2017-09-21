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

// @codingStandardsIgnoreFile

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_Customizer_Styling {

	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor.
	 *
	 * @access protected
	 */
	protected function __construct() {
		add_action( 'customize_controls_print_styles', array( $this, 'custom_css' ), 99 );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add custom CSS rules to the head, applying our custom styles.
	 *
	 * @access public
	 */
	public function custom_css() {

		$config = apply_filters( 'kirki/config', array() );
		if ( ! isset( $config['color_accent'] ) && ! isset( $config['color_back'] ) ) {
			return;
		}
		$back     = isset( $config['color_back'] ) ? $config['color_back'] : false;

		$text_on_back              = '';
		$border_on_back            = '';
		$back_on_back              = '';
		$hover_on_back             = '';
		$arrows_on_back            = '';
		$text_on_accent            = '';
		$border_on_accent          = '';
		$accent_disabled_obj       = '';
		$accent_disabled           = '';
		$text_on_accent_disabled   = '';
		$border_on_accent_disabled = '';

		if ( $back ) {
			$back_obj       = ariColor::newColor( $back );
			$text_on_back   = ( 60 > $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness + 60 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness - 60 )->toCSS( $back_obj->mode );
			$border_on_back = ( 80 < $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness - 13 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness + 13 )->toCSS( $back_obj->mode );
			$back_on_back   = ( 90 < $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness - 6 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness + 11 )->toCSS( $back_obj->mode );
			$hover_on_back  = ( 90 < $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness - 3 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness + 3 )->toCSS( $back_obj->mode );
			$arrows_on_back = ( 50 > $back_obj->lightness ) ? $back_obj->getNew( 'lightness', $back_obj->lightness + 30 )->toCSS( $back_obj->mode ) : $back_obj->getNew( 'lightness', $back_obj->lightness - 30 )->toCSS( $back_obj->mode );
		}
		$accent     = ( isset( $config['color_accent'] ) ) ? $config['color_accent'] : false;
		if ( $accent ) {
			$accent_obj                = ariColor::newColor( $accent );
			$text_on_accent            = ( 60 > $accent_obj->lightness ) ? $accent_obj->getNew( 'lightness', $accent_obj->lightness + 60 )->toCSS( $accent_obj->mode ) : $accent_obj->getNew( 'lightness', $accent_obj->lightness - 60 )->toCSS( $accent_obj->mode );
			$border_on_accent          = ( 50 < $accent_obj->lightness ) ? $accent_obj->getNew( 'lightness', $accent_obj->lightness - 4 )->toCSS( $accent_obj->mode ) : $accent_obj->getNew( 'lightness', $accent_obj->lightness + 4 )->toCSS( $accent_obj->mode );
			$accent_disabled_obj       = ( 35 < $accent_obj->lightness ) ? $accent_obj->getNew( 'lightness', $accent_obj->lightness - 30 ) : $accent_obj->getNew( 'lightness', $accent_obj->lightness + 30 );
			$accent_disabled           = $accent_disabled_obj->toCSS( $accent_disabled_obj->mode );
			$text_on_accent_disabled   = ( 60 > $accent_disabled_obj->lightness ) ? $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness + 60 )->toCSS( $accent_disabled_obj->mode ) : $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness - 60 )->toCSS( $accent_disabled_obj->mode );
			$border_on_accent_disabled = ( 50 < $accent_disabled_obj->lightness ) ? $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness - 4 )->toCSS( $accent_disabled_obj->mode ) : $accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness + 4 )->toCSS( $accent_disabled_obj->mode );
		}
		?>
		<style>
		.wp-full-overlay-sidebar,
		#customize-controls .customize-info .accordion-section-title,
		#customize-controls .panel-meta.customize-info .accordion-section-title:hover,
		#customize-theme-controls .accordion-section-title,
		.customize-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title:hover {
			background: <?php echo $back; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		#customize-controls .customize-info .panel-title,
		#customize-controls .customize-pane-child .customize-section-title h3,
		#customize-controls .customize-pane-child h3.customize-section-title,
		.customize-control,
		#customize-controls .description {
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		#customize-controls .customize-info,
		#customize-header-actions,
		.customize-section-title {
			border-bottom-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
		}

		.wp-full-overlay-sidebar .wp-full-overlay-header,
		.customize-controls-close,
		.expanded .wp-full-overlay-footer {
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
			background-color: <?php echo $back_on_back; // WPCS: XSS ok. ?>;
			border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
		}

		.accordion-section,
		#customize-theme-controls .customize-pane-child.accordion-section-content {
			background: <?php echo $back_on_back; // WPCS: XSS ok. ?>;
		}

		#accordion-section-themes+.control-section,
		#customize-theme-controls .control-section:last-of-type.open,
		#customize-theme-controls .control-section:last-of-type > .accordion-section-title,
		#customize-theme-controls .control-section.open {
			border-bottom-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			border-top-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
		}

		#customize-theme-controls .accordion-section-title {
			border-bottom-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			border-left-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
		}

		#customize-theme-controls .control-section-themes .accordion-section-title,
		#customize-theme-controls .control-section-themes .accordion-section-title:hover {
			border-bottom-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			border-top-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			border-bottom-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
		}

		#customize-theme-controls .accordion-section-title:after {
			color: <?php echo $arrows_on_back; // WPCS: XSS ok. ?>;
		}

		.wp-core-ui .button,
		.wp-core-ui .button-secondary {
			background-color: <?php echo $back; // WPCS: XSS ok. ?>;
			border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			-webkit-box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			text-shadow: 0 -1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 0 1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, -1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		@media screen and (max-width: 640px) {
			.customize-controls-preview-toggle{
				background-color: <?php echo $back; // WPCS: XSS ok. ?>;
				border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				box-shadow:0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				-webkit-box-shadow:0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				text-shadow:0 -1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 0 1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, -1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
			}
		}

		.wp-core-ui .button.focus,
		.wp-core-ui .button.hover,
		.wp-core-ui .button:focus,
		.wp-core-ui .button:hover,
		.wp-core-ui .button-secondary.focus,
		.wp-core-ui .button-secondary.hover,
		.wp-core-ui .button-secondary:focus,
		.wp-core-ui .button-secondary:hover,
		.customize-panel-back,
		.customize-section-back {
			background-color: <?php echo $back_on_back; // WPCS: XSS ok. ?>;
			border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			-webkit-box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			text-shadow: 0 -1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 0 1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, -1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		@media screen and (max-width: 640px) {
			.customize-controls-preview-toggle.focus,
			.customize-controls-preview-toggle.hover,
			.customize-controls-preview-toggle:focus,
			.customize-controls-preview-toggle:hover {
				background-color: <?php echo $back_on_back; // WPCS: XSS ok. ?>;
				border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				-webkit-box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				text-shadow: 0 -1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, 0 1px 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>, -1px 0 1px <?php echo $border_on_back; // WPCS: XSS ok. ?>;
				color:<?php echo $text_on_back; // WPCS: XSS ok. ?>;
			}
		}

		.customize-control-kirki-background .background-attachment .buttonset .switch-label,
		.customize-control-kirki-background .background-size .buttonset .switch-label,
		.customize-control-kirki-radio-buttonset .buttonset .switch-label {
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		.wp-color-result {
			border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			-webkit-box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			box-shadow: 0 1px 0 <?php echo $border_on_back; // WPCS: XSS ok. ?>;
		}

		.wp-color-result:focus,
		.wp-color-result:hover {
			border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			background: <?php echo $back_on_back; // WPCS: XSS ok. ?>;
		}

		.wp-color-result:after {
			border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			background: <?php echo $back; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		.wp-color-result:focus:after,
		.wp-color-result:hover:after {
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		.customize-control input[type=tel],
		.customize-control input[type=url],
		.customize-control input[type=text],
		.customize-control input[type=password],
		.customize-control input[type=email],
		.customize-control input[type=number],
		.customize-control input[type=search],
		.customize-control input[type=radio],
		.customize-control input[type=checkbox],
		.customize-control select,
		.select2-container--default .select2-selection--single,
		.select2-container--default .select2-selection--multiple {
			background: <?php echo $back; // WPCS: XSS ok. ?>;
			border-color: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		.customize-control-kirki-slider input[type=range]::-webkit-slider-thumb {
			background-color:<?php echo $accent; // WPCS: XSS ok. ?>;
		}

		.customize-control-kirki-slider input[type=range]::-moz-range-thumb {
			background-color: <?php echo $accent; // WPCS: XSS ok. ?>;
		}

		.customize-control-kirki-slider input[type=range]::-ms-thumb {
			background-color: <?php echo $accent; // WPCS: XSS ok. ?>;
		}

		.customize-control-kirki-slider input[type=range] {
			background: <?php echo $border_on_back; // WPCS: XSS ok. ?>;
		}

		.select2-container--default .select2-selection--single .select2-selection__rendered {
			color:<?php echo $text_on_back; // WPCS: XSS ok. ?>;
		}

		.wp-full-overlay-footer .devices {
			background: none;
			background: transparent;
			box-shadow: none;
			-webkit-box-shadow: none;
		}

		.kirki-reset-section .dashicons {
			color: <?php echo $back_on_back; // WPCS: XSS ok. ?>;
		}

		#customize-controls .control-section .accordion-section-title:focus,
		#customize-controls .control-section .accordion-section-title:hover,
		#customize-controls .control-section.open .accordion-section-title,
		#customize-controls .control-section:hover > .accordion-section-title,
		.customize-panel-back:focus,
		.customize-panel-back:hover,
		.customize-section-back:focus,
		.customize-section-back:hover {
			background: <?php echo $hover_on_back; // WPCS: XSS ok. ?>;
			color: <?php echo $accent; // WPCS: XSS ok. ?>;
			border-left-color: <?php echo $accent; // WPCS: XSS ok. ?>;
		}

		.customize-controls-close:hover {
			background-color: <?php echo $back; // WPCS: XSS ok. ?>;
			color: <?php echo $accent; // WPCS: XSS ok. ?>;
			border-color: <?php echo $accent; // WPCS: XSS ok. ?>;
		}

		#customize-theme-controls .control-section .accordion-section-title:focus:after,
		#customize-theme-controls .control-section .accordion-section-title:hover:after,
		#customize-theme-controls .control-section.open .accordion-section-title:after,
		#customize-theme-controls .control-section:hover>.accordion-section-title:after {
			color: <?php echo $accent; // WPCS: XSS ok. ?>;
		}

		.wp-core-ui .button.button-primary {
			background-color: <?php echo $accent; // WPCS: XSS ok. ?>;
			border-color: <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			box-shadow: 0 1px 0 <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			-webkit-box-shadow: 0 1px 0 <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			text-shadow: 0 -1px 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>, 1px 0 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>, 0 1px 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>, -1px 0 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_accent; // WPCS: XSS ok. ?>;
		}

		.wp-core-ui .button.button-primary.focus,
		.wp-core-ui .button.button-primary.hover,
		.wp-core-ui .button.button-primary:focus,
		.wp-core-ui .button.button-primary:hover {
			background-color: <?php echo $accent; // WPCS: XSS ok. ?>;
			border-color: <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			box-shadow: 0 1px 0 <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			-webkit-box-shadow: 0 1px 0 <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			text-shadow: 0 -1px 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>, 1px 0 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>, 0 1px 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>, -1px 0 1px <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_accent; // WPCS: XSS ok. ?>;
		}

		.wp-core-ui .button.button-primary-disabled,
		.wp-core-ui .button.button-primary.disabled,
		.wp-core-ui .button.button-primary:disabled,
		.wp-core-ui .button.button-primary[disabled] {
			background-color: <?php echo $accent_disabled; // WPCS: XSS ok. ?> !important;
			border-color: <?php echo $border_on_accent_disabled; // WPCS: XSS ok. ?> !important;
			box-shadow: 0 1px 0 <?php echo $border_on_accent_disabled; // WPCS: XSS ok. ?> !important;
			-webkit-box-shadow: 0 1px 0 <?php echo $border_on_accent_disabled; // WPCS: XSS ok. ?> !important;
			text-shadow: 0 -1px 1px <?php echo $border_on_accent_disabled; // WPCS: XSS ok. ?>, 1px 0 1px <?php echo $border_on_accent_disabled; // WPCS: XSS ok. ?>, 0 1px 1px <?php echo $border_on_accent_disabled; // WPCS: XSS ok. ?>, -1px 0 1px <?php echo $border_on_accent_disabled; // WPCS: XSS ok. ?> !important;
			color: <?php echo $text_on_accent_disabled; // WPCS: XSS ok. ?> !important;
		}

		input[type=checkbox]:checked:before {
			color: <?php echo $accent; // WPCS: XSS ok. ?>;
		}

		.select2-container--default .select2-results__option--highlighted[aria-selected] {
			background-color: <?php echo $accent; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_accent; // WPCS: XSS ok. ?>;
		}

		.customize-control-kirki-radio-buttonset .buttonset .switch-input:checked + .switch-label,
		.customize-control-kirki-background .background-attachment .buttonset .switch-input:checked + .switch-label,
		.customize-control-kirki-background .background-size .buttonset .switch-input:checked + .switch-label {
			background-color: <?php echo $accent; // WPCS: XSS ok. ?>;
			border-color: <?php echo $border_on_accent; // WPCS: XSS ok. ?>;
			color: <?php echo $text_on_accent; // WPCS: XSS ok. ?>;
		}

		<?php if ( isset( $config['width'] ) ) : ?>
			.wp-full-overlay-sidebar {
				width: <?php echo esc_attr( $config['width'] ); // WPCS: XSS ok. ?>;
			}
			.expanded .wp-full-overlay-footer {
				width: <?php echo esc_attr( $config['width'] ); // WPCS: XSS ok. ?>;
			}
			.wp-full-overlay.expanded {
				margin-left: <?php echo esc_attr( $config['width'] ); // WPCS: XSS ok. ?>;
			}
			.wp-full-overlay.collapsed .wp-full-overlay-sidebar {
				margin-left: -<?php echo esc_attr( $config['width'] ); // WPCS: XSS ok. ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
}
