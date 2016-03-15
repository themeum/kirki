
{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'     => 'textarea',
	'settings' => 'my_setting',
	'label'    => __( 'Textarea Control', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => esc_attr__( 'This is a defualt value', 'my_textdomain' ),
	'priority' => 10,
) );
?>
{% endhighlight %}
