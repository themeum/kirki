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
        class_alias( 'Kirki\Control\Dimension', 'Kirki_Control_Dimension' );
    }
);

class_alias( 'Kirki\Field\Dimension', 'Kirki_Field_Dimension' );