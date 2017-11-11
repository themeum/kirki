---
layout: default
title: The "repeater" control
slug: repeater
subtitle: Learn how to create controls using Kirki
mainMaxWidth: 50rem;
bodyClasses: control page
returns: array
---

Repeater controls allow you to build repeatable blocks of fields.
You can create for example a set of fields that will contain a checkbox and a textfield. The user will then be able to add "rows", and each row will contain a checkbox and a textfield.

### Usage

```php
<?php
// Default values for 'my_setting' theme mod.
$defaults = array(
    array(
        'link_text' => esc_attr__( 'Kirki Site', 'my_textdomain' ),
		'link_url'  => 'https://aristath.github.io/kirki/',
	),
	array(
		'link_text' => esc_attr__( 'Kirki Repository', 'my_textdomain' ),
		'link_url'  => 'https://github.com/aristath/kirki',
	),
);

// Theme_mod settings to check.
$settings = get_theme_mod( 'my_setting', $defaults ); ?>

<div class="kirki-links">
    <?php foreach( $settings as $setting ) : ?>
        <a href="<?php $setting['link_url']; ?>">
            <?php $setting['link_text']; ?>
        </a>
    <?php endforeach; ?>
</div>
```
