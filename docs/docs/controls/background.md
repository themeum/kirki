---
layout: default
title: The "background" control
slug: background
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

The `background` control allows you to have every CSS background property under one roof.

### Example

```php
Kirki::add_field( 'theme_config_id', array(
	'type'        => 'background',
	'settings'    => 'background_setting',
	'label'       => esc_attr__( 'Background Control', 'textdomain' ),
	'description' => esc_attr__( 'Background conrols are pretty complex - but extremely useful if properly used.', 'textdomain' ),
	'section'     => 'section_id',
	'default'     => array(
		'background-color'      => 'rgba(20,20,20,.8)',
		'background-image'      => '',
		'background-repeat'     => 'repeat',
		'background-position'   => 'center center',
		'background-size'       => 'cover',
		'background-attachment' => 'scroll',
	),
) );
```
