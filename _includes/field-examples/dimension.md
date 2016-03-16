
```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'dimension',
	'settings'    => 'my_setting',
	'label'       => __( 'Dimension Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1.5em',
	'priority'    => 10,
) );
?>
```
