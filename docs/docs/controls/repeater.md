---
layout: default
title: WordPress Customizer Repeater Control
slug: repeater
subtitle: Learn how to create a repeater control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

Repeater controls allow you to build repeatable blocks of fields.
You can create for example a set of fields that will contain a checkbox and a textfield. The user will then be able to add "rows", and each row will contain a checkbox and a textfield.

### Example


Creating a repeater control where each row contains 2 textfields:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Repeater Control', 'kirki' ),
	'section'     => 'section_id',
	'priority'    => 10,
	'row_label' => [
		'type'  => 'text',
		'value' => esc_html__('your custom value', 'kirki' ),
	],
	'button_label' => esc_html__('"Add new" button label (optional) ', 'kirki' ),
	'settings'     => 'my_setting',
	'default'      => [
		[
			'link_text' => esc_html__( 'Kirki Site', 'kirki' ),
			'link_url'  => 'https://kirki.org/',
		],
		[
			'link_text' => esc_html__( 'Kirki Repository', 'kirki' ),
			'link_url'  => 'https://github.com/aristath/kirki',
		],
	],
	'fields' => [
		'link_text' => [
			'type'        => 'text',
			'label'       => esc_html__( 'Link Text', 'kirki' ),
			'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
			'default'     => '',
		],
		'link_url'  => [
			'type'        => 'text',
			'label'       => esc_html__( 'Link URL', 'kirki' ),
			'description' => esc_html__( 'This will be the link URL', 'kirki' ),
			'default'     => '',
		],
	]
] );
```

Creating a repeater control where the label has a dynamic name based on a field's input.  This will use `['row_label']['value']` if nothing is returned from the specified field:

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'repeater',
	'label'       => esc_html__( 'Repeater Control', 'kirki' ),
	'section'     => 'section_id',
	'priority'    => 10,
	'row_label' => [
		'type'  => 'field',
		'value' => esc_html__('your custom value', 'kirki' ),
		'field' => 'link_text',
	],
	'button_label' => esc_html__('"Add new" button label (optional) ', 'kirki' ),
	'settings'     => 'my_setting',
	'default'      => [
		[
			'link_text' => esc_html__( 'Kirki Site', 'kirki' ),
			'link_url'  => 'https://kirki.org/',
		],
		[
			'link_text' => esc_html__( 'Kirki Repository', 'kirki' ),
			'link_url'  => 'https://github.com/aristath/kirki',
		],
	],
	'fields' => [
		'link_text' => [
			'type'        => 'text',
			'label'       => esc_html__( 'Link Text', 'kirki' ),
			'description' => esc_html__( 'This will be the label for your link', 'kirki' ),
			'default'     => '',
		],
		'link_url' => [
			'type'        => 'text',
			'label'       => esc_html__( 'Link URL', 'kirki' ),
			'description' => esc_html__( 'This will be the link URL', 'kirki' ),
			'default'     => '',
		],
	]
] );
```

### Usage

```php
<?php
// Default values for 'my_setting' theme mod.
$defaults = [
    [
        'link_text' => esc_html__( 'Kirki Site', 'kirki' ),
		'link_url'  => 'https://kirki.org/',
	],
	[
		'link_text' => esc_html__( 'Kirki Repository', 'kirki' ),
		'link_url'  => 'https://github.com/aristath/kirki',
	],
];

// Theme_mod settings to check.
$settings = get_theme_mod( 'my_setting', $defaults ); ?>

<div class="kirki-links">
    <?php foreach( $settings as $setting ) : ?>
        <a href="<?php $setting['link_url']; ?>">
            <?php $setting['link_text']; ?>
        </a>
    <?php endforeach; ?>
</div>
```
