# Kirki Color Palette Control
A `control-color-palette` package for Kirki Customizer Framework.

## Table of Contents
- [Kirki Color Palette Control](#kirki-color-palette-control)
	- [Table of Contents](#table-of-contents)
	- [Installation](#installation)
	- [Usage](#usage)
		- [Using Kirki API](#using-kirki-api)
		- [Using WordPress Customizer API](#using-wordpress-customizer-api)
	- [License](#license)

## Installation
First, install the package using composer:

```bash
composer require kirki-framework/control-color-palette
```

Then make sure you have included the autoloader:

```php
require_once "your/path/to/vendor/autoload.php";
```

## Usage

This control can be consumed using Kirki API or using WordPress Customizer API.

### Using Kirki API

```php
new \Kirki\Field\Color_Palette(
	[
		'settings'    => 'your_control_setting_id',
		'label'       => esc_html__( 'Your Control Label', 'your-text-domain' ),
		'description' => esc_html__( 'Your control description.', 'your-text-domain' ),
		'section'     => 'your_section_id',
		'default'     => 5,
		'choices'     => [
			'colors' => [ '#000000', '#222222', '#444444', '#666666', '#888888', '#aaaaaa', '#cccccc', '#eeeeee', '#ffffff' ],
			'shape'  => 'round', // Optional, default is 'square'.
			'size'   => 20, // Optional, default is 28.
		],
	]
);
```

### Using WordPress Customizer API

```php
/**
 * Register customizer settings and controls.
 *
 * @param \WP_Customize_Manager $wp_customize The Customizer object.
 */
function your_customize_register_function( $wp_customize ) {

	// Add setting.
	$wp_customize->add_setting(
		'your_control_setting_id',
		[
			'type'       => 'theme_mod', // Or 'option'.
			'capability' => 'edit_theme_options',
			'default'    => 5,
			'transport'  => 'postMessage', // Or 'refresh'.
			'sanitize'   => 'intval', // Or 'absint' or other int sanitization.
		]
	);

	// Add control.
	$wp_customize->add_control(
		new \Kirki\Control\Color_Palette(
			$wp_customize,
			'your_control_setting_id',
			[
				'label'       => esc_html__( 'Your Control Label', 'your-text-domain' ),
				'description' => esc_html__( 'Your control description.', 'your-text-domain' ),
				'section'     => 'your_section_id',
				'choices'     => [
					'colors' => [ '#000000', '#222222', '#444444', '#666666', '#888888', '#aaaaaa', '#cccccc', '#eeeeee', '#ffffff' ],
					'shape'  => 'round', // Optional, default is 'square'.
					'size'   => 20, // Optional, default is 28.
				],
			]
		)
	);

	// Add more settings...

	// Add more controls...

}
add_action( 'customize_register', 'your_customize_register_function' );
```

## License
[MIT License](https://oss.ninja/mit?organization=Kirki%20Framework)
