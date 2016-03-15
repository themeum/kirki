---
layout: docs-field
title: checkbox
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>checkbox</code>, <code>switch</code> or <code>toggle</code>.
  - argument: choices
    required: "no"
    type: array
    description: If you're using switches, you can use this to change the ON/OFF labels.
edit: docs/controls/checkbox.md
---

### Usage:

The saved value is a `boolean`:

{% highlight php %}
<?php if ( true == get_theme_mod( 'my_setting', true ) ) : ?>
	<p>Checkbox is checked</p>
<?php else : ?>
	<p>Checkbox is unchecked</p>
<?php endif; ?>
{% endhighlight %}
