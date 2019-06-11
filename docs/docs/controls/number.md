---
layout: default
title: WordPress Customizer Number Control
slug: number
subtitle: Learn how to create a number control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
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
Kirki::add_field( 'theme_config_id', [
	'type'        => 'number',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'kirki' ),
	'section'     => 'section_id',
	'default'     => 42,
	'choices'     => [
		'min'  => 0,
		'max'  => 80,
		'step' => 1,
	],
] );
```

### Usage

```php
<div style="font-size: <?php echo get_theme_mod( 'my_setting', 14 ); ?>px">
	<p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
```
