---
layout: default
title: The "code" control
slug: code
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

Using the `code` control your users can enter custom CSS, JS, HTML (and others) which you can then use however you please in your themes.
Internally this control uses the `CodeMirror` library available in WordPress.

`CodeMirror` is only available in WordPress 4.9+ so if used in an older WordPress installation we gracefully fallback to a textarea field.

### Example

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'code',
	'settings'    => 'code_setting',
	'label'       => esc_attr__( 'Code Control', 'textdomain' ),
	'description' => esc_attr__( 'Description', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '',
	'choices'     => array(
		'language' => 'css',
	),
) );
```

### Usage

```php
<?php echo get_theme_mod( 'code_setting', '' ); ?>
```
