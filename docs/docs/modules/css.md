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

### Output Arguments

#### `element`

<span class="warning label">string|array</span>
Defines a CSS element in your document that you want to affect. If you want to affect multiple elements, format them as an array. Example: `'element' => array( 'h1', 'h2', 'h3' )`.

#### `property`

<span class="success label">string</span>
Use any valid CSS property (`font-weight`, `padding-right`, `background-color` etc).

#### `prefix`

<span class="success label">string</span>
The value entered in the `prefix` argument will be used before the value.

#### `units`

<span class="success label">string</span>
The value entered in the `units` argument will be used after tha value (but before the `suffix` argument).

#### `suffix`

<span class="success label">string</span>
The value entered here will be appended to the value of the field - and after the `suffix`.

Example: ` !important`.

#### `media_query`

<span class="success label">string</span>
Allows you to define a custom CSS media query for this output.

Example: `@media (max-width: 600px)`.

#### `exclude`

<span class="warning label">array</span>
Define an array of values that will be excluded. If for example don't want to output any CSS if the value of the control equals 14 OR 17, then you can use `'exclude' => array( '14', '17' ),`.

#### `value_pattern`

<span class="success label">string</span>
Define a value pattern you want to use. you can use this to calculate complex CSS values, and use the dollar sign ( `$` ) as a placeholder for the value.

Example: `'value_pattern' => 'calc(100% - $em)'` or `'value_pattern' => '10px 0 0 $'` or `'value_pattern' => '10px 0 0 $, -10px 0 0 $'`

### `pattern_replace`

<span class="warning label">array</span>

The `pattern_replace` argument allows for even more complex structures. Imagine this scenario: We have 2 color controls and 2 slider controls, and we want to build a gradient from one color to the other. The `value_pattern` alone doesn't cover it because we need to get the values of a total of 4 controls and combine them in order to get the CSS rule. With `$` being the only placeholder available by default in the `value_pattern` argument, we need a way to define other field placeholders. And this is where the `pattern_replace` argument comes in.

**Example:**

In the example we detailed above, we want to generate CSS like this:
```css
background: linear-gradient(to bottom, #1e5799 14%,#7db9e8 77%);
```
The values we'll need are `#1e5799` (the top color), `14%` (the top position), `#7db9e8` (the bottom color) and `77%` (the bottom position).

The `output` argument for the top-color control would look like this:

```php
'output'    => array(
	array(
		'element'         => 'button',
		'property'        => 'background',
		'value_pattern'   => 'linear-gradient(to bottom, $ topPos%,bottomCol bottomPos%)',
		'pattern_replace' => array(
			'topPos'    => 'color_bottom',
			'bottomCol' => 'color_top_position',
			'bottomPos' => 'color_bottom_position',
		),
	),
),
```

For more details you can read this post that explains how things are built in that example with a more thorough and in-depth analysis: [Read article on aristath.github.io](http://aristath.github.io/wordpress/customizer/2017/07/04/customizer-output-part-2.html)
