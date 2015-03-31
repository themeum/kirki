<?php

namespace Kirki;

use Kirki;

class Controls {

    /** @var array An array that defines which custom control types are available and the corresponding class name */
    public static $CONTROL_TYPES = array(
        'multicheck'        => 'MultiCheckControl',
        'number'            => 'NumberControl',
        'radio-buttonset'   => 'RadioButtonSetControl',
        'radio-image'       => 'RadioImageControl',
        'slider'            => 'SliderControl',
        'sortable'          => 'SortableControl',
        'switch'            => 'SwitchControl',
        'toggle'            => 'ToggleControl',
        'palette'           => 'PaletteControl',
        'custom'            => 'CustomControl',
        'editor'            => 'EditorControl',
    );

    /** @var array The controls */
    private $controls = null;

    /**
     * Constructor
     */
	public function __construct() {
        // Hook into WP
        $this->register_hooks();
	}

	/**
	 * Get the controls for the Kirki customizer.
	 *
	 * @uses  'kirki/controls' filter.
	 */
	public function get_all() {
        if ( $this->controls == null ) {
			$fields = apply_filters( 'kirki/controls', array() );
			$fields = apply_filters( 'kirki/fields', $fields );

            $this->controls = array();
			foreach ( $fields as $field ) {
                $this->controls[] = Kirki::field()->sanitize( $field );
			}
		}
		return $this->controls;
	}

}
