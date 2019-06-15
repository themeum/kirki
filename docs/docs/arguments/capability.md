---
layout: default
title: capability
published: true
mainMaxWidth: 55rem;
---

The `capability` argument allows you to define the the capability that a user must have in order to access the control for a field.

If left undefined it defaults to `edit_theme_options`.

You can set the `capability` in your config, as well as on individual fields.

Example:

```php
<?php
// Only allow network admins to access options in this config
Kirki::add_config( 'my_config', [
	'option_type' => 'theme_mod',
	'capability'  => 'manage_network_plugins'
];

// Add a simple text-field.
// This will inherit the capability from our config.
Kirki::add_field( 'my_config', [
	'type'     => 'text',
	'settings' => 'my_setting1',
	'label'    => esc_html__( 'Text Control 1', 'kirki' ),
	'section'  => 'my_section',
	'default'  => esc_html__( 'This is a default value', 'kirki' ),
	'priority' => 10,
] );

// Another text-field.
// This will override the capability of the config and be available to admins.
Kirki::add_field( 'my_config', [
	'type'        => 'text',
	'settings'    => 'my_setting2',
	'label'       => esc_html__( 'Text Control 2', 'kirki' ),
	'section'     => 'my_section',
	'default'     => esc_html__( 'This is a default value', 'kirki' ),
	'priority'    => 10,
	'capability'  => 'edit_theme_options'
] );
?>
```

For a complete list of WordPress capabilities and what capabilities each user role has, please visit the [documentation on wordpress.org](https://codex.wordpress.org/Roles_and_Capabilities).
