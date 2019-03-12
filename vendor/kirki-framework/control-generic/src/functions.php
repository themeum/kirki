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
        class_alias( 'Kirki\Control\Generic', 'Kirki_Control_Generic' );
    }
);

class_alias( 'Kirki\Field\Generic', 'Kirki_Field_Kirki_Generic' );
class_alias( 'Kirki\Field\Generic', 'Kirki_Field_Generic' );
class_alias( 'Kirki\Field\Text', 'Kirki_Field_Text' );
class_alias( 'Kirki\Field\Textarea', 'Kirki_Field_Textarea' );
class_alias( 'Kirki\Field\URL', 'Kirki_Field_URL' );
class_alias( 'Kirki\Field\URL', 'Kirki_Field_Link' );
class_alias( 'Kirki\Field\URL', 'Kirki\Field\Link' );


add_action(
    'customize_controls_print_footer_scripts',
    function() {
        $path = apply_filters( 'kirki_control_view_generic', __DIR__ . '/view-generic.php' );
        echo '<script type="text/html" id="tmpl-kirki-input-generic">';
        include $path;
        echo '</script>';
    }
);

add_action(
    'customize_controls_print_footer_scripts',
    function() {
        $path = apply_filters( 'kirki_control_view_textarea', __DIR__ . '/view-textarea.php' );
        echo '<script type="text/html" id="tmpl-kirki-input-textarea">';
        include $path;
        echo '</script>';
    }
);
