<?php

class Kirki_Customize_Select_Control extends Kirki_Customize_Control {

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'select';
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() {

		if ( empty( $this->choices ) ) {
			return;
		} ?>

		<label>
			<span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
				<?php $this->description(); ?>
			</span>
			<?php $this->subtitle(); ?>
			<select <?php $this->link(); ?>>
				<?php
				foreach ( $this->choices as $value => $label ) {
					echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $label . '</option>';
				} ?>
			</select>
		</label>
		<?php

	}
}
