---
layout: default
title: Adding Panels and Sections
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

## Adding Panels

Panels are wrappers for sections, a way to group multiple sections together. To see how to create Panels using the WordPress Customizer API please take a look at [these docs](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#panels).

Using Kirki:
```php
Kirki::add_panel( 'panel_id', array(
    'priority'    => 10,
    'title'       => esc_attr__( 'My Title', 'textdomain' ),
    'description' => esc_attr__( 'My Description', 'textdomain' ),
) );
```

The `Kirki::add_panel()` method is nothing more than a wrapper for the WordPress customizer API and therefore follows the exact same syntax. More information on WordPress Customizer Panels can be found on the [WordPress Codex](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#panels).


## Adding Sections

Sections are wrappers for controls, a way to group multiple controls together. All fields must belong to a section, no field can be an orphan. To see how to create Sections using the WordPress Customizer API please take a look at [these docs](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#sections).

Using Kirki:
```php
Kirki::add_section( 'custom_css', array(
    'title'          => esc_attr__( 'Custom CSS', 'textdomain' ),
    'description'    => esc_attr__( 'Add custom CSS here', 'textdomain' ),
    'priority'       => 160,
) );
```

The `Kirki::add_section()` method is nothing more than a wrapper for the WordPress customizer API and therefore follows the exact same syntax. More information on WordPress Customizer Sections can be found on the [WordPress Codex](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#sections)
