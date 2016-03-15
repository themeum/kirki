---
layout: docs-field
title: upload
edit: docs/controls/upload.md
extra_args:
  - argument: type
    required: "yes"
    type: string
    description: Set to <code>upload</code>
  - argument: default
    required: "yes"
    type: string
    description: Define the URL to a file or use an empty string (<code>'default' => ''</code>).
---

### Usage

* returns `string` (url of the uploaded file).

{% highlight php %}
<?php
$file_url = get_theme_mod( 'my_setting', '' );
printf( esc_attr__( 'URL of uploaded file: %s', 'my_textdomain' ), $file_url );
?>
{% endhighlight %}
