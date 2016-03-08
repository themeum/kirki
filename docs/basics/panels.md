# Creating Panels

Panels are wrappers for sections, a way to group multiple sections together. To see how to create Panels using the WordPress Customizer API please take a look at [these docs](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#panels).

## Adding panels using the Kirki API

```php
Kirki::add_panel( 'panel_id', array(
    'priority'    => 10,
    'title'       => __( 'My Title', 'textdomain' ),
    'description' => __( 'My Description', 'textdomain' ),
) );
```

The `Kirki::add_panel()` method is nothing more than a wrapper for the WordPress customizer API and therefore follows the exact same syntax. More information on WordPress Customizer Panels can be found on the [WordPress Codex](https://developer.wordpress.org/themes/advanced-topics/customizer-api/#panels)
