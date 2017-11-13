---
layout: default
title: partial_refresh
published: true
mainMaxWidth: 50rem;
---
WordPress 4.5 introduced partial (or selective) refreshes to the customizer.

As documented in announcement on [make.wordpress.org/core](https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/), the syntax that we have to use would look like this:

```php

function my_register_blogname_partials( WP_Customize_Manager $wp_customize ) {

    // Abort if selective refresh is not available.
    if ( ! isset( $wp_customize->selective_refresh ) ) {
        return;
    }

    $wp_customize->selective_refresh->add_partial( 'header_site_title', array(
        'selector' => '.site-title a',
        'settings' => array( 'blogname' ),
        'render_callback' => function() {
            return get_bloginfo( 'name', 'display' );
        },
    ) );

    $wp_customize->selective_refresh->add_partial( 'document_title', array(
        'selector' => 'head > title',
        'settings' => array( 'blogname' ),
        'render_callback' => 'wp_get_document_title',
    ) );
}
add_action( 'customize_register', 'my_register_blogname_partials' );
```

Kirki simplifies that process and you can add the arguments for partial refreshes in your fields using the `partial_refresh` argument. The example from above when combined with a text field would become like this:


```php
Kirki::add_field( 'my_config', array(
	'type'     => 'text',
	'settings' => 'my_setting',
	'label'    => __( 'Text Control', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => esc_attr__( 'This is a defualt value', 'my_textdomain' ),
	'priority' => 10,
	'partial_refresh' => array(
		'header_site_title' => array(
			'selector'        => '.site-title a',
			'render_callback' => function() {
				return get_bloginfo( 'name', 'display' );
			},
		),
		'document_title' => array(
			'selector'        => 'head > title',
			'render_callback' => 'wp_get_document_title',
		),
	),
) );
```
