<?php

/**
 * Kirki API Class
 * Simple API for Kirki Framework
 */
class Kirki {

    public static $fields   = array();
    public static $sections = array();
    public static $help     = array();
    public static $args     = array();
    public static $priority = array();
    public static $errors   = array();
    public static $init     = array();

    public function __call( $closure, $args ) {
        return call_user_func_array( $this->{$closure}->bindTo( $this ), $args );
    }

    public function __toString() {
        return call_user_func( $this->{"__toString"}->bindTo( $this ) );
    }

    public static function load() {
        add_action( 'after_setup_theme', array( 'Kirki', 'create_kirki' ) );
        add_action( 'init', array( 'Kirki', 'create_kirki' ) );
    }

    public static function init( $instance_id = '' ) {
        if ( ! empty( $instance_id ) ) {
            self::loadKirki( $instance_id );
            remove_action( 'setup_theme', array( 'Kirki', 'create_kirki' ) );
        }
    }

    public static function loadKirki( $instance_id = '' ) {

        if ( empty( $instance_id ) ) {
            return;
        }

        $check = Kirki_Instances::get_instance( $instance_id );
        if ( isset( $check->apiHasRun ) ) {
            return;
        }

        $config   = self::construct_config( $instance_id );
        $sections = self::construct_sections( $instance_id );

        if ( ! class_exists( 'Kirki_Framework' ) ) {
            echo '<div id="message" class="error"><p>' . __( 'Kirki is <strong>not installed</strong>. Please install it.', 'kirki' ) . '</p></div>';
            return;
        }

        $kirki                    = new Kirki_Framework( $sections, $config );
        $kirki->apiHasRun         = 1;
        self::$init[$instance_id] = 1;

        if ( isset( $kirki->config['config_id'] ) && $kirki->config['config_id'] != $instance_id ) {
            self::$init[$kirki->config['config_id']] = 1;
        }

    }

    public static function create_kirki() {
        foreach ( self::$sections as $instance_id => $theSections ) {
            if ( ! self::$init[$instance_id] ) {
                self::loadKirki( $instance_id );
            }
        }
    }

    public static function construct_config( $instance_id ) {

        $config = isset( self::$args[$instance_id] ) ? self::$args[$instance_id] : array();

        $config['config_id'] = $instance_id;
		// TODO: Config sanitization (see Kirki_Config)

        return $config;

    }

    public static function construct_sections( $instance_id ) {

        $sections = array();
        if ( ! isset( self::$sections[$instance_id] ) ) {
            return $sections;
        }

        foreach ( self::$sections[$instance_id] as $section_id => $section ) {
            $section['fields'] = self::construct_fields( $instance_id, $section_id );
            $p = $section['priority'];
            while ( isset( $sections[$p] ) ) {
                echo $p++;
            }
            $sections[$p] = $section;
        }
        ksort( $sections );

        return $sections;

    }

    public static function construct_fields( $instance_id = '', $section_id = '' ) {

        $fields = array();
        if ( ! empty( self::$fields[$instance_id] ) ) {
            foreach ( self::$fields[$instance_id] as $key => $field ) {
                if ( $field['section_id'] == $section_id ) {
                    $p = $field['priority'];
                    while ( isset( $fields[$p] ) ) {
                        echo $p++;
                    }
                    $fields[$p] = $field;
                }
            }
        }
        ksort( $fields );

        return $fields;
    }

    public static function get_section( $instance_id = '', $id = '' ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $instance_id ) && ! empty( $id ) ) {
            if ( ! isset( self::$sections[$instance_id][$id] ) ) {
                $id = strtolower( sanitize_html_class( $id ) );
            }

            return isset( self::$sections[$instance_id][$id] ) ? self::$sections[$instance_id][$id] : false;
        }

        return false;
    }

    public static function set_sections( $instance_id = '', $sections = array() ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $sections ) ) {
            foreach ( $sections as $section ) {
                Kirki_Framework::set_section( $instance_id, $section );
            }
        }
    }

    public static function set_section( $instance_id = '', $section = array() ) {
        self::check_config_id( $instance_id );
        if ( ! isset( $section['id'] ) ) {
            $section['id'] = strtolower( sanitize_html_class( $section['title'] ) );
            if ( isset( self::$sections[$instance_id][$section['id']] ) ) {
                $orig = $section['id'];
                $i    = 0;
                while ( isset( self::$sections[$instance_id][$section['id']] ) ) {
                    $section['id'] = $orig . '_' . $i;
                }
            }
        }

        if ( ! empty( $instance_id ) && is_array( $section ) && ! empty( $section ) ) {
            if ( ! isset( $section['id'] ) && ! isset( $section['title'] ) ) {
                self::$errors[$instance_id]['section']['missing_title'] = "Unable to create a section due to missing id and title.";

                return;
            }
            if ( ! isset( $section['priority'] ) ) {
                $section['priority'] = self::getPriority( $instance_id, 'sections' );
            }
            if ( isset( $section['fields'] ) ) {
                if ( ! empty( $section['fields'] ) && is_array( $section['fields'] ) ) {
                    self::processFieldsArray( $instance_id, $section['id'], $section['fields'] );
                }
                unset( $section['fields'] );
            }
            self::$sections[$instance_id][$section['id']] = $section;
        } else {
            self::$errors[$instance_id]['section']['empty'] = "Unable to create a section due an empty section array or the section variable passed was not an array.";

            return;
        }
    }

    public static function processFieldsArray( $instance_id = '', $section_id = '', $fields = array() ) {
        if ( ! empty( $instance_id ) && ! empty( $section_id ) && is_array( $fields ) && ! empty( $fields ) ) {
            foreach ( $fields as $field ) {
                if ( ! is_array( $field ) ) {
                    continue;
                }
                $field['section_id'] = $section_id;
                self::setField( $instance_id, $field );
            }
        }
    }

    public static function getField( $instance_id = '', $id = '' ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $instance_id ) && ! empty( $id ) ) {
            return isset( self::$fields[$instance_id][$id] ) ? self::$fields[$instance_id][$id] : false;
        }

        return false;
    }

    public static function setField( $instance_id = '', $field = array() ) {
        self::check_config_id( $instance_id );

        if ( ! empty( $instance_id ) && is_array( $field ) && ! empty( $field ) ) {

            if ( ! isset( $field['priority'] ) ) {
                $field['priority'] = self::getPriority( $instance_id, 'fields' );
            }
            self::$fields[$instance_id][$field['id']] = $field;
        }
    }

    public static function setHelpTab( $instance_id = '', $tab = array() ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $instance_id ) && ! empty( $tab ) ) {
            if ( ! isset( self::$args[$instance_id]['help_tabs'] ) ) {
                self::$args[$instance_id]['help_tabs'] = array();
            }
            if ( isset( $tab['id'] ) ) {
                self::$args[$instance_id]['help_tabs'][] = $tab;
            } else if ( is_array( end( $tab ) ) ) {
                foreach ( $tab as $tab_item ) {
                    self::$args[$instance_id]['help_tabs'][] = $tab_item;
                }
            }
        }
    }

    public static function setHelpSidebar( $instance_id = '', $content = '' ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $instance_id ) && ! empty( $content ) ) {
            self::$args[$instance_id]['help_sidebar'] = $content;
        }
    }

    public static function setArgs( $instance_id = '', $args = array() ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $instance_id ) && ! empty( $args ) && is_array( $args ) ) {
            self::$args[$instance_id] = wp_parse_args( $args, self::$args[$instance_id] );
        }
    }

    public static function getArgs( $instance_id = '' ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $instance_id ) && ! empty( self::$args[$instance_id] ) ) {
            return self::$args[$instance_id];
        }
    }

    public static function getArg( $instance_id = '', $key = '' ) {
        self::check_config_id( $instance_id );
        if ( ! empty( $instance_id ) && ! empty( $key ) && ! empty( self::$args[$instance_id] ) ) {
            return self::$args[$instance_id][$key];
        } else {
            return;
        }
    }

    public static function getPriority( $instance_id, $type ) {
        $priority = self::$priority[$instance_id][$type];
        self::$priority[$instance_id][$type] += 1;

        return $priority;
    }

    public static function check_config_id( $instance_id = '' ) {
        if ( empty( $instance_id ) || is_array( $instance_id ) ) {
            return;
        }
        if ( ! isset( self::$args[$instance_id] ) ) {
            self::$args[$instance_id]             = array();
            self::$priority[$instance_id]['args'] = 1;
        }
        if ( ! isset( self::$sections[$instance_id] ) ) {
            self::$sections[$instance_id]             = array();
            self::$priority[$instance_id]['sections'] = 1;
        }
        if ( ! isset( self::$fields[$instance_id] ) ) {
            self::$fields[$instance_id]             = array();
            self::$priority[$instance_id]['fields'] = 1;
        }
        if ( ! isset( self::$help[$instance_id] ) ) {
            self::$help[$instance_id]             = array();
            self::$priority[$instance_id]['help'] = 1;
        }
        if ( ! isset( self::$errors[$instance_id] ) ) {
            self::$errors[$instance_id] = array();
        }
        if ( ! isset( self::$init[$instance_id] ) ) {
            self::$init[$instance_id] = false;
        }
    }

    /**
     * Retrieve metadata from a file. Based on WP Core's get_file_data function
     *
     * @since 2.1.1
     *
     * @param string $file Path to the file
     *
     * @return string
     */
    public static function getFileVersion( $file, $size = 8192 ) {
        // We don't need to write to the file, so just open for reading.
        $fp = fopen( $file, 'r' );

        // Pull only the first 8kiB of the file in.
        $file_data = fread( $fp, $size );

        // PHP will close file handle, but we are good citizens.
        fclose( $fp );

        // Make sure we catch CR-only line endings.
        $file_data = str_replace( "\r", "\n", $file_data );
        $version   = '';

        if ( preg_match( '/^[\t\/*#@]*' . preg_quote( '@version', '/' ) . '(.*)$/mi', $file_data, $match ) && $match[1] ) {
            $version = _cleanup_header_comment( $match[1] );
        }

        return $version;
    }

}

Kirki::load();
