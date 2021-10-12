# kirki-framework/control-slider
A slider control package for Kirki Customizer Framework.

## Table of Contents
- [kirki-framework/control-slider](#kirki-frameworkcontrol-slider)
	- [Table of Contents](#table-of-contents)
	- [Installation](#installation)
	- [Usage](#usage)
		- [Using the simplified API](#using-the-simplified-api)
		- [Using the Customizer API](#using-the-customizer-api)
	- [Development](#development)
	- [License](#license)

## Installation
First, install the package using composer:

```bash
composer require kirki-framework/control-slider
```

Then make sure you have included the autoloader:

```php
require_once "your/path/to/vendor/autoload.php";
```

## Usage

This control can be consumed using Kirki API or using WordPress Customizer API.

### Using the simplified API

```php
new \Kirki\Field\Slider(
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

### Using the Customizer API

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
		new \Kirki\Control\Slider(
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

## Development

If you want to make changes to this control, you can edit the JS files in the `src` folder.
- If you haven't installed the packages, then run `npm install`
- After done editing, run `npm run build`

## License
[MIT License](https://oss.ninja/mit?organization=Kirki%20Framework)
