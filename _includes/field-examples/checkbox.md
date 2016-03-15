
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
