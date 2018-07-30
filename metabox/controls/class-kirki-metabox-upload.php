<?php
class Kirki_Metabox_Upload extends Kirki_Metabox_Control
{
	public function init()
	{

	}
	public function render ( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value ( $post, '' );
		$theme_value = $this->get_theme_value();
		$input_val = '';
		if ( $this->field['type'] == 'image' )
		{
			if ( is_array ( $current_val ) )
				$input_val = esc_attr ( json_encode( $current_val ) );
			else
				$input_val = $current_val;
		}
		else
		{
			$input_val = $current_val;
		}
		?>
		<div class="kirki-metabox customize-control customize-control-kirki-upload" <?php $this->args(); ?>>
			<?php $this->field_label (); ?>
			<div class="image-wrapper attachment-media-view image-upload">
				<input type="hidden" <?php $this->field_link(); ?> value="<?php echo $input_val ?>">
				<?php if ( $this->field['type'] === 'image' ): ?>
				<div class="thumbnail thumbnail-image"><img src="<?php echo empty ( $current_val ) ? $theme_value['url'] : $current_val['url']; ?>" alt=""></div>
				<?php else: ?>
				<div class="link-preview-outer">
					<label>Selected:</label>
					<input type="text" class="media-link-preview" readonly="readonly" value="<?php echo $current_val ?>">
				</div>
				<?php endif; ?>
				<div class="actions">
					<!--<button type="button" class="button image-upload-remove-button"><?php _e ( 'Remove', 'kirki' ); ?></button>-->
					<button type="button" class="button image-default-button"><?php _e ( 'Default', 'kirki' ); ?></button>
					<button type="button" class="button image-upload-button"><?php _e ( $this->field['type'] === 'image' ? 'Select image' : 'Select media', 'kirki' ); ?></button>
				</div>
			</div>
		</div>
		<?php
	}
}