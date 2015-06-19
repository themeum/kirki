<?php

/**
 * Creates a TinyMCE control
 */
class Kirki_Controls_Editor_Control extends WP_Customize_Control {

	public $type = 'editor';

	public function enqueue() {
		wp_enqueue_script( 'kirki-editor', trailingslashit( kirki_url() ) . 'includes/controls/editor/kirki-editor.js', array( 'jquery' ) );
	}

	public function render_content() { ?>

		<label>
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_textarea( $this->value() ); ?>">
			<?php
				$settings = array(
					'textarea_name'    => $this->id,
					'teeny'            => true
				);
				wp_editor( esc_textarea( $this->value() ), $this->id, $settings );

				do_action('admin_footer');
				do_action('admin_print_footer_scripts');
			?>
		</label>
		<?php
	}

}
