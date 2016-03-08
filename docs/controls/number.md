# number

`number` controls are simple numeric fields that only accept numbers as input and not free text.

```php
Kirki::add_field( 'my_config', array(
    'type'        => 'number',
    'settings'    => 'my_setting',
    'label'       => esc_attr__( 'This is the label', 'my_textdomain' ),
    'section'     => 'my_section',
    'default'     => 42,
) );
```
