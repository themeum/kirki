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
        class_alias( 'Kirki\Control\Code', 'Kirki_Control_Code' );
    }
);
class_alias( 'Kirki\Field\Code', 'Kirki_Field_Code' );

add_action(
    'customize_controls_print_footer_scripts',
    function() {
        $path = apply_filters( 'kirki_control_view_code', __DIR__ . '/view.php' );
        echo '<script type="text/html" id="tmpl-kirki-input-code">';
        include $path;
        echo '</script>';
    }
);
