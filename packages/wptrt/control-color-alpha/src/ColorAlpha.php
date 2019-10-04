<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Customize API: ColorAlpha class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 1.0.0
 */

namespace WPTRT\Customize\Control;

use WP_Customize_Color_Control;

/**
 * Customize Color Control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class ColorAlpha extends WP_Customize_Color_Control {

	/**
	 * Type.
	 *
	 * @access public
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'color-alpha';

	/**
	 * Enqueue scripts/styles for the color picker.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue() {
		$control_root_url = str_replace(
			wp_normalize_path( untrailingslashit( WP_CONTENT_DIR ) ),
			untrailingslashit( content_url() ),
			__DIR__
		);

		/**
		 * Filters the URL for the scripts.
		 *
		 * @since 1.0.0
		 * @param string $control_root_url The URL to the root folder of the package.
		 * @return string
		 */
		$control_root_url = apply_filters( 'wptrt_color_picker_alpha_url', $control_root_url );

		// Enquue scripts.
		wp_enqueue_script(
			'wp-color-picker-alpha',
			$control_root_url . '/wp-color-picker-alpha.js',
			[ 'wp-color-picker', 'underscore' ],
			'2.1.3',
			true
		);
		wp_enqueue_script(
			'wptrt-control-color-picker-alpha',
			$control_root_url . '/control.js',
			[ 'jquery', 'customize-base', 'wp-color-picker-alpha' ],
			'1.0',
			true
		);

		// Add custom styles.
		wp_enqueue_style(
			'wptrt-control-color-picker-alpha',
			$control_root_url . '/style.css',
			[ 'wp-color-picker' ],
			time()
		);
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();
		$this->json['choices'] = $this->choices;
	}

	/**
	 * Render a JS template for the content of the color picker control.
	 *
	 * The only difference between this and the template from the WP_Customize_Color_Control object
	 * is the addition of `data-alpha=true` in the <input> element.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function content_template() {
		?>
		<# var defaultValue = '#RRGGBB', defaultValueAttr = '',
			isHueSlider = data.mode === 'hue';
		if ( data.defaultValue && _.isString( data.defaultValue ) && ! isHueSlider ) {
			if ( '#' !== data.defaultValue.substring( 0, 1 ) ) {
				defaultValue = '#' + data.defaultValue;
			} else {
				defaultValue = data.defaultValue;
			}
			defaultValueAttr = ' data-default-color=' + defaultValue; // Quotes added automatically.
		} #>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<label><span class="screen-reader-text">{{{ data.label }}}</span>
			<# if ( isHueSlider ) { #>
				<input class="color-picker-hue" type="text" data-type="hue" />
			<# } else { #>
				<input class="color-picker-hex" type="text" maxlength="7" data-alpha="true" placeholder="{{ defaultValue }}" {{ defaultValueAttr }} />
			<# } #>
			</label>
		</div>
		<?php
	}
}
