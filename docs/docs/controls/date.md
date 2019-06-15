---
layout: default
title: WordPress Customizer Date Control
slug: date
subtitle: Learn how to create a date control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `date` control allows you to select a date.

The returned value is a string.

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/date.png" alt="date control example" style="max-width:300px;">

### Example

```php
<?php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'date',
	'settings'    => 'date_setting',
	'label'       => esc_html__( 'Date Control', 'kirki' ),
	'description' => esc_html__( 'This is a date control.', 'kirki' ),
	'section'     => 'date_section',
	'default'     => '',
] );
?>
```

### Usage

```php
<?php
$date = get_theme_mod( 'date_setting', '2019-01-30' );
echo esc_html( $date );
?>
```
