<?php

/**
 * Control inspired by the Titan Framework MultiCheck control.
 * See https://github.com/gambitph/Titan-Framework/blob/v1.4.2/class-option-multicheck.php for more details.
 */
class Kirki_Controls_MultiCheck_Control extends Kirki_Control {

	public $type = 'multicheck';

	private static $firstLoad = true;

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
			<?php $this->title(); ?>
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
