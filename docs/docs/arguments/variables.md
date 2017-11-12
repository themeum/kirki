---
layout: default
title: variables
published: false
---


If you're using a CSS preprocessor and for example a less-php, sass-php or even less.js compiler for your styles, you may wish to have the values of your options returned as variables that you can then use and feed them to your compiler.

In order to facilitate this we now have a `variables` argument you can define in your fields.

Example:

```php
<?php
Kirki::add_field( 'my_config', array(
	'settings'  => 'my_setting',
	'label'     => __( 'My custom control', 'translation_domain' ),
	'section'   => 'my_section',
	'type'      => 'number',
	'priority'  => 10,
	'default'   => '25',
	'variables' => array(
		array(
			'name'     => 'font-size-h1',
			'callback' => 'intval'
		),
		array(
			'name'     => 'font-size-h2',
			'callback' => 'my_h2_calc'
		),
		array(
			'name'     => 'font-size-h3',
			'callback' => 'my_h3_calc'
		),
	),
) );
?>
```

You can then create your own custom functions that will calculate the necessary values:

```php
<?php
function my_h2_calc( $value ) {
	return intval( $value * 0.8 );
}

function my_h3_calc( $value ) {
	return intval( $value * 0.65 );
}
?>
```

What we did in the above example is add a control for the H1 font-size, and then using variables created variables for the h1, h2 & h3 font-sizes, with h2 being 80% of h1's font-size and h3 65% of h1's size.

If we omit the `callback` argument inside the array then the value is returned without any modifications applied.

In our compiler then in order to get the values and format them properly we'd do something like this:

```php
<?php
$variables = Kirki_Util::get_variables();

foreach ( $variables as $variable => $value ) {
	echo '@' . $variable . ':' . $value . ';';
}
?>
```

This would format our variables for use by a LESS compiler.
