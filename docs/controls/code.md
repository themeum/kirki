# code

`code` controls use the [CodeMirror](https://codemirror.net/) script to properly format the code area.

You can define the language you'll be using (`css`, `html`, `javascript` etc) as well as the theme in the `choices` argument as seen in the code example below.

You can see a list of all available languages [here](https://codemirror.net/mode/index.html) and a list of all available themes [here](https://codemirror.net/demo/theme.html).

```php
Kirki::add_field( 'my_config', array(
    'type'        => 'code',
    'settings'    => 'code_demo',
    'label'       => __( 'Code Control', 'my_textdomain' ),
    'section'     => 'my_section',
    'default'     => 'body { background: #fff; }',
    'priority'    => 10,
    'choices'     => array(
        'language' => 'css',
        'theme'    => 'monokai',
        'height'   => 250,
    ),
) );
```

## Usage

The saved values is a `string`

```php
<?php echo get_theme_mod( 'my_setting', '' ); ?>
```
