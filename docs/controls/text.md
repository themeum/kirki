---
layout: docs-field
title: text
edit: docs/controls/text.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>text</code>.
---

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'     => 'text',
	'settings' => 'my_setting',
	'label'    => __( 'Text Control', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => esc_attr__( 'This is a defualt value', 'my_textdomain' ),
	'priority' => 10,
) );
?>
{% endhighlight %}
