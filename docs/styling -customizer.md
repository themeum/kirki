# Styling the Customizer

Kirki allows you to change the styling of the customizer using the `kirki/config` filter:

```php
/**
 * Configuration sample for the Kirki Customizer
 */
function kirki_demo_configuration_sample_styling( $config ) {

    $config['logo_image']   = 'http://kirki.org/img/kirki-new-logo-white.png';
    $config['description']  = __( 'The theme description.', 'kirki' );
    $config['color_accent'] = '#00bcd4';
    $config['color_back']   = '#455a64';
    $config['width']        = '20%';

    return $config;

}
add_filter( 'kirki/config', 'kirki_demo_configuration_sample_styling' );
```

* `logo_image`: Change the logo image (URL). If omitted, the default theme info will be displayed. You may want to use a relatively large image (for example 700px wide) so that it's properly displayed on retina screens as well.
* `description`: Changes the theme description. Will be visible when clicking on the theme logo.
* `color_accent`: The accent color. This will be used on selected items and control details.
* `color_back`: The background color. This will be used on sections & panels titles.
* `width`: The width of the customizer. Use any valid CSS value like for example `24%`, `400px`, `25em` etc. In case you decide to change the width, please take into account mobile users as well.
