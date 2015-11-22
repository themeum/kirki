<?php
/**
 * editor Customizer Control.
 *
 * Creates a TinyMCE textarea.
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
if ( class_exists( 'Kirki_Controls_Editor_Control' ) ) {
	return;
}

class Kirki_Controls_Editor_Control extends Kirki_Customize_Control {

	public $type = 'editor';

	public function render_content() { ?>
		<?php if ( '' != $this->help ) : ?>
			<a href="#" class="tooltip hint--left" data-hint="<?php echo esc_html( $this->help ); ?>"><span class='dashicons dashicons-info'></span></a>
		<?php endif; ?>

		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<?php
				$settings = array(
					'textarea_name' => $this->id,
					'teeny'         => true,
				);
				add_filter( 'the_editor', array( $this, 'filter_editor_setting_link' ) );
				wp_editor( html_entity_decode( wp_kses_post( $this->value() ) ), $this->id, $settings );

				do_action( 'admin_footer' );
				do_action( 'admin_print_footer_scripts' );
			?>
		</label>
		<?php
	}

	public function filter_editor_setting_link( $output ) {
        return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 );
    }

}
