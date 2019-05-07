# control-multicolor

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-multicolor
```

Make sure you include the autoloader:
```php
require_once get_parent_theme_file_path( 'vendor/autoload.php' );
```

To add a control using the customizer API:

```php

/**
 * Registers the control and whitelists it for JS templating.
 *
 * @since 1.0
 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
 * @return void
 */
add_action( 'customize_register', function( $wp_customize ) {
	$wp_customize->register_control_type( '\Kirki\Control\Multicolor' );
} );

/**
 * Add Customizer settings & controls.
 * 
 * @since 1.0
 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
 * @return void
 */
add_action( 'customize_register', function( $wp_customize ) {

	// Add setting.
	$wp_customize->add_setting( 'my_control', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => [
            'default' => '#ffffff',
            'active'  => '#08ccff',
        ],
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => [ '\Kirki\Field\Multicolor', 'sanitize' ], // Or a custom sanitization callback.
	] );

	// Add control.
	$wp_customize->add_control( new \Kirki\Control\Multicolor( $wp_customize, 'my_control', [
		'label'   => esc_html__( 'My Control', 'theme_textdomain' ),
		'section' => 'my_section',
		'choices' => [
			'option-1' => esc_html__( 'Option 1', 'theme_textdomain' ),
			'option-2' => esc_html__( 'Option 2', 'theme_textdomain' ),
			'option-3' => esc_html__( 'Option 3', 'theme_textdomain' ),
			'option-4' => esc_html__( 'Option 4', 'theme_textdomain' ),
			'option-5' => esc_html__( 'Option 5', 'theme_textdomain' ),
		],
	] ) );
} );
```
