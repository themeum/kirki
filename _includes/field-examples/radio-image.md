
```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'radio-image',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'Radio Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => get_template_directory_uri() . '/assets/images/red.png',
		'green' => get_template_directory_uri() . '/assets/images/green.png',
		'blue'  => get_template_directory_uri() . '/assets/images/blue.png',
	),
) );
?>
```
