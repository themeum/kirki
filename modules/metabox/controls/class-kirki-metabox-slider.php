<?php
class Kirki_Metabox_Slider extends Kirki_Metabox_Control
{
	public function __construct ( $config_id, $field )
	{
		parent::__construct ( $config_id, $field );

		$defaults = array(
			'min'    => '0',
			'max'    => '100',
			'step'   => '1',
			'suffix' => '',
		);

		if ( isset ( $this->field['choices'] ) )
		{
			$this->field['choices'] = wp_parse_args ( $this->field['choices'], $defaults );
		}
		else
		{
			$this->field['choices'] = $defaults;
		}
	}
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post, '0' );
		?>
		<div class="customize-control kirki-metabox customize-control-kirki-slider" <?php $this->args() ?>>
			<?php $this->field_label(); ?>
			<div class="wrapper">
				<input type="range" min="<?php echo $this->field['choices']['min']; ?>" max="<?php echo $this->field['choices']['max'] ?>" step="<?php echo $this->field['choices']['step']; ?>" value="<?php $current_val ?>" <?php $this->field_link(); ?>/>
				<span class="slider-reset dashicons dashicons-image-rotate"><span class="screen-reader-text"><?php esc_attr_e( 'Reset', 'kirki' ); ?></span></span>
				<span class="value">
					<input type="text"/>
					<span class="suffix"><?php echo $this->field['choices']['suffix']; ?></span>
				</span>
			</div>
		</div>
		<?php
	}
}