---
layout: docs-field
title: textarea
edit: docs/controls/textarea.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>textarea</code>.
---

`textarea` controls allow you to add a simple, multi-line text input.

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'     => 'textarea',
	'settings' => 'my_setting',
	'label'    => __( 'Textarea Control', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => esc_attr__( 'This is a defualt value', 'my_textdomain' ),
	'priority' => 10,
) );
?>
{% endhighlight %}
