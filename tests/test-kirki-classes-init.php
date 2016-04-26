<?php

class Test_Kirki_Classes_Init extends WP_UnitTestCase {

	public function test() {

		$l10n = new Kirki_l10n();
		$this->assertTrue( is_object( $l10n ) );

		$loading = new Kirki_Scripts_Loading();
		$this->assertTrue( is_object( $loading ) );

	}

	public function test_add_fields() {
		$types = array(
			'checkbox',
			'code',
			'color',
			'color-palette',
			'custom',
			'dashicons',
			'date',
			'dimension',
			'dropdown-pages',
			'editor',
			'generic',
			'multicheck',
			'multicolor',
			'number',
			'palette',
			'preset',
			'radio',
			'radio-buttonset',
			'radio-image',
			'repeater',
			'select',
			'slider',
			'sortable',
			'spacing',
			'switch',
			'toggle',
			'typography',
		);
		foreach ( $types as $type ) {
			Kirki::add_field( 'global', array(
				'type' => $type,
				'settings' => 'my_setting' . $type,
			));
			$this->assertTrue( isset( Kirki::$fields[ 'my_setting' . $type ] ) );
			$this->assertTrue( ! empty( Kirki::$fields[ 'my_setting' . $type ] ) );
		}
		Kirki::$fields = array();
	}

}
