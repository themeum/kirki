# control-select

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-select
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
	$wp_customize->register_control_type( '\Kirki\Control\Select' );
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
	$wp_customize->add_setting( 'my_control', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => 'option-1',
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => function( $value ) {
            if ( ! in_array( $value, [ 'option-1', 'option-2', 'option-3', 'option-3', 'option-4', 'option-5' ], true ) ) {
                return 'option-1';
            }
            return $value;
        },
	] );
	$wp_customize->add_setting( 'my_control_multi', [
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'default'           => [ 'option-1', 'option-2' ],
		'transport'         => 'refresh', // Or postMessage.
		'sanitize_callback' => function( $value ) {
            $value     = (array) $value;
            $sanitized = [];

            foreach ( $value as $sub_value ) {
                if ( ! in_array( $sub_value, [ 'option-1', 'option-2', 'option-3', 'option-3', 'option-4', 'option-5' ], true ) ) {
                    $sanitized[] = $sub_value;
                }
            }
            // We want a max of 2 options.
            if ( 2 < count( $sanitized ) ) {
                return array_slice( $sanitized, 0, 2 );
            }
            return $sanitized;
        },
	] );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Select( $wp_customize, 'my_control', [
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
	$wp_customize->add_control( new \Kirki\Control\Select( $wp_customize, 'my_control_multi', [
		'label'   => esc_html__( 'My Control', 'theme_textdomain' ),
        'section' => 'my_section',
        'choices' => [
			'option-1' => esc_html__( 'Option 1', 'theme_textdomain' ),
			'option-2' => esc_html__( 'Option 2', 'theme_textdomain' ),
			'option-3' => esc_html__( 'Option 3', 'theme_textdomain' ),
			'option-4' => esc_html__( 'Option 4', 'theme_textdomain' ),
			'option-5' => esc_html__( 'Option 5', 'theme_textdomain' ),
        ],
        'multiple' => 2,
	] ) );
} );
```
