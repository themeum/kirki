<?php

class Test_Kirki_Scripts_Frontend_Google_Fonts extends WP_UnitTestCase {

	function add_font_family_field() {
		Kirki::add_field( '', array(
		    'type'     => 'select',
		    'setting'  => 'font_family',
		    'label'    => __( 'Font Family', 'example' ),
		    'section'  => 'base_typography',
		    'default'  => 'Roboto',
		    'priority' => 20,
		    'choices'  => Kirki_Fonts::get_font_choices(),
		    'output' => array(
		        'element'  => 'body',
		        'property' => 'font-family',
		    ),
		) );
	}

	function add_font_subsets_field() {
		Kirki::add_field( '', array(
		    'type'     => 'multicheck',
		    'setting'  => 'subsets',
		    'label'    => __( 'Google-Font subsets', 'example' ),
		    'description' => __( 'The subsets used from Google\'s API.', 'example' ),
		    'section'  => 'base_typography',
		    'default'  => 'all',
		    'priority' => 22,
		    'choices'  => Kirki_Fonts::get_google_font_subsets(),
		    'output' => array(
		        'element'  => 'body',
		        'property' => 'font-subset',
		    ),
		) );
	}

	function add_font_weight_field() {
		Kirki::add_field( '', array(
		    'type'     => 'slider',
		    'setting'  => 'font_weight',
		    'label'    => __( 'Font Weight', 'example' ),
		    'section'  => 'base_typography',
		    'default'  => 300,
		    'priority' => 24,
		    'choices'  => array(
		        'min'  => 100,
		        'max'  => 900,
		        'step' => 100,
		    ),
		    'output' => array(
		        'element'  => 'body',
		        'property' => 'font-weight',
		    ),
		) );
	}

	function test_google_link_font_family_roboto() {
		$this->add_font_family_field();
		set_theme_mod( 'font_family', 'Roboto' );
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$link         = $googlefonts->google_link();
		$this->assertEquals(
			$link,
			'//fonts.googleapis.com/css?family=Roboto:regular,italic,700,400&subset=cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese'
		);
	}

	function test_google_link_font_family_open_sans() {
		$this->add_font_family_field();
		set_theme_mod( 'font_family', 'Open Sans' );
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$link         = $googlefonts->google_link();
		$this->assertEquals(
			$link,
			'//fonts.googleapis.com/css?family=Open+Sans:regular,italic,700,400&subset=cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese'
		);
	}

	function test_google_link_font_subset_roboto() {
		$this->add_font_family_field();
		$this->add_font_subsets_field();
		set_theme_mod( 'font_family', 'Roboto' );
		set_theme_mod( 'subsets', 'greek' );
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$link         = $googlefonts->google_link();
		$this->assertEquals(
			$link,
			'//fonts.googleapis.com/css?family=Roboto:regular,italic,700,400&subset=greek'
		);
	}

	function test_google_link_font_subset_open_sans() {
		$this->add_font_family_field();
		$this->add_font_subsets_field();
		set_theme_mod( 'font_family', 'Open Sans' );
		set_theme_mod( 'subsets', 'devangari' );
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$link         = $googlefonts->google_link();
		$this->assertEquals(
			$link,
			'//fonts.googleapis.com/css?family=Open+Sans:regular,italic,700,400&subset=devangari'
		);
	}

	function test_google_link_font_combo_roboto() {
		$this->add_font_family_field();
		$this->add_font_subsets_field();
		$this->add_font_weight_field();
		set_theme_mod( 'font_family', 'Roboto' );
		set_theme_mod( 'subsets', 'greek' );
		set_theme_mod( 'font_weight', '900' );
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$link         = $googlefonts->google_link();
		$this->assertEquals(
			$link,
			'//fonts.googleapis.com/css?family=Roboto:regular,italic,700,900&subset=greek'
		);
	}

	function test_google_link_font_combo_open_sans() {
		$this->add_font_family_field();
		$this->add_font_subsets_field();
		$this->add_font_weight_field();
		set_theme_mod( 'font_family', 'Open Sans' );
		set_theme_mod( 'subsets', 'devangari' );
		set_theme_mod( 'font_weight', 100 );
		$googlefonts  = new Kirki_Scripts_Frontend_Google_Fonts();
		$link         = $googlefonts->google_link();
		$this->assertEquals(
			$link,
			'//fonts.googleapis.com/css?family=Open+Sans:regular,italic,700,100&subset=devangari'
		);
	}

}
