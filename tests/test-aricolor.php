<?php

class Test_ariColor extends WP_UnitTestCase {

	public function test_colors() {

		$colors = array(
			'000000' => array(
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
					'luminance'  => 0,
				),
			),
			'FFFFFF' => array(
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
					'luminance'  => 255,
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
					'luminance'  => 126,
				),
			),
			'038703' => array(
				'input' => array(
					'hex'  => '#038703',
					'rgb'  => 'rgb(3, 135, 3)',
					'rgba' => 'rgba(3, 135, 3, 1)',
					'hsl'  => 'hsl(120, 96%, 27%)',
					'hsla' => 'hsla(120, 96%, 27%, 1)',
				),
				'output' => array(
					'hex'        => '#038703',
					'rgb'        => 'rgb(3,135,3)',
					'rgba'       => 'rgba(3,135,3,1)',
					'hsl'        => 'hsl(120,96%,27%)',
					'hsla'       => 'hsla(120,96%,27%,1)',
					'hue'        => 120,
					'saturation' => 96,
					'lightness'  => 27,
					'alpha'      => 1,
					'luminance'  => 97,
				),
			),
			'D8D5AC' => array(
				'input' => array(
					'hex'  => '#D8D5AC',
					'rgb'  => 'rgb(216, 213, 172)',
					'rgba' => 'rgba(216, 213, 172, 1)',
					'hsl'  => 'hsl(56, 36%, 76%)',
					'hsla' => 'hsla(56, 36%, 76%, 1)',
				),
				'output' => array(
					'hex'        => '#D8D5AC',
					'rgb'        => 'rgb(216,213,172)',
					'rgba'       => 'rgba(216,213,172,1)',
					'hsl'        => 'hsl(56,36%,76%)',
					'hsla'       => 'hsla(56,36%,76%,1)',
					'hue'        => 56,
					'saturation' => 36,
					'lightness'  => 76,
					'alpha'      => 1,
					'luminance'  => 211,
				),
			),
			'B8191E' => array(
				'input' => array(
					'hex'  => '#B8191E',
					'rgb'  => 'rgb(184, 25, 30)',
					'rgba' => 'rgba(184, 25, 30, 1)',
					'hsl'  => 'hsl(358, 76%, 41%)',
					'hsla' => 'hsla(358, 76%, 41%, 1)',
				),
				'output' => array(
					'hex'        => '#B8191E',
					'rgb'        => 'rgb(184,25,30)',
					'rgba'       => 'rgba(184,25,30,1)',
					'hsl'        => 'hsl(358,76%,41%)',
					'hsla'       => 'hsla(358,76%,41%,1)',
					'hue'        => 358,
					'saturation' => 76,
					'lightness'  => 41,
					'alpha'      => 1,
					'luminance'  => 59,
				),
			),
			'9600AD' => array(
				'input' => array(
					'hex'  => '#9600AD',
					'rgb'  => 'rgb(150, 0, 173)',
					'rgba' => 'rgba(150, 0, 173, 1)',
					'hsl'  => 'hsl(292, 100%, 34%)',
					'hsla' => 'hsla(292, 100%, 34%, 1)',
				),
				'output' => array(
					'hex'        => '#9600AD',
					'rgb'        => 'rgb(150,0,173)',
					'rgba'       => 'rgba(150,0,173,1)',
					'hsl'        => 'hsl(292,100%,34%)',
					'hsla'       => 'hsla(292,100%,34%,1)',
					'hue'        => 292,
					'saturation' => 100,
					'lightness'  => 34,
					'alpha'      => 1,
					'luminance'  => 44,
				),
			),
		);

		foreach ( $colors as $color ) {
			foreach ( $color['input'] as $color_mode => $input_value ) {
				$color_obj = ariColor::newColor( $input_value );
				$this->assertEquals( $color_mode, $color_obj->mode );
				foreach ( $color['output'] as $test => $expected_result ) {
					switch ( $test ) {

						case 'hex':
							$this->assertEquals( $expected_result, $color_obj->toCSS( 'hex' ) );
							break;
						case 'rgb':
							$this->assertEquals( $expected_result, $color_obj->toCSS( 'rgb' ) );
							break;
						case 'rgba':
							$this->assertEquals( $expected_result, $color_obj->toCSS( 'rgba' ) );
							break;
						case 'hsl':
							$this->assertEquals( $expected_result, $color_obj->toCSS( 'hsl' ) );
							break;
						case 'hsla':
							$this->assertEquals( $expected_result, $color_obj->toCSS( 'hsla' ) );
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
						case 'luminance':
							$this->assertEquals( $expected_result, $color_obj->luminance );
							break;

					}
				}
			}
		}
	}
}
