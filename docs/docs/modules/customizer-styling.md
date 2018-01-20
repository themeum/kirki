---
layout: default
title: Styling the Customizer
mainMaxWidth: 50rem;
bodyClasses: page
---

Kirki allows you to change the styling of the customizer using the `kirki_config` filter:

```php
<?php
/**
 * Configuration sample for the Kirki Customizer.
 * The function's argument is an array of existing config values
 * The function returns the array with the addition of our own arguments
 * and then that result is used in the kirki_config filter
 *
 * @param $config the configuration array
 *
 * @return array
 */
function kirki_demo_configuration_sample_styling( $config ) {
	return wp_parse_args( array(
		'logo_image'   => 'https://aristath.github.io/kirki/images/logo.png',
		'description'  => esc_attr__( 'The theme description.', 'kirki' ),
		'color_accent' => '#0091EA',
		'color_back'   => '#FFFFFF',
	), $config );
}
add_filter( 'kirki_config', 'kirki_demo_configuration_sample_styling' );
```

* `logo_image`: Change the logo image (URL). If omitted, the default theme info will be displayed. You may want to use a relatively large image (for example 700px wide) so that it's properly displayed on retina screens as well.
* `description`: Changes the theme description. Will be visible when clicking on the theme logo.
* `color_accent`: The accent color. This will be used on selected items and control details.
* `color_back`: The background color. This will be used on sections & panels titles.
* `width`: The width of the customizer. Use any valid CSS value like for example `24%`, `400px`, `25em` etc. In case you decide to change the width, please take into account mobile users as well.
* `disable_loader`: set to `true` if you want to disable the custom Kirki loader and use the WP Core default.
