<?php
/**
 * Customizer Control: background.
 *
 * Creates a new custom control.
 * Custom controls contains all background-related options.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

/**
 * Adds multiple input fiels that combined make up the background control.
 */
class Kirki_Control_Background extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'kirki-background';

	/**
	 * Used to automatically generate all CSS output.
	 *
	 * @access public
	 * @var array
	 */
	public $output = array();

	/**
	 * Data type
	 *
	 * @access public
	 * @var string
	 */
	public $option_type = 'theme_mod';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 */
	public function enqueue() {
		wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.2', true );
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script( 'kirki-background', trailingslashit( Kirki::$url ) . 'controls/background/background.js', array( 'jquery', 'wp-color-picker-alpha' ) );
		wp_enqueue_style( 'kirki-background', trailingslashit( Kirki::$url ) . 'controls/background/background.css', null );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 */
	public function to_json() {
		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['output']  = $this->output;
		$this->json['value']   = $this->value();
		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['id']      = $this->id;

		if ( 'user_meta' === $this->option_type ) {
			$this->json['value'] = get_user_meta( get_current_user_id(), $this->id, true );
		}

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}
		$config_id = 'global';
		$this->json['l10n'] = $this->l10n( $config_id );
	}

	/**
	 * Render the control's content.
	 *
	 * Allows the content to be overridden without having to rewrite the wrapper in `$this::render()`.
	 *
	 * Supports basic input types `text`, `checkbox`, `textarea`, `radio`, `select` and `dropdown-pages`.
	 * Additional input types such as `email`, `url`, `number`, `hidden` and `date` are supported implicitly.
	 *
	 * Control content can alternately be rendered in JS. See WP_Customize_Control::print_template().
	 *
	 * @since 3.4.0
	 */
	protected function render_content() {}

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
		<label>
			<span class="customize-control-title">
				{{{ data.label }}}
			</span>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="background-wrapper">

			<!-- background-color -->
			<div class="background-color">
				<h4>{{ data.l10n['background-color'] }}</h4>
				<input type="text" data-default-color="{{ data.default['background-color'] }}" data-alpha="true" value="{{ data.value['background-color'] }}" class="kirki-color-control color-picker" {{{ data.link }}} />
			</div>

			<!-- background-image -->
			<div class="background-image">
				<h4>{{ data.l10n['background-image'] }}</h4>
				<div class="attachment-media-view background-image-upload">
					<# if ( data.value['background-image'] ) { #>
						<div class="thumbnail thumbnail-image">
							<img src="{{ data.value['background-image'] }}" alt="" />
						</div>
					<# } else { #>
						<div class="placeholder">
							{{ data.l10n['no-file-selected'] }}
						</div>
					<# } #>
					<div class="actions">
						<button class="button background-image-upload-remove-button<# if ( ! data.value['background-image'] ) { #> hidden <# } #>">
							{{ data.l10n['remove'] }}
						</button>
						<button type="button" class="button background-image-upload-button">
							{{ data.l10n['select-file'] }}
						</button>
					</div>
				</div>
			</div>

			<!-- background-repeat -->
			<div class="background-repeat">
				<h4>{{ data.l10n['background-repeat'] }}</h4>
				<#
				var repeats = [
						'no-repeat',
						'repeat-all',
						'repeat-x',
						'repeat-y'
					];
				#>
				<select {{{ data.inputAttrs }}} {{{ data.link }}}>
					<# _.each( repeats, function( repeat ) { #>
						<option value="{{ repeat }}"<# if ( repeat === data.value['background-repeat'] ) { #> selected <# } #>>{{ data.l10n[ repeat ] }}</option>
					<# }); #>
				</select>
			</div>

			<!-- background-position -->
			<div class="background-position">
				<h4>{{ data.l10n['background-position'] }}</h4>
				<#
				var positions = [
						'left top',
						'left center',
						'left bottom',
						'right top',
						'right center',
						'right bottom',
						'center top',
						'center center',
						'center bottom'
					];
				#>
				<select {{{ data.inputAttrs }}} {{{ data.link }}}>
					<# _.each( positions, function( position ) { #>
						<option value="{{ position }}"<# if ( position === data.value['background-position'] ) { #> selected <# } #>>{{ data.l10n[ position ] }}</option>
					<# }); #>
				</select>
			</div>

			<!-- background-size -->
			<div class="background-size">
				<h4>{{ data.l10n['background-size'] }}</h4>
				<#
				var sizes = [
						'cover',
						'contain',
						'auto'
					];
				#>
				<div class="buttonset">
					<# _.each( sizes, function( size ) { #>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="{{ size }}" name="_customize-bg-{{{ data.id }}}-size" id="{{ data.id }}{{ size }}" {{{ data.link }}}<# if ( size === data.value['background-size'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( size === data.value['background-size'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}{{ size }}">
								{{ data.l10n[ size ] }}
							</label>
						</input>
					<# }); #>
				</div>
			</div>

			<!-- background-attachment -->
			<div class="background-attachment">
				<h4>{{ data.l10n['background-attachment'] }}</h4>
				<#
				var attachments = [
						'scroll',
						'fixed',
						'local'
					];
				#>
				<div class="buttonset">
					<# _.each( attachments, function( attachment ) { #>
						<input {{{ data.inputAttrs }}} class="switch-input screen-reader-text" type="radio" value="{{ attachment }}" name="_customize-bg-{{{ data.id }}}-attachment" id="{{ data.id }}{{ attachment }}" {{{ data.link }}}<# if ( attachment === data.value['background-attachment'] ) { #> checked="checked" <# } #>>
							<label class="switch-label switch-label-<# if ( attachment === data.value['background-attachment'] ) { #>on <# } else { #>off<# } #>" for="{{ data.id }}{{ attachment }}">
								{{ data.l10n[ attachment ] }}
							</label>
						</input>
					<# }); #>
				</div>
			</div>
		<?php
	}

	/**
	 * Returns an array of translation strings.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param string|false $config_id The string-ID.
	 * @return array
	 */
	protected function l10n( $config_id ) {
		$translation_strings = array(
			'background-color'      => esc_attr__( 'Background Color', 'kirki' ),
			'background-image'      => esc_attr__( 'Background Image', 'kirki' ),
			'background-repeat'     => esc_attr__( 'Background Repeat', 'kirki' ),
			'background-attachment' => esc_attr__( 'Background Attachment', 'kirki' ),
			'background-position'   => esc_attr__( 'Background Position', 'kirki' ),
			'background-size'       => esc_attr__( 'Background Size', 'kirki' ),

			'no-repeat'             => esc_attr__( 'No Repeat', 'kirki' ),
			'repeat-all'            => esc_attr__( 'Repeat All', 'kirki' ),
			'repeat-x'              => esc_attr__( 'Repeat Horizontally', 'kirki' ),
			'repeat-y'              => esc_attr__( 'Repeat Vertically', 'kirki' ),

			'cover'                 => esc_attr__( 'Cover', 'kirki' ),
			'contain'               => esc_attr__( 'Contain', 'kirki' ),
			'auto'                  => esc_attr__( 'Auto', 'kirki' ),
			'inherit'               => esc_attr__( 'Inherit', 'kirki' ),

			'fixed'                 => esc_attr__( 'Fixed', 'kirki' ),
			'scroll'                => esc_attr__( 'Scroll', 'kirki' ),
			'local'                 => esc_attr__( 'Local', 'kirki' ),

			'left top'              => esc_attr__( 'Left Top', 'kirki' ),
			'left center'           => esc_attr__( 'Left Center', 'kirki' ),
			'left bottom'           => esc_attr__( 'Left Bottom', 'kirki' ),
			'right top'             => esc_attr__( 'Right Top', 'kirki' ),
			'right center'          => esc_attr__( 'Right Center', 'kirki' ),
			'right bottom'          => esc_attr__( 'Right Bottom', 'kirki' ),
			'center top'            => esc_attr__( 'Center Top', 'kirki' ),
			'center center'         => esc_attr__( 'Center Center', 'kirki' ),
			'center bottom'         => esc_attr__( 'Center Bottom', 'kirki' ),

			'no-file-selected'      => esc_attr__( 'No File Selected', 'kirki' ),
			'remove'                => esc_attr__( 'Remove', 'kirki' ),
			'select-file'           => esc_attr__( 'Select File', 'kirki' ),
		);
		return apply_filters( "kirki/{$config_id}/l10n", $translation_strings );
	}
}
