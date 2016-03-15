---
layout: docs-field
title: radio-buttonset
sections:
  - Arguments
  - Example
edit: docs/controls/radio-buttonset.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>radio-buttonset</code>.
  - argument: default
    required: "yes"
    type: string
    description: Use the key of one of the items in the <code>choices</code> argument.
  - argument: choices
    required: "yes"
    type: array
    description: Use an array of elements. Format <code>$key => $label</code>.
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'my_setting',
	'label'       => __( 'Radio-Buttonset Control', 'my_textdomain' ),
	'section'     => 'radio',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => esc_attr__( 'Red', 'my_textdomain' ),
		'green' => esc_attr__( 'Green', 'my_textdomain' ),
		'blue'  => esc_attr__( 'Blue', 'my_textdomain' ),
	),
) );
?>
{% endhighlight %}
