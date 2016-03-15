---
layout: docs-field
title: multicheck
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>multicheck</code>.
  - argument: default
    required: "yes"
    type: array
    description: Define an array of the elements you want activated by default.
  - argument: choices
    required: "no"
    type: array
    description: The array of available checkboxes formatted as <code>$key => $label</code>.
---

### Usage

{% highlight php %}
<?php $multicheck_value = get_theme_mod( 'my_setting', array( 'option-1', 'option-3' ) ); ?>
<?php if ( ! empty( $multicheck_value ) ) : ?>
  <ul>
	<?php foreach ( $multicheck_value as $checked_value ) : ?>
		<li><?php echo $checked_value; ?></li>
	<?php endforeach; ?>
  </ul>
<?php endif; ?>
{% endhighlight %}

Please keep in mind that the returned values are the keys of the settings you have defined, not their labels. If you want to display the labels then you will have to implement this on your code.
