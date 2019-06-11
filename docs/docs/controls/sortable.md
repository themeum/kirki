---
layout: default
title: WordPress Customizer Sortable Control
slug: sortable
subtitle: Learn how to create a sortable control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

Example:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'sortable',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'This is the label', 'kirki' ),
	'section'     => 'section_id',
	'default'     => [
		'option3',
		'option1',
		'option4'
	],
	'choices'     => [
		'option1' => esc_html__( 'Option 1', 'kirki' ),
		'option2' => esc_html__( 'Option 2', 'kirki' ),
		'option3' => esc_html__( 'Option 3', 'kirki' ),
		'option4' => esc_html__( 'Option 4', 'kirki' ),
		'option5' => esc_html__( 'Option 5', 'kirki' ),
		'option6' => esc_html__( 'Option 6', 'kirki' ),
	],
	'priority'    => 10,
] );
```

Example of how to load template parts based on the value of the control in a template:

```php
<?php
// Get the parts.
$template_parts = get_theme_mod( 'my_setting', array( 'option3', 'option1', 'option4' ) );

// Loop parts.
foreach ( $template_parts as $template_part ) {
	get_template_part( 'partial-templates/' . $template_part );
}
```
