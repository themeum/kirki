---
layout: default
title: The "typography" control
slug: typography
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: string
---

The `upload` control is identical to the `image` control, the only difference is that it allows uploading more file types and not only images.

### Usage

```php
<?php
$file_url = get_theme_mod( 'my_setting', '' );
printf( esc_attr__( 'URL of uploaded file: %s', 'my_textdomain' ), $file_url );
?>
```
