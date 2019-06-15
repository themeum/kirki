---
layout: default
title: WordPress Customizer Dropdown Pages Control
slug: dropdown-pages
subtitle: Learn how to create a dropdown pages control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: int
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

Exactly the same as [`select`](select) controls.

The only difference is that the field `type` is defined as `dropdown-pages` and it will show a list of your pages. As a result, you don't have to manually define the `choices` argument as it will be auto-populated using your pages.

The default value for dropdown-pages controls can be a page ID (int).

example: `'default' => 42,`
The returned value is the ID of the selected page.

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'dropdown-pages',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'kirki' ),
	'section'     => 'section_id',
	'default'     => 42,
	'priority'    => 10,
] );
```
