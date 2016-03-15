---
layout: docs-field
title: checkbox
sections:
  - Arguments
  - Creating a checkbox Control
  - Creating a switch Control
  - Creating a toggle Control
  - Usage
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>checkbox</code>, <code>switch</code> or <code>toggle</code>.
  - argument: choices
    required: "no"
    type: array
    description: If you're using switches, you can use this to change the ON/OFF labels.
edit: docs/controls/checkbox.md
---

WordPress Core already allows you to create checkbox controls.
However in some cases you may want to enrich those, either to better convey your message, or to visually enrich the user experience.

Besides checkboxes we also allow you to use `switch` and `toggle` controls. To change a checkbox to a switch all you have to do is change its type from `checkbox` to `switch` or `toggle`. Since switches & toggles are internally checkboxes, they will still return values `true` / `false` like checkboxes do.

### Creating a `checkbox` control

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'checkbox',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1',
	'priority'    => 10,
) );
?>
{% endhighlight %}

### Creating a `switch` control

Switches have the benefit of allowing you to change their labels.
In the example below we'll be using 'Enable' and 'Disable' as labels.
The default labels are "On" & "Off", so iof you don't want to change them you can simply omit the `choices` argument.

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'switch',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1',
	'priority'    => 10,
	'choices'     => array(
		'on'  => esc_attr__( 'Enable', 'my_textdomain' ),
		'off' => esc_attr__( 'Disable', 'my_textdomain' ),
	),
) );
?>
{% endhighlight %}

### Creating a `toggle` control

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'toggle',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1',
	'priority'    => 10,
) );
?>
{% endhighlight %}

### Usage:

The saved value is a `boolean`:

{% highlight php %}
<?php if ( true == get_theme_mod( 'my_setting', true ) ) : ?>
	<p>Checkbox is checked</p>
<?php else : ?>
	<p>Checkbox is unchecked</p>
<?php endif; ?>
{% endhighlight %}
