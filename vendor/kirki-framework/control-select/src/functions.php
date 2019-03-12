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
        class_alias( 'Kirki\Control\Select', 'Kirki_Control_Select' );
    }
);

class_alias( 'Kirki\Field\Dropdown_Pages', 'Kirki_Field_Dropdown_Pages' );
class_alias( 'Kirki\Field\Preset', 'Kirki_Field_Preset' );
class_alias( 'Kirki\Field\Select', 'Kirki_Field_Select' );

add_action(
    'customize_controls_print_footer_scripts',
    function() {
        $path = apply_filters( 'kirki_control_view_select', __DIR__ . '/view.php' );
        echo '<script type="text/html" id="tmpl-kirki-input-select">';
        include $path;
        echo '</script>';
    }
);
