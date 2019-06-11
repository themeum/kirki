---
layout: default
title: WordPress Customizer Generic Control
slug: generic
subtitle: Learn how to create a generic control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `generic` control is one of the most versatile controls in Kirki. It allows you to create any HTML `input` type you want using any attributes you can imagine.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'generic',
	'settings'    => 'generic_custom_setting',
	'label'       => esc_html__( 'Custom input Control.', 'kirki' ),
	'description' => esc_html__( 'The "generic" control allows you to add any input type you want. In this case we use type="password" and define custom styles.', 'kirki' ),
	'section'     => 'section_id',
	'default'     => '',
	'choices'     => [
		'element'  => 'input',
		'type'     => 'password',
		'style'    => 'background-color:black;color:red;',
		'data-foo' => 'bar',
	],
] );
```

The above code will create this HTML in your control:

```html
<input type="password" style="background-color:black;color:red;" data-foo="bar" />
```

The `data-link` is added automatically so your fields will work out of the box.

`generic` fields are an abstraction of `text` fields and `textarea` fields. These child controls internally use the generic control by passing on the appropriate arguments.
