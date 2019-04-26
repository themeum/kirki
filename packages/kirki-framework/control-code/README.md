# control-code

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-code
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
	$wp_customize->register_control_type( '\Kirki\Control\Code' );
} );

/**
 * Add Customizer settings & controls.
 * 
 * @since 1.0
 * @param WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
 * @return void
 */
add_action( 'customize_register', function( $wp_customize ) {

	// Add settings.
	$wp_customize->add_setting( 'my_control_code', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => '',
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => function( $value ) { // Or a custom sanitization callback.
            return $value;
        },
	] );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Code( $wp_customize, 'my_control_code', [
		'label'   => esc_html__( 'My Code Control', 'theme_textdomain' ),
        'section' => 'my_section',
        'choices' => [
            'language' => 'css',
		],
	] ) );
} );
```
