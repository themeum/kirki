# control-checkbox

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-checkbox
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
	$wp_customize->register_control_type( '\Kirki\Control\Checkbox' );
	$wp_customize->register_control_type( '\Kirki\Control\Checkbox_Switch' );
	$wp_customize->register_control_type( '\Kirki\Control\Checkbox_Toggle' );
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
	$wp_customize->add_setting( 'my_control_checkbox', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => true,
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => [ '\kirki\Field\Checkbox', 'sanitize' ], // Or a custom sanitization callback.
	] );
	$wp_customize->add_setting( 'my_control_switch', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => true
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => [ '\kirki\Field\Checkbox', 'sanitize' ], // Or a custom sanitization callback.
	] );
	$wp_customize->add_setting( 'my_control_toggle', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => false
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => [ '\kirki\Field\Checkbox', 'sanitize' ], // Or a custom sanitization callback.
	] );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Checkbox( $wp_customize, 'my_control_checkbox', [
		'label'   => esc_html__( 'My Checkbox Control', 'theme_textdomain' ),
		'section' => 'my_section',
	] ) );
	$wp_customize->add_control( new \Kirki\Control\Checkbox_Switch( $wp_customize, 'my_control_checkbox', [
		'label'   => esc_html__( 'My Switch Control', 'theme_textdomain' ),
		'section' => 'my_section',
	] ) );
	$wp_customize->add_control( new \Kirki\Control\Checkbox_Toggle( $wp_customize, 'my_control_checkbox', [
		'label'   => esc_html__( 'My Toggle Control', 'theme_textdomain' ),
		'section' => 'my_section',
	] ) );
} );
```
