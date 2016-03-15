---
layout: docs-field
title: repeater
sections:
  - Arguments
  - Example
edit: docs/controls/repeater.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>repeater</code>.
  - argument: default
    required: "no"
    type: array
    description: Use the key of one of the items in the <code>choices</code> argument.
  - argument: fields
    required: "yes"
    type: array
    description: "Define an array of fields that will be used. Each defined field must be an array."
---

### Example

Creating a repeater control where each row contains 2 textfields.

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'repeater',
	'label'       => esc_attr__( 'Repeater Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'priority'    => 10,
	'settings'    => 'my_setting',
	'default'     => array(
		array(
			'link_text' => esc_attr__( 'Kirki Site', 'my_textdomain' ),
			'link_url'  => 'https://kirki.org',
		),
		array(
			'link_text' => esc_attr__( 'Kirki Repository', 'my_textdomain' ),
			'link_url'  => 'https://github.com/aristath/kirki',
		),
	),
	'fields' => array(
		'link_text' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link Text', 'my_textdomain' ),
			'description' => esc_attr__( 'This will be the label for your link', 'my_textdomain' ),
			'default'     => '',
		),
		'link_url' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link URL', 'my_textdomain' ),
			'description' => esc_attr__( 'This will be the link URL', 'my_textdomain' ),
			'default'     => '',
		),
	)
) );
?>
{% endhighlight %}
