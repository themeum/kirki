---
layout: default
title: WordPress Customizer Multiple Checkbox Control
slug: multicheck
subtitle: Learn how to create a multiple checkbox control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: array
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---


On Multicheck fields, you can specify the options that will be available to your users by editing the `choices` argument and specifying an array of options in the form of `key => label`.

> Please keep in mind that you should always use WordPress's i18n functions for your labels and descriptions so they are translatable. More information on WordPress's i18n functions can be found on the [WordPress Codex](https://codex.wordpress.org/I18n_for_WordPress_Developers).

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'multicheck',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'My Control', 'kirki' ),
	'section'     => 'section_id',
	'default'     => array('option-1', 'option-3', 'option-4'),
	'priority'    => 10,
	'choices'     => [
		'option-1' => esc_html__( 'Option 1', 'kirki' ),
		'option-2' => esc_html__( 'Option 2', 'kirki' ),
		'option-3' => esc_html__( 'Option 3', 'kirki' ),
		'option-4' => esc_html__( 'Option 4', 'kirki' ),
		'option-5' => esc_html__( 'Option 5', 'kirki' ),
	],
] );
```

### Usage

```php
<?php $multicheck_value = get_theme_mod( 'my_setting', array( 'option-1', 'option-3' ) ); ?>
<?php if ( ! empty( $multicheck_value ) ) : ?>
  <ul>
	<?php foreach ( $multicheck_value as $checked_value ) : ?>
		<li><?php echo $checked_value; ?></li>
	<?php endforeach; ?>
  </ul>
<?php endif; ?>
```

Please keep in mind that the returned values are the keys of the settings you have defined, not their labels. If you want to display the labels then you will have to implement this on your code.
