
```php
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
```
