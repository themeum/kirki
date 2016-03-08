# radio-image

You can define the available options using the `choices` argument and formating them as an array `key => URL`.

```php
Kirki::add_field( 'my_config', array(
    'type'        => 'radio',
    'settings'    => 'my_setting',
    'label'       => __( 'Radio Control', 'my_textdomain' ),
    'section'     => 'radio',
    'default'     => 'red',
    'priority'    => 10,
    'choices'     => array(
        'red'   => 'https://my-domain.com/red.png',
        'green' => 'https://my-domain.com/green.png',
        'blue'  => 'https://my-domain.com/blue.png',
    ),
) );
```
