---
layout: default
title: The "typography" control
slug: typography
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

The `typography` field allows you to add the most important typography-related controls in a single, compact view.
It shows the following controls:

* font-family
* variant
* subsets
* font-size
* line-height
* letter-spacing
* color
* text-align
* text-transform

### Defining active sub-fields

You can define which of the above fields you want displayed or hidden using the `default` argument of the field.

Since defining a default value is **mandatory** for all fields, this way you can control both the default value of the field and the fields it contains in as little code as possible.

If for example you wanted to hide the `line-height` and `letter-spacing` controls, you'd delete these 2 lines from the defaults specified in the above example.

The exception to the above rule is the `variant` and `subsets` controls.

Since the `typography` control uses google fonts, in order to ensure that your fonts will be properly enqueued we have to add the variant & subsets controls for google fonts.
So if you add `font-family`, all 3 controls will be automatically displayed when the selected font requires it.

### Output

The `typography` field requires you to use only the `element` argument in order to properly generate its CSS.
Of course you can define multiple elements as documented in the documentation of the `output` argument, but you do not have to define a `property` since it will be automatically applies for each sub-element of the control.

### Variants

The available options for variants are:

* `'100'`
* `'100italic'`
* `'200'`
* `'200italic'`
* `'300'`
* `'300italic'`
* `'regular'`
* `'italic'`
* `'500'`
* `'500italic'`
* `'600'`
* `'600italic'`
* `'700'`
* `'700italic'`
* `'800'`
* `'800italic'`
* `'900'`
* `'900italic'`

When selecting a default value for the variant, please make sure that the value is valid for the selected google font.

### Example

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'typography',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'Control Label', 'kirki' ),
	'section'     => 'my_section',
	'default'     => array(
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left'
	),
	'priority'    => 10,
	'output'      => array(
		array(
			'element' => 'body',
		),
	),
) );
```

### Usage

It is advised to use this field with the `output` argument to directly apply the generated CSS and automatically generate and enqueue the script necessary for Google Fonts to function.

```php
<?php

$value = get_theme_mod( 'my_setting', array() );

if ( isset( $value['font-family'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Font Family: %s', 'my-textdomain' ), $value['font-family'] ) . '</p>';
}
if ( isset( $value['variant'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Variant: %s', 'my-textdomain' ), $value['variant'] ) . '</p>';
}
if ( isset( $value['subsets'] ) ) {
	if ( is_array( $value['subsets'] ) ) {
		echo '<p>' . sprintf( esc_attr_e( 'Subsets: %s', 'my-textdomain' ), implode( ', ', $value['subsets'] ) ) . '</p>';
	} else {
		echo '<p>' . sprintf( esc_attr_e( 'Subset: %s', 'my-textdomain' ), $value['subsets'] ) . '</p>';
	}
}
if ( isset( $value['font-size'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Font Size: %s', 'my-textdomain' ), $value['font-size'] ) . '</p>';
}
if ( isset( $value['line-height'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Line Height: %s', 'my-textdomain' ), $value['line-height'] ) . '</p>';
}
if ( isset( $value['letter-spacing'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Letter Spacing: %s', 'my-textdomain' ), $value['letter-spacing'] ) . '</p>';
}
if ( isset( $value['color'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Color: %s', 'my-textdomain' ), $value['color'] ) . '</p>';
}
```
