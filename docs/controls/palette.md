---
layout: docs-field
title: palette
sections:
  - Arguments
  - Example
  - Usage
edit: docs/controls/palette.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>palette</code>.
  - argument: default
    required: "yes"
    type: string
    description: Use the key of one of the items in the <code>choices</code> argument.
  - argument: choices
    required: "yes"
    type: array
    description: Use an array of elements. Format <code>$key => array( $color1, $color2, $color3 )</code>.
---

Palette controls are essentially radio controls. The difference between palette controls and radio controls is purely presentational: Palette controls allow you to define an array of colors for each option which will be used to show users a palette.

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'palette',
	'settings'    => 'my_setting',
	'label'       => __( 'Palette Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'light',
	'priority'    => 10,
	'choices'     => array(
		'light' => array(
			'#ECEFF1',
			'#333333',
			'#4DD0E1',
		),
		'dark' => array(
			'#37474F',
			'#FFFFFF',
			'#F9A825',
		),
	),
) );
?>
{% endhighlight %}

### Usage

{% highlight php %}
<?php
$saved_palette = get_theme_mod( 'my_setting', 'light' );
if ( 'light' == $saved_palette ) {
	$background   = '#ECEFF1';
	$text_color   = '#333333';
	$border_color = '#4DD0E1';
} else if ( 'dark' == $saved_palette ) {
	$background   = '#37474F';
	$text_color   = '#FFFFFF';
	$border_color = '#F9A825';
}
$styles = "background-color:{$background}; color:{$text_color}; border-color:{$border_color};";
?>
<div style="<?php echo $styles; ?>">
	Some text here
</div>
{% endhighlight %}
