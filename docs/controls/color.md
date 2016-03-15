---
layout: docs-field
title: color
sections:
  - Arguments
  - Example
  - Usage
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>color</code>.
  - argument: default
    required: "yes"
    type: string
    description: Define a HEX or RGBA value as default. Ex. <code>rgba(0,0,0,1)</code> or <code>#000000</code>.
  - argument: choices
    required: "no"
    type: array
    description: If you want to use RGBA colors, set to <code>array( 'alpha' => true )</code>
edit: docs/controls/color.md
---

Kirki's `color` control extends WordPress Core's color control, allowing you to select not only `HEX` colors but also `RGBA` colors.

If you want to enable the alpha layer (opacity) in your color controls, you can add `'alpha' => true` to your field's `choices` argument.

### Example:

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'color',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '#0088CC',
	'priority'    => 10,
	'alpha'       => true,
) );
?>
{% endhighlight %}

### Usage
Most times you won't have to manually retrieve the value of `color` controls since the `output` argument can cover most use-cases.

The `color` control saves its value as a `string`:

{% highlight php %}
<div style="color:<?php echo get_theme_mod( 'my_setting', '#FFFFFF' ); ?>">
	<p>The text-color of this div is controlled by "my_setting".
</div>
{% endhighlight %}
