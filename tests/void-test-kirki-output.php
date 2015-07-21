<?php

class Test_Kirki_Output extends WP_UnitTestCase {

	public function timestwo( $value ) {
		return 2 * intval( $value );
	}

	public function test_css_theme_mod() {
		set_theme_mod( 'foo', '#333' );
		$this->assertEquals(
		'@media (min-width: 700px){body > #foo{background-color:#333!important;}body > #foo a:after{color:#333;}}#bar{color:#333;}',
			Kirki_Output::css(
				'foo',
				'theme_mod',
				array(
					array(
						'element' => 'body > #foo',
						'property' => 'background-color',
						'units' => '!important',
						'prefix' => '@media (min-width: 700px) {',
						'suffix' => '}',
					),
					array(
						'element' => '#bar',
						'property' => 'color',
					),
					array(
						'element' => 'body > #foo a:after',
						'property' => 'color',
						'media_query' => '@media (min-width: 700px)',
					),
				),
				''
			)
		);
	}

	public function test_css_option() {
		update_option( 'foo', '#333' );
		$this->assertEquals(
		'@media (min-width: 700px){body > #foo{background-color:#333!important;}body > #foo a:after{color:#333;}}#bar{color:#333;}',
			Kirki_Output::css(
				'foo',
				'option',
				array(
					array(
						'element' => 'body > #foo',
						'property' => 'background-color',
						'units' => '!important',
						'prefix' => '@media (min-width: 700px) {',
						'suffix' => '}',
					),
					array(
						'element' => '#bar',
						'property' => 'color',
					),
					array(
						'element' => 'body > #foo a:after',
						'property' => 'color',
						'media_query' => '@media (min-width: 700px)',
					),
				),
				''
			)
		);
	}

	public function test_css_option_serialized() {
		update_option( 'foo', array( 'bar' => '#333' ) );
		$this->assertEquals(
		'@media (min-width: 700px){body > #foo{background-color:#333!important;}body > #foo a:after{color:#333;}}#bar{color:#333;}',
			Kirki_Output::css(
				'foo[bar]',
				'option',
				array(
					array(
						'element' => 'body > #foo',
						'property' => 'background-color',
						'units' => '!important',
						'prefix' => '@media (min-width: 700px) {',
						'suffix' => '}',
					),
					array(
						'element' => '#bar',
						'property' => 'color',
					),
					array(
						'element' => 'body > #foo a:after',
						'property' => 'color',
						'media_query' => '@media (min-width: 700px)',
					),
				),
				''
			)
		);
	}

	public function test_css() {
		$this->assertEquals( null, Kirki_Output::css() );
		set_theme_mod( 'foo', '3' );
		$this->assertEquals( 'body{font-size:6px;}',
			Kirki_Output::css(
				'foo',
				'theme_mod',
				array( array(
					'element' => 'body',
					'property' => 'font-size',
					'units' => 'px',

				) ),
				array( $this, 'timestwo' )
			)
		);

		set_theme_mod( 'foo', 'http://foo.com/bar.png' );
		$this->assertEquals( 'body{background-image:url("http://foo.com/bar.png");}',
			Kirki_Output::css(
				'foo',
				'theme_mod',
				array( array(
					'element' => 'body',
					'property' => 'background-image',

				) ),
				''
			)
		);

		set_theme_mod( 'foo', 'left-top' );
		$this->assertEquals( 'body{background-position:left top;}',
			Kirki_Output::css(
				'foo',
				'theme_mod',
				array( array(
					'element' => 'body',
					'property' => 'background-position',

				) ),
				''
			)
		);
	}

	public function test_add_prefixes() {
		$this->assertEquals( null, Kirki_Output::add_prefixes( '' ) );
		$css = array();
		$css['global']['body']['border-radius'] = '3px';
		$css['global']['body']['box-shadow'] = '10px 10px 5px 0px rgba(0,0,0,0.75)';
		$css['global']['body']['box-sizing'] = 'border-box';
		$css['global']['body']['text-shadow'] = '0';
		$css['global']['body']['transform'] = 'rotate(30deg)';
		$css['global']['body']['background-size'] = 'cover';
		$css['global']['body']['transition'] = 'width 1s';
		$css['global']['body']['transition-property'] = 'width';
		$this->assertEquals(
			array( 'global' => array( 'body' => array(
				'border-radius' => '3px',
				'-moz-border-radius' => '3px',
				'-webkit-border-radius' => '3px',
				'box-shadow' => '10px 10px 5px 0px rgba(0,0,0,0.75)',
				'-moz-box-shadow' => '10px 10px 5px 0px rgba(0,0,0,0.75)',
				'-webkit-box-shadow' => '10px 10px 5px 0px rgba(0,0,0,0.75)',
				'box-sizing' => 'border-box',
				'-moz-box-sizing' => 'border-box',
				'-webkit-box-sizing' => 'border-box',
				'text-shadow' => '0',
				'-moz-text-shadow' => '0',
				'-webkit-text-shadow' => '0',
				'transform' => 'rotate(30deg)',
				'-moz-transform' => 'rotate(30deg)',
				'-webkit-transform' => 'rotate(30deg)',
				'-ms-transform' => 'rotate(30deg)',
				'-o-transform' => 'rotate(30deg)',
				'background-size' => 'cover',
				'-moz-background-size' => 'cover',
				'-webkit-background-size' => 'cover',
				'-ms-background-size' => 'cover',
				'-o-background-size' => 'cover',
				'transition' => 'width 1s',
				'-moz-transition' => 'width 1s',
				'-webkit-transition' => 'width 1s',
				'-ms-transition' => 'width 1s',
				'-o-transition' => 'width 1s',
				'transition-property' => 'width',
				'-moz-transition-property' => 'width',
				'-webkit-transition-property' => 'width',
				'-ms-transition-property' => 'width',
				'-o-transition-property' => 'width',
			) ) ),
			Kirki_Output::add_prefixes( $css )
		);
	}

}
