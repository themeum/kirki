# control-color

## Installation

First, install the package using composer:

```bash
composer require kirki-framework/url-getter
composer require kirki-framework/control-base
composer require kirki-framework/control-color
```

Make sure you include the autoloader:
```php
require_once get_parent_theme_file_path( 'vendor/autoload.php' );
```

To add a control using the customizer API:

```php
add_action(
	'customize_register',
	function( $wp_customize ) {
		$wp_customize->add_setting(
			'my_control',
			[
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'default'           => '#fff',
				'transport'         => 'refresh', // Or postMessage.
				'sanitize_callback' => 'sanitize_text_field', // Or a custom sanitization callback.
			]
		);

		$wp_customize->add_control(
			new \Kirki\Control\Color(
				$wp_customize,
				'my_control',
				[
					'label'   => esc_html__( 'My Color Control', 'theme_textdomain' ),
					'section' => 'colors',
					'choices' => [
						'alpha' => true,
					]
				]
			)
		);
	}
);
```