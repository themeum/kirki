# slider

`slider` controls are numeric fields that allow you to set a minimum value, a maximum value and a step.

```php
Kirki::add_field( 'my_config', array(
    'type'        => 'slider',
    'settings'    => 'my_setting',
    'label'       => esc_attr__( 'This is the label', 'my_textdomain' ),
    'section'     => 'my_section',
    'default'     => 42,
    'choices'     => array(
        'min'  => '0',
        'max'  => '100',
        'step' => '1',
    ),
) );
```
