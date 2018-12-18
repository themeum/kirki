<?php
class Kirki_Metabox_Multi_Color extends Kirki_Metabox_Control
{
	public function init()
	{
	}
	
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		if ( empty ( $current_val ) )
			$current_val = array();
		?>
		<div class="kirki-multicolor-outer" <?php $this->args() ?>>
			<?php $this->field_label(); ?>
			<div class="color-pickers-container">
				<?php foreach ( $this->field['choices'] as $k => $v ): ?>
				<div class="color-picker-outer">
					<label><?php echo $v ?></label>
					<input type="text" class="kirki-mb color-picker" color-id="<?php echo $k ?>" data-alpha="true" value="<?php echo isset ( $current_val[$k] ) ? $current_val[$k] : '' ?>">
				</div>
				<?php endforeach; ?>
			</div>
			<input type="hidden" <?php $this->field_link(); ?>>
		</div>
		<?php
	}
}