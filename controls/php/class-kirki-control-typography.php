<?php
/**
 * Customizer Control: typography.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license    https://opensource.org/licenses/MIT
 * @since       2.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Typography control.
 */
class Kirki_Control_Typography extends Kirki_Control_Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-typography';

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		if ( is_array( $this->json['value'] ) ) {
			foreach ( array_keys( $this->json['value'] ) as $key ) {
				if ( ! in_array( $key, array( 'variant', 'font-weight', 'font-style' ), true ) && ! isset( $this->json['default'][ $key ] ) ) {
					unset( $this->json['value'][ $key ] );
				}

				// Fix for https://wordpress.org/support/topic/white-font-after-updateing-to-3-0-16.
				if ( ! isset( $this->json['default'][ $key ] ) ) {
					unset( $this->json['value'][ $key ] );
				}

				// Fix for https://github.com/aristath/kirki/issues/1405.
				if ( isset( $this->json['default'][ $key ] ) && false === $this->json['default'][ $key ] ) {
					unset( $this->json['value'][ $key ] );
				}
			}
		}

		$this->json['show_variants'] = ( true === Kirki_Fonts_Google::$force_load_all_variants ) ? false : true;
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>
		<label class="customizer-text">
			<# if ( data.label ) { #><span class="customize-control-title">{{{ data.label }}}</span><# } #>
			<# if ( data.description ) { #><span class="description customize-control-description">{{{ data.description }}}</span><# } #>
		</label>

		<div class="wrapper">

			<# if ( ! _.isUndefined( data.default['font-family'] ) ) { #>
				<# data.value['font-family'] = data.value['font-family'] || data['default']['font-family']; #>
				<# if ( data.choices['fonts'] ) { data.fonts = data.choices['fonts']; } #>
				<div class="font-family">
					<h5><?php esc_html_e( 'Font Family', 'kirki' ); ?></h5>
					<select {{{ data.inputAttrs }}} id="kirki-typography-font-family-{{{ data.id }}}" placeholder="<?php esc_attr_e( 'Select Font Family', 'kirki' ); ?>"></select>
				</div>
				<# if ( ! _.isUndefined( data.choices['font-backup'] ) && true === data.choices['font-backup'] ) { #>
					<div class="font-backup hide-on-standard-fonts kirki-font-backup-wrapper">
						<h5><?php esc_html_e( 'Backup Font', 'kirki' ); ?></h5>
						<select {{{ data.inputAttrs }}} id="kirki-typography-font-backup-{{{ data.id }}}" placeholder="<?php esc_attr_e( 'Select Font Family', 'kirki' ); ?>"></select>
					</div>
				<# } #>
				<# if ( true === data.show_variants || false !== data.default.variant ) { #>
					<div class="variant kirki-variant-wrapper">
						<h5><?php esc_html_e( 'Variant', 'kirki' ); ?></h5>
						<select {{{ data.inputAttrs }}} class="variant" id="kirki-typography-variant-{{{ data.id }}}"></select>
					</div>
				<# } #>
				<div class="kirki-host-font-locally">
					<label>
						<input type="checkbox">
						<?php esc_html_e( 'Download font-family to server instead of using the Google CDN.', 'kirki' ); ?>
					</label>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['font-size'] ) ) { #>
				<# data.value['font-size'] = data.value['font-size'] || data['default']['font-size']; #>
				<div class="font-size">
					<h5><?php esc_html_e( 'Font Size', 'kirki' ); ?></h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['font-size'] }}"/>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['line-height'] ) ) { #>
				<# data.value['line-height'] = data.value['line-height'] || data['default']['line-height']; #>
				<div class="line-height">
					<h5><?php esc_html_e( 'Line Height', 'kirki' ); ?></h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['line-height'] }}"/>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['letter-spacing'] ) ) { #>
				<# data.value['letter-spacing'] = data.value['letter-spacing'] || data['default']['letter-spacing']; #>
				<div class="letter-spacing">
					<h5><?php esc_html_e( 'Letter Spacing', 'kirki' ); ?></h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['letter-spacing'] }}"/>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['word-spacing'] ) ) { #>
				<# data.value['word-spacing'] = data.value['word-spacing'] || data['default']['word-spacing']; #>
				<div class="word-spacing">
					<h5><?php esc_html_e( 'Word Spacing', 'kirki' ); ?></h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['word-spacing'] }}"/>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['text-align'] ) ) { #>
				<# data.value['text-align'] = data.value['text-align'] || data['default']['text-align']; #>
				<div class="text-align">
					<h5><?php esc_html_e( 'Text Align', 'kirki' ); ?></h5>
					<div class="text-align-choices">
						<input {{{ data.inputAttrs }}} type="radio" value="inherit" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-inherit" <# if ( data.value['text-align'] === 'inherit' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-inherit">
								<span class="dashicons dashicons-editor-removeformatting"></span>
								<span class="screen-reader-text"><?php esc_html_e( 'Inherit', 'kirki' ); ?></span>
							</label>
						</input>
						<input {{{ data.inputAttrs }}} type="radio" value="left" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-left" <# if ( data.value['text-align'] === 'left' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-left">
								<span class="dashicons dashicons-editor-alignleft"></span>
								<span class="screen-reader-text"><?php esc_html_e( 'Left', 'kirki' ); ?></span>
							</label>
						</input>
						<input {{{ data.inputAttrs }}} type="radio" value="center" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-center" <# if ( data.value['text-align'] === 'center' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-center">
								<span class="dashicons dashicons-editor-aligncenter"></span>
								<span class="screen-reader-text"><?php esc_html_e( 'Center', 'kirki' ); ?></span>
							</label>
						</input>
						<input {{{ data.inputAttrs }}} type="radio" value="right" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-right" <# if ( data.value['text-align'] === 'right' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-right">
								<span class="dashicons dashicons-editor-alignright"></span>
								<span class="screen-reader-text"><?php esc_html_e( 'Right', 'kirki' ); ?></span>
							</label>
						</input>
						<input {{{ data.inputAttrs }}} type="radio" value="justify" name="_customize-typography-text-align-radio-{{ data.id }}" id="{{ data.id }}-text-align-justify" <# if ( data.value['text-align'] === 'justify' ) { #> checked="checked"<# } #>>
							<label for="{{ data.id }}-text-align-justify">
								<span class="dashicons dashicons-editor-justify"></span>
								<span class="screen-reader-text"><?php esc_html_e( 'Justify', 'kirki' ); ?></span>
							</label>
						</input>
					</div>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['text-transform'] ) ) { #>
				<# data.value['text-transform'] = data.value['text-transform'] || data['default']['text-transform']; #>
				<div class="text-transform">
					<h5><?php esc_html_e( 'Text Transform', 'kirki' ); ?></h5>
					<select {{{ data.inputAttrs }}} id="kirki-typography-text-transform-{{{ data.id }}}">
						<option value=""<# if ( '' === data.value['text-transform'] ) { #>selected<# } #>></option>
						<option value="none"<# if ( 'none' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_html_e( 'None', 'kirki' ); ?></option>
						<option value="capitalize"<# if ( 'capitalize' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_html_e( 'Capitalize', 'kirki' ); ?></option>
						<option value="uppercase"<# if ( 'uppercase' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_html_e( 'Uppercase', 'kirki' ); ?></option>
						<option value="lowercase"<# if ( 'lowercase' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_html_e( 'Lowercase', 'kirki' ); ?></option>
						<option value="initial"<# if ( 'initial' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_html_e( 'Initial', 'kirki' ); ?></option>
						<option value="inherit"<# if ( 'inherit' === data.value['text-transform'] ) { #>selected<# } #>><?php esc_html_e( 'Inherit', 'kirki' ); ?></option>
					</select>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['text-decoration'] ) ) { #>
				<# data.value['text-decoration'] = data.value['text-decoration'] || data['default']['text-decoration']; #>
				<div class="text-decoration">
					<h5><?php esc_html_e( 'Text Decoration', 'kirki' ); ?></h5>
					<select {{{ data.inputAttrs }}} id="kirki-typography-text-decoration-{{{ data.id }}}">
						<option value=""<# if ( '' === data.value['text-decoration'] ) { #>selected<# } #>></option>
						<option value="none"<# if ( 'none' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_html_e( 'None', 'kirki' ); ?></option>
						<option value="underline"<# if ( 'underline' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_html_e( 'Underline', 'kirki' ); ?></option>
						<option value="overline"<# if ( 'overline' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_html_e( 'Overline', 'kirki' ); ?></option>
						<option value="line-through"<# if ( 'line-through' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_html_e( 'Line-Through', 'kirki' ); ?></option>
						<option value="initial"<# if ( 'initial' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_html_e( 'Initial', 'kirki' ); ?></option>
						<option value="inherit"<# if ( 'inherit' === data.value['text-decoration'] ) { #>selected<# } #>><?php esc_html_e( 'Inherit', 'kirki' ); ?></option>
					</select>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['margin-top'] ) ) { #>
				<# data.value['margin-top'] = data.value['margin-top'] || data['default']['margin-top']; #>
				<div class="margin-top">
					<h5><?php esc_html_e( 'Margin Top', 'kirki' ); ?></h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['margin-top'] }}"/>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['margin-bottom'] ) ) { #>
				<# data.value['margin-bottom'] = data.value['margin-bottom'] || data['default']['margin-bottom']; #>
				<div class="margin-bottom">
					<h5><?php esc_html_e( 'Margin Bottom', 'kirki' ); ?></h5>
					<input {{{ data.inputAttrs }}} type="text" value="{{ data.value['margin-bottom'] }}"/>
				</div>
			<# } #>

			<# if ( ! _.isUndefined( data.default['color'] ) && false !== data.default['color'] ) { #>
				<# data.value['color'] = data.value['color'] || data['default']['color']; #>
				<div class="color">
					<h5><?php esc_html_e( 'Color', 'kirki' ); ?></h5>
					<input {{{ data.inputAttrs }}} type="text" data-palette="{{ data.palette }}" data-default-color="{{ data.default['color'] }}" value="{{ data.value['color'] }}" class="kirki-color-control"/>
				</div>
			<# } #>

		</div>
		<input class="typography-hidden-value" type="hidden" {{{ data.link }}}>
		<?php
	}

	/**
	 * Formats variants.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $variants The variants.
	 * @return array
	 */
	protected function format_variants_array( $variants ) {
		$all_variants   = Kirki_Fonts::get_all_variants();
		$final_variants = array();
		foreach ( $variants as $variant ) {
			if ( is_string( $variant ) ) {
				$final_variants[] = array(
					'id'    => $variant,
					'label' => isset( $all_variants[ $variant ] ) ? $all_variants[ $variant ] : $variant,
				);
			} elseif ( is_array( $variant ) && isset( $variant['id'] ) && isset( $variant['label'] ) ) {
				$final_variants[] = $variant;
			}
		}
		return $final_variants;
	}
}
