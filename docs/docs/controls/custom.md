---
layout: default
title: WordPress Customizer Custom Control
slug: custom
subtitle: Learn how to create a custom control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: null
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

Custom controls allow you to add raw HTML in a control. Mostly used for informative controls, expanatory headers etc, but you can use it for whatever you want.

You can enter your custom HTML in the field's `default` argument.

### Example

```php
<?php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'custom',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'kirki' ),
	'section'     => 'section_id',
	'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'You can enter custom markup in this control and use it however you want', 'kirki' ) . '</div>',
	'priority'    => 10,
] );
?>
```

The content of the field is defined in the `default` argument.
You can use valid HTML.

### Usage

The `custom` control does not return any value. Its function is usually decorative and informational in the customizer.
