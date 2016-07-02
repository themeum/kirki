<?php
/**
 * A wrapper class for WP_Customize_Control.
 * We'll be using this to define things that all Kirki fields must inherit.
 * Helps us keep a cleaner codebase and avoid code duplication.
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

if ( ! class_exists( 'Kirki_Customize_Control' ) ) {

	/**
	 * The parent class for all Kirki controls.
	 * Other controls should extend this object.
	 */
	class Kirki_Customize_Control extends WP_Customize_Control {

		/**
		 * Tooltips content.
		 *
		 * @access public
		 * @var string
		 */
		public $tooltip = '';

		/**
		 * Used to automatically generate all postMessage scripts.
		 *
		 * @access public
		 * @var array
		 */
		public $js_vars = array();

		/**
		 * Used to automatically generate all CSS output.
		 *
		 * @access public
		 * @var array
		 */
		public $output = array();

		/**
		 * Data type
		 *
		 * @access public
		 * @var string
		 */
		public $option_type = 'theme_mod';

		/**
		 * The kirki_config we're using for this control
		 *
		 * @access public
		 * @var string
		 */
		public $kirki_config = 'global';

		/**
		 * The translation strings.
		 *
		 * @access protected
		 * @since 2.3.5
		 * @var array
		 */
		protected $l10n = array();

		/**
		 * Constructor.
		 *
		 * Supplied `$args` override class property defaults.
		 *
		 * If `$args['settings']` is not defined, use the $id as the setting ID.
		 *
		 * @since 2.3.5
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id      Control ID.
		 * @param array                $args    {
		 *     Optional. Arguments to override class property defaults.
		 *
		 *     @type int                  $instance_number Order in which this instance was created in relation
		 *                                                 to other instances.
		 *     @type WP_Customize_Manager $manager         Customizer bootstrap instance.
		 *     @type string               $id              Control ID.
		 *     @type array                $settings        All settings tied to the control. If undefined, `$id` will
		 *                                                 be used.
		 *     @type string               $setting         The primary setting for the control (if there is one).
		 *                                                 Default 'default'.
		 *     @type int                  $priority        Order priority to load the control. Default 10.
		 *     @type string               $section         Section the control belongs to. Default empty.
		 *     @type string               $label           Label for the control. Default empty.
		 *     @type string               $description     Description for the control. Default empty.
		 *     @type array                $choices         List of choices for 'radio' or 'select' type controls, where
		 *                                                 values are the keys, and labels are the values.
		 *                                                 Default empty array.
		 *     @type array                $input_attrs     List of custom input attributes for control output, where
		 *                                                 attribute names are the keys and values are the values. Not
		 *                                                 used for 'checkbox', 'radio', 'select', 'textarea', or
		 *                                                 'dropdown-pages' control types. Default empty array.
		 *     @type array                $json            Deprecated. Use WP_Customize_Control::json() instead.
		 *     @type string               $type            Control type. Core controls include 'text', 'checkbox',
		 *                                                 'textarea', 'radio', 'select', and 'dropdown-pages'. Additional
		 *                                                 input types such as 'email', 'url', 'number', 'hidden', and
		 *                                                 'date' are supported implicitly. Default 'text'.
		 * }
		 */
		public function __construct( $manager, $id, $args = array() ) {

			// Call the constructor from the parent class.
			parent::__construct( $manager, $id, $args );

			// Add translation strings.
			$this->l10n = Kirki_l10n::get_strings( $this->kirki_config );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 */
		public function to_json() {
			parent::to_json();

			if ( isset( $this->default ) ) {
				$this->json['default'] = $this->default;
			} else {
				$this->json['default'] = $this->setting->default;
			}
			$this->json['js_vars']     = $this->js_vars;
			$this->json['output']      = $this->output;
			$this->json['value']       = $this->value();
			$this->json['choices']     = $this->choices;
			$this->json['link']        = $this->get_link();
			$this->json['tooltip']     = $this->tooltip;
			$this->json['id']          = $this->id;
			$this->json['l10n']        = $this->l10n;
			$this->json['kirkiConfig'] = $this->kirki_config;

			if ( 'user_meta' === $this->option_type ) {
				$this->json['value'] = get_user_meta( get_current_user_id(), $this->id, true );
			}
		}

		/**
		 * Renders the control wrapper and calls $this->render_content() for the internals.
		 */
		protected function render() {
			$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $this->id );
			$class = 'customize-control customize-control-kirki customize-control-' . $this->type;
			?><li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
				<?php $this->render_content(); ?>
			</li><?php
		}

		/**
		 * Render the control's content.
		 *
		 * @see WP_Customize_Control::render_content()
		 */
		protected function render_content() {}
	}
}
