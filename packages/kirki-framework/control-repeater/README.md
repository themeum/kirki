# control-repeater

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/control-repeater
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
	$wp_customize->register_control_type( '\Kirki\Control\Repeater' );
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
	$wp_customize->add_setting( new \Kirki\Settings\Repeater( $wp_customize, 'my_repeater_setting', [
		'default'           => [
			[
				'link_text'   => esc_html__( 'Kirki Site', 'theme_textdomain' ),
				'link_url'    => 'https://aristath.github.io/kirki/',
				'link_target' => '_self',
			],
			[
				'link_text'   => esc_html__( 'Kirki Repository', 'theme_textdomain' ),
				'link_url'    => 'https://github.com/aristath/kirki',
				'link_target' => '_self',
			],
		],
		'type'              => 'theme_mod',
		'capability'        => 'edit_theme_options',
		'transport'         => 'refresh',
		'sanitize_callback' => function( $value ) { // Custom sanitization callback.
			$value = ( is_array( $value ) ) ? $value : json_decode( urldecode( $value ), true );
			$value = ( empty( $value ) || ! is_array( $value ) ) ? [] : $value;

			foreach ( $value as $row_index => $row_data ) {
				$value[ $row_index ]['link_text'] = isset( $row_data['link_text'] ) ? sanitize_text_field( $row_data['link_text'] ) : '';
				$value[ $row_index ]['link_url'] = isset( $row_data['link_url'] ) ? esc_url( $row_data['link_url'] ) : '';
				$value[ $row_index ]['link_target'] = isset( $row_data['link_target'] ) && in_array( $row_data['link_target'], [ '_self', '_blank', '_parent', '_top' ], true ) ? $row_data['link_target'] : '_self';
			}
		},
	] ) );

	// Add controls.
	$wp_customize->add_control( new \Kirki\Control\Repeater( $wp_customize, 'my_repeater_setting', [
		'label'   => esc_html__( 'My Control', 'theme_textdomain' ),
		'section' => 'colors',
		'fields'  => [
			'link_text'   => [
				'type'        => 'text',
				'label'       => esc_html__( 'Link Text', 'theme_textdomain' ),
				'description' => esc_html__( 'This will be the label for your link', 'theme_textdomain' ),
				'default'     => '',
			],
			'link_url'    => [
				'type'        => 'text',
				'label'       => esc_html__( 'Link URL', 'theme_textdomain' ),
				'description' => esc_html__( 'This will be the link URL', 'theme_textdomain' ),
				'default'     => '',
			],
			'link_target' => [
				'type'        => 'radio',
				'label'       => esc_html__( 'Link Target', 'theme_textdomain' ),
				'description' => esc_html__( 'This will be the link target', 'theme_textdomain' ),
				'default'     => '_self',
				'choices'     => [
					'_blank' => esc_html__( 'New Window', 'theme_textdomain' ),
					'_self'  => esc_html__( 'Same Frame', 'theme_textdomain' ),
				],
			],
		],
	] ) );
} );
```
