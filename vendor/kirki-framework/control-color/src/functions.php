<?php
/**
 * Add extra functions and hooks.
 *
 * @package    Kirki
 * @copyright  Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since      4.0
 */

if ( ! function_exists( 'add_action' ) ) {
    return;
}
add_action(
    'customize_register',
    function() {
        class_alias( 'Kirki\Control\Color', 'Kirki_Control_Color' );
    }
);
class_alias( 'Kirki\Field\Color', 'Kirki_Field_Color' );
class_alias( 'Kirki\Field\Color_Alpha', 'Kirki_Field_Color_Alpha' );

add_action(
    'customize_controls_print_footer_scripts',
    function() {
        $path = apply_filters( 'kirki_control_view_color', __DIR__ . '/view.php' );
        echo '<script type="text/html" id="tmpl-kirki-input-color">';
        include $path;
        echo '</script>';
    }
);
