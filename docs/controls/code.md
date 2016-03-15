---
layout: docs-field
title: code
sections:
  - Arguments
  - Example
  - Usage
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>code</code>.
  - argument: default
    required: "yes"
    type: string
    description: Define a default string that will be used, or use an empty string (<code>'default' => ''</code>)
  - argument: choices
    required: "yes"
    type: array
    description: Use it to define the language to be used, the theme, and the area's height.
edit: docs/controls/code.md
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'code',
	'settings'    => 'code_demo',
	'label'       => __( 'Code Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'body { background: #fff; }',
	'priority'    => 10,
	'choices'     => array(
		'language' => 'css',
		'theme'    => 'monokai',
		'height'   => 250,
	),
) );
?>
{% endhighlight %}

### Usage

The saved values is a `string`

{% highlight php %}
<?php echo get_theme_mod( 'my_setting', '' ); ?>
{% endhighlight %}
