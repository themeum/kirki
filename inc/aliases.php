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
		class_alias( 'Kirki\Control\Dashicons', 'Kirki_Control_Dashicons' );
        class_alias( 'Kirki\Control\Date', 'Kirki_Control_Date' );
        class_alias( 'Kirki\Control\Dimension', 'Kirki_Control_Dimension' );
        class_alias( 'Kirki\Control\Dimensions', 'Kirki_Control_Dimensions' );
        class_alias( 'Kirki\Control\Editor', 'Kirki_Control_Editor' );
		class_alias( 'Kirki\Control\FontAwesome', 'Kirki_Control_FontAwesome' );
        class_alias( 'Kirki\Control\Generic', 'Kirki_Control_Generic' );
        class_alias( 'Kirki\Control\Image', 'Kirki_Control_Image' );
        class_alias( 'Kirki\Control\Multicheck', 'Kirki_Control_Multicheck' );
        class_alias( 'Kirki\Control\Multicolor', 'Kirki_Control_Multicolor' );
        class_alias( 'Kirki\Control\Number', 'Kirki_Control_Number' );
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
class_alias( 'Kirki\Field\Dashicons', 'Kirki_Field_Dashicons' );
class_alias( 'Kirki\Field\Date', 'Kirki_Field_Date' );
class_alias( 'Kirki\Field\Dimension', 'Kirki_Field_Dimension' );
class_alias( 'Kirki\Field\Dimensions', 'Kirki_Field_Dimensions' );
class_alias( 'Kirki\Field\Editor', 'Kirki_Field_Editor' );
class_alias( 'Kirki\Field\FontAwesome', 'Kirki_Field_FontAwesome' );
class_alias( 'Kirki\Field\Generic', 'Kirki_Field_Kirki_Generic' );
class_alias( 'Kirki\Field\Generic', 'Kirki_Field_Generic' );
class_alias( 'Kirki\Field\Text', 'Kirki_Field_Text' );
class_alias( 'Kirki\Field\Textarea', 'Kirki_Field_Textarea' );
class_alias( 'Kirki\Field\URL', 'Kirki_Field_URL' );
class_alias( 'Kirki\Field\URL', 'Kirki_Field_Link' );
class_alias( 'Kirki\Field\URL', 'Kirki\Field\Link' );
class_alias( 'Kirki\Field\Image', 'Kirki_Field_Image' );
class_alias( 'Kirki\Field\Multicheck', 'Kirki_Field_Multicheck' );
class_alias( 'Kirki\Field\Multicolor', 'Kirki_Field_Multicolor' );
class_alias( 'Kirki\Field\Number', 'Kirki_Field_Number' );
