<?php

namespace Kirki;

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
		    $user_controls = apply_filters( 'kirki/controls', array() );

            $this->controls = array();
			foreach ( $user_controls as $control ) {
                $this->controls[] = Control::sanitize( $control );
			}
		}

		return $this->controls;
	}

    /**
     * Hook into WP
     */
    private function register_hooks() {
        add_action( 'customize_register', array( $this, 'include_files' ), 99 );
    }

    /**
     * Include the custom control files. Because they depend on the WP_Cs
     */
    public function include_files() {
        $path = KIRKI_PATH . '/includes/Controls';
        foreach ( self::$CONTROL_TYPES as $typeId => $className ) {
            include_once( $path . '/' . $className . '.php' );
        }
    }

}
