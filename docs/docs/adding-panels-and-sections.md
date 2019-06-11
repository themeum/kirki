---
layout: default
title: Adding Panels and Sections to the WordPress Customizer
subtitle: How to add panels and sections to the WordPress Customizer using the Kirki framework.
mainMaxWidth: 55rem;
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
    'title'       => esc_html__( 'My Panel', 'kirki' ),
    'description' => esc_html__( 'My panel description', 'kirki' ),
) );
```

The `Kirki::add_panel()` method is nothing more than a wrapper for the WordPress customizer API and therefore follows the exact same syntax. More information on WordPress Customizer Panels can be found on the [WordPress Codex](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#panels).


## Adding Sections

Sections are wrappers for controls, a way to group multiple controls together. All fields must belong to a section, no field can be an orphan. To see how to create Sections using the WordPress Customizer API please take a look at [these docs](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#sections).

Using Kirki:
```php
Kirki::add_section( 'section_id', array(
    'title'          => esc_html__( 'My Section', 'kirki' ),
    'description'    => esc_html__( 'My section description.', 'kirki' ),
    'panel'          => 'panel_id',
    'priority'       => 160,
) );
```

The `Kirki::add_section()` method is nothing more than a wrapper for the WordPress customizer API and therefore follows the exact same syntax. More information on WordPress Customizer Sections can be found on the [WordPress Codex](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#sections)
