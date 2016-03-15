---
layout: docs-field
title: image
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

### Usage

{% highlight php %}
<?php $image = get_theme_mo( 'my_setting', '' ); ?>
<div style="background-image: url('<?php echo esc_url_raw( $image ); ?>')">
	Set the background-image of this div from "my_setting".
</div>
{% endhighlight %}
