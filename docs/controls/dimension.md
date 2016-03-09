# dimension

`dimension` controls allow you to add a simple, single-line text input. The difference with normal text inputs is that entered values can only be valid CSS units (example: `10px`, `3em`, `48%`, `90vh` etc.).

Values are sanitized both on input and on save. If the user enters an invalid value, a warning message appears below the input field informing them that the entered value is invalid.

Invalid values are not saved, and the preview refresh is only triggered once a valid value has been entered.

```php
Kirki::add_field( 'my_config', array(
    'type'        => 'dimension',
    'settings'    => 'my_setting',
    'label'       => __( 'Dimension Control', 'my_textdomain' ),
    'section'     => 'my_section',
    'default'     => '1.5em',
    'priority'    => 10,
) );
```
