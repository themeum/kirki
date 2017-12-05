---
layout: default
title: The "number" control
slug: number
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

`number` controls are simple numeric fields that only accept numbers as input and not free text.

### Example

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'number',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'This is the label', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => 42,
	'choices'     => array(
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	),
) );
```

### Usage

```php
<div style="font-size: <?php echo get_theme_mod( 'my_setting', '14' ); ?>px">
	<p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
```
