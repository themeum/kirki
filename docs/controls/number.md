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

## Usage

```php
<div style="font-size: <?php echo get_theme_mod( 'my_setting', '14' ); ?>px">
    <p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
```
