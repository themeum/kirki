---
layout: default
title: Configuring your project
subtitle: How to add kirki to your project.
mainMaxWidth: 50rem;
bodyClasses: page
heroButtons:
  - url: config
    class: white button round border-only
    icon: fa fa-cogs
    label: Configuring Project
  - url: adding-panels-and-sections
    class: white button round border-only
    icon: fa fa-th-list
    label: Add Panels and Sections
  - url: controls
    class: white button round
    icon: fa fa-diamond
    label: Controls
---

When you create a project in Kirki, the first thing you have to do is **create a configuration**. Configurations allow each project to use a different setup and act as identifiers so it's important you create one. Fields that belong to your configuration will inherit your config properties.

```php
Kirki::add_config( $config_id, $args );
```

### Example:

```php
Kirki::add_config( 'my_theme', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );
```


### Arguments

* `capability`: any valid WordPress capability. See the [WordPress Codex](https://codex.wordpress.org/Roles_and_Capabilities) for details.
* `option_type`: can be either `option` or `theme_mod`. We recommend using `theme_mod`. If however you choose to use `option` you need to understand how your data will be saved, and in most cases you will also have to use the `option_name` argument as well.
* `option_name`: If you're using options instead of theme mods then you can use this to specify an option name. All your fields will then be saved as an array under that option in the WordPress database.
* `disable_output`: Set to `true` if you don't want Kirki to automatically output any CSS for your config (defaults to `false`).

To create a field that will then use this configuration you can add your fields like this:
```php
Kirki::add_field( 'my_theme', $field_args );
```
