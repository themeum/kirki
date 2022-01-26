# control-palette

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-palette
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
	$wp_customize->register_control_type( '\Kirki\Control\Palette' );
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
		'sanitize_callback' => 'sanitize_text_field', // Or a custom sanitization callback.
	] );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Palette( $wp_customize, 'my_control_code', [
		'label'   => esc_html__( 'My Control', 'theme_textdomain' ),
        'section' => 'my_section',
        'choices' => [
			'green' => [ '#E8F5E9', '#C8E6C9', '#A5D6A7', '#81C784', '#66BB6A', '#4CAF50', '#43A047', '#388E3C', '#2E7D32', '#1B5E20', '#B9F6CA', '#69F0AE', '#00E676', '#00C853' ],
			'bnw'   => [ '#000000', '#ffffff' ],
		],
	] ) );
} );
```
