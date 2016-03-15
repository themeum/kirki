---
layout: docs-field
title: number
sections:
  - Arguments
  - Example
  - Usage
edit: docs/controls/number.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>number</code>.
  - argument: default
    required: "yes"
    type: string|int|float
    description: Define a numeric value.
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'number',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 42,
) );
?>
{% endhighlight %}

### Usage

{% highlight php %}
<div style="font-size: <?php echo get_theme_mod( 'my_setting', '14' ); ?>px">
	<p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
{% endhighlight %}
