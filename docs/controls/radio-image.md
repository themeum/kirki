---
layout: docs-field
title: radio-image
sections:
  - Arguments
  - Example
edit: docs/controls/radio-image.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>radio-image</code>.
  - argument: default
    required: "yes"
    type: string
    description: Use the key of one of the items in the <code>choices</code> argument.
  - argument: choices
    required: "yes"
    type: array
    description: Use an array of elements. Format <code>$key => $url</code>.
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'radio-image',
	'settings'    => 'my_setting',
	'label'       => __( 'Radio Control', 'my_textdomain' ),
	'section'     => 'radio',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => 'https://my-domain.com/red.png',
		'green' => 'https://my-domain.com/green.png',
		'blue'  => 'https://my-domain.com/blue.png',
	),
) );
?>
{% endhighlight %}
