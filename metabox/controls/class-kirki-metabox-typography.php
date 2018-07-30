<?php
class Kirki_Metabox_Typography extends Kirki_Metabox_Control
{
	public function init()
	{
		$defaults = [
			'choices' => array(
				'fonts' => array(
					'google' => array(),
					'standard' => array()
				),
			)
		];
		$this->field = wp_parse_args( $this->field, $defaults );
	}
	
	public function render( $post )
	{
		$id = $this->get_field_id();
		$current_val = $this->get_meta_value( $post, $this->field['default'] );
		$type = $this->field['type'];
		?>
		<div class="customize-control customize-control-kirki-typography">
			<?php $this->field_label(); ?>
			<div class="wrapper" <?php $this->args() ?>>
				<?php if ( isset( $this->field['default'], $this->field['default']['font-family'] ) ) { ?>
				<div class="font-family">
					<h5><?php esc_attr_e( 'Font Family', 'kirki' ); ?></h5>
					<select id="kirki-typography-font-family-<?php echo $id ?>" placeholder="<?php esc_attr_e( 'Select Font Family', 'kirki' ); ?>"></select>
				</div>
				<?php if ( isset( $this->field['choices'], $this->field['choices']['font-backup'] ) && true === $this->field['choices']['font-backup'] ) { ?>
					<div class="font-backup hide-on-standard-fonts kirki-font-backup-wrapper">
						<h5><?php esc_attr_e( 'Backup Font', 'kirki' ); ?></h5>
						<select id="kirki-typography-font-backup-<?php echo ""?> " placeholder="<?php esc_attr_e( 'Select Font Family', 'kirki' ); ?>"></select>
					</div>
				<?php } //End font backup ?>
				<?php if ( isset ( $this->field['show_varients'] ) && $this->field['show_varients'] ) { ?>
				<div class="variant kirki-variant-wrapper">
					<h5><?php esc_attr_e( 'Variant', 'kirki' ); ?></h5>
					<select class="variant" id="kirki-typography-variant-<?php echo $id ?>"></select>
				</div>
				<?php } //End show variant ?>
				<div class="kirki-host-font-locally">
					<label>
						<input type="checkbox">
						<?php esc_html_e( 'Download font-family to server instead of using the Google CDN.', 'kirki' ); ?>
					</label>
				</div>
				<?php } //End font-family ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['font-size'] ) ) { ?>
				<div class="font-size">
					<h5><?php esc_attr_e( 'Font Size', 'kirki' ); ?></h5>
					<input type="text" value="<?php echo $current_val['font-size']; ?>"/>
				</div>
				<?php } //End font size ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['line-height'] ) ) { ?>
				<div class="line-height">
					<h5><?php esc_attr_e( 'Line Height', 'kirki' ); ?></h5>
					<input type="text" value="<?php echo $current_val['line-height'] ?>"/>
				</div>
				<?php } //End line-height ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['letter-spacing'] ) ) { ?>
				<div class="line-height">
					<h5><?php esc_attr_e( 'Letter Spacing', 'kirki' ); ?></h5>
					<input type="text" value="<?php echo $current_val['letter-spacing'] ?>"/>
				</div>
				<?php } //End letter-spacing ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['word-spacing'] ) ) { ?>
				<div class="word-spacing">
					<h5><?php esc_attr_e( 'Word Spacing', 'kirki' ); ?></h5>
					<input type="text" value="<?php echo $current_val['word-spacing'] ?>"/>
				</div>
				<?php } //End word-spacing ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['text-align'] ) ) { ?>
				<div class="text-align">
					<h5><?php esc_attr_e( 'Text Align', 'kirki' ); ?></h5>
					<div class="text-align-choices">
						<input type="radio" value="inherit" name="_customize-typography-text-align-radio-<?php echo $id ?>" id="<?php echo $id ?>-text-align-inherit" <?php if ( $current_val['text-align'] === 'inherit' ) { ?> checked="checked"<?php } ?>>
							<label for="<?php echo $id ?>-text-align-inherit">
								<span class="dashicons dashicons-editor-removeformatting"></span>
								<span class="screen-reader-text"><?php esc_attr_e( 'Inherit', 'kirki' ); ?></span>
							</label>
						</input>
						<input type="radio" value="left" name="_customize-typography-text-align-radio-<?php echo $id ?>" id="<?php echo $id ?>-text-align-left" <?php if ( $current_val['text-align'] === 'left' ) { ?> checked="checked"<?php } ?>>
							<label for="<?php echo $id ?>-text-align-left">
								<span class="dashicons dashicons-editor-alignleft"></span>
								<span class="screen-reader-text"><?php esc_attr_e( 'Left', 'kirki' ); ?></span>
							</label>
						</input>
						<input type="radio" value="center" name="_customize-typography-text-align-radio-<?php echo $id ?>" id="<?php echo $id ?>-text-align-center" <?php if ( $current_val['text-align'] === 'center' ) { ?> checked="checked"<?php } ?>>
							<label for="<?php echo $id ?>-text-align-center">
								<span class="dashicons dashicons-editor-aligncenter"></span>
								<span class="screen-reader-text"><?php esc_attr_e( 'Center', 'kirki' ); ?></span>
							</label>
						</input>
						<input type="radio" value="right" name="_customize-typography-text-align-radio-<?php echo $id ?>" id="<?php echo $id ?>-text-align-right" <?php if ( $current_val['text-align'] === 'right' ) { ?> checked="checked"<?php } ?>>
							<label for="<?php echo $id ?>-text-align-right">
								<span class="dashicons dashicons-editor-alignright"></span>
								<span class="screen-reader-text"><?php esc_attr_e( 'Right', 'kirki' ); ?></span>
							</label>
						</input>
						<input type="radio" value="justify" name="_customize-typography-text-align-radio-<?php echo $id ?>" id="<?php echo $id ?>-text-align-justify" <?php if ( $current_val['text-align'] === 'justify' ) { ?> checked="checked"<?php } ?>>
							<label for="<?php echo $id ?>-text-align-justify">
								<span class="dashicons dashicons-editor-justify"></span>
								<span class="screen-reader-text"><?php esc_attr_e( 'Justify', 'kirki' ); ?></span>
							</label>
						</input>
					</div>
				</div>
				<?php } //End text-align ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['text-transform'] ) ) { ?>
				<div class="text-transform">
					<h5><?php esc_attr_e( 'Text Transform', 'kirki' ); ?></h5>
					<select id="kirki-typography-text-transform-<?php echo $id; ?>">
						<option value=""<?php if ( '' === $current_val['text-transform'] ) { ?>selected<?php } ?>></option>
						<option value="none"<?php if ( 'none' === $current_val['text-transform'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'None', 'kirki' ); ?></option>
						<option value="capitalize"<?php if ( 'capitalize' === $current_val['text-transform'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Capitalize', 'kirki' ); ?></option>
						<option value="uppercase"<?php if ( 'uppercase' === $current_val['text-transform'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Uppercase', 'kirki' ); ?></option>
						<option value="lowercase"<?php if ( 'lowercase' === $current_val['text-transform'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Lowercase', 'kirki' ); ?></option>
						<option value="initial"<?php if ( 'initial' === $current_val['text-transform'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Initial', 'kirki' ); ?></option>
						<option value="inherit"<?php if ( 'inherit' === $current_val['text-transform'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Inherit', 'kirki' ); ?></option>
					</select>
				</div>
				<?php } //End text-transform ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['text-decoration'] ) ) { ?>
				<div class="text-decoration">
					<h5><?php esc_attr_e( 'Text Decoration', 'kirki' ); ?></h5>
					<select id="kirki-typography-text-decoration-<?php echo $id; ?>">
						<option value=""<?php if ( '' === $current_val['text-decoration'] ) { ?>selected<?php } ?>></option>
						<option value="none"<?php if ( 'none' === $current_val['text-decoration'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'None', 'kirki' ); ?></option>
						<option value="underline"<?php if ( 'underline' === $current_val['text-decoration'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Underline', 'kirki' ); ?></option>
						<option value="overline"<?php if ( 'overline' === $current_val['text-decoration'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Overline', 'kirki' ); ?></option>
						<option value="line-through"<?php if ( 'line-through' === $current_val['text-decoration'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Line-Through', 'kirki' ); ?></option>
						<option value="initial"<?php if ( 'initial' === $current_val['text-decoration'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Initial', 'kirki' ); ?></option>
						<option value="inherit"<?php if ( 'inherit' === $current_val['text-decoration'] ) { ?>selected<?php } ?>><?php esc_attr_e( 'Inherit', 'kirki' ); ?></option>
					</select>
				</div>
				<?php } //End text-decoration ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['margin-top'] ) ) { ?>
				<div class="margin-top">
					<h5><?php esc_attr_e( 'Margin Top', 'kirki' ); ?></h5>
					<input type="text" value="<?php echo $current_val['margin-top']; ?>"/>
				</div>
				<?php } //End margin-top ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['margin-bottom'] ) ) { ?>
				<div class="margin-bottom">
					<h5><?php esc_attr_e( 'Margin Bottom', 'kirki' ); ?></h5>
					<input type="text" value="<?php echo $current_val['margin-bottom']; ?>"/>
				</div>
				<?php } //End margin-bottom ?>
				
				<?php if ( isset ( $this->field['default'], $this->field['default']['color'] ) ) { ?>
					<div class="color">
						<h5><?php esc_attr_e( 'Color', 'kirki' ); ?></h5>
						<input type="text" data-palette="" value="<?php echo $current_val['color'] ?>" class="kirki-color-control color-picker"/>
					</div>
				<?php } //End color ?>
			</div>
			<input class="typography-hidden-value" type="hidden" <?php $this->field_link(); ?>>
		</div>
		<?php
	}
}