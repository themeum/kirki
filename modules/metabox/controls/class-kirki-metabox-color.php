<?php
class Kirki_Metabox_Color extends Kirki_Metabox_Control
{
	public function init()
	{
		if ( !isset ( $this->field['choices'] ) )
		{
			$this->field['choices'] = array();
		}
		
		if ( !isset ( $this->field['choices']['alpha'] ) )
		{
			$this->field['choices']['alpha'] = false;
		}
	}
	
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		$type = $this->field['type'];
		?>
		<div class="kirki-color-picker-outer" <?php $this->args() ?>>
		<?php $this->field_label(); ?>
		<input type="text" class="kirki-mb color-picker" <?php $this->field_link(); ?> data-alpha="<?php echo $this->field['choices']['alpha'] ? 'true' : 'false'; ?>" data-default-color="" value="<?php echo $current_val ?>">
		</div>
		<?php
	}
}