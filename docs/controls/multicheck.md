# multicheck

Using the Kirki API:

```php
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
```

On Multicheck fields, you can specify the options that will be available to your users by editing the `choices` argument and specifying an array of options in the form of `key => label`.

> Please keep in mind that you should always use WordPress's i18n functions for your labels and descriptions so they are translatable. More information on WordPress's i18n functions can be found on the [WordPress Codex](https://codex.wordpress.org/I18n_for_WordPress_Developers).
