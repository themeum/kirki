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

		$css = '';

		$config = apply_filters( 'kirki/config', array() );
		if ( ! isset( $config['color_accent'] ) && ! isset( $config['color_back'] ) ) {
			return;
		}
		$back     = isset( $config['color_back'] ) ? $config['color_back'] : false;
		$back_obj = ( $back ) ? ariColor::newColor( $back ) : false;
		if ( $back ) {
			$text_on_back = ( 60 > $back_obj->lightness ) ?
				$back_obj->getNew( 'lightness', $back_obj->lightness + 60 )->toCSS( $back_obj->mode ) :
				$back_obj->getNew( 'lightness', $back_obj->lightness - 60 )->toCSS( $back_obj->mode );
			$border_on_back = ( 80 < $back_obj->lightness ) ?
				$back_obj->getNew( 'lightness', $back_obj->lightness - 13 )->toCSS( $back_obj->mode ) :
				$back_obj->getNew( 'lightness', $back_obj->lightness + 13 )->toCSS( $back_obj->mode );
			$back_on_back = ( 90 < $back_obj->lightness ) ?
				$back_obj->getNew( 'lightness', $back_obj->lightness - 6 )->toCSS( $back_obj->mode ) :
				$back_obj->getNew( 'lightness', $back_obj->lightness + 11 )->toCSS( $back_obj->mode );
			$hover_on_back = ( 90 < $back_obj->lightness ) ?
				$back_obj->getNew( 'lightness', $back_obj->lightness - 3 )->toCSS( $back_obj->mode ) :
				$back_obj->getNew( 'lightness', $back_obj->lightness + 3 )->toCSS( $back_obj->mode );
			$arrows_on_back = ( 50 > $back_obj->lightness ) ?
				$back_obj->getNew( 'lightness', $back_obj->lightness + 30 )->toCSS( $back_obj->mode ) :
				$back_obj->getNew( 'lightness', $back_obj->lightness - 30 )->toCSS( $back_obj->mode );
			$back_disabled_obj = ( 35 < $back_obj->lightness ) ?
				$back_obj->getNew( 'lightness', $back_obj->lightness - 30 ) :
				$back_obj->getNew( 'lightness', $back_obj->lightness + 30 );
		}
		$accent     = ( isset( $config['color_accent'] ) ) ? $config['color_accent'] : false;
		$accent_obj = ( $accent ) ? ariColor::newColor( $accent ) : false;
		if ( $accent ) {
			$text_on_accent = ( 60 > $accent_obj->lightness ) ?
				$accent_obj->getNew( 'lightness', $accent_obj->lightness + 60 )->toCSS( $accent_obj->mode ) :
				$accent_obj->getNew( 'lightness', $accent_obj->lightness - 60 )->toCSS( $accent_obj->mode );
			$border_on_accent = ( 50 < $accent_obj->lightness ) ?
				$accent_obj->getNew( 'lightness', $accent_obj->lightness - 4 )->toCSS( $accent_obj->mode ) :
				$accent_obj->getNew( 'lightness', $accent_obj->lightness + 4 )->toCSS( $accent_obj->mode );
			$accent_disabled_obj = ( 35 < $accent_obj->lightness ) ?
				$accent_obj->getNew( 'lightness', $accent_obj->lightness - 30 ) :
				$accent_obj->getNew( 'lightness', $accent_obj->lightness + 30 );
			$accent_disabled = $accent_disabled_obj->toCSS( $accent_disabled_obj->mode );
			$text_on_accent_disabled = ( 60 > $accent_disabled_obj->lightness ) ?
				$accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness + 60 )->toCSS( $accent_disabled_obj->mode ) :
				$accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness - 60 )->toCSS( $accent_disabled_obj->mode );
			$border_on_accent_disabled = ( 50 < $accent_disabled_obj->lightness ) ?
				$accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness - 4 )->toCSS( $accent_disabled_obj->mode ) :
				$accent_disabled_obj->getNew( 'lightness', $accent_disabled_obj->lightness + 4 )->toCSS( $accent_disabled_obj->mode );
		}

		if ( $back ) {
			$elements = array(
				'.wp-full-overlay-sidebar',
				'#customize-controls .customize-info .accordion-section-title',
				'#customize-controls .panel-meta.customize-info .accordion-section-title:hover',
				'#customize-theme-controls .accordion-section-title',
				'.customize-section-title',
				'#customize-theme-controls .control-section-themes .accordion-section-title',
				'#customize-theme-controls .control-section-themes .accordion-section-title',
				'#customize-theme-controls .control-section-themes .accordion-section-title:hover',
			);

			$css .= implode( ',', $elements ) . "{background:{$back};color:{$text_on_back};}";

			$elements = array(
				'#customize-controls .customize-info .panel-title',
				'#customize-controls .customize-pane-child .customize-section-title h3',
				'#customize-controls .customize-pane-child h3.customize-section-title',
				'.customize-control',
				'#customize-controls .description',
			);
			$css .= implode( ',', $elements ) . "{color:{$text_on_back};}";

			$elements = array(
				'#customize-controls .customize-info',
				'#customize-header-actions',
				'.customize-section-title',
			);
			$css .= implode( ',', $elements ) . "{border-bottom-color:{$border_on_back};}";

			$elements = array(
				'.wp-full-overlay-sidebar .wp-full-overlay-header',
				'.customize-controls-close',
				'.expanded .wp-full-overlay-footer',
			);
			$css .= implode( ',', $elements ) . "{color:{$text_on_back};background-color:{$back_on_back};border-color:{$border_on_back};}";

			$elements = array(
				'.accordion-section',
				'#customize-theme-controls .customize-pane-child.accordion-section-content',
			);
			$css .= implode( ',', $elements ) . "{background:{$back_on_back};}";

			$elements = array(
				'#accordion-section-themes+.control-section',
				'#customize-theme-controls .control-section:last-of-type.open',
				'#customize-theme-controls .control-section:last-of-type > .accordion-section-title',
				'#customize-theme-controls .control-section.open',
			);
			$css .= implode( ',', $elements ) . "{border-bottom-color:{$border_on_back};border-top-color:{$border_on_back};}";

			$elements = array(
				'#customize-theme-controls .accordion-section-title',
			);
			$css .= implode( ',', $elements ) . "{border-bottom-color:{$border_on_back};border-left-color:{$border_on_back};}";

			$elements = array(
				'#customize-theme-controls .control-section-themes .accordion-section-title',
				'#customize-theme-controls .control-section-themes .accordion-section-title:hover',
			);
			$css .= implode( ',', $elements ) . "{border-bottom-color:{$border_on_back};border-top-color:{$border_on_back};border-bottom-color:{$border_on_back};}";

			$elements = array(
				'#customize-theme-controls .accordion-section-title:after',
			);
			$css .= implode( ',', $elements ) . "{color:{$arrows_on_back};}";

			$elements = array(
				'.wp-core-ui .button',
				'.wp-core-ui .button-secondary',
			);
			$css .= implode( ',', $elements ) . "{background-color:{$back};border-color:{$border_on_back};box-shadow:0 1px 0 {$border_on_back};-webkit-box-shadow:0 1px 0 {$border_on_back};text-shadow:0 -1px 1px {$border_on_back}, 1px 0 1px {$border_on_back}, 0 1px 1px {$border_on_back}, -1px 0 1px {$border_on_back};color:{$text_on_back};}";

			$css .= "@media screen and (max-width: 640px) {.customize-controls-preview-toggle{background-color:{$back};border-color:{$border_on_back};box-shadow:0 1px 0 {$border_on_back};-webkit-box-shadow:0 1px 0 {$border_on_back};text-shadow:0 -1px 1px {$border_on_back}, 1px 0 1px {$border_on_back}, 0 1px 1px {$border_on_back}, -1px 0 1px {$border_on_back};color:{$text_on_back};}}";

			$elements = array(
				'.wp-core-ui .button.focus',
				'.wp-core-ui .button.hover',
				'.wp-core-ui .button:focus',
				'.wp-core-ui .button:hover',
				'.wp-core-ui .button-secondary.focus',
				'.wp-core-ui .button-secondary.hover',
				'.wp-core-ui .button-secondary:focus',
				'.wp-core-ui .button-secondary:hover',
				'.customize-panel-back',
				'.customize-section-back',
			);
			$css .= implode( ',', $elements ) . "{background-color:{$back_on_back};border-color:{$border_on_back};box-shadow: 0 1px 0 {$border_on_back};-webkit-box-shadow: 0 1px 0 {$border_on_back};text-shadow: 0 -1px 1px {$border_on_back}, 1px 0 1px {$border_on_back}, 0 1px 1px {$border_on_back}, -1px 0 1px {$border_on_back};color:{$text_on_back};}";

			$css .= "@media screen and (max-width: 640px) {.customize-controls-preview-toggle.focus,.customize-controls-preview-toggle.hover,.customize-controls-preview-toggle:focus,.customize-controls-preview-toggle:hover{background-color:{$back_on_back};border-color:{$border_on_back};box-shadow: 0 1px 0 {$border_on_back};-webkit-box-shadow: 0 1px 0 {$border_on_back};text-shadow: 0 -1px 1px {$border_on_back}, 1px 0 1px {$border_on_back}, 0 1px 1px {$border_on_back}, -1px 0 1px {$border_on_back};color:{$text_on_back};}}";

			$elements = array(
				'.customize-control-kirki-background .background-attachment .buttonset .switch-label',
				'.customize-control-kirki-background .background-size .buttonset .switch-label',
				'.customize-control-kirki-radio-buttonset .buttonset .switch-label',
			);
			$css .= implode( ',', $elements ) . "{color:{$text_on_back};}";

			$elements = array(
				'.wp-color-result',
			);
			$css .= implode( ',', $elements ) . "{border-color:{$border_on_back};-webkit-box-shadow: 0 1px 0 {$border_on_back};box-shadow: 0 1px 0 {$border_on_back};}";

			$elements = array(
				'.wp-color-result:focus',
				'.wp-color-result:hover',
			);
			$css .= implode( ',', $elements ) . "{border-color:{$border_on_back};background:{$back_on_back};}";

			$elements = array(
				'.wp-color-result:after',
			);
			$css .= implode( ',', $elements ) . "{border-color:{$border_on_back};background:{$back};color:{$text_on_back};}";

			$elements = array(
				'.wp-color-result:focus:after',
				'.wp-color-result:hover:after',
			);
			$css .= implode( ',', $elements ) . "{color:{$text_on_back};}";

			$elements = array(
				'.customize-control input[type=tel]',
				'.customize-control input[type=url]',
				'.customize-control input[type=text]',
				'.customize-control input[type=password]',
				'.customize-control input[type=email]',
				'.customize-control input[type=number]',
				'.customize-control input[type=search]',
				'.customize-control input[type=radio]',
				'.customize-control input[type=checkbox]',
				'.customize-control select',
				'.select2-container--default .select2-selection--single',
				'.select2-container--default .select2-selection--multiple',
			);
			$css .= implode( ',', $elements ) . "{background:{$back};border-color:{$border_on_back};color:{$text_on_back};}";

			$css .= ".customize-control-kirki-slider input[type=range]::-webkit-slider-thumb{background-color:{$accent};}";
			$css .= ".customize-control-kirki-slider input[type=range]::-moz-range-thumb{background-color:{$accent};}";
			$css .= ".customize-control-kirki-slider input[type=range]::-ms-thumb{background-color:{$accent};}";

			$css .= ".customize-control-kirki-slider input[type=range]{background:{$border_on_back};}";

			$elements = array(
				'.select2-container--default .select2-selection--single .select2-selection__rendered',
			);
			$css .= implode( ',', $elements ) . "{color:{$text_on_back};}";

			$elements = array(
				'.wp-full-overlay-footer .devices',
			);
			$css .= implode( ',', $elements ) . '{background:none;background:transparent;box-shadow:none;-webkit-box-shadow:none;}';

			$css .= ".kirki-reset-section .dashicons{color:{$back_on_back};}";

		} // End if().

		if ( $back || $accent ) {
			$elements = array(
				'#customize-controls .control-section .accordion-section-title:focus',
				'#customize-controls .control-section .accordion-section-title:hover',
				'#customize-controls .control-section.open .accordion-section-title',
				'#customize-controls .control-section:hover > .accordion-section-title',
				'.customize-panel-back:focus',
				'.customize-panel-back:hover',
				'.customize-section-back:focus',
				'.customize-section-back:hover',
			);
			$css .= implode( ',', $elements ) . '{';
			$css .= ( $back ) ? "background:{$hover_on_back};" : '';
			$css .= ( $accent ) ? "color:{$accent};border-left-color:{$accent};" : '';
			$css .= '}';

			$css .= '.customize-controls-close:hover{';
			$css .= ( $back ) ? "background-color:{$back};" : '';
			$css .= ( $accent ) ? "color:{$accent};border-color:{$accent};" : '';
			$css .= '}';

		}

		if ( $accent ) {
			$elements = array(
				'#customize-theme-controls .control-section .accordion-section-title:focus:after',
				'#customize-theme-controls .control-section .accordion-section-title:hover:after',
				'#customize-theme-controls .control-section.open .accordion-section-title:after',
				'#customize-theme-controls .control-section:hover>.accordion-section-title:after',
			);
			$css .= implode( ',', $elements ) . "{color:{$accent};}";

			$elements = array(
				'.wp-core-ui .button.button-primary',
			);
			$css .= implode( ',', $elements ) . "{background-color:{$accent};border-color:{$border_on_accent};box-shadow:0 1px 0 {$border_on_accent};-webkit-box-shadow:0 1px 0 {$border_on_accent};text-shadow:0 -1px 1px {$border_on_accent}, 1px 0 1px {$border_on_accent}, 0 1px 1px {$border_on_accent}, -1px 0 1px {$border_on_accent};color:{$text_on_accent};}";

			$elements = array(
				'.wp-core-ui .button.button-primary.focus',
				'.wp-core-ui .button.button-primary.hover',
				'.wp-core-ui .button.button-primary:focus',
				'.wp-core-ui .button.button-primary:hover',
			);
			$css .= implode( ',', $elements ) . "{background-color:{$accent};border-color:{$border_on_accent};box-shadow: 0 1px 0 {$border_on_accent};-webkit-box-shadow: 0 1px 0 {$border_on_accent};text-shadow: 0 -1px 1px {$border_on_accent}, 1px 0 1px {$border_on_accent}, 0 1px 1px {$border_on_accent}, -1px 0 1px {$border_on_accent};color:{$text_on_accent};}";

			$elements = array(
				'.wp-core-ui .button.button-primary-disabled',
				'.wp-core-ui .button.button-primary.disabled',
				'.wp-core-ui .button.button-primary:disabled',
				'.wp-core-ui .button.button-primary[disabled]',
			);
			$css .= implode( ',', $elements ) . "{background-color:{$accent_disabled} !important;border-color: {$border_on_accent_disabled} !important;box-shadow: 0 1px 0 {$border_on_accent_disabled} !important;-webkit-box-shadow: 0 1px 0 {$border_on_accent_disabled} !important;text-shadow: 0 -1px 1px {$border_on_accent_disabled}, 1px 0 1px {$border_on_accent_disabled}, 0 1px 1px {$border_on_accent_disabled}, -1px 0 1px {$border_on_accent_disabled} !important;color:{$text_on_accent_disabled} !important;}";

			$elements = array(
				'input[type=checkbox]:checked:before',
			);
			if ( $accent ) {
				$css .= implode( ',', $elements ) . "{color:{$accent}}";
			}

			$elements = array(
				'.select2-container--default .select2-results__option--highlighted[aria-selected]',
			);
			$css .= implode( ',', $elements ) . "{background-color:{$accent}color:{$text_on_accent}}";

			$elements = array(
				'.customize-control-kirki-radio-buttonset .buttonset .switch-input:checked + .switch-label',
				'.customize-control-kirki-background .background-attachment .buttonset .switch-input:checked + .switch-label',
				'.customize-control-kirki-background .background-size .buttonset .switch-input:checked + .switch-label',
			);
			$css .= implode( ',', $elements ) . "{background-color:{$accent};border-color:{$border_on_accent};color:{$text_on_accent};}";
		} // End if().

		if ( isset( $config['width'] ) ) {
			if ( false === strpos( $config['width'], 'calc' ) ) {
				$width = esc_attr( $config['width'] );
				$css .= ".wp-full-overlay-sidebar{width:{$width};}.expanded .wp-full-overlay-footer{width:{$width};}.wp-full-overlay.expanded{margin-left:{$width};}.wp-full-overlay.collapsed .wp-full-overlay-sidebar{margin-left: -{$width};}";
			}
		}

		echo '<style>' . $css . '</style>'; // WPCS: XSS ok.
	}
}
