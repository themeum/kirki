
```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'spacing',
	'settings'    => 'my_setting',
	'label'       => __( 'Spacing Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => array(
		'top'    => '1.5em',
		'bottom' => '10px',
		'left'   => '40%',
		'right'  => '2rem',
	),
	'priority'    => 10,
) );
?>
```

You can disable a direction by removing its default value.
So this for example would only show top & bottom controls:

```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'spacing',
	'settings'    => 'my_setting',
	'label'       => __( 'Spacing Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'priority'    => 10,
	'default'     => array(
		'top'    => '1.5em',
		'bottom' => '10px',
	),
) );
?>
```
