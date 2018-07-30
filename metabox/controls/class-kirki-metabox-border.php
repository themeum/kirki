<?php
class Kirki_Metabox_Border extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post );
		$defaults = [
			'border_type' => 'none',
			'top' => '',
			'right' => '',
			'bottom' => '',
			'left' => '',
			'color' => ''
		];
		if (!$current_val)
		{
			$current_val = $defaults;
		}
		else
		{
			$current_val = wp_parse_args($current_val, $defaults);
		}
		?>
		<?php $this->field_label(); ?>
		<div class="rugged-group-outer border" <?php echo $this->args(); ?>>
			<input type="hidden" class="rugged-border-value" value="<?php echo esc_attr(json_encode($current_val)); ?>" <?php $this->field_link(); ?> />
			<h5><?php _e( 'Border Type', 'kirki' ) ?></h5>
			<select class="rugged-border-select" name="<?php echo $id; ?>[border_type]">
				<option value="none"><?php _e('None', 'kirki' ); ?></option>
				<option value="solid"><?php _e('Solid', 'kirki' ); ?></option>
				<option value="double"><?php _e('Double', 'kirki' ); ?></option>
				<option value="dotted"><?php _e('Dotted', 'kirki' ); ?></option>
				<option value="dashed"><?php _e('Dashed', 'kirki' ); ?></option>
				<option value="groove"><?php _e('Groove', 'kirki' ); ?></option>
			</select>
			<div class="size-outer">
				<h5><?php _e( 'Size', 'kirki' ) ?></h5>
				<div class="rugged-control-type-dimensions">
					<ul class="rugged-control-dimensions">
						<li class="rugged-control-dimension">
							<input type="number" id="<?php echo $id; ?>-top" data-border-type="top">
							<label for="<?php echo $id; ?>-top" class="rugged-control-dimension-label"><?php _e('Top', 'kirki') ?></span>
						</li>
						<li class="rugged-control-dimension">
							<input type="number" id="<?php echo $id; ?>-right" data-border-type="right">
							<label for="<?php echo $id; ?>-right" class="rugged-control-dimension-label"><?php _e('Right', 'kirki') ?></span>
						</li>
						<li class="rugged-control-dimension">
							<input type="number" id="<?php echo $id; ?>-bottom" data-border-type="bottom">
							<label for="<?php echo $id; ?>-bottom" class="rugged-control-dimension-label"><?php _e('Bottom', 'kirki') ?></span>
						</li>
						<li class="rugged-control-dimension">
							<input type="number" id="<?php echo $id; ?>-left" data-border-type="left">
							<label for="<?php echo $id; ?>-left" class="rugged-control-dimension-label"><?php _e( 'Left', 'kirki' ) ?></span>
						</li>
						<li>
							<button class="rugged-link-dimensions tooltip-target unlinked" data-tooltip="<?php _e( 'Link values together', 'kirki' ); ?>" original-title="">
								<span class="rugged-linked">
									<span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
									<span class="rugged-screen-only"><?php _e( 'Link values together', 'kirki' );?></span>
								</span>
								<span class="rugged-unlinked">
									<span class="dashicons dashicons-editor-unlink" aria-hidden="true"></span>
									<span class="rugged-screen-only"><?php _e( 'Unlinked values', 'kirki' );?></span>
								</span>
							</button>
						</li>
					</ul>
				</div>
			</div>
			<div class="color-outer">
				<h5><?php _e( 'Color', 'kirki' ) ?></h5>
				<input type="text" class="color-picker" data-alpha="true" value=""/>
			</div>
		</div>
		<?php
	}
}