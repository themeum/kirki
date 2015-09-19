<?php
/**
 * select2 Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Select_Control' ) ) {
	return;
}

class Kirki_Controls_Select_Control extends WP_Customize_Control {

	public $type = 'kirki-select';

	public $multiple = 1;

	public function to_json() {
		parent::to_json();

		$this->json['value']    = $this->value();
		$this->json['choices']  = $this->choices;
		$this->json['link']     = $this->get_link();
		$this->json['multiple'] = $this->multiple;
	}

	public function enqueue() {
		wp_enqueue_script( 'selectize', trailingslashit( kirki_url() ) . 'includes/controls/select/selectize.js', array( 'jquery' ) );
		wp_enqueue_script( 'kirki-select', trailingslashit( kirki_url() ) . 'includes/controls/select/script.js', array( 'jquery', 'selectize' ) );
	}

	protected function content_template() { ?>
		<label>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<select {{{ data.link }}} data-multiple="{{ data.multiple }}"<# if ( 1 < data.multiple ) { #> multiple<# } #>>
				<# if ( 1 < data.multiple ) { #>
					<# for ( key in data.choices ) { #>
						<option value="{{ key }}"<# if ( _.contains( data.value, key ) ) { #> selected<# } #>>{{ data.choices[ key ] }}</option>
					<# } #>
				<# } else { #>
					<# for ( key in data.choices ) { #>
						<option value="{{ key }}"<# if ( key === data.value ) { #>selected<# } #>>{{ data.choices[ key ] }}</option>
					<# } #>
				<# } #>
			</select>
		</label>
		<?php
	}

}
