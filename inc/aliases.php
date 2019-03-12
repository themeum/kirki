<?php
/**
 * Class aliases for backwards compatibility.
 *
 * @since 4.0
 * @package kirki
 */

add_action(
    'customize_register',
    function() {
        class_alias( 'Kirki\Control\Background', 'Kirki_Control_Background' );
        class_alias( 'Kirki\Control\Base', 'Kirki_Control_Base' );
        class_alias( 'Kirki\Control\Checkbox', 'Kirki_Control_Checkbox' );
        class_alias( 'Kirki\Control\Checkbox_Switch', 'Kirki_Control_Switch' );
        class_alias( 'Kirki\Control\Checkbox_Toggle', 'Kirki_Control_Toggle' );
        class_alias( 'Kirki\Control\Code', 'Kirki_Control_Code' );
    }
);
class_alias( 'Kirki\Field\Background', 'Kirki_Field_Background' );
class_alias( 'Kirki\Field\Checkbox', 'Kirki_Field_Checkbox' );
class_alias( 'Kirki\Field\Checkbox_Switch', 'Kirki_Field_Switch' );
class_alias( 'Kirki\Field\Checkbox_Toggle', 'Kirki_Field_Toggle' );
class_alias( 'Kirki\Field\Code', 'Kirki_Field_Code' );
