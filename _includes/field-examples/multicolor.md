
```php
<?php
Kirki::add_field( 'my_config', array(
    'type'        => 'multicolor',
    'settings'    => 'my_setting',
    'label'       => esc_attr__( 'Label', 'my_textdomain' ),
    'section'     => 'color',
    'priority'    => 10,
    'choices'     => array(
        'link'    => esc_attr__( 'Color', 'my_textdomain' ),
        'hover'   => esc_attr__( 'Hover', 'my_textdomain' ),
        'active'  => esc_attr__( 'Active', 'my_textdomain' ),
    ),
    'default'     => array(
        'link'    => '#0088cc',
        'hover'   => '#00aaff',
        'active'  => '#00ffff',
    ),
) );
```
