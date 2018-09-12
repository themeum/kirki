<?php
class Kirki_Metabox_Spacing extends Kirki_Metabox_Control
{
	public function render( $post )
	{
		$id = $this->get_field_id();
		$defaults = array( 
			'margin' => array( 
				'desktop' => '',
				'tablet' => '',
				'mobile' => ''
			),
			'padding' => array(
				'desktop' => '',
				'tablet' => '',
				'mobile' => ''
			)
		);
		$value = $this->get_meta_value( $post, $defaults );
		if ( is_array ( $value ) )
			$value = json_encode ( $value );
		$type = $this->field['type'];
		$uq_id = mt_rand( 100, 1000 );
		?>
		<div <?php $this->args(); ?>>
			<?php $this->field_label(); ?>
			<div class="kirki-group-outer spacing" value="<?php echo esc_attr( $value ); ?>">
			<input type="hidden" class="kirki-spacing-value" <?php $this->field_link(); ?> value="<?php echo esc_attr( $value ); ?>" />
			<div class="margin-outer">
				<h5>
					<span><?php _e( 'Margin', 'kirki' ) ?></span>
					<ul class="kirki-respnsive-switchers">
						<li class="desktop"><span class="eicon-device-desktop"></span></li>
						<li class="tablet hidden-device"><span class="eicon-device-tablet"></span></li>
						<li class="mobile hidden-device"><span class="eicon-device-mobile"></span></li>
					</ul>
					<div class="kirki-units-choices">
						<input id="margin_type_px_<?php echo $uq_id ?>" type="radio" name="margin_type" data-setting="unit" value="px">
						<label class="kirki-units-choices-label" for="margin_type_px_<?php echo $uq_id ?>">px</label>

						<input id="margin_type_%_<?php echo $uq_id ?>" type="radio" name="margin_type" data-setting="unit" value="%">
						<label class="kirki-units-choices-label" for="margin_type_%_<?php echo $uq_id ?>">%</label>
					</div>
				</h5>
				<div class="kirki-control-type-dimensions">
					<ul class="kirki-control-dimensions">
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-margin-top" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" margin-type="top">
							<label for="<?php echo $id; ?>-margin-top" class="kirki-control-dimension-label"><?php _e( 'Top', 'kirki' ); ?></span>
						</li>
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-margin-right" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" margin-type="right">
							<label for="<?php echo $id; ?>-margin-right" class="kirki-control-dimension-label"><?php _e( 'Right', 'kirki' ); ?></span>
						</li>
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-margin-bottom" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" margin-type="bottom">
							<label for="<?php echo $id; ?>-margin-bottom" class="kirki-control-dimension-label"><?php _e( 'Bottom', 'kirki' ); ?></span>
						</li>
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-margin-left" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" margin-type="left">
							<label for="<?php echo $id; ?>-margin-left" class="kirki-control-dimension-label"><?php _e( 'Left', 'kirki' ); ?></span>
						</li>
						<li>
							<button class="kirki-input-link tooltip-target unlinked" data-tooltip="<?php _e( 'Link values together', 'kirki' ); ?>" original-title="">
								<span class="kirki-linked">
									<span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
									<span class="kirki-screen-only"><?php _e( 'Link values together', 'kirki' );?></span>
								</span>
								<span class="kirki-unlinked">
									<span class="dashicons dashicons-editor-unlink" aria-hidden="true"></span>
									<span class="kirki-screen-only"><?php _e( 'Unlinked values', 'kirki' );?></span>
								</span>
							</button>
						</li>
					</ul>
				</div>
			</div>
			<div class="padding-outer">
				<h5>
					<span><?php _e( 'Padding', 'kirki' ) ?></span>
					<ul class="kirki-respnsive-switchers">
						<li class="desktop"><span class="eicon-device-desktop"></span></li>
						<li class="tablet hidden-device"><span class="eicon-device-tablet"></span></li>
						<li class="mobile hidden-device"><span class="eicon-device-mobile"></span></li>
					</ul>
					<div class="kirki-units-choices">
						<input id="padding_type_px_<?php echo $uq_id ?>" type="radio" name="padding_type" data-setting="unit" value="px">
						<label class="kirki-units-choices-label" for="padding_type_px_<?php echo $uq_id ?>">px</label>

						<input id="padding_type_em_<?php echo $uq_id ?>" type="radio" name="padding_type" data-setting="unit" value="em">
						<label class="kirki-units-choices-label" for="padding_type_em_<?php echo $uq_id ?>">em</label>

						<input id="padding_type_%_<?php echo $uq_id ?>" type="radio" name="padding_type" data-setting="unit" value="%">
						<label class="kirki-units-choices-label" for="padding_type_%_<?php echo $uq_id ?>">%</label>
					</div>
				</h5>
				<div class="kirki-control-type-dimensions">
					<ul class="kirki-control-dimensions">
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-padding-top" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" padding-type="top">
							<label for="<?php echo $id; ?>-padding-top" class="kirki-control-dimension-label"><?php _e('Top', 'kirki'); ?></span>
						</li>
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-padding-right" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" padding-type="right">
							<label for="<?php echo $id; ?>-padding-right" class="kirki-control-dimension-label"><?php _e('Right', 'kirki'); ?></span>
						</li>
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-padding-bottom" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" padding-type="bottom">
							<label for="<?php echo $id; ?>-padding-bottom" class="kirki-control-dimension-label"><?php _e('Bottom', 'kirki'); ?></span>
						</li>
						<li class="kirki-control-dimension">
							<input type="number" id="<?php echo $id; ?>-padding-left" active-type="desktop" desktop-value="" tablet-value="" mobile-value="" padding-type="left">
							<label for="<?php echo $id; ?>-padding-left" class="kirki-control-dimension-label"><?php _e('Left', 'kirki'); ?></span>
						</li>
						<li>
							<button class="kirki-input-link tooltip-target unlinked" data-tooltip="<?php _e('Link values together', 'kirki'); ?>" original-title="">
								<span class="kirki-linked">
									<span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
									<span class="kirki-screen-only"><?php _e('Link values together', 'kirki' );?></span>
								</span>
								<span class="kirki-unlinked">
									<span class="dashicons dashicons-editor-unlink" aria-hidden="true"></span>
									<span class="kirki-screen-only"><?php _e('Unlinked values', 'kirki');?></span>
								</span>
							</button>
						</li>
					</ul>
				</div>
			</div>
		</div>
		</div>
		<?php
	}
}