
```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'multicheck',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'My Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'option-1',
	'priority'    => 10,
	'choices'     => array(
		'option-1' => esc_attr__( 'Option 1', 'my_textdomain' ),
		'option-2' => esc_attr__( 'Option 2', 'my_textdomain' ),
		'option-3' => esc_attr__( 'Option 3', 'my_textdomain' ),
		'option-4' => esc_attr__( 'Option 4', 'my_textdomain' ),
		'option-5' => esc_attr__( 'Option 5', 'my_textdomain' ),
	),
) );
?>
```
