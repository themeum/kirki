<?php

class Kirki_Controls {

    /** @var array The controls */
    private $controls = null;

    /**
     * Constructor
     */
	public function __construct() {
	}

	/**
	 * Get the controls for the Kirki customizer.
	 *
	 * @uses  'kirki/controls' filter.
	 */
	public function get_all() {
        if ($this->controls==null) {
		    $user_controls = apply_filters( 'kirki/controls', array() );

            $this->controls = array();
			foreach ( $user_controls as $control ) {
                $this->controls[] = Kirki_Control::sanitize( $control );
			}
		}

		return $this->controls;
	}

}
