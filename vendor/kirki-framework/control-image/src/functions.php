<?php
/**
 * Add extra functions and hooks.
 *
 * @package    Kirki
 * @copyright  Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since      4.0
 */

add_action(
    'customize_register',
    function() {
        class_alias( 'Kirki\Control\Image', 'Kirki_Control_Image' );
    }
);

class_alias( 'Kirki\Field\Image', 'Kirki_Field_Image' );

add_action(
    'customize_controls_print_footer_scripts',
    function() {
        $path = apply_filters( 'kirki_control_view_image', __DIR__ . '/view.php' );
        echo '<script type="text/html" id="tmpl-kirki-input-image">';
        include $path;
        echo '</script>';
    }
);
