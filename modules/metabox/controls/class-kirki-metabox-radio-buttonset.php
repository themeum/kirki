<?php
class Kirki_Metabox_Radio_Buttonset extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		?>
		<div class="customize-control customize-control-kirki-radio-buttonset" id="container_<?php $id ?>" <?php $this->args() ?>>
			<?php $this->field_label(); ?>
			<div class="buttonset">
				<input class="switch-input screen-reader-text" type="radio" value="" <?php $this->field_id( '_default' ); ?> <?php if ( $current_val === '' ) { echo ' checked="checked"'; } ?>>
					<label class="switch-label switch-label-<?php if ( $current_val === '' ) { echo 'on'; } else { echo 'off'; }?>" for="<?php echo $id; ?>_default"><?php _e ( 'Default', 'kirki' ); ?></label>
				</input>
				<?php foreach ( $this->field['choices'] as $k => $v ): ?>
				<input class="switch-input screen-reader-text" type="radio" value="<?php echo $k ?>" <?php $this->field_id( '_' . $k ); ?> <?php if ( $k === $current_val ) { echo ' checked="checked"'; } ?>>
					<label class="switch-label switch-label-<?php if ( $k === $current_val ) { echo 'on'; } else { echo 'off'; } ?>" for="<?php echo $id . '_' . $k ?>"><?php echo $v; ?></label>
				</input>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}
}