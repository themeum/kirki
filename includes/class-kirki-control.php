<?php

/**
 * Try to keep the controls DRY.
 * We can include some common things here like the titles and descriptions
 * Other controls can then extend this class and use these at will without having to write everything all over again.
 */
class Kirki_Control extends WP_Customize_Control {

	/**
	 * The markup for the label.
	 */
	public function label() {
		// The label has already been sanitized in the Fields class, no need to re-sanitize it.
		echo $this->label;
	}

	/**
	 * Markup for the field's description
	 */
	public function description() {

		if ( ! empty( $this->description ) ) {
			// The description has already been sanitized in the Fields class, no need to re-sanitize it.
			echo '<span class="description customize-control-description">' . $this->description . '</span>';
		}

	}

	/**
	 * Markup for the field's title
	 */
	public function title() {
		echo '<span class="customize-control-title">';
			$this->label();
			$this->description();
		echo '</span>';
	}

}
