
```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'custom',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'You can enter custom markup in this control and use it however you want', 'my_textdomain' ) . '</div>',
	'priority'    => 10,
) );
?>
```

The content of the field is defined in the `default` argument.
You can use valid HTML.
