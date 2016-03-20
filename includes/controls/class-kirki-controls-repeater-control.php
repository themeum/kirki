<?php
/**
 * Repeater Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Repeater_Control' ) ) {
	class Kirki_Controls_Repeater_Control extends Kirki_Customize_Control {

		public $type = 'repeater';

		public $fields = array();

		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			$l10n = Kirki_l10n::get_strings();
			if ( empty( $this->button_label ) ) {
				$this->button_label = $l10n['add-new-row'];
			}

			if ( empty( $args['fields'] ) || ! is_array( $args['fields'] ) ) {
				$args['fields'] = array();
			}

			foreach ( $args['fields'] as $key => $value ) {
				if ( ! isset( $value['default'] ) ) {
					$args['fields'][ $key ]['default'] = '';
				}

				if ( ! isset( $value['label'] ) ) {
					$args['fields'][ $key ]['label'] = '';
				}
				$args['fields'][ $key ]['id'] = $key;
			}

			$this->fields = $args['fields'];
		}

		public function to_json() {
			parent::to_json();

			$fields = $this->fields;
			$i18n   = Kirki_l10n::get_strings();
			$default_image_button_labels = array(
				'default'     => $i18n['add-image'],
				'remove'      => $i18n['remove'],
				'change'      => $i18n['change-image'],
				'placeholder' => $i18n['no-image-selected'],
			);

			foreach ( $fields as $key => $field ) {
				if ( 'image' != $field['type'] ) {
					continue;
				}

				$fields[ $key ]['buttonLabels'] = $default_image_button_labels;
			}

			$this->json['fields'] = $fields;
		}

		public function enqueue() {
			Kirki_Styles_Customizer::enqueue_customizer_control_script( 'kirki-repeater', 'controls/repeater', array( 'jquery', 'customize-base' ), true );

			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
		}

		public function render_content() { ?>
			<?php $l10n = Kirki_l10n::get_strings(); ?>
			<?php if ( '' != $this->tooltip ) : ?>
				<a href="#" class="tooltip hint--left" data-hint="<?php echo esc_html( $this->tooltip ); ?>"><span class='dashicons dashicons-info'></span></a>
			<?php endif; ?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
				<input type="hidden" <?php $this->input_attrs(); ?> value="" <?php echo $this->get_link(); ?> />
			</label>

			<ul class="repeater-fields"></ul>

			<?php if ( isset( $this->choices['limit'] ) ) : ?>
				<p class="limit"><?php printf( $l10n['limit-rows'], $this->choices['limit'] ); ?></p>
			<?php endif; ?>
			<button class="button-secondary repeater-add"><?php echo esc_html( $this->button_label ); ?></button>

			<?php

			$this->repeater_js_template();

		}

		public function repeater_js_template() {
			?>
			<script type="text/html" class="customize-control-repeater-content">
				<# var field; var index = data['index']; #>


				<li class="repeater-row" data-row="{{{ index }}}">

					<div class="repeater-row-header">
						<span class="repeater-row-number"></span>
						<span class="repeater-row-remove"><i class="dashicons dashicons-no-alt repeater-remove"></i></span>
						<span class="repeater-row-minimize"><i class="dashicons dashicons-arrow-up repeater-minimize"></i></span>
						<span class="repeater-row-move"><i class="dashicons dashicons-sort repeater-move"></i></span>
					</div>

					<# for ( i in data ) { #>
						<# if ( ! data.hasOwnProperty( i ) ) continue; #>
						<# field = data[i]; #>
						<# if ( ! field.type ) continue; #>

						<div class="repeater-field repeater-field-{{{ field.type }}}">

							<# if ( field.type === 'text' ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>
									<input type="text" name="" value="{{{ field.default }}}" data-field="{{{ field.id }}}">
								</label>

							<# } else if ( field.type === 'checkbox' ) { #>

								<label>
									<input type="checkbox" value="true" data-field="{{{ field.id }}}" <# if ( field.default ) { #> checked="checked" <# } #> />
									<# if ( field.description ) { #>
										{{ field.description }}
									<# } #>
								</label>

							<# } else if ( field.type === 'select' ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>
									<select data-field="{{{ field.id }}}">
										<# for ( i in field.choices ) { #>
											<# if ( field.choices.hasOwnProperty( i ) ) { #>
												<option value="{{{ i }}}" <# if ( field.default == i ) { #> selected="selected" <# } #>>{{ field.choices[i] }}</option>
											<# } #>
										<# } #>
									</select>
								</label>

							<# } else if ( field.type === 'radio' ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>

									<# for ( i in field.choices ) { #>
										<# if ( field.choices.hasOwnProperty( i ) ) { #>
											<label>
												<input type="radio" name="{{{ field.id }}}" data-field="{{{ field.id }}}" value="{{{ i }}}" <# if ( field.default == i ) { #> checked="checked" <# } #>> {{ field.choices[i] }} <br/>
											</label>
										<# } #>
									<# } #>
								</label>

							<# } else if ( field.type == 'radio-image' ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>

									<# for ( i in field.choices ) { #>
										<# if ( field.choices.hasOwnProperty( i ) ) { #>
											<input type="radio" id="{{{ field.id }}}_{{ index }}_{{{ i }}}" name="{{{ field.id }}}{{ index }}" data-field="{{{ field.id }}}" value="{{{ i }}}" <# if ( field.default == i ) { #> checked="checked" <# } #>>
												<label for="{{{ field.id }}}_{{ index }}_{{{ i }}}">
													<img src="{{ field.choices[i] }}">
												</label>
											</input>
										<# } #>
									<# } #>
								</label>

							<# } else if ( field.type == 'textarea' ) { #>

								<# if ( field.label ) { #>
									<span class="customize-control-title">{{ field.label }}</span>
								<# } #>
								<# if ( field.description ) { #>
									<span class="description customize-control-description">{{ field.description }}</span>
								<# } #>
								<textarea rows="5" data-field="{{{ field.id }}}">{{ field.default }}</textarea>

							<# } else if ( field.type === 'image' ) { #>

								<label>
									<# if ( field.label ) { #>
										<span class="customize-control-title">{{ field.label }}</span>
									<# } #>
									<# if ( field.description ) { #>
										<span class="description customize-control-description">{{ field.description }}</span>
									<# } #>
								</label>

								<figure class="kirki-image-attachment" data-placeholder="{{ field.buttonLabels.placeholder }}" >
									<# if ( field.default ) { #>
										<img src="{{{ field.default }}}">
									<# } else { #>
										{{ field.buttonLabels.placeholder }}
									<# } #>
								</figure>

								<div class="actions">
									<button type="button" class="button remove-button<# if ( ! field.default ) { #> hidden<# } #>">{{ field.buttonLabels.remove }}</button>
									<button type="button" class="button upload-button" data-label="{{{ field.buttonLabels.default }}}" data-alt-label="{{{ field.buttonLabels.change }}}" >
										<# if ( field.default ) { #>
											{{ field.buttonLabels.change }}
										<# } else { #>
											{{ field.buttonLabels.default }}
										<# } #>
									</button>
									<input type="hidden" class="hidden-field" value="{{{ field.default }}}" data-field="{{{ field.id }}}" >
								</div>

							<# } #>

						</div>
					<# } #>
				</li>
			</script>
			<?php
		}

	}
}
