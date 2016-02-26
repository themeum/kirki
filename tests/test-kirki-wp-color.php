<?php

class Test_Kirki_WP_Color extends WP_UnitTestCase {

	public function test_colors() {

		$colors = array(
			'black' => array(
				'input' => array(
					'hex'  => '#000000',
					'rgb'  => 'rgb(0, 0, 0)',
					'rgba' => 'rgba(0, 0, 0, 1)',
					'hsl'  => 'hsl(0, 0%, 0%)',
					'hsla' => 'hsla(0, 0%, 0%, 1)',
				),
				'output' => array(
					'hex'        => '#000000',
					'rgb'        => 'rgb(0,0,0)',
					'rgba'       => 'rgba(0,0,0,1)',
					'hsl'        => 'hsl(0,0%,0%)',
					'hsla'       => 'hsla(0,0%,0%,1)',
					'hue'        => 0,
					'saturation' => 0,
					'lightness'  => 0,
					'alpha'      => 1,
				),
			),
			'white' => array(
				'input' => array(
					'hex'  => '#ffffff',
					'rgb'  => 'rgb(255, 255, 255)',
					'rgba' => 'rgba(255, 255, 255, 1)',
					'hsl'  => 'hsl(0, 0%, 100%)',
					'hsla' => 'hsla(0, 0%, 100%, 1)',
				),
				'output' => array(
					'hex'        => '#FFFFFF',
					'rgb'        => 'rgb(255,255,255)',
					'rgba'       => 'rgba(255,255,255,1)',
					'hsl'        => 'hsl(0,0%,100%)',
					'hsla'       => 'hsla(0,0%,100%,1)',
					'hue'        => 0,
					'saturation' => 0,
					'lightness'  => 100,
					'alpha'      => 1,
				),
			),
			'049CBE' => array(
				'input' => array(
					'hex'  => '#049CBE',
					'rgb'  => 'rgb(4, 156, 190)',
					'rgba' => 'rgba(4, 156, 190, 1)',
					'hsl'  => 'hsl(191, 96%, 38%)',
					'hsla' => 'hsla(191, 96%, 38%, 1)',
				),
				'output' => array(
					'hex'        => '#049CBE',
					'rgb'        => 'rgb(4,156,190)',
					'rgba'       => 'rgba(4,156,190,1)',
					'hsl'        => 'hsl(191,96%,38%)',
					'hsla'       => 'hsla(191,96%,38%,1)',
					'hue'        => 191,
					'saturation' => 96,
					'lightness'  => 38,
					'alpha'      => 1,
				),
			),
		);

		foreach ( $colors as $color ) {
			foreach ( $color['input'] as $color_mode => $input_value ) {
				$color_obj = Kirki_WP_Color::get_instance( $input_value );
				$this->assertEquals( $color_mode, $color_obj->mode );
				foreach ( $color['output'] as $test => $expected_result ) {
					switch ( $test ) {

						case 'hex':
							$this->assertEquals( $expected_result, $color_obj->get_css( 'hex' ) );
							break;
						case 'rgb':
							$this->assertEquals( $expected_result, $color_obj->get_css( 'rgb' ) );
							break;
						case 'rgba':
							$this->assertEquals( $expected_result, $color_obj->get_css( 'rgba' ) );
							break;
						case 'hsl':
							$this->assertEquals( $expected_result, $color_obj->get_css( 'hsl' ) );
							break;
						case 'hsla':
							$this->assertEquals( $expected_result, $color_obj->get_css( 'hsla' ) );
							break;
						case 'hue':
							$this->assertEquals( $expected_result, $color_obj->hue );
							break;
						case 'saturation':
							$this->assertEquals( $expected_result, $color_obj->saturation );
							break;
						case 'lightness':
							$this->assertEquals( $expected_result, $color_obj->lightness );
							break;

					}
				}
			}
		}
	}
}
