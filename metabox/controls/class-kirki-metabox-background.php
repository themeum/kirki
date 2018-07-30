<?php
class Kirki_Metabox_Background extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		if ( empty ( $current_val ) )
		{
			$current_val = [
				'background-image' => '',
				'background-color' => '',
				'background-repeat' => '',
				'background-position' => '',
				'background-size' => '',
				'background-attachment' => ''
			];
		}
		
		if ( !empty( $current_val['background-image'] ) && is_array( $current_val['background-image'] ) )
		{
			$current_val['background-image'] = json_encode( $current_val['background-image'] );
		}
		?>
		<div class="background-wrapper customize-control customize-control-kirki-radio-buttonset" id="container_<?php echo $id ?>" <?php $this->args() ?>>
			<?php $this->field_label(); ?>
			<!-- background-color -->
			<div class="background-color">
				<h4><?php esc_attr_e( 'Background Color', 'kirki' ); ?></h4>
				<input type="text" data-alpha="true" value="<?php echo isset ( $current_val['background-color'] ) ? $current_val['background-color'] : '' ; ?>" class="kirki-color-control"/>
			</div>
			
			<!-- background-image -->
			<div class="background-image">
				<h4><?php esc_attr_e( 'Background Image', 'kirki' ); ?></h4>
				<div class="attachment-media-view background-image-upload">
					<div class="thumbnail thumbnail-image"><img src="<?php echo $current_val['background-image']; ?>"/></div>
					<div class="placeholder"<?php if ( !empty( $current_val['background-image'] ) ) { echo ' style="display: none"'; } ?>><?php esc_attr_e( 'No File Selected', 'kirki' ); ?></div>
					<?php if ( isset ( $current_val['background-image'] ) && !empty( $current_val['background-image'] ) ) { ?>
					<?php } ?>
					<div class="actions">
						<button type="button" class="button background-image-upload-remove-button<?php if ( !isset ( $current_val['background-image'] ) ) { echo ' hidden'; } ?>"><?php esc_attr_e( 'Remove', 'kirki' ); ?></button>
						<button type="button" class="button background-image-upload-button"><?php esc_attr_e( 'Select File', 'kirki' ); ?></button>
					</div>
				</div>
				<input type="hidden" class="image-url" value="<?php echo $current_val['background-image']; ?>">
			</div>
			
			<!-- background-repeat -->
			<div class="background-repeat">
				<h4><?php esc_attr_e( 'Background Repeat', 'kirki' ); ?></h4>
				<select>
					<option value="no-repeat"<?php if ( empty ( $current_val['background-repeat'] ) || 'no-repeat' === $current_val['background-repeat'] ) { echo ' selected'; } ?>><?php esc_attr_e( 'No Repeat', 'kirki' ); ?></option>
					<option value="repeat"<?php if ( 'repeat' === $current_val['background-repeat'] ) { echo ' selected '; } ?>><?php esc_attr_e( 'Repeat All', 'kirki' ); ?></option>
					<option value="repeat-x"<?php if ( 'repeat-x' === $current_val['background-repeat'] ) { echo ' selected'; } ?>><?php esc_attr_e( 'Repeat Horizontally', 'kirki' ); ?></option>
					<option value="repeat-y"<?php if ( 'repeat-y' === $current_val['background-repeat'] ) { echo ' selected'; } ?>><?php esc_attr_e( 'Repeat Vertically', 'kirki' ); ?></option>
				</select>
			</div>
			
			<!-- background-position -->
			<div class="background-position">
				<h4><?php esc_attr_e( 'Background Position', 'kirki' ); ?></h4>
				<select>
					<option value="left top"<?php if ( empty ( $current_val['background-position'] ) || 'left top' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Left Top', 'kirki' ); ?></option>
					<option value="left center"<?php if ( 'left center' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Left Center', 'kirki' ); ?></option>
					<option value="left bottom"<?php if ( 'left bottom' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Left Bottom', 'kirki' ); ?></option>
					<option value="right top"<?php if ( 'right top' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Right Top', 'kirki' ); ?></option>
					<option value="right center"<?php if ( 'right center' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Right Center', 'kirki' ); ?></option>
					<option value="right bottom"<?php if ( 'right bottom' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Right Bottom', 'kirki' ); ?></option>
					<option value="center top"<?php if ( 'center top' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Center Top', 'kirki' ); ?></option>
					<option value="center center"<?php if ( 'center center' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Center Center', 'kirki' ); ?></option>
					<option value="center bottom"<?php if ( 'center bottom' === $current_val['background-position'] ) { ?> selected <?php } ?>><?php esc_attr_e( 'Center Bottom', 'kirki' ); ?></option>
				</select>
			</div>
			
			<!-- background-size -->
			<div class="background-size">
				<h4><?php esc_attr_e( 'Background Size', 'kirki' ); ?></h4>
				<div class="buttonset">
					<input class="switch-input screen-reader-text" type="radio" value="cover" name="_customize-bg-<?php echo $id ?>-size" id="<?php echo $id ?>cover" <?php if ( empty ( $current_val['background-size'] ) || 'cover' === $current_val['background-size'] ) { ?> checked="checked" <?php } ?>>
						<label class="switch-label switch-label-<?php if ( empty ( $current_val['background-size'] ) || 'cover' === $current_val['background-size'] ) { ?>on <?php } else { ?>off<?php } ?>" for="<?php echo $id ?>cover"><?php esc_attr_e( 'Cover', 'kirki' ); ?></label>
					</input>
					<input class="switch-input screen-reader-text" type="radio" value="contain" name="_customize-bg-<?php echo $id ?>-size" id="<?php echo $id ?>contain" <?php if ( 'contain' === $current_val['background-size'] ) { ?> checked="checked" <?php } ?>>
						<label class="switch-label switch-label-<?php if ( 'contain' === $current_val['background-size'] ) { ?>on <?php } else { ?>off<?php } ?>" for="<?php echo $id ?>contain"><?php esc_attr_e( 'Contain', 'kirki' ); ?></label>
					</input>
					<input class="switch-input screen-reader-text" type="radio" value="auto" name="_customize-bg-<?php echo $id ?>-size" id="<?php echo $id ?>auto" <?php if ( 'auto' === $current_val['background-size'] ) { ?> checked="checked" <?php } ?>>
						<label class="switch-label switch-label-<?php if ( 'auto' === $current_val['background-size'] ) { ?>on <?php } else { ?>off<?php } ?>" for="<?php echo $id ?>auto"><?php esc_attr_e( 'Auto', 'kirki' ); ?></label>
					</input>
				</div>
			</div>
			
			
			<!-- background-attachment -->
			<div class="background-attachment">
				<h4><?php esc_attr_e( 'Background Attachment', 'kirki' ); ?></h4>
				<div class="buttonset">
					<input class="switch-input screen-reader-text" type="radio" value="scroll" name="_customize-bg-<?php echo $id ?>-attachment" id="<?php echo $id ?>scroll" <?php if ( empty ( $current_val['background-attachment'] ) || 'scroll' === $current_val['background-attachment'] ) { ?> checked="checked" <?php } ?>>
						<label class="switch-label switch-label-<?php if ( empty ( $current_val['background-attachment'] ) || 'scroll' === $current_val['background-attachment'] ) { ?>on <?php } else { ?>off<?php } ?>" for="<?php echo $id ?>scroll"><?php esc_attr_e( 'Scroll', 'kirki' ); ?></label>
					</input>
					<input class="switch-input screen-reader-text" type="radio" value="fixed" name="_customize-bg-<?php echo $id ?>-attachment" id="<?php echo $id ?>fixed" <?php if ( 'fixed' === $current_val['background-attachment'] ) { ?> checked="checked" <?php } ?>>
						<label class="switch-label switch-label-<?php if ( 'fixed' === $current_val['background-attachment'] ) { ?>on <?php } else { ?>off<?php } ?>" for="<?php echo $id ?>fixed"><?php esc_attr_e( 'Fixed', 'kirki' ); ?></label>
					</input>
				</div>
			</div>
			
			<input class="background-hidden-value" type="hidden" <?php $this->field_link() ?>>
		</div>
		<?php
	}
}