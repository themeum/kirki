```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'dropdown-pages',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 42,
	'priority'    => 10,
	'multiple'    => 1,
) );
?>
```
