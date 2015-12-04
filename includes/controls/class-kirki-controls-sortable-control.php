<?php
/**
 * sortable Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Sortable_Control' ) ) {
	return;
}

class Kirki_Controls_Sortable_Control extends Kirki_Customize_Control {

	public $type = 'sortable';

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		add_filter( 'customize_sanitize_' . $id, array( $this, 'customize_sanitize' ) );
	}

	/**
	 * Unserialize the setting before saving on DB
	 *
	 * @param $value Serialized settings
	 *
	 * @return Array
	 */
	public function customize_sanitize( $value ) {
		$value = maybe_unserialize( $value );
		return $value;
	}

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-sortable', 'controls/sortable', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ) );
	}

	public function to_json() {
		parent::to_json();

		$this->json['choicesLength'] = 0;
		if ( is_array( $this->choices ) && count( $this->choices ) )
			$this->json['choicesLength'] = count( $this->choices );

		$values = $this->value() == '' ? array_keys( $this->choices ) : $this->value();
		$filtered_values = array();
		if ( is_array( $values && ! empty( $values ) ) ) {
			foreach ( $values as $key => $value ) {
				if ( array_key_exists( $value, $this->choices ) ) {
					$filtered_values[$key] = $value;
				}
			}
		}

		$this->json['filteredValues'] = $filtered_values;

		$this->json['invisibleKeys'] = array_diff( array_keys( $this->choices ), $filtered_values );

		$this->json['inputAttrs'] = maybe_serialize( $this->input_attrs() );


	}

	protected function content_template() { ?>
		<# if ( ! data.choicesLength ) return; #>

		<# if ( data.help ) { #>
			<a href="#" class="tooltip hint--left" data-hint="{{ data.help }}"><span class='dashicons dashicons-info'></span></a>
		<# } #>

		<label class='kirki-sortable'>
			<span class="customize-control-title">
				{{{ data.label }}}
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>

			<ul class="sortable">
				<# for ( i in data.filteredValues ) { #>
					<# if ( data.filteredValues.hasOwnProperty( i ) ) { #>
						<li class='kirki-sortable-item' data-value='{{ data.filteredValues[i] }}'>
							<i class='dashicons dashicons-menu'></i>
							<i class="dashicons dashicons-visibility visibility"></i>
							{{{ data.choices[ data.filteredValues[i] ] }}}
						</li>
					<# } #>
				<# } #>

				<# for ( i in data.invisibleKeys ) { #>
					<# if ( data.invisibleKeys.hasOwnProperty( i ) ) { #>
						<li class='kirki-sortable-item invisible' data-value='{{ data.invisibleKeys[i] }}'>
							<i class='dashicons dashicons-menu'></i>
							<i class="dashicons dashicons-visibility visibility"></i>
							{{{ data.choices[ data.invisibleKeys[i] ] }}}
						</li>
					<# } #>
				<# } #>
			</ul>

			<div style='clear: both'></div>
			<input type="hidden" {{ data.link }} value="" {{ data.inputAttrs }}/>
		</label>

		<?php
	}
}
