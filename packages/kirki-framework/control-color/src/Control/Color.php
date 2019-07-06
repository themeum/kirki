<?php
/**
 * Customizer Control: color.
 *
 * @package   kirki-framework/control-color
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     0.1
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Adds a color & color-alpha control
 *
 * @since 0.1
 */
class Color extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 0.1
	 * @var string
	 */
	public $type = 'kirki-color';

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access public
	 * @since 0.1
	 * @var string
	 */
	public static $control_ver = '0.1';

	/**
	 * Colorpicker palette
	 *
	 * @access public
	 * @since 0.1
	 * @var array|bool
	 */
	public $palette = true;

	/**
	 * Mode.
	 *
	 * @access public
	 * @since 0.1
	 * @var string
	 */
	public $mode = 'full';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 0.1
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha', URL::get_from_path( __DIR__ . '/wp-color-picker-alpha.js' ), [ 'wp-color-picker' ], '2.1.3', false );

		// Enqueue the control script.
		wp_enqueue_script( 'kirki-control-color', URL::get_from_path( __DIR__ . '/control.js' ), [ 'jquery', 'customize-base', 'customize-controls', 'kirki-dynamic-control' ], self::$control_ver, false );

		// Enqueue the control style.
		wp_enqueue_style( 'kirki-control-color', URL::get_from_path( __DIR__ . '/style.css' ), [], self::$control_ver );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 * @since 0.1
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		$this->json['palette']          = $this->palette;
		$this->json['choices']['alpha'] = ( isset( $this->choices['alpha'] ) && $this->choices['alpha'] ) ? 'true' : 'false';
		$this->json['mode']             = $this->mode;
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
	 * @since 0.1
	 * @return void
	 */
	protected function content_template() {
		?>
		<#
		data.choices       = data.choices || {};
		data.choices.alpha = data.choices.alpha || false;
		data.value         = data.value.toString().toLowerCase();
		if ( 0 === data.value.indexOf( '#' ) && 4 === data.value.split( '' ).length ) {
			data.value = '#' + data.value.split( '' )[1] + data.value.split( '' )[1] + data.value.split( '' )[2] + data.value.split( '' )[2] + data.value.split( '' )[3] + data.value.split( '' )[3]
		}
		var hasPaletteColorSelected = false;
		#>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>

		<#
		var palette = data.palette;
		if ( true === data.palette ) {
			<?php $editor_palette = current( (array) get_theme_support( 'editor-color-palette' ) ); ?>
			<?php if ( ! empty( $editor_palette ) ) : ?>
				palette = [];
				var kirkiColorEditorPalette = <?php echo wp_strip_all_tags( wp_json_encode( $editor_palette ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>;
				_.each( kirkiColorEditorPalette, function( paletteColor ) {
					paletteColor.color = paletteColor.color.toLowerCase();
					if ( 0 === paletteColor.color.indexOf( '#' ) && 4 === paletteColor.color.split( '' ).length ) {
						paletteColor.color = '#' + paletteColor.color.split( '' )[1] + paletteColor.color.split( '' )[1] + paletteColor.color.split( '' )[2] + paletteColor.color.split( '' )[2] + paletteColor.color.split( '' )[3] + paletteColor.color.split( '' )[3]
					}
					palette.push( paletteColor.color );
				});
			<?php else : ?>
				palette = [ '#000000', '#ffffff', '#cf2e2e', '#ff6900', '#fcb900', '#00d084', '#0693e3', '#abb8c3', '#546E7A', '#313131' ]
			<?php endif; ?>
		}
		#>
		<input
			type="text"
			data-type="{{ data.mode }}"
			{{{ data.inputAttrs }}}
			data-palette="{{ JSON.stringify( palette ) }}"
			data-default-color="{{ data.default }}"
			data-alpha="{{ data.choices.alpha }}"
			value="{{ data.value }}"
			class="kirki-color-control"
		/>
		<?php
	}
}
