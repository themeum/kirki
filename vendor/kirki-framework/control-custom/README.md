# control-custom

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-custom
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
	$wp_customize->register_control_type( '\Kirki\Control\Custom' );
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
		'default'           => '<div style="padding:12px;background-color:#000;color>' . esc_html__( 'content', 'theme_textdomain' ) . '</div>',
		'transport'         => 'refresh',
		'sanitize_callback' => '__return_null',
	] );

	// Add control.
	$wp_customize->add_control( new \Kirki\Control\Custom( $wp_customize, 'my_control', [
		'label'   => esc_html__( 'My Custom Control', 'theme_textdomain' ),
		'section' => 'colors',
	] ) );
} );
```
