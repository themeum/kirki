
```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'color',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '#0088CC',
	'priority'    => 10,
	'choices'     => array(
		'alpha' => true,
	),
) );
?>
```
