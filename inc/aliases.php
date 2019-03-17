<?php
/**
 * Class aliases for backwards compatibility.
 *
 * @since 4.0
 * @package kirki
 */

// Core.
class_alias( 'Kirki\Core\Kirki', 'Kirki' );
class_alias( 'Kirki\Core\Config', 'Kirki_Config' );
class_alias( 'Kirki\Core\Control', 'Kirki_Control' );
class_alias( 'Kirki\Core\Field', 'Kirki_Field' );
class_alias( 'Kirki\Core\Helper', 'Kirki_Helper' );
class_alias( 'Kirki\Core\Init', 'Kirki_Init' );
class_alias( 'Kirki\Core\L10n', 'Kirki_L10n' );
class_alias( 'Kirki\Core\Modules', 'Kirki_Modules' );
class_alias( 'Kirki\Core\Panel', 'Kirki_Panel' );
class_alias( 'Kirki\Core\Sanitize_Values', 'Kirki_Sanitize_Values' );
class_alias( 'Kirki\Core\Section', 'Kirki_Section' );
class_alias( 'Kirki\Core\Sections', 'Kirki_Sections' );
class_alias( 'Kirki\Core\Values', 'Kirki_Values' );
class_alias( 'Kirki\Core\Util', 'Kirki_Util' );
class_alias( 'Kirki\Core\Framework', 'Kirki_Toolkit' );

// Module: CSS.
class_alias( 'Kirki\Modules\CSS\Output', 'Kirki_Output' );
class_alias( 'Kirki\Modules\CSS\Module', 'Kirki_Modules_CSS' );
class_alias( 'Kirki\Modules\CSS\Generator', 'Kirki_Modules_CSS_Generator' );
class_alias( 'Kirki\Modules\CSS\Property', 'Kirki_Output_Property' );
class_alias( 'Kirki\Modules\CSS\Property\Font_Family', 'Kirki_Output_Property_Font_Family' );
class_alias( 'Kirki\Modules\CSS\Field\Background', 'Kirki_Output_Field_Background' );
class_alias( 'Kirki\Modules\CSS\Field\Dimensions', 'Kirki_Output_Field_Dimensions' );
class_alias( 'Kirki\Modules\CSS\Field\Image', 'Kirki_Output_Field_Image' );
class_alias( 'Kirki\Modules\CSS\Field\Multicolor', 'Kirki_Output_Field_Multicolor' );
class_alias( 'Kirki\Modules\CSS\Field\Typography', 'Kirki_Output_Field_Typography' );
class_alias( 'Kirki\Modules\CSS_Vars\Module', 'Kirki_Modules_CSS_Vars' );
// Module: Custom Sections & Panels.
class_alias( 'Kirki\Modules\Custom_Sections\Module', 'Kirki_Modules_Custom_Sections' );
// Module: Loading Animation.
class_alias( 'Kirki\Modules\Loading\Module', 'Kirki_Modules_Loading' );
// Module: Preset.
class_alias( 'Kirki\Modules\Preset\Module', 'Kirki_Modules_Preset' );
// Module: Tooltips.
class_alias( 'Kirki\Modules\Tooltips\Module', 'Kirki_Modules_Tooltips' );
// Module: Webfonts.
class_alias( 'Kirki\Modules\Webfonts\Module', 'Kirki_Modules_Webfonts' );
class_alias( 'Kirki\Modules\Webfonts\Google', 'Kirki_Fonts_Google' );
class_alias( 'Kirki\Modules\Webfonts\Fonts', 'Kirki_Fonts' );
class_alias( 'Kirki\Modules\Webfonts\Embed', 'Kirki_Modules_Webfonts_Embed' );
class_alias( 'Kirki\Modules\Webfonts\Async', 'Kirki_Modules_Webfonts_Async' );
// Module: Field Dependencies.
class_alias( 'Kirki\Modules\Field_Dependencies\Module', 'Kirki_Modules_Field_Dependencies' );
// Module: Editor Styles.
class_alias( 'Kirki\Modules\Editor_Styles\Module', 'Kirki_Modules_Gutenberg' );

// Fields.
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
class_alias( 'Kirki\Field\Dimensions', 'Kirki_Field_Spacing' );
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
class_alias( 'Kirki\Field\Palette', 'Kirki_Field_Palette' );
class_alias( 'Kirki\Field\Repeater', 'Kirki_Field_Repeater' );
class_alias( 'Kirki\Field\Dropdown_Pages', 'Kirki_Field_Dropdown_Pages' );
class_alias( 'Kirki\Field\Preset', 'Kirki_Field_Preset' );
class_alias( 'Kirki\Field\Select', 'Kirki_Field_Select' );
class_alias( 'Kirki\Field\Slider', 'Kirki_Field_Slider' );
class_alias( 'Kirki\Field\Sortable', 'Kirki_Field_Sortable' );
class_alias( 'Kirki\Field\Typography', 'Kirki_Field_Typography' );
class_alias( 'Kirki\Field\Upload', 'Kirki_Field_Upload' );

// Controls.
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
		class_alias( 'Kirki\Control\Palette', 'Kirki_Control_Palette' );
		class_alias( 'Kirki\Control\Radio', 'Kirki_Control_Radio' );
		class_alias( 'Kirki\Control\Radio_Buttonset', 'Kirki_Control_Radio_Buttonset' );
		class_alias( 'Kirki\Control\Radio_Image', 'Kirki_Control_Radio_Image' );
		class_alias( 'Kirki\Control\Repeater', 'Kirki_Control_Repeater' );
		class_alias( 'Kirki\Control\Select', 'Kirki_Control_Select' );
		class_alias( 'Kirki\Control\Slider', 'Kirki_Control_Slider' );
		class_alias( 'Kirki\Control\Sortable', 'Kirki_Control_Sortable' );
		class_alias( 'Kirki\Control\Typography', 'Kirki_Control_Typography' );
		class_alias( 'Kirki\Control\Upload', 'Kirki_Control_Upload' );

		class_alias( 'Kirki\Settings\Repeater', 'Kirki\Settings\Repeater_Setting' );
		class_alias( 'Kirki\Settings\Repeater', 'Kirki_Settings_Repeater_Setting' );

		class_alias( 'Kirki\Modules\Custom_Sections\Section_Default', 'Kirki_Sections_Default_Section' );
		class_alias( 'Kirki\Modules\Custom_Sections\Section_Expanded', 'Kirki_Sections_Expanded_Section' );
		class_alias( 'Kirki\Modules\Custom_Sections\Section_Nested', 'Kirki_Sections_Nested_Section' );
		class_alias( 'Kirki\Modules\Custom_Sections\Section_Link', 'Kirki_Sections_Link_Section' );
		class_alias( 'Kirki\Modules\Custom_Panels\Panel_Nested', 'Kirki_Panels_Nested_Panel' );
	}
);
