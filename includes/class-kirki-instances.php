<?php

/**
 * Kirki Framework Instance Container Class
 * Automatically captures and stores all instances
 * of Kirki_Framework at instantiation.
 */
class Kirki_Framework_Instances {

    /**
     * Kirki_Framework_Instances
     *
     * @var object
     */
    private static $instance;

    /**
     * Kirki_Framework instances
     *
     * @var array
     */
    private static $instances;

    /**
     * Get Instance
     * Get Kirki_Framework_Instances instance
     * OR an instance of Kirki_Framework by [config_id]
     *
     * @param  string $config_id the defined config_id
     *
     * @return object                class instance
     */
    public static function get_instance( $config_id = false ) {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        if ( $config_id && ! empty( self::$instances[$config_id] ) ) {
            return self::$instances[$config_id];
        }

        return self::$instance;
    }

    /**
     * Get all instantiated Kirki_Framework instances (so far)
     *
     * @return [type] [description]
     */
    public static function get_all_instances() {
        return self::$instances;
    }

    private function __construct() {
        add_action( 'kirki/construct', array( $this, 'capture' ), 5, 1 );
    }

    function capture( $Kirki_Framework ) {
        $this->store( $Kirki_Framework );
    }

    private function store( $Kirki_Framework ) {

        if ( $Kirki_Framework instanceof Kirki_Framework ) {
            $key                     = $Kirki_Framework->args['config_id'];
            self::$instances[$key] = $Kirki_Framework;
        }

    }

}
