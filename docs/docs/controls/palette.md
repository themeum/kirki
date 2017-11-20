---
layout: default
title: The "palette" control
slug: palette
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

Palette controls are essentially [`radio`](radio) controls. The difference between palette controls and radio controls is purely presentational: Palette controls allow you to define an array of colors for each option which will be used to show users a palette.

### Example

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'palette',
	'settings'    => 'my_setting',
	'label'       => __( 'Palette Control', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => 'light',
	'priority'    => 10,
	'choices'     => array(
		'light' => array(
			'#ECEFF1',
			'#333333',
			'#4DD0E1',
		),
		'dark' => array(
			'#37474F',
			'#FFFFFF',
			'#F9A825',
		),
	),
) );
```

### Usage

```php
<?php
$saved_palette = get_theme_mod( 'my_setting', 'light' );
if ( 'light' == $saved_palette ) {
	$background   = '#ECEFF1';
	$text_color   = '#333333';
	$border_color = '#4DD0E1';
} else if ( 'dark' == $saved_palette ) {
	$background   = '#37474F';
	$text_color   = '#FFFFFF';
	$border_color = '#F9A825';
}
$styles = "background-color:{$background}; color:{$text_color}; border-color:{$border_color};";
?>
<div style="<?php echo $styles; ?>">
	Some text here
</div>
```
