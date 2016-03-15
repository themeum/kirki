---
layout: docs-field
title: select
sections:
  - Arguments
  - Example
  - Multi-Select
edit: docs/controls/select.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>select</code>.
  - argument: default
    required: "yes"
    type: string|array
    description: If <code>multiple</code> is > 1 then use an <code>array</code>. If not, then a <code>string</code>.
  - argument: multiple
    required: "no"
    type: int
    description: The number of options users will be able to select simultaneously. Use <code>1</code> for single-select controls (defaults to <code>1</code>).
---

We extend WordPress Core's `select` controls and all `select` controls created using Kirki will use the [selectize.js](http://brianreavis.github.io/selectize.js/) script.

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'select',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'option-1',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => array(
		'option-1' => esc_attr__( 'Option 1', 'my_textdomain' ),
		'option-2' => esc_attr__( 'Option 2', 'my_textdomain' ),
		'option-3' => esc_attr__( 'Option 3', 'my_textdomain' ),
		'option-4' => esc_attr__( 'Option 4', 'my_textdomain' ),
	),
) );
?>
{% endhighlight %}

### Multi-Select

The `multiple` argument allows you to define the maximum number of simultaneous selections a user can make.
If `multiple` is set to `1` then users will be able to select a single option like on a normal dropdown.
If `multiple` is set to `2` for example, the user will be able to select 2 items from the dropdown, as well as re-order their selections using drag-n-drop.
To allow unlimited options simply set a high number like `999`.

If `multiple` is set to `1` then the saved value will be a string.
If `multiple` is set to a value greater than 1 and the user selects multiple elements then the saved value will be an array of all the selected values.
