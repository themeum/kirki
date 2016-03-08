# output

Using the `output` argument you can specify if you want Kirki to automatically generate and apply CSS for various elements of your page.

Based on these values Kirki will then automatically generate the necessary CSS and properly enqueue it to the `<head>` of your document so that your changes take effect immediately without the need to write any additional code.

Example: Using the `output` argument of a slider control to automatically apply CSS that changes the `border-top-width` of elements with the `variable-top-border` class, and also the `border-bottom-width` of elements with the `variable-bottom-border` class:

```php
Kirki::add_config( 'my_config' );

Kirki::add_field( 'my_config', array(
	'type'     => 'slider',
	'settings' => 'my_setting',
	'label'    => __( 'Border width', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => 1,
	'priority' => 1,
	'choices'  => array(
		'min'  => 0,
		'max'  => 20,
		'step' => 1,
	),
	'output' => array(
		array(
			'element'  => '.variable-top-border',
			'property' => 'border-top-width',
			'units'    => 'px',
		),
		array(
			'element'  => '.variable-bottom-border',
			'property' => 'border-bottom-width',
			'units'    => 'px',
		),
	),
) );
```

## Arguments you can use inside each `output` array:

* `element`: (**string|array**) Defines a CSS element in your document that you want to affect. If you want to affect multiple elements, format them as an array. Example: `'element' => array( 'h1', 'h2', 'h3' )`.
* `property`: (**string**) Use any valid CSS property.
* `prefix`: (**string**) The value entered here will be prepended to the value of the field.
* `units`: (**string**) The value entered here will be appended to the value of the field (for example `px`, `em`, `rem` etc.)
* `suffix`: (**string**) The value entered here will be appended to the value of the field **after** the `suffix`. Example: ` !important`.
* `media_query`: (**string**) Allows you to define a custom CSS media query for this output. Example: `@media (max-width: 600px)`.
* `exclude`: (**string**) Define a value that will be excluded. If your example you use `'exclude' => '14',` then if the value of the field is 14, the field will not output any CSS.
