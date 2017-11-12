---
layout: default
title: The "generic" control
slug: generic
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

The `generic` control is one of the most versatile controls in Kirki. It allows you to create any HTML `input` type you want using any attributes you can imagine.

### Example

```php
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'generic',
	'settings'    => 'generic_custom_setting',
	'label'       => esc_attr__( 'Custom input Control.', 'kirki' ),
	'description' => esc_attr__( 'The "generic" control allows you to add any input type you want. In this case we use type="password" and define custom styles.', 'kirki' ),
	'section'     => 'generic_section',
	'default'     => '',
	'choices'     => array(
		'element'  => 'input',
		'type'     => 'password',
		'style'    => 'background-color:black;color:red;',
		'data-foo' => 'bar',
	),
) );
```

The above code will create this HTML in your control:

```html
<input type="password" style="background-color:black;color:red;" data-foo="bar" />
```

The `data-link` is added automatically so your fields will work out of the box.

`generic` fields are an abstraction of `text` fields and `textarea` fields. These child controls internally use the generic control by passing on the appropriate arguments.
