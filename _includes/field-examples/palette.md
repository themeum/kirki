
{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'palette',
	'settings'    => 'my_setting',
	'label'       => __( 'Palette Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'light',
	'priority'    => 10,
	'choices'     => array(
		'light' => array(
			'#ECEFF1',
			'#333333',
			'#4DD0E1',
		),
		'dark' => array(
			'#37474F',
			'#FFFFFF',
			'#F9A825',
		),
	),
) );
?>
{% endhighlight %}
