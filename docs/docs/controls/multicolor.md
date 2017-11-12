---
layout: default
title: The "multicolor" control
slug: multicolor
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

On multicolor fields, you can specify the options that will be available to your users by editing the `choices` argument and specifying an array of options in the form of `key => label`.

The saved options will be in the form of an array of the form `$key => $value`. See usage and example for more details.

> Please keep in mind that you should always use WordPress's i18n functions for your labels and descriptions so they are translatable. More information on WordPress's i18n functions can be found on the [WordPress Codex](https://codex.wordpress.org/I18n_for_WordPress_Developers).

### Example

```php
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

### Usage

```php
<?php
$defaults = array(
	'link'   => '#0088cc',
	'hover'  => '#00aaff',
	'active' => '#00ffff',
);
$value = get_theme_mod( 'my_setting', $defaults );

echo '<style>';
echo 'a { color: ' . $value['link'] . '; }';
echo 'a:hover { color: ' . $value['hover'] . '; }';
echo 'a:active { color: ' . $value['active'] . '; }';
echo '</style>';
```
