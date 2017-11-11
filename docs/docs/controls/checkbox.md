---
layout: default
title: The "checkbox" control
slug: checkbox
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: boolean
---

`checkbox` controls provide a simple true/false choice to users.

Example:

```php
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'checkbox',
	'settings'    => 'checkbox_setting',
	'label'       => esc_attr__( 'Checkbox Control', 'kirki' ),
	'description' => esc_attr__( 'Description', 'kirki' ),
	'section'     => 'checkbox_section',
	'default'     => true,
) );
```
