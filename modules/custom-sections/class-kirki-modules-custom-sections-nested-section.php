<?php

class Kirki_Modules_Custom_Sections_Nested_Section extends WP_Customize_Section {

	public $section;

	public $type = 'kirki_nested_section';

	public function json() {

		$array = wp_array_slice_assoc( (array) $this, array(
			'id',
			'description',
			'priority',
			'panel',
			'type',
			'description_hidden',
			'section',
		));

		$array['title']          = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$array['content']        = $this->get_content();
		$array['active']         = $this->active();
		$array['instanceNumber'] = $this->instance_number;

		$array['customizeAction'] = esc_attr__( 'Customizing', 'kirki' );
		if ( $this->panel ) {
			$array['customizeAction'] = sprintf(
				esc_attr__( 'Customizing &#9656; %s', 'kirki' ),
				esc_html( $this->manager->get_panel( $this->panel )->title )
			);
		}
		return $array;
	}
}
