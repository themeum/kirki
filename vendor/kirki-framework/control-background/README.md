# control-background

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-background
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
	$wp_customize->register_control_type( '\Kirki\Control\Background' );
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
	$wp_customize->add_setting( 'my_control_background', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => [
			'background-color'      => '',
			'background-image'      => '',
			'background-repeat'     => '',
			'background-position'   => '',
			'background-size'       => '',
			'background-attachment' => '',
		],
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => [ '\kirki\Field\Background', 'sanitize' ], // Or a custom sanitization callback.
	] );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Background( $wp_customize, 'my_control_background', [
		'label'   => esc_html__( 'My Background Control', 'theme_textdomain' ),
		'section' => 'my_section',
	] ) );
} );
```
