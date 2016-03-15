---
layout: docs-field
title: spacing
sections:
  - Arguments
  - Example
  - Usage
edit: docs/controls/spacing.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>spacing</code>.
  - argument: default
    required: "yes"
    type: array
    description: array of default values <code>array( 'top' => '10px', 'bottom' => '1em', 'left' => '0', 'right' => '0' )</code>. The default values also determine which of the elements will be displayed. If for example you only want to display top & bottom, then in the array of defaults only include top & bottom.
---

The functionality of `spacing` controls is similar to that of `dimension` controls:
They  allow you to add inputs that get sanitized as CSS dimensions (example: `10px`, `3em`, `48%`, `90vh` etc.).
The difference between `spacing` and `dimension` controls is that `spacing` controls allow you to control the left/right/top/bottom spacing of an element, and they save their values as an array instead of a string.

Invalid values are not saved, and the preview refresh is only triggered once a valid value has been entered.

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'spacing',
	'settings'    => 'my_setting',
	'label'       => __( 'Spacing Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => array(
		'top'    => '1.5em',
		'bottom' => '10px',
		'left'   => '40%',
		'right'  => '2rem',
	),
	'priority'    => 10,
) );
?>
{% endhighlight %}

You can disable a direction by removing its default value.
So this for example would only show top & bottom controls:

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'spacing',
	'settings'    => 'my_setting',
	'label'       => __( 'Spacing Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'priority'    => 10,
	'default'     => array(
		'top'    => '1.5em',
		'bottom' => '10px',
	),
) );
?>
{% endhighlight %}
