<?php
class Kirki_Metabox_Sortable extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		if ( empty ( $current_val ) )
		{
			$current_val = array();
		}
		$type = $this->field['type'];
		?>
		<div class="kirki-mb-sortable-outer customize-control customize-control-kirki-sortable" <?php $this->args() ?>>
		<?php $this->field_label(); ?>
			<ul class="sortable ui-sortable">
				<?php foreach ( $this->field['choices'] as $k => $v ): ?>
				<li class="kirki-sortable-item invisible" data-value="<?php echo $k ?>">
					<i class="dashicons dashicons-menu"></i>
					<i class="dashicons dashicons-visibility visibility"></i>
					<?php echo $v ?>
				</li>
				<?php endforeach; ?>
			</ul>
			<input type="hidden" <?php $this->field_link(); ?>>
		</div>
		<?php
	}
}