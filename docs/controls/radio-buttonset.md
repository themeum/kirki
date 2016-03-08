# radio-buttonset

You can define the available options using the `choices` argument and formating them as an array `key => label`.

```php
Kirki::add_field( 'my_config', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'my_setting',
    'label'       => __( 'Radio-Buttonset Control', 'my_textdomain' ),
    'section'     => 'radio',
    'default'     => 'red',
    'priority'    => 10,
    'choices'     => array(
        'red'   => esc_attr__( 'Red', 'my_textdomain' ),
        'green' => esc_attr__( 'Green', 'my_textdomain' ),
        'blue'  => esc_attr__( 'Blue', 'my_textdomain' ),
    ),
) );
```
