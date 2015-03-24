<?php

class Kirki_Config {

    /** @var array The configuration values for Kirki */
    private $config = null;

    /**
     * Constructor
     */
    function __construct() {
    }

    /**
	 * Get the configuration options for the Kirki customizer.
	 *
	 * @uses 'kirki/config' filter.
	 */
	public function get() {
        if ($this->config==null) {
            // Get configuration from the filter
            $this->config = apply_filters('kirki/config', array());

            // Merge a default configuration with the one we got from the user to make sure nothing is missing
            $default_config = array(
                'stylesheet_id' => 'kirki-styles'
            );
            $this->config = array_merge($default_config, $this->config);
        }

		return $this->config;
	}
}
