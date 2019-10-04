# WPTRT `color-alpha` Control

A color control for the WordPress Customizer with support for alpha channel.

The control will save either a HEX value (`#000000`) or RGBA (`rgba(0,0,0,0.9)`) depending on the opacity of the selected color. If the color is completely opaque, then it will save a HEX value. If the selected color is not completely opaque (has an alpha value smaller than 1) then the value will be saved as RGBA.

## Usage

### Registering the Control

This is a control containing a JS template. As such, it should be whitelisted in the Customizer. To do that we can use the [`WP_Customize_Manager::register_control_type`](https://developer.wordpress.org/reference/classes/wp_customize_manager/register_control_type/) method:

```php
add_action( 'customize_register', function( $wp_customize ) {
	$wp_customize->register_control_type( '\WPTRT\Customize\Control\ColorAlpha' );
} );
```

After we register the control using the above code, we can use it in the customizer using the [Customizer API](https://developer.wordpress.org/themes/customize-api/customizer-objects/):


```php
use \WPTRT\Customize\Control\ColorAlpha;

add_action( 'customize_register', function( $wp_customize ) {

	$wp_customize->add_setting( 'your_setting_id' , [
		'default'           => 'rgba(0,0,0,0.5)', // Use any HEX or RGBA value.
		'transport'         => 'refresh',
		'sanitize_callback' => 'my_custom_sanitization_callback'
	] );
	$wp_customize->add_control( new ColorAlpha( $wp_customize, 'your_setting_id', [
		'label'      => __( 'My Color', 'mytheme' ),
		'section'    => 'my_section',
		'settings'   => 'your_setting_id',
	] ) );
} );
```

## Available filters

### `wptrt_color_picker_alpha_url`

You can use this filter to change the URL for control assets. By default the control will work out of the box for any plugins and themes installed in `wp-content/themes` and `wp-content/plugins` respectively. It is possible however to change the URL by using the `wptrt_color_picker_alpha_url` filter:

```php
add_filter( 'wptrt_color_picker_alpha_url', function() {
	return get_template_directory_uri() . '/vendor/wptrt/control-color-alpha/src';
} );
```

## Sanitization

All controls in the WordPress Customizer should have a sanitize_callback defined.
You can write your own function and use it as a sanitization callback, or use the example function below:

```php
/**
 * Sanitize colors.
 *
 * @since 1.0.0
 * @param string $value The color.
 * @return string
 */
function my_custom_sanitization_callback( $value ) {
	// This pattern will check and match 3/6/8-character hex, rgb, rgba, hsl, & hsla colors.
	$pattern = '/^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/';
	\preg_match( $pattern, $value, $matches );
	// Return the 1st match found.
	if ( isset( $matches[0] ) ) {
		if ( is_string( $matches[0] ) ) {
			return $matches[0];
		}
		if ( is_array( $matches[0] ) && isset( $matches[0][0] ) ) {
			return $matches[0][0];
		}
	}
	// If no match was found, return an empty string.
	return '';
}
```

## Advanced Usage

This control allows you to save the value as either a `string` or an `array`. The default behavior is to save a `string`, but you can easily alter that by using the `choices` argument in the control:

```php
$wp_customize->add_control( new ColorAlpha( $wp_customize, 'your_setting_id', [
	'label'    => __( 'My Color', 'mytheme' ),
	'section'  => 'my_section',
	'settings' => 'your_setting_id',
	'choices'  => [
		'save_as' => 'array',
	]
] ) );
```

The value will then be saved using a format like this:

```php
[
	'r'    => 107, // Red.
	'g'    => 55, // Green.
	'b'    => 119, // Blue.
	'h'    => 289, // Hue.
	's'    => 37, // Saturation.
	'l'    => 34, // Lightness.
	'a'    => 0.82, // Alpha
	'hex'  => '#6b3777', // The HEX code of the color (alpha = 1)
	'css'  => 'rgba(107,55,119,0.82)', // The CSS value of the selected color.
	'a11y' => [ // An array of accessibility-related properties.
		'luminance'                         => 0.0719,
		// Contrast with white (value 0 - 21).
		'distanceFromWhite'                 => 8.613,
		// Contrast with black (value 0 - 21).
		'distanceFromBlack'                 => 2.438,
		// Maximum contrasting color. Use this to get the text-color
		// if the colorpicker is used to select a background-color.
		'maxContrastColor'                  => '#ffffff',
		// Readable text-colors on white background preserving the hue.
		// The 1st value has a minimum contrast of 7:1 with white.
		// The 2nd value has a minimum contrast of 4.5:1 with white.
		'readableContrastingColorFromWhite' => [ '#6b3777', '#6b3777' ],
		// Readable text-colors on black background preserving the hue.
		// The 1st value has a minimum contrast of 7:1 with black.
		// The 2nd value has a minimum contrast of 4.5:1 with black.
		'readableContrastingColorFromBlack' => [ '#bc83c7', '#a458b5' ],
		// True if the color is dark.
		'isDark'                            => true
	],
]
```

If you choose to save the value of this control as an `array`, then you will need to change the sanitization function for this setting. You can write your own, or use the one below.
```php
/**
 * Sanitize colors.
 *
 * @since 1.0.0
 * @param array $value The color.
 * @return array
 */
function my_custom_sanitization_callback( $value ) {
	return [
		'r' => (int) $value['r'],
		'g' => (int) $value['g'],
		'b' => (int) $value['b'],
		'h' => (int) $value['h'],
		's' => (int) $value['s'],
		'l' => (int) $value['l'],
		'a' => (float) $value['a'],

		'hex' => my_custom_color_string_sanitization_callback( $value['hex'] ),
		'css' => my_custom_color_string_sanitization_callback( $value['css'] ),

		'a11y' => [
			'luminance'         => (float) $value['a11y']['luminance'],
			'distanceFromWhite' => (float) $value['a11y']['distanceFromWhite'],
			'distanceFromBlack' => (float) $value['a11y']['distanceFromBlack'],
			'maxContrastColor'  => my_custom_color_string_sanitization_callback( $value['a11y']['maxContrastColor'] ),
			'isDark'            => (float) $value['a11y']['isDark'],

			'readableContrastingColorFromWhite' => [
				my_custom_color_string_sanitization_callback( $value['a11y']['readableContrastingColorFromWhite'][0] ),
				my_custom_color_string_sanitization_callback( $value['a11y']['readableContrastingColorFromWhite'][1] ),
			],
			'readableContrastingColorFromBlack' => [
				my_custom_color_string_sanitization_callback( $value['a11y']['readableContrastingColorFromBlack'][0] ),
				my_custom_color_string_sanitization_callback( $value['a11y']['readableContrastingColorFromBlack'][1] ),
			]
		]
	];
}

/**
 * Sanitize colors.
 *
 * @since 1.0.0
 * @param string $value The color.
 * @return string
 */
function my_custom_color_string_sanitization_callback( $value ) {
	// This pattern will check and match 3/6/8-character hex, rgb, rgba, hsl, & hsla colors.
	$pattern = '/^(\#[\da-f]{3}|\#[\da-f]{6}|\#[\da-f]{8}|rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0\.\d+|1))\)|hsla\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)(,\s*(0\.\d+|1))\)|rgb\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)|hsl\(\s*((\d{1,2}|[1-2]\d{2}|3([0-5]\d|60)))\s*,\s*((\d{1,2}|100)\s*%)\s*,\s*((\d{1,2}|100)\s*%)\))$/';
	\preg_match( $pattern, $value, $matches );
	// Return the 1st match found.
	if ( isset( $matches[0] ) ) {
		if ( is_string( $matches[0] ) ) {
			return $matches[0];
		}
		if ( is_array( $matches[0] ) && isset( $matches[0][0] ) ) {
			return $matches[0][0];
		}
	}
	// If no match was found, return an empty string.
	return '';
}
```

## Autoloading

You'll need to use an autoloader with this. Ideally, this would be [Composer](https://getcomposer.org).  However, we have a [basic autoloader](https://github.com/WPTRT/autoload) available to include with themes if needed.

### Composer

From the command line:

```sh
composer require wptrt/control-color-alpha
```

### WPTRT Autoloader

If using the WPTRT autoloader, use the following code:

```php
include get_theme_file_path( 'path/to/autoload/src/Loader.php' );

$loader = new \WPTRT\Autoload\Loader();
$loader->add( 'WPTRT\\Customize\\Control', get_theme_file_path( 'path/to/control-color-alpha/src' ) );
$loader->register();
```
