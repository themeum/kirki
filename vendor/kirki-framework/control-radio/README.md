# control-radio

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-radio
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
	$wp_customize->register_control_type( '\Kirki\Control\Radio' );
	$wp_customize->register_control_type( '\Kirki\Control\Radio_Buttonset' );
	$wp_customize->register_control_type( '\Kirki\Control\Radio_Image' );
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
	$wp_customize->add_setting( 'my_control_radio', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => 'option-1',
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => 'sanitize_text_field', // Or a custom sanitization callback.
	] );
	$wp_customize->add_setting( 'my_control_radio_buttonset', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => 'option-1',
		'transport'         => 'refresh', // Or postMessage.
        'sanitize_callback' => function( $value ) { // Custom callback example.
            if ( 'option-1' !== $value || 'option-2' !== $value ) {
                return 'option-1';
            }
            return $value;
        },
	] );
	$wp_customize->add_setting( 'my_control_radio_image', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => 'option-1',
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => 'sanitize_text_field', // Or a custom sanitization callback.
	] );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Radio( $wp_customize, 'my_control_code', [
		'label'   => esc_html__( 'My Radio Control', 'theme_textdomain' ),
        'section' => 'my_section',
        'choices' => [
			'option-1' => esc_html__( 'Option 1', 'theme_textdomain' ),
			'option-2' => esc_html__( 'Option 2', 'theme_textdomain' ),
			'option-3' => esc_html__( 'Option 3', 'theme_textdomain' ),
			'option-4' => esc_html__( 'Option 4', 'theme_textdomain' ),
			'option-5' => esc_html__( 'Option 5', 'theme_textdomain' ),
		],
	] ) );
	$wp_customize->add_control( new \Kirki\Control\Radio_Buttonset( $wp_customize, 'my_control_code', [
		'label'   => esc_html__( 'My Radio-Buttonset Control', 'theme_textdomain' ),
        'section' => 'my_section',
        'choices' => [
			'option-1' => esc_html__( 'Option 1', 'theme_textdomain' ),
			'option-2' => esc_html__( 'Option 2', 'theme_textdomain' ),
		],
	] ) );
	$wp_customize->add_control( new \Kirki\Control\Radio( $wp_customize, 'my_control_code', [
		'label'   => esc_html__( 'My Radio-Image Control', 'theme_textdomain' ),
        'section' => 'my_section',
        'choices' => [
			'moto'    => 'https://jawordpressorg.github.io/wapuu/wapuu-archive/wapuu-moto.png',
			'cossack' => 'https://raw.githubusercontent.com/templatemonster/cossack-wapuula/master/cossack-wapuula.png',
			'travel'  => 'https://jawordpressorg.github.io/wapuu/wapuu-archive/wapuu-travel.png',
		],
	] ) );
} );
```
