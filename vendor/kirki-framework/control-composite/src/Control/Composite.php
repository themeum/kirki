<?php
/**
 * Customizer Control: composite.
 *
 * @package   kirki-framework/control-composite
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     0.1
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\URL;

/**
 * Composite control
 *
 * @since 0.1
 */
class Composite extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 0.1
	 * @var string
	 */
	public $type = 'kirki-composite';
	
	/**
	 * An array of fields used to compile this composite control.
	 *
	 * @access protected
	 * @since 0.1
	 * @var array
	 */
	protected $fields = [];

	/**
	 * Script dependencies.
	 *
	 * @access protected
	 * @since 0.1
	 * @var array
	 */
	protected $script_dependencies = [];

	/**
	 * Constructor.
	 * Supplied `$args` override class property defaults.
	 * If `$args['settings']` is not defined, use the $id as the setting ID.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    {@see WP_Customize_Control::__construct}.
	 */
	public function __construct( $manager, $id, $args = [] ) {
		$args['type'] = 'kirki-composite';
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 0.1
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		$script_dependencies = array_unique( array_merge( $this->script_dependencies, [ 'jquery', 'customize-base', 'kirki-dynamic-control' ] ) );

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-composite', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), $script_dependencies, self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-composite', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @access public
	 * @since 0.1
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$this->json['fields'] = $this->fields;
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see WP_Customize_Control::print_template()
	 *
	 * @access protected
	 * @since 1.0.8
	 * @return void
	 */
	protected function content_template() {
		?>
		<input class="composite-hidden-value" type="hidden" value="{{ JSON.stringify( data.value ) }}" {{{ data.link }}}>
		<?php
	}
}
