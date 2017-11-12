---
layout: default
title: option_type
published: false
---


You don't have to manually set the `option_name` argument as it is automatically set for you from the config you're using.

However, if needed, you can override it on a per-field basis.

Example:

```php
<?php
// Use serialized options under "my_option".
// Settings will be accessed from "my_option['my_setting']".
Kirki::add_config( 'my_config', array(
	'option_type' => 'option',
	'option_name' => 'my_option'
);

// Add a simple text-field.
// This will inherit the option_type from our config.
Kirki::add_field( 'my_config', array(
	'type'     => 'text',
	'settings' => 'my_setting',
	'label'    => __( 'Text Control', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => esc_attr__( 'This is a defualt value', 'my_textdomain' ),
	'priority' => 10,
) );

// Another text-field.
// This will override the option_type of the config.
// We want this option to be saved as a theme_mod.
Kirki::add_field( 'my_config', array(
	'type'        => 'text',
	'settings'    => 'my_setting',
	'label'       => __( 'Text Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => esc_attr__( 'This is a defualt value', 'my_textdomain' ),
	'priority'    => 10,
	'option_type' => 'theme_mod',
) );
?>
```
