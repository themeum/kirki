<?php

class Kirki_Output_Property_Background_Image extends Kirki_Output_Property {

	protected function process_value() {

		if ( false === strrpos( $this->value, 'url(' ) ) {
			$this->value = 'url("' . $this->value . '")';
		}

	}

}
