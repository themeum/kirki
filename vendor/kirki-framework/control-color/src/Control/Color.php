<?php
/**
 * Customizer Control: color.
 *
 * @package   kirki-framework/control-color
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Adds a color & color-alpha control
 *
 * @since 1.0
 */
class Color extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-color';

	/**
	 * The version. Used in scripts & styles for cache-busting.
	 *
	 * @static
	 * @access public
	 * @since 1.0.2
	 * @var string
	 */
	public static $control_ver = '1.0.7';

	/**
	 * Colorpicker palette
	 *
	 * @access public
	 * @since 1.0
	 * @var array|bool
	 */
	public $palette = true;

	/**
	 * Mode.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $mode = 'full';

	/**
	 * Has the template already been added?
	 *
	 * @static
	 * @access private
	 * @since 1.0.1
	 * @var bool
	 */
	private static $template_added = false;

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		// Enqueue iro.
		wp_enqueue_script( 'iro', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/node_modules/@jaames/iro/dist/iro.min.js' ), [], '4.3.3', true );
		wp_enqueue_script( 'iro-transparency-plugin', URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/node_modules/iro-transparency-plugin/dist/iro-transparency-plugin.min.js' ), [ 'iro' ], '1.0.2', true );

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
	 * @since 1.0.6
	 * @return string
	 */
	public static function get_control_path_url() {
		return URL::get_from_path( dirname( __DIR__ ) );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function to_json() {
		parent::to_json();

		$this->json['palette']          = $this->palette;
		$this->json['choices']['alpha'] = ( isset( $this->choices['alpha'] ) && $this->choices['alpha'] ) ? 'true' : 'false';
		$this->json['mode']             = $this->mode;
		$this->json['defaultPalette']   = [ '#f78da7', '#cf2e2e', '#ff6900', '#fcb900', '#7bdcb5', '#00d084', '#8ed1fc', '#0693e3', '#eee', '#abb8c3', '#313131' ];
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
	 * @since 1.0.8
	 * @return void
	 */
	protected function content_template() {
		?>
		<#
		data.choices = data.choices || {};
		data.choices.alpha = data.choices.alpha || false;
		#>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</label>
		<div class="kirki-color-input-wrapper collapsed mode-{{ data.mode }}">
			<button class="toggle-colorpicker" title="<?php esc_attr_e( 'Select Color', 'kirki' ); ?>">
				<span class="screen-reader-text"><?php esc_html_e( 'Select Color', 'kirki' ); ?></span>
				<span class="placeholder"></span>
			</button>
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
			<button class="reset">
				<# if ( ! data.default ) { #>
					<?php esc_html_e( 'Clear', 'kirki' ); ?>
				<# } else { #>
					<?php esc_html_e( 'Default', 'kirki' ); ?>
				<# } #>
			</button>
		</div>
		<div class="kirki-colorpicker-wrapper colorpicker-{{ data.id.replace( '[', '--' ).replace( ']', '' ) }}"></div>
		<div class="kirki-colorpicker-wrapper-palette">
			<# if ( 'hue' !== data.mode && true === data.palette ) { #>
				<?php $editor_palette = current( (array) get_theme_support( 'editor-color-palette' ) ); ?>
				<?php if ( ! empty( $editor_palette ) ) : ?>
					<# var kirkiColorEditorPalette = <?php echo wp_strip_all_tags( wp_json_encode( $editor_palette ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>; #>
					<# _.each( kirkiColorEditorPalette, function( paletteColor ) { #>
						<button class="palette-color palette-color-{{ paletteColor.slug }}" style="background-color:{{ paletteColor.color }};" title="{{ paletteColor.name }}" data-color="{{ paletteColor.color }}">
							<span class="screen-reader-text">{{ paletteColor.name }}</span>
						</button>
					<# }); #>
				<?php else : ?>
					<# _.each( data.defaultPalette, function( paletteColor ) { #>
						<button class="palette-color palette-color-{{ paletteColor }}" style="background-color:{{ paletteColor }};" title="{{ paletteColor }}" data-color="{{ paletteColor }}">
							<span class="screen-reader-text">{{ paletteColor }}</span>
						</button>
					<# }); #>
				<?php endif; ?>
			<# } else if ( 'object' === typeof data.palette ) { #>
				<# _.each( data.data.palette, function( paletteColor ) { #>
					<button class="palette-color palette-color-{{ paletteColor }}" style="background-color:{{ paletteColor }};" title="{{ paletteColor }}" data-color="{{ paletteColor }}">
						<span class="screen-reader-text">{{ paletteColor }}</span>
					</button>
				<# }); #>
			<# } #>
		</div>
		<?php
	}
}
