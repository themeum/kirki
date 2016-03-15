---
layout: docs-field
title: custom
sections:
  - Arguments
  - Example
  - Usage
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>custom</code>.
edit: docs/controls/custom.md
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'custom',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '<div style="padding: 30px;background-color: #333; color: #fff; border-radius: 50px;">' . esc_html__( 'You can enter custom markup in this control and use it however you want', 'my_textdomain' ) . '</div>',
	'priority'    => 10,
) );
?>
{% endhighlight %}

The content of the field is defined in the `default` argument.
You can use valid HTML.

> Please keep in mind that you should always use WordPress's i18n functions for your labels and descriptions so they are translatable. More information on WordPress's i18n functions can be found on the [WordPress Codex](https://codex.wordpress.org/I18n_for_WordPress_Developers).

### Usage

The `custom` control does not return any value. Its function is usually decorative and informational in the customizer.
