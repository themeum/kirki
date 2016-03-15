---
layout: docs-field
title: typography
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>typography</code>.
  - argument: default
    required: "yes"
    type: array
    description: See "Defining active sub-fields" section.
---

### Usage

It is advised to use this field with the `output` argument to directly apply the generated CSS and automatically generate and enqueue the script necessary for Google Fonts to function.

* returns array

{% highlight php %}
<?php

$value = get_theme_mod( 'my_setting', array() );

if ( isset( $value['font-family'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Font Family: %s', 'my-textdomain' ), $value['font-family'] ) . '</p>';
}
if ( isset( $value['variant'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Variant: %s', 'my-textdomain' ), $value['variant'] ) . '</p>';
}
if ( isset( $value['subset'] ) ) {
	if ( is_array( $value['subset'] ) ) {
		echo '<p>' . sprintf( esc_attr_e( 'Subsets: %s', 'my-textdomain' ), implode( ', ', $value['subset'] ) ) . '</p>';
	} else {
		echo '<p>' . sprintf( esc_attr_e( 'Subset: %s', 'my-textdomain' ), $value['subset'] ) . '</p>';
	}
}
if ( isset( $value['font-size'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Font Size: %s', 'my-textdomain' ), $value['font-size'] ) . '</p>';
}
if ( isset( $value['line-height'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Line Height: %s', 'my-textdomain' ), $value['line-height'] ) . '</p>';
}
if ( isset( $value['letter-spacing'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Letter Spacing: %s', 'my-textdomain' ), $value['letter-spacing'] ) . '</p>';
}
if ( isset( $value['color'] ) ) {
	echo '<p>' . sprintf( esc_attr_e( 'Color: %s', 'my-textdomain' ), $value['color'] ) . '</p>';
}
{% endhighlight %}
