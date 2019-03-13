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
		class_alias( 'Kirki\Control\Color', 'Kirki_Control_Color' );
		class_alias( 'Kirki\Control\Color_Palette', 'Kirki_Control_Color_Palette' );
        class_alias( 'Kirki\Control\Cropped_Image', 'Kirki_Control_Cropped_Image' );
        class_alias( 'Kirki\Control\Custom', 'Kirki_Control_Custom' );
	}
);
class_alias( 'Kirki\Field\Background', 'Kirki_Field_Background' );
class_alias( 'Kirki\Field\Checkbox', 'Kirki_Field_Checkbox' );
class_alias( 'Kirki\Field\Checkbox_Switch', 'Kirki_Field_Switch' );
class_alias( 'Kirki\Field\Checkbox_Toggle', 'Kirki_Field_Toggle' );
class_alias( 'Kirki\Field\Code', 'Kirki_Field_Code' );
class_alias( 'Kirki\Field\Color', 'Kirki_Field_Color' );
class_alias( 'Kirki\Field\Color_Alpha', 'Kirki_Field_Color_Alpha' );
class_alias( 'Kirki\Field\Color_Palette', 'Kirki_Field_Color_Palette' );
class_alias( 'Kirki\Field\Custom', 'Kirki_Field_Custom' );
