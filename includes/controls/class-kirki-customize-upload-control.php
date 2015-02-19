<?php

/**
 * Customize Upload Control Class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 3.4.0
 */
class Kirki_Customize_Upload_Control extends Kirki_Customize_Control {
	public $removed = '';
	public $context;
	public $extensions = array();

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'upload';
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since 3.4.0
	 */
	public function enqueue() {
		wp_enqueue_script( 'wp-plupload' );
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['removed'] = $this->removed;

		if ( $this->context )
			$this->json['context'] = $this->context;

		if ( $this->extensions )
			$this->json['extensions'] = implode( ',', $this->extensions );
	}

	/**
	 * Render the control's content.
	 *
	 * @since 3.4.0
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php $this->description(); ?>
			</span>
			<?php $this->subtitle(); ?>

			<div>
				<a href="#" class="button-secondary upload"><?php _e( 'Upload', 'kirki' ); ?></a>
				<a href="#" class="remove"><?php _e( 'Remove', 'kirki' ); ?></a>
			</div>
		</label>
		<?php

	}
}
