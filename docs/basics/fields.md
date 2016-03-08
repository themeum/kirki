# Adding Fields

If you are familiar with the WordPress Customizer API then this will be a lot easier for you.
To add a new simple text field using Kirki you will have to add the following to your project:

```php
Kirki::add_field( 'my_config', array(
	'settings' => 'my_setting',
	'label'    => __( 'My custom control', 'translation_domain' ),
	'section'  => 'my_section',
	'type'     => 'text',
	'priority' => 10,
	'default'  => 'some-default-value',
) );
```

This of course requires that you have first created a `'my_config'` configuration.

What Kirki does internally would look something like this:
```php
function my_custom_text_settings( $wp_customize ) {

	// Register the settings
	$wp_customize->add_setting( 'my_setting', array(
		'default'        => 'some-default-value',
		'type'           => 'theme_mod',
		'capability'     => 'edit_theme_options',
	) );

	// Add the controls
	$wp_customize->add_control( 'my_setting', array(
		'label'       => __( 'My custom control', 'translation_domain' ),
		'section'     => 'my_section',
		'settings'    => 'my_setting',
		'type'        => 'text',
		'priority'    => 10
    ) );

}
add_action( 'customize_register', 'my_custom_text_settings' );
```

When you create a new field using the Kirki API, we automatically create the setting and the control for that field.

Below is a list of all the arguments you can use when creating a field as well as documentation on each of these arguments.

# Breakdown of a field creation call:

When creating fields you will have to use a syntax like this:

```php
Kirki::add_field( $config_id, $field_arguments )
```

* `$config_id`: string. See [Getting Started - Creating a configuration](https://github.com/aristath/kirki/wiki/Getting-Started#creating-a-configuration-for-your-project) for details. You can use the configuration to define how your project will save & handle data.
* `$field_arguments`: array. This is where you can define the properties of your field. Read below for a detailed breakdown of each argument.

# Field arguments

Depending on the control type you want to create, the arguments vary.

## Required arguments

* type
* settings
* section
* default
