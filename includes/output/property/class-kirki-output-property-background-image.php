<?php

class Kirki_Output_Property_Background_Image extends Kirki_Output_Property {

	protected function process_value() {

		if ( false === strrpos( $this->value, 'url(' ) ) {
			if ( empty( $this->value ) ) {
				return;
			}
			$this->value = 'url("' . $this->value . '")';
		}

	}

}
