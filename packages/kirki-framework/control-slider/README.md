# Kirki Range Slider Control
A `control-range-slider` package for Kirki Customizer Framework.

## Table of Contents
- [Kirki Range Slider Control](#kirki-range-slider-control)
	- [Table of Contents](#table-of-contents)
	- [Installation](#installation)
	- [Usage](#usage)
		- [Using Kirki API](#using-kirki-api)
		- [Using WordPress Customizer API](#using-wordpress-customizer-api)
	- [License](#license)

## Installation
First, install the package using composer:

```bash
composer require kirki-framework/control-range-slider
```

Then make sure you have included the autoloader:

```php
require_once "your/path/to/vendor/autoload.php";
```

## Usage

This control can be consumed using Kirki API or using WordPress Customizer API.

### Using Kirki API

```php
new \Kirki\Field\RangeSlider(
	[
		'settings'    => 'your_control_setting_id',
		'label'       => esc_html__( 'Your Control Label', 'your-text-domain' ),
		'description' => esc_html__( 'Your control description.', 'your-text-domain' ),
		'section'     => 'your_section_id',
		'default'     => 5,
		'choices'     => [
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
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
		new \Kirki\Control\RangeSlider(
			$wp_customize,
			'your_control_setting_id',
			[
				'label'       => esc_html__( 'Your Control Label', 'your-text-domain' ),
				'description' => esc_html__( 'Your control description.', 'your-text-domain' ),
				'section'     => 'your_section_id',
				'choices'     => [
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
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
