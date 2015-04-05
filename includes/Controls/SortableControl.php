<?php

namespace Kirki\Controls;

class SortableControl extends \WP_Customize_Control {

	public $type = 'sortable';

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
	}


	public function render_content() {
		if ( ! is_array( $this->choices ) ) {
			return;
		}
		if ( ! count( $this->choices ) ) {
			return;
		}

		?>
		<label class='kirki-sortable'>
			<span class="customize-control-title">
				<?php
					// The label has already been sanitized in the Fields class, no need to re-sanitize it.
				?>
				<?php echo $this->label; ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php
						// The description has already been sanitized in the Fields class, no need to re-sanitize it.
					?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>

			<?php
				$values = $this->value();
				$values = $values == '' ? array_keys( $this->choices ) : $values;
				$values = maybe_unserialize( $values );
				$this->visible_button = count( $values ) != count( $this->choices ) ? true : '';
				$visibleButton = '<i class="dashicons dashicons-visibility visibility"></i>';
			?>
			<ul>
				<?php foreach ( $values as $key => $value ) : ?>
					<?php printf( "<li class='kirki-sortable-item' data-value='%s'><i class='dashicons dashicons-menu'></i>%s%s</li>", esc_attr( $value ), $visibleButton, $this->choices[$value] ); ?>
				<?php endforeach; ?>
				<?php $invisibleKeys = array_diff( array_keys( $this->choices ), $values ); ?>
				<?php foreach ( $invisibleKeys as $key => $value ) : ?>
					<?php printf( "<li class='kirki-sortable-item' data-value='%s'><i class='dashicons dashicons-menu'></i>%s%s</li>", esc_attr( $value ), $visibleButton, $this->choices[$value] ); ?>
				<?php endforeach; ?>
			</ul>
			<div style='clear: both'></div>
			<?php $values = maybe_serialize( $values ); ?>
			<input type='hidden' <?php $this->link(); ?> value='<?php echo esc_attr( $values )  ?>'/>
		</label>
		<?php
	}
}
