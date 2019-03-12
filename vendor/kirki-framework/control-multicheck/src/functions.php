<?php
/**
 * Class aliases for backwards-compatibility.
 *
 * @package    Kirki
 * @copyright  Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since      4.0
 */

add_action(
    'customize_register',
    function() {
        class_alias( 'Kirki\Control\Multicheck', 'Kirki_Control_Multicheck' );
    }
);

class_alias( 'Kirki\Field\Multicheck', 'Kirki_Field_Multicheck' );
