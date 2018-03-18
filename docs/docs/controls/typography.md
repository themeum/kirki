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

The exception to the above rule is the `variant` control.

Since the `typography` control uses google fonts, in order to ensure that your fonts will be properly enqueued we have to add the variant control for google fonts.
So if you add `font-family`, all 3 controls will be automatically displayed when the selected font requires it.

### Output

The `typography` field requires you to use only the `element` argument in order to properly generate its CSS.
Of course you can define multiple elements as documented in the documentation of the `output` argument, but you do not have to define a `property` since it will be automatically applies for each sub-element of the control.

### Choosing which fonts-families to use

#### Google Fonts

You can choose which google-fonts to use by defining an array in the `choices` argument:

```php
'choices' => array(
	'fonts' => array(
		'google' => array(
			'Roboto',
			'Open Sans',
			'Lato',
			'Roboto Condensed',
			'Slabo 27px',
			'Montserrat',
			'Oswald',
			'Source Sans Pro',
			'Raleway',
			'PT Sans',
			'Merriweather',
		),
	),
),
```

To use the top 30 google-fonts sorted by `popularity`:
```php
'choices' => array(
	'fonts' => array(
		'google' => array( 'popularity', 30 ),
	),
),
```

To use the top 30 google-fonts sorted by `trending`:
```php
'choices' => array(
	'fonts' => array(
		'google' => array( 'trending', 30 ),
	),
),
```

#### Standard Fonts

You can choose which standard fonts to use by defining an array in the `choices` argument:

```php
'choices' => array(
	'fonts' => array(
		'standard' => array(
			'serif',
			'sans-serif',
		),
	),
),
```

The `serif`, `sans-serif` and `monospace` keywords automatically load these font-families:


* `serif`: `Georgia,Times,"Times New Roman",serif`
* `sans-serif`: `-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif`
* `monospace`: `Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace`

If you want to use custom definitions you can also do that:
'choices' => array(
	'fonts' => array(
		'standard' => array(
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif'
		),
	),
),

#### Combining custom google-fonts & standard fonts

```php
'choices' => array(
	'fonts' => array(
		'google'   => array( 'popularity', 50 ),
		'standard' => array(
			'Georgia,Times,"Times New Roman",serif',
			'Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif',
		),
	),
),
```

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
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'typography',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'Control Label', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => array(
		'font-family'    => 'Roboto',
		'variant'        => 'regular',
		'font-size'      => '14px',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'color'          => '#333333',
		'text-transform' => 'none',
		'text-align'     => 'left',
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
	echo '<p>' . sprintf( esc_attr__( 'Font Family: %s', 'textdomain' ), $value['font-family'] ) . '</p>';
}
if ( isset( $value['variant'] ) ) {
	echo '<p>' . sprintf( esc_attr__( 'Variant: %s', 'textdomain' ), $value['variant'] ) . '</p>';
}
if ( isset( $value['font-size'] ) ) {
	echo '<p>' . sprintf( esc_attr__( 'Font Size: %s', 'textdomain' ), $value['font-size'] ) . '</p>';
}
if ( isset( $value['line-height'] ) ) {
	echo '<p>' . sprintf( esc_attr__( 'Line Height: %s', 'textdomain' ), $value['line-height'] ) . '</p>';
}
if ( isset( $value['letter-spacing'] ) ) {
	echo '<p>' . sprintf( esc_attr__( 'Letter Spacing: %s', 'textdomain' ), $value['letter-spacing'] ) . '</p>';
}
if ( isset( $value['color'] ) ) {
	echo '<p>' . sprintf( esc_attr__( 'Color: %s', 'textdomain' ), $value['color'] ) . '</p>';
}
```
