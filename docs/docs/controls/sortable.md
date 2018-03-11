---
layout: default
title: The "sortable" control
slug: sortable
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
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
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'sortable',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => array(
		'option3',
		'option1',
		'option4'
	),
	'choices'     => array(
		'option1' => esc_attr__( 'Option 1', 'textdomain' ),
		'option2' => esc_attr__( 'Option 2', 'textdomain' ),
		'option3' => esc_attr__( 'Option 3', 'textdomain' ),
		'option4' => esc_attr__( 'Option 4', 'textdomain' ),
		'option5' => esc_attr__( 'Option 5', 'textdomain' ),
		'option6' => esc_attr__( 'Option 6', 'textdomain' ),
	),
	'priority'    => 10,
) );
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
