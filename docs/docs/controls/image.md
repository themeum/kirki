---
layout: default
title: The "image" control
slug: image
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: string|array|int
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `image` control allows you create a control where users can upload images, or select images from their media-library.
You can choose how you want your data to be saved. By default the control saves the URL of the image as a string, but you have the ability to save the data as an `array( 'url', 'id', 'width', 'height' )` or as integer (image ID).

Examples:

```php

/**
 * Default behaviour (saves data as a URL).
 */
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => 'image_setting_url',
	'label'       => esc_attr__( 'Image Control (URL)', 'textdomain' ),
	'description' => esc_attr__( 'Description Here.', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '',
) );

/**
 * Save data as integer (ID)
 */
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => 'image_setting_id',
	'label'       => esc_attr__( 'Image Control (ID)', 'textdomain' ),
	'description' => esc_attr__( 'Description Here.', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '',
	'choices'     => array(
		'save_as' => 'id',
	),
) );

/**
 * Save data as array.
 */
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'image',
	'settings'    => 'image_setting_array',
	'label'       => esc_attr__( 'Image Control (array)', 'textdomain' ),
	'description' => esc_attr__( 'Description Here.', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => '',
	'choices'     => array(
		'save_as' => 'array',
	),
) );
```

### Usage

```php
<?php $image = get_theme_mod( 'my_setting', '' ); ?>
<div style="background-image: url('<?php echo esc_url( $image ); ?>')">
	Set the background-image of this div from "my_setting".
</div>
```
