<?php

/**
 * Control inspired by the Titan Framework Multicheck control.
 * See https://github.com/gambitph/Titan-Framework/blob/v1.4.2/class-option-multicheck.php for more details.
 */

class Kirki_Customize_Multicheck_Control extends Kirki_Customize_Control {

	private static $firstLoad = true;

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'multicheck';
		parent::__construct( $manager, $id, $args );
	}

	// Since theme_mod cannot handle multichecks, we will do it with some JS
	public function render_content() {
		// the saved value is an array. convert it to csv
		if ( is_array( $this->value() ) ) {
			$savedValueCSV = implode( ',', $this->value() );
			$values = $this->value();
		} else {
			$savedValueCSV = $this->value();
			$values = explode( ',', $this->value() );
		}

		if ( self::$firstLoad ) {
			self::$firstLoad = false;

			?>
			<script>
			jQuery(document).ready(function($) {
				"use strict";

				$('input.tf-multicheck').change(function(event) {
					event.preventDefault();
					var csv = '';

					$(this).parents('li:eq(0)').find('input[type=checkbox]').each(function() {
						if ($(this).is(':checked')) {
							csv += $(this).attr('value') + ',';
						}
					});

					csv = csv.replace(/,+$/, "");

					$(this).parents('li:eq(0)').find('input[type=hidden]').val(csv)
					// we need to trigger the field afterwards to enable the save button
					.trigger('change');
					return true;
				});
			});
			</script>
			<?php
		} ?>
		<label class='tf-multicheck-container'>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php $this->description(); ?>
			</span>
			<?php $this->subtitle(); ?>
			<?php
			foreach ( $this->choices as $value => $label ) {
				printf('<label for="%s"><input class="tf-multicheck" id="%s" type="checkbox" value="%s" %s/> %s</label><br>',
					$this->id . $value,
					$this->id . $value,
					esc_attr( $value ),
					checked( in_array( $value, $values ), true, false ),
					$label
				);
			}
			?>
			<input type="hidden" value="<?php echo esc_attr( $savedValueCSV ); ?>" <?php $this->link(); ?> />
		</label>
		<?php

	}
}
