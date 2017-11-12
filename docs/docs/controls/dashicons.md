---
layout: default
title: The "dashicons" control
slug: dashicons
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `dashicons` control allows you to select an available icons from the WordPress [Dashicons iconfont](https://developer.wordpress.org/resource/dashicons/).

The returned value is a string and does not contain the `dashicons dashicons-` prefix, and allows you to handle the selected values as you see fit.

### Example

```php
<?php
Kirki::add_field( 'my_config', array(
	'type'     => 'dashicons',
	'settings' => 'my_setting',
	'label'    => __( 'Dashicons Control', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => 'menu',
	'priority' => 10,
) );
?>
```

### Usage

```php
<?php $icon = get_theme_mod( 'my_setting', 'menu' ); ?>
<span class="dashicons dashicons-<?php echo esc_attr( $icon ); ?>"></span>
```
