
{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'radio-image',
	'settings'    => 'my_setting',
	'label'       => __( 'Radio Control', 'my_textdomain' ),
	'section'     => 'radio',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => 'https://my-domain.com/red.png',
		'green' => 'https://my-domain.com/green.png',
		'blue'  => 'https://my-domain.com/blue.png',
	),
) );
?>
{% endhighlight %}
