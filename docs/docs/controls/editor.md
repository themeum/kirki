---
layout: default
title: WordPress Customizer Editor Control
slug: editor
subtitle: Learn how to create an editor control using the Kirki Customizer Framework.
mainMaxWidth: 55rem;
bodyClasses: control page
returns: string
heroButtons:
  - url: ../controls
    class: white button round border-only
    icon: fa fa-arrow-circle-o-left
    label: Back to Controls
---

The `editor` control renders a rich-text editor in the WordPress Customizer. This editor is the same that WordPress-Core uses in its default widgets, so not all buttons and capabilities are available.

<img src="https://raw.githubusercontent.com/aristath/kirki/master/docs/assets/images/editor.png" alt="editor control example" style="max-width:300px;">

### Example

```php
Kirki::add_field( 'theme_config_id', [
	'type'        => 'editor',
	'settings'    => 'my_setting',
	'label'       => esc_html__( 'My Editor Control', 'kirki' ),
	'description' => esc_html__( 'This is an editor control.', 'kirki' ),
	'section'     => 'my_section',
	'default'     => '',
] );
```
