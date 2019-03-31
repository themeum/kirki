# control-color-palette

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-color-palette
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
	$wp_customize->register_control_type( '\Kirki\Control\Color_Palette' );
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
	$wp_customize->add_setting( 'my_control_color_palette', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => '#00acdc',
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => [ '\kirki\Field\Color_Palette', 'sanitize' ], // Or a custom sanitization callback.
	] );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Color_Palette( $wp_customize, 'my_control_color_palette', [
		'label'   => esc_html__( 'My Color-Palette Control', 'theme_textdomain' ),
        'section' => 'my_section',
        'choices' => [
            'colors' => [ '#00acdc', '#f00', '#fff', '#469aa1' ],
            'style'  => 'round',
            'size'   => 23,
        ],
	] ) );
} );
```
