---
layout: default
title: The "dimension" control
slug: dimension
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: string
---

The `dimension` control allows you create an input where users can enter any valid dimension CSS value. It automatically detects invalid values and notifies the user when that happens.

Example:

```php
Kirki::add_field( 'kirki_demo', array(
	'type'        => 'dimension',
	'settings'    => 'dimension_example',
	'label'       => esc_attr__( 'Dimension Control', 'kirki' ),
	'description' => esc_attr__( 'Description Here.', 'kirki' ),
	'section'     => 'dimension_section',
	'default'     => '10px',
) );
```

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/dimension.gif" alt="dimension control example" style="max-width:300px;">
