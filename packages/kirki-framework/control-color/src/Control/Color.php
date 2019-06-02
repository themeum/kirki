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

		// Enqueue iro.
		wp_enqueue_script( 'iro', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/node_modules/@jaames/iro/dist/iro.min.js' ), [], '4.3.3', true );
		wp_enqueue_script( 'iro-transparency-plugin', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/node_modules/iro-transparency-plugin/dist/iro-transparency-plugin.min.js' ), [ 'iro' ], '0.1.2', true );

		// Enqueue the control script.
		wp_enqueue_script( 'kirki-control-color', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'customize-controls', 'iro', 'iro-transparency-plugin', 'kirki-dynamic-control' ], self::$control_ver, false );
		wp_set_script_translations( 'kirki-control-color', 'kirki' );

		// Enqueue the control style.
		wp_enqueue_style( 'kirki-control-color', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
	}

	/**
	 * Get the URL for the control folder.
	 *
	 * This is a static method because there are more controls in the Kirki framework
	 * that use colorpickers, and they all need to enqueue the same assets.
	 *
	 * @static
	 * @access public
	 * @since 0.1
	 * @return string
	 */
	public static function get_control_path_url() {
		return URL::get_from_path( dirname( __DIR__ ) );
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
		$this->json['defaultPalette']   = [
			[
				'name'  => esc_attr__( 'Pale Pink', 'kirki' ),
				'slug'  => 'pale-pink',
				'color' => '#f78da7',
			],
			[
				'name'  => esc_attr__( 'Vivid Red', 'kirki' ),
				'slug'  => 'vivid-red',
				'color' => '#cf2e2e',
			],
			[
				'name'  => esc_attr__( 'Luminous Vivid Orange', 'kirki' ),
				'slug'  => 'luminous-vivid-orange',
				'color' => '#ff6900',
			],
			[
				'name'  => esc_attr__( 'Luminous Vivid Amber', 'kirki' ),
				'slug'  => 'luminous-vivid-amber',
				'color' => '#fcb900',
			],
			[
				'name'  => esc_attr__( 'Light Green Cyan', 'kirki' ),
				'slug'  => 'light-green-cyan',
				'color' => '#7bdcb5',
			],
			[
				'name'  => esc_attr__( 'Vivid Green Cyan', 'kirki' ),
				'slug'  => 'vivid-green-cyan',
				'color' => '#00d084',
			],
			[
				'name'  => esc_attr__( 'Pale Cyan Blue', 'kirki' ),
				'slug'  => 'pale-cyan-blue',
				'color' => '#8ed1fc',
			],
			[
				'name'  => esc_html__( 'Vivid Cyan Blue', 'kirki' ),
				'slug'  => 'vivid-cyan-blue',
				'color' => '#0693e3',
			],
			[
				'name'  => esc_attr__( 'White', 'kirki' ),
				'slug'  => 'theme-white',
				'color' => '#fff',
			],
			[
				'name'  => esc_attr__( 'Very Light Gray', 'kirki' ),
				'slug'  => 'very-light-gray',
				'color' => '#eee',
			],
			[
				'name'  => esc_html__( 'Cyan Bluish Gray', 'kirki' ),
				'slug'  => 'cyan-bluish-gray',
				'color' => '#abb8c3',
			],
			[
				'name'  => esc_attr__( 'Blue Gray', 'kirki' ),
				'slug'  => 'blue-gray',
				'color' => '#546E7A',
			],
			[
				'name'  => esc_attr__( 'Very Dark Gray', 'kirki' ),
				'slug'  => 'very-dark-gray',
				'color' => '#313131',
			],
			[
				'name'  => esc_attr__( 'Black', 'kirki' ),
				'slug'  => 'theme-black',
				'color' => '#000',
			],
		];
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

		<!-- The palette. -->
		<div class="kirki-colorpicker-wrapper-palette">
			<# if ( 'hue' !== data.mode && true === data.palette ) { #>
				<?php $editor_palette = current( (array) get_theme_support( 'editor-color-palette' ) ); ?>
				<?php if ( ! empty( $editor_palette ) ) : ?>
					<# var kirkiColorEditorPalette = <?php echo wp_strip_all_tags( wp_json_encode( $editor_palette ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>; #>
				<?php else : ?>
					<# var kirkiColorEditorPalette = data.defaultPalette; #>
				<?php endif; ?>

				<# _.each( kirkiColorEditorPalette, function( paletteColor ) { #>
					<#
					paletteColor.color = paletteColor.color.toLowerCase();
					if ( 0 === paletteColor.color.indexOf( '#' ) && 4 === paletteColor.color.split( '' ).length ) {
						paletteColor.color = '#' + paletteColor.color.split( '' )[1] + paletteColor.color.split( '' )[1] + paletteColor.color.split( '' )[2] + paletteColor.color.split( '' )[2] + paletteColor.color.split( '' )[3] + paletteColor.color.split( '' )[3]
					}

					var selected = ( data.value === paletteColor.color );
					if ( selected ) {
						hasPaletteColorSelected = true;
					}
					#>
					<button
						class="palette-color palette-color-{{ paletteColor.slug }}"
						data-color="{{ paletteColor.color }}"
						title="{{ paletteColor.name }}"
						<?php /* translators: the color name. */ ?>
						aria-label="<?php printf( esc_attr_e( 'Color: %s', 'kirki' ), '{{ paletteColor.name }}' ); ?>"
						aria-pressed="{{ selected }}"
						>
						<span class="button-inner" style="color:{{ paletteColor.color }};">
							<svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-saved" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M15.3 5.3l-6.8 6.8-2.8-2.8-1.4 1.4 4.2 4.2 8.2-8.2"></path></svg>
						</span>
					</button>
				<# }); #>
			<# } else if ( 'object' === typeof data.palette ) { #>
				<# _.each( data.palette, function( paletteColor ) { #>
					<#
					paletteColor = paletteColor.toLowerCase();
					if ( 0 === paletteColor.indexOf( '#' ) && 4 === paletteColor.split( '' ).length ) {
						paletteColor = '#' + paletteColor.split( '' )[1] + paletteColor.split( '' )[1] + paletteColor.split( '' )[2] + paletteColor.split( '' )[2] + paletteColor.split( '' )[3] + paletteColor.split( '' )[3]
					}
					var selected = ( data.value === paletteColor );
					if ( selected ) {
						hasPaletteColorSelected = true;
					}
					#>
					<button
						class="palette-color palette-color-{{ paletteColor }}"
						data-color="{{ paletteColor }}"
						title="{{ paletteColor }}"
						<?php /* translators: the color name. */ ?>
						aria-label="<?php printf( esc_attr_e( 'Color: %s', 'kirki' ), '{{ paletteColor }}' ); ?>"
						aria-pressed="{{ selected }}"
						>
						<span class="button-inner" style="color:{{ paletteColor }};">
							<svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-saved" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M15.3 5.3l-6.8 6.8-2.8-2.8-1.4 1.4 4.2 4.2 8.2-8.2"></path></svg>
						</span>
					</button>
				<# }); #>
			<# } #>
		</div>

		<details class="kirki-color-input-wrapper mode-{{ data.mode }}" <# if ( 'hue' === data.mode ) { #>open<# } #>>
			<summary>
				<span>
					<button
						class="palette-color placeholder color-preview"
						data-color="{{ data.value }}"
						<?php /* translators: the color name. */ ?>
						aria-label="<?php printf( esc_attr_e( 'Color: %s', 'kirki' ), '{{ data.value }}' ); ?>"
						aria-pressed="{{ ! hasPaletteColorSelected }}"
						>
						<span class="button-inner" style="color:{{ data.value }};">
							<svg aria-hidden="true" role="img" focusable="false" class="dashicon dashicons-saved" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path d="M15.3 5.3l-6.8 6.8-2.8-2.8-1.4 1.4 4.2 4.2 8.2-8.2"></path></svg>
						</span>
					</button>
				</span>
				<span class="summary-description">
					<?php esc_html_e( 'Select Color', 'kirki' ); ?>
				</span>
				<input
					type = "text"
					data-type="{{ data.mode }}"
					{{{ data.inputAttrs }}}
					data-default-color="{{ data.default }}"
					value="{{ data.value }}"
					class="kirki-color-control<# if ( 'hue' === data.mode ) {#> screen-reader-text<# } #>"
					data-id="{{ data.id }}"
					{{ data.link }}
				/>
			</summary>
			<div class="kirki-colorpicker-wrapper colorpicker-{{ data.id.replace( '[', '--' ).replace( ']', '' ) }}">
		</details>
		<?php
	}
}
