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
        class_alias( 'Kirki\Control\Radio', 'Kirki_Control_Radio' );
        class_alias( 'Kirki\Control\Radio_Buttonset', 'Kirki_Control_Radio_Buttonset' );
        class_alias( 'Kirki\Control\Radio_Image', 'Kirki_Control_Radio_Image' );
    }
);