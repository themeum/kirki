<?php
class Kirki_Metabox_Link extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post, ['target' => '', 'url' => '', 'rel' => 'nofollow'] );
		$type = $this->field['type'];
		?>
		<div class="kirki-mb-link-outer" <?php $this->args() ?>>
		<?php $this->field_label(); ?>
		<?php
			$rel_name = $id . '_rel';
			$target_name = $id . '_target';
			?>
			<div class="link-outer">
				<input class="link" type="text" value="<?php echo $current_val['url']; ?>">
				<button type="button" class="select-link"><span class="dashicons dashicons-admin-generic"></span></button>
			</div>
			<div class="options-outer">
				<h4><?php _e('Target', 'kirki'); ?></h4>
				<div class="target">
					<input type="checkbox" id="<?php echo $target_name ?>" <?php checked ( $current_val['target'], '_blank' ); ?>>
					<label for="<?php echo $target_name ?>"><?php _e('Open link in new tab', 'kirki'); ?></label>
				</div>
				<h4><?php _e('Relationship', 'kirki'); ?></h4>
				<div class="rel">
					<input type="checkbox" id="<?php echo $rel_name ?>" <?php checked ( $current_val['rel'], 'nofollow' ); ?>>
					<label for="<?php echo $rel_name ?>"><?php _e('Do not follow', 'kirki'); ?></label>
				</div>
			</div>
			<input type="hidden" <?php $this->field_link(); ?>>
		</div>
		<?php
	}
}