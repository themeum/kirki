<?php
class Kirki_Metabox_Select extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		?>
		<div class="kirki-mb-select-outer" <?php $this->args() ?>>
			<?php $this->field_label(); ?>
			<select <?php $this->field_link(); ?> <?php if ( isset ( $this->field['multiple'] ) && $this->field['multiple'] ) { echo 'multiple="multiple"'; } ?>>
				<option value="" <?php selected ( '', $current_val );?>><?php _e ( 'Default', 'kirki' )?></option>
				<?php foreach ( $this->field['choices'] as $k => $v ): ?>
				<option value="<?php echo $k; ?>"<?php selected ( $k, $current_val ); ?>><?php echo $v ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<?php
	}
}