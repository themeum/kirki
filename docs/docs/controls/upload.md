---
layout: default
title: WordPress Customizer Upload Control
slug: upload
subtitle: Learn how to create an upload control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `upload` control is identical to the [`image`](https://kirki.org/docs/controls/image.html) control, the only difference is that it allows uploading more file types and not only images.

### Usage

```php
<?php
$file_url = get_theme_mod( 'my_setting', '' );
printf( esc_html__( 'URL of uploaded file: %s', 'kirki' ), $file_url );
?>
```
