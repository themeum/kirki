---
layout: default
title: WordPress Customizer Dimension Control
slug: dimension
subtitle: Learn how to create a dimension control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
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
Kirki::add_field( 'theme_config_id', [
	'type'        => 'dimension',
	'settings'    => 'dimension_setting',
	'label'       => esc_html__( 'Dimension Control', 'kirki' ),
	'description' => esc_html__( 'Description Here.', 'kirki' ),
	'section'     => 'section_id',
	'default'     => '10px',
] );
```

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/dimension.gif" alt="dimension control example" style="max-width:300px;">

### Usage

```php
<div style="font-size: <?php echo get_theme_mod( 'dimension_setting', '1em' ); ?>">
	<p>The font-size of this paragraph is controlled by "dimension_setting".</p>
</div>
```
