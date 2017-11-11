---
layout: default
title: CSS module
subtitle: Auto-generate CSS from your fields
mainMaxWidth: 55rem;
bodyClasses: page module
---

The automatic CSS generation is one of the most powerful features in Kirki. Using the `output` argument in your fields you can define the CSS that your field will generate, and kirki will automatically take care of the rest.

### The basics

The `output` argument has to be defined as an array of arrays, with each sub-array being the definition for a CSS output. Each such definition (with a couple of exceptions) has to have the following arguments: `element`, `property`.

Example:

```php
'output' => array(
	array(
		'element'  => 'body',
		'property' => 'color',
	),
	array(
		'element'  => '.my-super-cool-css-class',
		'property' => 'background-color',
	),
),
```

If we add the above to say a color control and the value of the color in the control is `#0073AA`, then Kirki will output the following CSS:

```css
body{color:#0073AA;}.my-super-cool-css-class{background-color:#0073AA;}
```

As seen above Kirki also minimizes the generated CSS. The above in a more human-readable format would look like this:

```css
body {
  color: #0073AA;
}
.my-super-cool-css-class {
  background-color: #0073AA;
}
```

### Advanced Arguments

`element` and `property` in a lot of cases are all you need. But sometimes you need something more, so we have a plethora of additional arguments you can use:


* `element`: (**string, array**) Defines a CSS element in your document that you want to affect. If you want to affect multiple elements, format them as an array. Example: `'element' => array( 'h1', 'h2', 'h3' )`.
* `property`: (**string**) Use any valid CSS property.
* `prefix`: (**string**) The value entered here will be prepended to the value of the field.
* `units`: (**string**) The value entered here will be appended to the value of the field (for example `px`, `em`, `rem` etc.)
* `suffix`: (**string**) The value entered here will be appended to the value of the field. Example: ` !important`.
* `media_query`: (**string**) Allows you to define a custom CSS media query for this output. Example: `@media (max-width: 600px)`.
* `exclude`: (**array**) Define an array of values that will be excluded. If for example you use `'exclude' => array( '14', '17' ),` then if the value of the field is 14 or 17, the field will not output any CSS.
* `value_pattern`: (**string**) Define a value pattern you want to use. you can use this to calculate complex CSS values, and use the dollar sign ( `$` ) as a placeholder for the value. Example: `'value_pattern' => 'calc(100% - $em)'` or `'value_pattern' => '10px 0 0 $'` or `'value_pattern' => '10px 0 0 $, -10px 0 0 $'`
