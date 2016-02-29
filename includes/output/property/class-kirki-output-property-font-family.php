<?php

class Kirki_Output_Property_Font_Family extends Kirki_Output_Property {

	protected function process_value() {

		$google_fonts_array = Kirki_Fonts::get_google_fonts();
		$backup_fonts       = Kirki_Fonts::get_backup_fonts();
		// Add backup font
		if ( Kirki_Fonts::is_google_font( $this->value ) ) {

			if ( isset( $google_fonts_array[ $this->value ] ) && isset( $google_fonts_array[ $this->value ]['category'] ) ) {
				if ( isset( $backup_fonts[ $google_fonts_array[ $this->value ]['category'] ] ) ) {
					// add double quotes if needed
					if ( false !== strpos( $this->value, ' ' ) && false === strpos( $this->value, '"' ) ) {
						$this->value = '"' . $this->value . '", ' . $backup_fonts[ $google_fonts_array[ $this->value ]['category'] ];
					} else {
						$this->value .= ', ' . $backup_fonts[ $google_fonts_array[ $this->value ]['category'] ];
					}
				}
			}

		} else {

			// add double quotes if needed
			if ( false !== strpos( $this->value, ' ' ) && false === strpos( $this->value, '"' ) ) {
				$this->value = '"' . $this->value . '"';
			}

		}

	}

}
