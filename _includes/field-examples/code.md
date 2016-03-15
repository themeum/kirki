
{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'code',
	'settings'    => 'code_demo',
	'label'       => __( 'Code Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'body { background: #fff; }',
	'priority'    => 10,
	'choices'     => array(
		'language' => 'css',
		'theme'    => 'monokai',
		'height'   => 250,
	),
) );
?>
{% endhighlight %}
