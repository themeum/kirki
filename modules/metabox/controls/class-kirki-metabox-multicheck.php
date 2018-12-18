<?php
class Kirki_Metabox_Multi_Check extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		if ( !is_array ( $current_val ) )
			$current_val = array();
		?>
		<div class="kirki-mb-multicheck-outer customize-control customize-control-kirki-multicheck" <?php $this->args() ?>>
			<?php $this->field_label(); ?>
			<ul>
				<li>
					<label<?php if ( empty ( $current_val ) ) { echo ' class="checked"'; } ?>>
						<input type="checkbox" class="default" value=""<?php if ( empty ( $current_val ) ) { echo ' checked'; } ?>><?php _e( 'Default', 'kirki' ); ?>
					</label>
				</li>
				<?php foreach ( $this->field['choices'] as $k => $v ): ?>
				<li>
					<label<?php if ( in_array ( $k, $current_val ) ) { echo ' class="checked"'; } ?>>
						<input type="checkbox" value="<?php echo $k ?>"<?php if ( in_array ( $k, $current_val ) ) { echo ' checked'; } ?>><?php echo $v; ?>
					</label>
				</li>
				<?php endforeach; ?>
			</ul>
			<input type="hidden" <?php $this->field_link(); ?>>
		</div>
		<?php
	}
}