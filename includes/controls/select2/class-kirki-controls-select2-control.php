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
if ( class_exists( 'Kirki_Controls_Select2_Control' ) ) {
	return;
}

class Kirki_Controls_Select2_Control extends WP_Customize_Control {

	public $type = 'select2';

	public function enqueue() {
		wp_enqueue_script( 'jquery-select2', trailingslashit( kirki_url() ) . 'includes/controls/select2/select2.full.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'kirki-select2', trailingslashit( kirki_url() ) . 'includes/controls/select2/script.js', array( 'jquery', 'jquery-select2' ) );
		wp_enqueue_style( 'css-select2', trailingslashit( kirki_url() ) . 'includes/controls/select2/select2.min.css' );
	}

	protected function render() {
		$id = str_replace( '[', '-', str_replace( ']', '', $this->id ) );
		$class = 'customize-control customize-control-' . $this->type; ?>
		<li id="customize-control-<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li>
		<?php
	}

	public function render_content() {
		$id = str_replace( '[', '-', str_replace( ']', '', $this->id ) );

		if ( empty( $this->choices ) ) {
			return;
		}
		?>

		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>

			<select <?php $this->link(); ?> class="select2">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<?php
	}

}
