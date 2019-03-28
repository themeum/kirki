<?php
/**
 * Customizer Control: checkbox.
 *
 * Creates a new custom control.
 * Custom controls contains all background-related options.
 *
 * @package    kirki-framework/control-checkbox
 * @copyright  Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license    https://opensource.org/licenses/MIT
 * @since      1.0
 */

namespace Kirki\Control;

use Kirki\Control\Base;
use Kirki\Core\Kirki;
use Kirki\URL;

/**
 * Adds a checkbox control.
 *
 * @since 1.0
 */
class Checkbox extends Base {

	/**
	 * The control type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-checkbox';

	/**
	 * The control version.
	 *
	 * @static
	 * @access private
	 * @since 1.0
	 * @var string
	 */
	private static $control_ver = '1.0';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue() {
		parent::enqueue();

		// Enqueue the script.
		wp_enqueue_script( 'kirki-control-checkbox', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/control.js' ), [ 'jquery', 'customize-base', 'kirki-dynamic-control' ], self::$control_ver, false );

		// Enqueue the style.
		wp_enqueue_style( 'kirki-control-checkbox-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], self::$control_ver );
	}

	/**
	 * Render the control's content.
	 * Verbatim copy from WP_Customize_Control->render_content.
	 *
	 * @access protected
	 * @since 1.0
	 * @return void
	 */
	protected function render_content() {
		$input_id       = '_customize-input-' . $this->id;
		$description_id = '_customize-description-' . $this->id;
		?>
		<span class="customize-inside-control-row">
			<input
				id="<?php echo esc_attr( $input_id ); ?>"
				<?php echo ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : ''; ?>
				type="checkbox"
				value="<?php echo esc_attr( $this->value() ); ?>"
				<?php $this->link(); ?>
				<?php checked( $this->value() ); ?>
			/>
			<label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $this->label ); ?></label>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
		</span>
		<?php
	}
}
