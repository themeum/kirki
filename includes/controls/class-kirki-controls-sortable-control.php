<?php
/**
 * Customizer Control: sortable.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Sortable_Control' ) ) {

	/**
	 * Sortable control (uses checkboxes).
	 */
	class Kirki_Controls_Sortable_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-sortable';

		/**
		 * Constructor.
		 * Supplied `$args` override class property defaults.
		 * If `$args['settings']` is not defined, use the $id as the setting ID.
		 *
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id      Control ID.
		 * @param array                $args    {@see WP_Customize_Control::__construct}.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );
			add_filter( 'customize_sanitize_' . $id, array( $this, 'customize_sanitize' ) );
		}

		/**
		 * Unserialize the setting before saving on DB.
		 *
		 * @param string $value Serialized settings.
		 * @return array
		 */
		public function customize_sanitize( $value ) {
			$value = maybe_unserialize( $value );
			return $value;
		}

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-sortable' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			parent::to_json();

			$this->json['choicesLength'] = 0;
			if ( is_array( $this->choices ) && count( $this->choices ) ) {
				$this->json['choicesLength'] = count( $this->choices );
			}

			$values = $this->value() == '' ? array_keys( $this->choices ) : $this->value();
			$filtered_values = array();
			if ( is_array( $values ) && ! empty( $values ) ) {
				foreach ( $values as $key => $value ) {
					if ( array_key_exists( $value, $this->choices ) ) {
						$filtered_values[ $key ] = $value;
					}
				}
			}

			$this->json['filteredValues'] = $filtered_values;

			$this->json['invisibleKeys'] = array_diff( array_keys( $this->choices ), $filtered_values );

			$this->json['inputAttrs'] = maybe_serialize( $this->input_attrs() );

		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
			<# if ( ! data.choicesLength ) return; #>

			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>

			<label class='kirki-sortable'>
				<span class="customize-control-title">
					{{{ data.label }}}
				</span>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>

				<ul class="sortable">
					<# for ( i in data.filteredValues ) { #>
						<# if ( data.filteredValues.hasOwnProperty( i ) ) { #>
							<li {{{ data.inputAttrs }}} class='kirki-sortable-item' data-value='{{ data.filteredValues[i] }}'>
								<i class='dashicons dashicons-menu'></i>
								<i class="dashicons dashicons-visibility visibility"></i>
								{{{ data.choices[ data.filteredValues[i] ] }}}
							</li>
						<# } #>
					<# } #>

					<# for ( i in data.invisibleKeys ) { #>
						<# if ( data.invisibleKeys.hasOwnProperty( i ) ) { #>
							<li {{{ data.inputAttrs }}} class='kirki-sortable-item invisible' data-value='{{ data.invisibleKeys[i] }}'>
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
}
