<?php
/**
 * Extra functions & hooks.
 *
 * @package   Kirki
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     4.0
 */

add_action(
    'customize_register',
    function() {
        class_alias( 'Kirki\Control\Checkbox', 'Kirki_Control_Checkbox' );
        class_alias( 'Kirki\Control\Checkbox_Switch', 'Kirki_Control_Switch' );
        class_alias( 'Kirki\Control\Checkbox_Toggle', 'Kirki_Control_Toggle' );
    }
);

class_alias( 'Kirki\Field\Checkbox', 'Kirki_Field_Checkbox' );
class_alias( 'Kirki\Field\Checkbox_Switch', 'Kirki_Field_Switch' );
class_alias( 'Kirki\Field\Checkbox_Toggle', 'Kirki_Field_Toggle' );
