---
layout: default
title: settings
published: true
mainMaxWidth: 55rem;
---

`settings` is a mandatory argument for any field. The value entered here will be used to store the settings in the database.

If for example you create a field using something like this:

```php
Kirki::add_field( 'global', [
    'type'     => 'color',
    'settings' => 'body_background_color',
    'label'    => esc_html__( 'This is the label', 'kirki' ),
    'section'  => 'my_section',
    'default'  => '#0088CC',
    'priority' => 10,
] );
```

then in your theme you can access that value using:

```php
<?php $color = get_theme_mod( 'body_background_color', '#0088CC' ); ?>
```
