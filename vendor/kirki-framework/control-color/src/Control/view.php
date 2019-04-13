<?php
/**
 * Customizer control underscore.js template.
 *
 * @package   kirki-framework/control-color
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

?>
<#
data = _.defaults( data, {
	label: '',
	description: '',
	mode: 'full',
	inputAttrs: '',
	'data-palette': data['data-palette'] ? data['data-palette'] : true,
	'data-default-color': data['data-default-color'] ? data['data-default-color'] : '',
	'data-alpha': data['data-alpha'] ? data['data-alpha'] : false,
	value: '',
	'data-id': ''
} );
#>

<div class="kirki-input-container" data-id="{{ data['data-id'] }}" data-has-alpha="{{ data['data-alpha'] }}">
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
			type="text"
			data-type="{{ data.mode }}"
			{{{ data.inputAttrs }}}
			data-palette="{{ data['data-palette'] }}"
			data-default-color="{{ data['data-default-color'] }}"
			value="{{ data.value }}"
			class="kirki-color-control"
			data-id="{{ data['data-id'] }}"
		/>
		<button class="reset"><?php esc_html_e( 'Reset', 'kirki' ); ?></button>
	</div>
	<div class="kirki-colorpicker-wrapper colorpicker-{{ data['data-id'] }}"></div>
	<div class="kirki-colorpicker-wrapper-palette">
		<# if ( 'hue' !== data.mode && true === data['data-palette'] ) { #>
			<?php $editor_palette = current( (array) get_theme_support( 'editor-color-palette' ) ); ?>
			<?php if ( ! empty( $editor_palette ) ) : ?>
				<# var kirkiColorEditorPalette = <?php echo wp_strip_all_tags( json_encode( $editor_palette ) ); ?>; #>
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
		<# } else if ( 'object' === typeof data['data-palette'] ) { #>
			<# _.each( data.data['data-palette'], function( paletteColor ) { #>
				<button class="palette-color palette-color-{{ paletteColor }}" style="background-color:{{ paletteColor }};" title="{{ paletteColor }}" data-color="{{ paletteColor }}">
					<span class="screen-reader-text">{{ paletteColor }}</span>
				</button>
			<# }); #>
		<# } #>
	</div>
</div>
