<?php

class Test_Class_Kirki_Control extends WP_UnitTestCase {

	public function test_control_class_name() {
		// checkbox
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'checkbox' ) ),
			'Kirki_Controls_Checkbox_Control'
		);
		// code
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'code' ) ),
			'Kirki_Controls_Code_Control'
		);
		// color
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'color' ) ),
			'Kirki_Controls_Color_Control'
		);
		// color-alpha
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'color-alpha' ) ),
			'Kirki_Controls_Color_Alpha_Control'
		);
		// custom
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'custom' ) ),
			'Kirki_Controls_Custom_Control'
		);
		// dimension
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'dimension' ) ),
			'Kirki_Controls_Dimension_Control'
		);
		// editor
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'editor' ) ),
			'Kirki_Controls_Editor_Control'
		);
		// multicheck
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'multicheck' ) ),
			'Kirki_Controls_MultiCheck_Control'
		);
		// number
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'number' ) ),
			'Kirki_Controls_Number_Control'
		);
		// palette
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'palette' ) ),
			'Kirki_Controls_Palette_Control'
		);
		// preset
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'preset' ) ),
			'Kirki_Controls_Preset_Control'
		);
		// radio
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'radio' ) ),
			'Kirki_Controls_Radio_Control'
		);
		// radio-buttonset
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'radio-buttonset' ) ),
			'Kirki_Controls_Radio_ButtonSet_Control'
		);
		// radio-image
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'radio-image' ) ),
			'Kirki_Controls_Radio_Image_Control'
		);
		// repeater
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'repeater' ) ),
			'Kirki_Controls_Repeater_Control'
		);
		// select
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'select' ) ),
			'Kirki_Controls_Select_Control'
		);
		// slider
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'slider' ) ),
			'Kirki_Controls_Slider_Control'
		);
		// sortable
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'sortable' ) ),
			'Kirki_Controls_Sortable_Control'
		);
		// spacing
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'spacing' ) ),
			'Kirki_Controls_Spacing_Control'
		);
		// switch
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'switch' ) ),
			'Kirki_Controls_Switch_Control'
		);
		// text
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'text' ) ),
			'Kirki_Controls_Text_Control'
		);
		// textarea
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'textarea' ) ),
			'Kirki_Controls_Textarea_Control'
		);
		// toggle
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'toggle' ) ),
			'Kirki_Controls_Toggle_Control'
		);
		// typography
		$this->assertEquals(
			Kirki_Control::control_class_name( array( 'type' => 'typography' ) ),
			'Kirki_Controls_Typography_Control'
		);
	}
}
