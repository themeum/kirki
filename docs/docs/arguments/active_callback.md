---
layout: default
title: active_callback
published: false
---

You can use the `active_callback` argument to define if you want to hide or display a control under conditions.

The default WordPress Customizer implementation for `active_callback` allows you to define a callable function or method (see the [Customizer API Handbook](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#contextual-controls-sections-and-panels) for details).


Kirki extends the `active_callback` argument to allow defined field dependencies:

```php
<?php
'active_callback'    => array(
	array(
		'setting'  => 'checkbox_demo',
		'operator' => '==',
		'value'    => true,
	),
),
?>
```
It is formatted as an array of arrays so you can add multiple dependencies.

* `setting`: you can use the `settings` argument of the controller-field.
* `operator`: you can use any of the following:
  * `===` : uses PHP's `===` to evaluate the value
  * `==`, `=`, `equal`, `equals` : uses PHP's `==` to evaluate the value
  * `!==` : uses PHP's `!==` to evaluate the value
  * `!=`, `not equal` : uses PHP's `!==` to evaluate the value
  * `>=`, `greater or equal`, `equal or greater` : uses PHP's `>=` to evaluate the value
  * `<=`, `smaller or equal`, `equal or smaller`: uses PHP's `<=` to evaluate the value
  * `>`, `greater` : uses PHP's `>` to evaluate the value
  * `<`, `smaller` : uses PHP's `<` to evaluate the value
  * `contains`, `in` : If the context is an array then we'll check if the value defined exists in the array (using PHP's [`in_array()`](http://php.net/manual/en/function.in-array.php) function. If on the other hand the context is a string then we'll check if the string contains the value defined using PHP's [`strpos()`](http://php.net/manual/en/function.strpos.php) and checking not the position of the string but whether the result returns `false` or not (using `===` for safety).
* `value`: the value of the controller-field against which all comparisons and checks will be performed to determin if the field should be visible or not.

In the example below we're first creating a config, then a section, and finally we add 3 fields to our customizer: a checkbox, a radio and finally a text control.

The text control will **only** be shown if the value of the checkbox is equal to 1 **and** the value of the radio control is not equal to `option-1`.


```php
<?php
Kirki::add_config( 'my_config' );

Kirki::add_section( 'my_section', array(
    'title'          => __( 'My Section' ),
    'priority'       => 10,
) );

Kirki::add_field( 'my_config', array(
	'type'      => 'checkbox',
	'settings'  => 'my_checkbox',
	'label'     => __( 'My Checkbox', 'my_textdomain' ),
	'section'   => 'my_section',
	'default'   => 0,
	'priority'  => 10,
) );

Kirki::add_field( 'my_config', array(
	'type'      => 'radio',
	'settings'  => 'my_radio',
	'label'     => __( 'My Radio', 'my_textdomain' ),
	'section'   => 'my_section',
	'default'   => 'option-1',
	'priority'  => 20,
	'choices'   => array(
		'option-1' => __( 'Option 1', 'my_textdomain' ),
		'option-2' => __( 'Option 2', 'my_textdomain' ),
		'option-3' => __( 'Option 3', 'my_textdomain' )
	)
) );

Kirki::add_field( 'my_config', array(
	'type'      => 'text',
	'settings'  => 'my_setting',
	'label'     => __( 'Text Color', 'my_textdomain' ),
	'section'   => 'my_section',
	'default'   => __( 'my default text here', 'my_textdomain' ),
	'priority'  => 30,
	'active_callback'  => array(
		array(
			'setting'  => 'my_checkbox',
			'operator' => '==',
			'value'    => 1,
		),
		array(
			'setting'  => 'my_radio',
			'operator' => '!=',
			'value'    => 'option-1',
		),
	)
) );
?>
```
