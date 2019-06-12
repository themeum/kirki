---
layout: default
title: js_vars
published: true
mainMaxWidth: 55rem;
---

<div class="callout warning">
    <h5>Use <code>output</code> and set <code>transport</code> to <code>auto</code> instead.</h5>
    <p>Using <code>js_vars</code> is almost never needed. This argument should only be used in special cases as it will be internally calculated from the <code>output</code> argument if you set <code>transport</code> to <code>auto</code>.</p>
    <p>See the <a href="https://kirki.org/docs/arguments/transport.html"><code>transport</code></a> and <a href="https://kirki.org/docs/arguments/output.html"><code>output</code></a> arguments for more details.</p>
</div>


If you set `transport` to `postMessage` you can write your own scripts, or you can use the `js_vars` argument and let Kirki automatically create these for you.

It is defined as an array of arrays so you can specify multiple elements.

```php
Kirki::add_field( 'my_config', [
	'type'      => 'color',
	'settings'  => 'my_setting',
	'label'     => esc_html__( 'Text Color', 'translation_domain' ),
	'section'   => 'my_section',
	'default'   => 1,
	'priority'  => 1,
	'transport' => 'postMessage',
	'js_vars'   => [
		[
			'element'  => 'body',
			'function' => 'css',
			'property' => 'color',
		],
		[
			'element'  => 'h1, h2, h3, h4',
			'function' => 'css',
			'property' => 'color',
		],
	]
] );
```

Available arguments you can use on each item inside each array:

* `'element'` (string): The CSS element you want to affect.
* `'function'` (string): Can be `'css'`,`'html'` or `'style'`:
	* `css`: Changes the affected elements directly with inline styles
	* `style`: Will add a `'<style>'`element to the `'<head>'`section of your Customizer live preview with styles set for `'element'` and `'property'`. Recommend if you want to live preview for example `'a:hover'`, pseudo-element or style changes that might conflict with existing styles.
	* `html`: Outputs the option value to `'element'` and replaces existing text or html.
* `'property'` (string): If you set `'function'` to `'css'` or `'style'` then this will allow you to select what CSS you want applied to the selected `'element'`.
* `units` (string): In some cases you may want to add units. The string entered here will be appended to the value. Example: If you have a slider control that should change the border-radius of an element, then you will have to use `px` or `%` as units since sliders output a simple numeric value.
* `prefix` (string): Will be used before the value
* `suffix` (string): Will be used after the value and units.
