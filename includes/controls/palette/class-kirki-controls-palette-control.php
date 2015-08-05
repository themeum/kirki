<?php
/**
 * palette Customizer Control.
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
if ( class_exists( 'Kirki_Controls_Palette_Control' ) ) {
	return;
}

class Kirki_Controls_Palette_Control extends WP_Customize_Control {

	public $type = 'palette';

	public function enqueue() {

		wp_enqueue_script( 'jquery-ui-button' );
		wp_enqueue_style( 'kirki-palette', trailingslashit( kirki_url() ).'includes/controls/palette/style.css' );

	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-palette-'.$this->id;

		?>
		<span class="customize-control-title">
			<?php echo esc_attr( $this->label ); ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
		</span>

		<div id="input_<?php echo $this->id; ?>" class="buttonset">
			<?php foreach ( $this->choices as $value => $colorSet ) : ?>
				<input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id.esc_attr( $value ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
					<label for="<?php echo $this->id.esc_attr( $value ); ?>">
						<?php
						foreach ( $colorSet as $color ) {
							printf( "<span style='background: {$color}'>{$color}</span>" );
						}
						?>
					</label>
				</input>
			<?php endforeach; ?>
		</div>
		<script>jQuery(document).ready(function($) { $( '[id="input_<?php echo $this->id; ?>"]' ).buttonset(); });</script>

		<?php
	}
}
