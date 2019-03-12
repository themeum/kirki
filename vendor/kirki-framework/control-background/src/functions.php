<?php
/**
 * Extra functions and hooks.
 *
 * @package   Kirki
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     4.0
 */

add_action(
    'customize_register',
    function() {
        class_alias( 'Kirki\Control\Background', 'Kirki_Control_Background' );
    }
);
class_alias( 'Kirki\Field\Background', 'Kirki_Field_Background' );
