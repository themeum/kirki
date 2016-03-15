---
layout: docs-field
title: sortable
sections:
  - Example
edit: docs/controls/sortable.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>sortable</code>.
  - argument: default
    required: "yes"
    type: array
    description: array of default selected items.
  - argument: choices
    required: "yes"
    type: array
    description: An array of all available options, with each option being an array (<code>$key => $label</code>)
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'sortable',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => array(
		'option3',
		'option1',
		'option4'
	),
	'choices'     => array(
		'option1' => esc_attr__( 'Option 1', 'kirki' ),
		'option2' => esc_attr__( 'Option 2', 'kirki' ),
		'option3' => esc_attr__( 'Option 3', 'kirki' ),
		'option4' => esc_attr__( 'Option 4', 'kirki' ),
		'option5' => esc_attr__( 'Option 5', 'kirki' ),
		'option6' => esc_attr__( 'Option 6', 'kirki' ),
	),
	'priority'    => 10,
) );
?>
{% endhighlight %}
