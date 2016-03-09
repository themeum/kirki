# color

Kirki's `color` control extends WordPress Core's color control, allowing you to select not only `HEX` colors but also `RGBA` colors.

If you want to enable the alpha layer (opavity) in your color controls, you can add `'alpha' => true` to your field's arguments.

Example:

```php
Kirki::add_field( 'my_config', array(
    'type'        => 'color',
    'settings'    => 'my_setting',
    'label'       => __( 'This is the label', 'my_textdomain' ),
    'section'     => 'my_section',
    'default'     => '#0088CC',
    'priority'    => 10,
    'alpha'       => true,
) );
```

## Usage
Most times you won't have to manually retrieve the value of `color` controls since the `output` argument can cover most use-cases.

The `color` control saves its value as a `string`:
```php
<div style="color:<?php echo get_theme_mod( 'my_setting', '#FFFFFF' ); ?>">
    <p>The text-color of this div is controlled by "my_setting".
</div>
```
