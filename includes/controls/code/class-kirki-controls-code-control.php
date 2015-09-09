<?php
/**
 * code Customizer Control.
 *
 * Creates a new custom control.
 * Custom controls accept raw HTML/JS.
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
if ( class_exists( 'Kirki_Controls_Code_Control' ) ) {
	return;
}

class Kirki_Controls_Code_Control extends WP_Customize_Control {

	public $type = 'code';

	public function enqueue() {

		wp_enqueue_script( 'ace', trailingslashit( kirki_url() ) . 'includes/controls/code/src-min-noconflict/ace.js', array( 'jquery' ) );
		wp_enqueue_script( 'kirki-code', trailingslashit( kirki_url() ) . 'includes/controls/code/script.js', array( 'jquery', 'ace' ) );
		wp_enqueue_style( 'kirki-code-style', trailingslashit( kirki_url() ).'includes/controls/code/style.css' );

	}

	public function render_content() { ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
			<?php
			/**
			 * Get the proper language
			 */
			$language = ( isset( $this->choices['language'] ) ) ? $this->choices['language'] : 'css';
			/**
			 * Get the theme we'll be using
			 */
			$theme = ( isset( $this->choices['theme'] ) ) ? $this->choices['theme'] : 'monokai';
			/**
			 * Get the height
			 */
			$height = ( isset( $this->choices['height'] ) ) ? $this->choices['height'] : 200;
			?>
			<textarea <?php $this->link(); ?> data-editor="<?php echo esc_attr( $language ); ?>" data-theme="<?php echo esc_attr( $theme ); ?>" height="<?php echo esc_attr( $height ); ?>" rows="15">
				<?php
				/**
				 * This is a CODE EDITOR.
				 * As such, we will not be escaping anything by default.
				 *
				 * It can be used for custom CSS, custom JS and even custom PHP depending on the implementation.
				 * It's up to the theme/plugin developer to properly escape it depending on the use case.
				 */
				echo $this->value();
				?>
			</textarea>
		</label>
		<?php
		/**
		 * Add some custom CSS to define the height
		 */
		?>
		<style>li#customize-control-<?php echo $this->id; ?> .ace_editor { height: <?php echo intval( $height ); ?>px !important; }</style>
		<?php
	}

}
