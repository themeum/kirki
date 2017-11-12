---
layout: default
title: The "dimension" control
slug: dimension
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `dimension` control allows you create an input where users can enter any valid dimension CSS value. It automatically detects invalid values and notifies the user when that happens.

### Example:

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

### Usage

```php
<div style="font-size: <?php echo get_theme_mod( 'my_setting', '1em' ); ?>">
	<p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
```
