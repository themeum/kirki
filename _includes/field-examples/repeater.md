
Creating a repeater control where each row contains 2 textfields:

```php
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'repeater',
	'label'       => esc_attr__( 'Repeater Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'priority'    => 10,
	'row_label' => array(               
        	'type' => 'text',
        	'value' => esc_attr__('your custom value', 'my_textdomain' ),
	),
	'settings'    => 'my_setting',
	'default'     => array(
		array(
			'link_text' => esc_attr__( 'Kirki Site', 'my_textdomain' ),
			'link_url'  => 'https://aristath.github.io/kirki/',
		),
		array(
			'link_text' => esc_attr__( 'Kirki Repository', 'my_textdomain' ),
			'link_url'  => 'https://github.com/aristath/kirki',
		),
	),
	'fields' => array(
		'link_text' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link Text', 'my_textdomain' ),
			'description' => esc_attr__( 'This will be the label for your link', 'my_textdomain' ),
			'default'     => '',
		),
		'link_url' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link URL', 'my_textdomain' ),
			'description' => esc_attr__( 'This will be the link URL', 'my_textdomain' ),
			'default'     => '',
		),
	)
) );
?>
```
