<?php
/**
 * Adds class aliases for backwards compatibility.
 *
 * @package   Kirki
 * @category  Core
 * @author    Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     0.1
 */

namespace Kirki\Compatibility;

/**
 * Adds class aliases for backwards compatibility.
 *
 * @since 0.1
 */
class Aliases {

	/**
	 * An array of class aliases.
	 *
	 * @access private
	 * @since 0.1
	 * @var array
	 */
	private $aliases = [
		'generic'    => [
			[ 'Kirki\Core\Kirki', 'Kirki' ],
			[ 'Kirki\Core\Config', 'Kirki_Config' ],
			[ 'Kirki\Core\Control', 'Kirki_Control' ],
			[ 'Kirki\Compatibility\Field', 'Kirki_Field' ],
			[ 'Kirki\Core\Helper', 'Kirki_Helper' ],
			[ 'Kirki\Core\Init', 'Kirki_Init' ],
			[ 'Kirki\Core\L10n', 'Kirki_L10n' ],
			[ 'Kirki\Core\Modules', 'Kirki_Modules' ],
			[ 'Kirki\Core\Panel', 'Kirki_Panel' ],
			[ 'Kirki\Core\Sanitize_Values', 'Kirki_Sanitize_Values' ],
			[ 'Kirki\Core\Section', 'Kirki_Section' ],
			[ 'Kirki\Core\Sections', 'Kirki_Sections' ],
			[ 'Kirki\Core\Values', 'Kirki_Values' ],
			[ 'Kirki\Core\Util', 'Kirki_Util' ],
			[ 'Kirki\Core\Framework', 'Kirki_Toolkit' ],
			[ 'Kirki\Modules\CSS\Output', 'Kirki_Output' ],
			[ 'Kirki\Modules\CSS\Module', 'Kirki_Modules_CSS' ],
			[ 'Kirki\Modules\CSS\Generator', 'Kirki_Modules_CSS_Generator' ],
			[ 'Kirki\Modules\CSS\Property', 'Kirki_Output_Property' ],
			[ 'Kirki\Modules\CSS\Property\Font_Family', 'Kirki_Output_Property_Font_Family' ],
			[ 'Kirki\Modules\CSS\Field\Background', 'Kirki_Output_Field_Background' ],
			[ 'Kirki\Modules\CSS\Field\Dimensions', 'Kirki_Output_Field_Dimensions' ],
			[ 'Kirki\Modules\CSS\Field\Image', 'Kirki_Output_Field_Image' ],
			[ 'Kirki\Modules\CSS\Field\Multicolor', 'Kirki_Output_Field_Multicolor' ],
			[ 'Kirki\Modules\CSS\Field\Typography', 'Kirki_Output_Field_Typography' ],
			[ 'Kirki\Module\CSS_Vars', 'Kirki_Modules_CSS_Vars' ],
			[ 'Kirki\Module\Custom_Sections', 'Kirki_Modules_Custom_Sections' ],
			[ 'Kirki\Modules\Loading\Module', 'Kirki_Modules_Loading' ],
			[ 'Kirki\Module\Preset', 'Kirki_Modules_Preset' ],
			[ 'Kirki\Module\Tooltips', 'Kirki_Modules_Tooltips' ],
			[ 'Kirki\Module\Webfonts', 'Kirki_Modules_Webfonts' ],
			[ 'Kirki\Module\Webfonts\Google', 'Kirki_Fonts_Google' ],
			[ 'Kirki\Module\Webfonts\Fonts', 'Kirki_Fonts' ],
			[ 'Kirki\Module\Webfonts\Embed', 'Kirki_Modules_Webfonts_Embed' ],
			[ 'Kirki\Module\Webfonts\Async', 'Kirki_Modules_Webfonts_Async' ],
			[ 'Kirki\Modules\Field_Dependencies\Module', 'Kirki_Modules_Field_Dependencies' ],
			[ 'Kirki\Modules\Editor_Styles\Module', 'Kirki_Modules_Gutenberg' ],
			[ 'Kirki\Modules\Selective_Refresh\Module', 'Kirki_Modules_Selective_Refresh' ],
			[ 'Kirki\Modules\Postmessage\Module', 'Kirki_Modules_Postmessage' ],
			[ 'Kirki\Module\Section_Icons', 'Kirki_Modules_Icons' ],
			[ 'Kirki\Field\Background', 'Kirki_Field_Background' ],
			[ 'Kirki\Field\Checkbox', 'Kirki_Field_Checkbox' ],
			[ 'Kirki\Field\Checkbox_Switch', 'Kirki_Field_Switch' ],
			[ 'Kirki\Field\Checkbox_Switch', 'Kirki\Field\Switch' ],
			[ 'Kirki\Field\Checkbox_Toggle', 'Kirki_Field_Toggle' ],
			[ 'Kirki\Field\Checkbox_Toggle', 'Kirki\Field\Toggle' ],
			[ 'Kirki\Field\Code', 'Kirki_Field_Code' ],
			[ 'Kirki\Field\Color', 'Kirki_Field_Color' ],
			[ 'Kirki\Field\Color', 'Kirki_Field_Color_Alpha' ],
			[ 'Kirki\Field\Color_Palette', 'Kirki_Field_Color_Palette' ],
			[ 'Kirki\Field\Custom', 'Kirki_Field_Custom' ],
			[ 'Kirki\Field\Dashicons', 'Kirki_Field_Dashicons' ],
			[ 'Kirki\Field\Date', 'Kirki_Field_Date' ],
			[ 'Kirki\Field\Dimension', 'Kirki_Field_Dimension' ],
			[ 'Kirki\Field\Dimensions', 'Kirki_Field_Dimensions' ],
			[ 'Kirki\Field\Dimensions', 'Kirki_Field_Spacing' ],
			[ 'Kirki\Field\Dimensions', 'Kirki\Field\Spacing' ],
			[ 'Kirki\Field\Editor', 'Kirki_Field_Editor' ],
			[ 'Kirki\Field\FontAwesome', 'Kirki_Field_FontAwesome' ],
			[ 'Kirki\Field\Generic', 'Kirki_Field_Kirki_Generic' ],
			[ 'Kirki\Field\Generic', 'Kirki_Field_Generic' ],
			[ 'Kirki\Field\Text', 'Kirki_Field_Text' ],
			[ 'Kirki\Field\Textarea', 'Kirki_Field_Textarea' ],
			[ 'Kirki\Field\URL', 'Kirki_Field_URL' ],
			[ 'Kirki\Field\URL', 'Kirki_Field_Link' ],
			[ 'Kirki\Field\URL', 'Kirki\Field\Link' ],
			[ 'Kirki\Field\Image', 'Kirki_Field_Image' ],
			[ 'Kirki\Field\Multicheck', 'Kirki_Field_Multicheck' ],
			[ 'Kirki\Field\Multicolor', 'Kirki_Field_Multicolor' ],
			[ 'Kirki\Field\Number', 'Kirki_Field_Number' ],
			[ 'Kirki\Field\Palette', 'Kirki_Field_Palette' ],
			[ 'Kirki\Field\Repeater', 'Kirki_Field_Repeater' ],
			[ 'Kirki\Field\Dropdown_Pages', 'Kirki_Field_Dropdown_Pages' ],
			[ 'Kirki\Field\Preset', 'Kirki_Field_Preset' ],
			[ 'Kirki\Field\Select', 'Kirki_Field_Select' ],
			[ 'Kirki\Field\Slider', 'Kirki_Field_Slider' ],
			[ 'Kirki\Field\Sortable', 'Kirki_Field_Sortable' ],
			[ 'Kirki\Field\Typography', 'Kirki_Field_Typography' ],
			[ 'Kirki\Field\Upload', 'Kirki_Field_Upload' ],
		],
		'customizer' => [
			[ 'Kirki\Control\Base', 'Kirki_Control_Base' ],
			[ 'Kirki\Control\Checkbox', 'Kirki_Control_Checkbox' ],
			[ 'Kirki\Control\Checkbox_Switch', 'Kirki_Control_Switch' ],
			[ 'Kirki\Control\Checkbox_Toggle', 'Kirki_Control_Toggle' ],
			[ 'Kirki\Control\Code', 'Kirki_Control_Code' ],
			[ 'Kirki\Control\Color', 'Kirki_Control_Color' ],
			[ 'Kirki\Control\Color_Palette', 'Kirki_Control_Color_Palette' ],
			[ 'Kirki\Control\Cropped_Image', 'Kirki_Control_Cropped_Image' ],
			[ 'Kirki\Control\Custom', 'Kirki_Control_Custom' ],
			[ 'Kirki\Control\Dashicons', 'Kirki_Control_Dashicons' ],
			[ 'Kirki\Control\Date', 'Kirki_Control_Date' ],
			[ 'Kirki\Control\Dimension', 'Kirki_Control_Dimension' ],
			[ 'Kirki\Control\Editor', 'Kirki_Control_Editor' ],
			[ 'Kirki\Control\FontAwesome', 'Kirki_Control_FontAwesome' ],
			[ 'Kirki\Control\Generic', 'Kirki_Control_Generic' ],
			[ 'Kirki\Control\Image', 'Kirki_Control_Image' ],
			[ 'Kirki\Control\Multicheck', 'Kirki_Control_Multicheck' ],
			[ 'Kirki\Control\Generic', 'Kirki_Control_Number' ],
			[ 'Kirki\Control\Palette', 'Kirki_Control_Palette' ],
			[ 'Kirki\Control\Radio', 'Kirki_Control_Radio' ],
			[ 'Kirki\Control\Radio_Buttonset', 'Kirki_Control_Radio_Buttonset' ],
			[ 'Kirki\Control\Radio_Image', 'Kirki_Control_Radio_Image' ],
			[ 'Kirki\Control\Repeater', 'Kirki_Control_Repeater' ],
			[ 'Kirki\Control\Select', 'Kirki_Control_Select' ],
			[ 'Kirki\Control\Slider', 'Kirki_Control_Slider' ],
			[ 'Kirki\Control\Sortable', 'Kirki_Control_Sortable' ],
			[ 'Kirki\Control\Upload', 'Kirki_Control_Upload' ],
			[ 'Kirki\Settings\Repeater', 'Kirki\Settings\Repeater_Setting' ],
			[ 'Kirki\Settings\Repeater', 'Kirki_Settings_Repeater_Setting' ],
			[ 'Kirki\Module\Custom_Sections\Section_Default', 'Kirki_Sections_Default_Section' ],
			[ 'Kirki\Module\Custom_Sections\Section_Expanded', 'Kirki_Sections_Expanded_Section' ],
			[ 'Kirki\Module\Custom_Sections\Section_Nested', 'Kirki_Sections_Nested_Section' ],
			[ 'Kirki\Module\Custom_Sections\Section_Link', 'Kirki_Sections_Link_Section' ],
			[ 'Kirki\Module\Custom_Panels\Panel_Nested', 'Kirki_Panels_Nested_Panel' ],
		],
	];

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 0.1
	 */
	public function __construct() {
		$this->add_aliases();
		add_action( 'customize_register', [ $this, 'add_customizer_aliases' ] );
	}

	/**
	 * Adds object aliases.
	 *
	 * @access public
	 * @since 0.1
	 * @return void
	 */
	public function add_aliases() {
		foreach ( $this->aliases['generic'] as $item ) {
			if ( class_exists( $item[0] ) ) {
				class_alias( $item[0], $item[1] );
			}
		}
	}

	/**
	 * Adds object aliases for classes that get instantiated on customize_register.
	 *
	 * @access public
	 * @since 0.1
	 * @return void
	 */
	public function add_customizer_aliases() {
		foreach ( $this->aliases['customizer'] as $item ) {
			if ( class_exists( $item[0] ) ) {
				class_alias( $item[0], $item[1] );
			}
		}
	}
}
