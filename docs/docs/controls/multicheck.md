---
layout: default
title: The "multicheck" control
slug: multicheck
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
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
Kirki::add_field( 'my_config', array(
	'type'        => 'multicheck',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'My Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => array('option-1', 'option-3', 'option-4'),
	'priority'    => 10,
	'choices'     => array(
		'option-1' => esc_attr__( 'Option 1', 'my_textdomain' ),
		'option-2' => esc_attr__( 'Option 2', 'my_textdomain' ),
		'option-3' => esc_attr__( 'Option 3', 'my_textdomain' ),
		'option-4' => esc_attr__( 'Option 4', 'my_textdomain' ),
		'option-5' => esc_attr__( 'Option 5', 'my_textdomain' ),
	),
) );
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
