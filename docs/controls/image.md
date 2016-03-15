---
layout: docs-field
title: image
sections:
  - Arguments
  - Example
  - Usage
edit: docs/controls/image.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>image</code>
  - argument: default
    required: "yes"
    type: string
    description: Define the URL to an image or use an empty string (<code>'default' => ''</code>).
---

### Example

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
	'type'        => 'image',
	'settings'    => 'image_demo',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'description' => __( 'This is the control description', 'my_textdomain' ),
	'help'        => __( 'This is some extra help text.', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '',
	'priority'    => 10,
) );
?>
{% endhighlight %}
The control saves the URL to the image, and if you want to define a default value as an image, then you will have to add a string containing the full URL to that image.

### Usage

{% highlight php %}
<?php $image = get_theme_mo( 'my_setting', '' ); ?>
<div style="background-image: url('<?php echo esc_url_raw( $image ); ?>')">
	Set the background-image of this div from "my_setting".
</div>
{% endhighlight %}
