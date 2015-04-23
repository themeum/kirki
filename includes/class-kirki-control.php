<?php

class Kirki_Control extends WP_Customize_Control {

	public function label() {
		// The label has already been sanitized in the Fields class, no need to re-sanitize it.
		echo $this->label;
	}

	public function description() {

		if ( ! empty( $this->description ) ) {
			// The description has already been sanitized in the Fields class, no need to re-sanitize it.
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}

	}

	public function title() {
		echo '<span class="customize-control-title">';
			$this->label();
			$this->description();
		echo '</span>';
	}

}
