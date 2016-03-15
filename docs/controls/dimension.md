---
layout: docs-field
title: dimension
sections:
  - Arguments
  - Example
  - Usage
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>dimension</code>.
  - argument: default
    required: "yes"
    type: string
    description: Define a valid CSS value. Example <code>10px</code>, <code>1em</code>, <code>90vh</code> etc.
edit: docs/controls/dimension.md
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'dimension',
	'settings'    => 'my_setting',
	'label'       => __( 'Dimension Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1.5em',
	'priority'    => 10,
) );
?>
{% endhighlight %}

### Usage

{% highlight php %}
<div style="font-size: <?php echo get_theme_mod( 'my_setting', '1em' ); ?>">
	<p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
{% endhighlight %}
