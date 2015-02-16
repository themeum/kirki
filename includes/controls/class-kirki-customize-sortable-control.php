<?php

class Kirki_Customize_Sortable_Control extends WP_Customize_Control {
	public $description;
	public $choices;
	public $visible_btn;
	public static $firstLoad;

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
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php
				// $values = $this->value();
				// $values = empty( $values ) ? array_keys( $this->choices ) : $values;
				$values = array_keys( $this->choices );
				$values = is_serialized( $values ) ? unserialize( $values ) : $values;
				$this->visible_btn = count( $values ) != count( $this->choices ) ? true : $this->visible_btn;
				$visibleButton = ( $this->visible_btn === true ) ? '<i class="dashicons dashicons-visibility visibility"></i>' : '';
			?>
			<ul>
				<?php foreach ( $values as $dummy => $value ) : ?>
					<?php printf( "<li data-value='%s'><i class='dashicons dashicons-menu'></i>%s%s</li>", esc_attr( $value ), $visibleButton, $this->choices[$value] ); ?>
				<?php endforeach; ?>
				<?php $invisibleKeys = array_diff( array_keys( $this->choices ), $values ); ?>
				<?php foreach ( $invisibleKeys as $dummy => $value ) : ?>
					<?php printf( "<li data-value='%s'><i class='dashicons dashicons-menu'></i>%s%s</li>", esc_attr( $value ), $visibleButton, $this->choices[$value] ); ?>
				<?php endforeach; ?>
			</ul>
			<div style='clear: both'></div>
			<?php $values = ! is_serialized( $values ) ? serialize( $values ) : $values; ?>
			<input type='hidden' <?php $this->link(); ?> value="<?php echo esc_attr( $values )  ?>"/>
		</label>
		<p class='description'><?php echo $this->description; ?></p>
		<?php

	}

}
