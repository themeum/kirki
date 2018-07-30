<?php
class Kirki_Metabox_Generic extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		$type = $this->field['type'];
		?>
		<div <?php $this->args() ?>>
		<?php
		$this->field_label();
		switch ( $type )
		{
			case 'text':
			case 'password':
				?>
				<input class="kirki-mb-<?php echo $type ?>" type="<?php echo $type ?>" value="<?php echo esc_attr ( $current_val ); ?>" <?php $this->field_link(); ?>>
				<?php
				break;
			case 'checkbox':
			case 'radio':
				?>
				<input class="kirki-mb-<?php echo $type ?>" type="<?php echo $type ?>" <?php $this->field_link(); ?>>
				<?php
				break;
			case 'textarea':
				?>
				<textarea class="kirki-mb-<?php echo $type ?>" <?php $this->field_link(); ?>><?php echo $current_val ?></textarea>
				<?php
				break;
		}
		?>
		</div>
		<?php
	}
}