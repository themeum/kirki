<?php
/**
 * Automatic postMessage scripts calculation for Kirki controls.
 *
 * @package     Kirki
 * @category    Modules
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds styles to the customizer.
 */
class Kirki_Modules_PostMessage {
	/**
	 * The object instance.
	 *
	 * @static
	 * @access private
	 * @since 3.0.0
	 * @var object
	 */
	private static $instance;

	/**
	 * The script.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @var string
	 */
	protected $script = '';

	/**
	 * Constructor.
	 *
	 * @access protected
	 * @since 3.0.0
	 */
	protected function __construct() {
		add_action( 'customize_preview_init', array( $this, 'postmessage' ) );
	}

	/**
	 * Gets an instance of this object.
	 * Prevents duplicate instances which avoid artefacts and improves performance.
	 *
	 * @static
	 * @access public
	 * @since 3.0.0
	 * @return object
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Enqueues the postMessage script
	 * and adds variables to it using the wp_localize_script function.
	 * The rest is handled via JS.
	 */
	public function postmessage() {

		wp_enqueue_script( 'kirki_auto_postmessage', trailingslashit( Kirki::$url ) . 'modules/postmessage/postmessage.js', array( 'jquery', 'customize-preview' ), KIRKI_VERSION, true );
		$fields = Kirki::$fields;
		foreach ( $fields as $field ) {
			if ( isset( $field['transport'] ) && 'postMessage' === $field['transport'] && isset( $field['js_vars'] ) && ! empty( $field['js_vars'] ) && is_array( $field['js_vars'] ) && isset( $field['settings'] ) ) {
				$this->script .= $this->script( $field );
			}
		}
		$this->script = apply_filters( 'kirki_postmessage_script', $this->script );
		wp_add_inline_script( 'kirki_auto_postmessage', $this->script, 'after' );

	}

	/**
	 * Generates script for a single field.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args The arguments.
	 */
	protected function script( $args ) {

		$script = 'wp.customize(\'' . $args['settings'] . '\',function(value){value.bind(function(newval){';

		$add_css = false;
		foreach ( $args['js_vars'] as $js_var ) {
			if ( ! isset( $js_var['function'] ) || 'html' !== $js_var['function'] ) {
				$add_css = true;
			}
		}

		if ( $add_css ) {

			// append unique style tag if not exist
			// The style ID.
			$style_id = 'kirki-postmessage-' . str_replace( array( '[', ']' ), '', $args['settings'] );
			$script  .= 'if(null===document.getElementById(\'' . $style_id . '\')||\'undefined\'===typeof document.getElementById(\'' . $style_id . '\')){jQuery(\'head\').append(\'<style id="' . $style_id . '"></style>\');}';
		}

		// Add anything we need before the main script.
		$script .= $this->before_script( $args );

		$field = array(
			'scripts' => array(),
		);
		// Loop through the js_vars and generate the script.
		foreach ( $args['js_vars'] as $key => $js_var ) {

			// Skip styles if "exclude" is defined and value is excluded.
			if ( isset( $js_var['exclude'] ) ) {
				$js_var['exclude'] = (array) $js_var['exclude'];
				$script           .= 'exclude=false;';
				foreach ( $js_var['exclude'] as $exclussion ) {
					$script .= "if(newval=='{$exclussion}'||(''==='{$exclussion}'&&_.isObject(newval)&&_.isEmpty(newval))){exclude=true;}";
				}
			}
			if ( isset( $js_var['element'] ) ) {
				// Array to string.
				if ( is_array( $js_var['element'] ) ) {
					$js_var['element'] = implode( ',', $js_var['element'] );
				}
				// Replace single quotes with double quotes to avoid issues with the compiled JS.
				$js_var['element'] = str_replace( '\'', '"', $js_var['element'] );
			}
			if ( isset( $js_var['function'] ) && 'html' === $js_var['function'] ) {
				$script .= $this->script_html_var( $js_var );
				continue;
			}
			$js_var['index_key'] = $key;
			$callback            = $this->get_callback( $args );
			if ( is_callable( $callback ) ) {
				$field['scripts'][ $key ] = call_user_func_array( $callback, array( $js_var, $args ) );
				continue;
			}
			$field['scripts'][ $key ] = $this->script_var( $js_var );
		}
		$combo_extra_script = '';
		$combo_css_script   = '';
		foreach ( $field['scripts'] as $script_array ) {
			$combo_extra_script .= $script_array['script'];
			$combo_css_script   .= ( 'css' !== $combo_css_script ) ? $script_array['css'] : '';
		}
		$text = ( 'css' === $combo_css_script ) ? 'css' : '\'' . $combo_css_script . '\'';

		$script .= $combo_extra_script . "var cssContent={$text};";
		if ( isset( $js_var['exclude'] ) ) {
			$script .= 'if(true===exclude){cssContent="";}';
		}
		if ( $add_css ) {
			$script .= "jQuery('#{$style_id}').text(cssContent);jQuery('#{$style_id}').appendTo('head');";
		}
		$script .= '});});';
		return $script;
	}

	/**
	 * Generates script for a single js_var when using "html" as function.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 */
	protected function script_html_var( $args ) {

		$script = ( isset( $args['choice'] ) ) ? "newval=newval['{$args['choice']}'];" : '';

		// Apply the value_pattern.
		if ( isset( $args['value_pattern'] ) && '' !== $args['value_pattern'] ) {
			$script .= $this->value_pattern_replacements( 'newval', $args );
		}

		if ( isset( $args['attr'] ) ) {
			$script .= "jQuery('{$args['element']}').attr('{$args['attr']}',newval);";
			return $script;
		}
		$script .= "jQuery('{$args['element']}').html(newval);";
		return $script;
	}

	/**
	 * Generates script for a single js_var.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 */
	protected function script_var( $args ) {
		$script          = '';
		$property_script = '';

		$value_key        = 'newval' . $args['index_key'];
		$property_script .= $value_key . '=newval;';

		$args = $this->get_args( $args );

		// Apply callback to the value if a callback is defined.
		if ( ! empty( $args['js_callback'] ) && is_array( $args['js_callback'] ) && isset( $args['js_callback'][0] ) && ! empty( $args['js_callback'][0] ) ) {
			$script .= $value_key . '=' . $args['js_callback'][0] . '(' . $value_key . ',' . $args['js_callback'][1] . ');';
		}

		// Apply the value_pattern.
		if ( '' !== $args['value_pattern'] ) {
			$script .= $this->value_pattern_replacements( $value_key, $args );
		}

		// Tweak to add url() for background-images.
		if ( 'background-image' === $args['property'] && ( ! isset( $args['value_pattern'] ) || false === strpos( $args['value_pattern'], 'gradient' ) ) ) {
			$script .= 'if(-1===' . $value_key . '.indexOf(\'url(\')){' . $value_key . '=\'url("\'+' . $value_key . '+\'")\';}';
		}

		// Apply prefix.
		$value = $value_key;
		if ( '' !== $args['prefix'] ) {
			$value = "'" . $args['prefix'] . "'+" . $value_key;
		}
		$css = $args['element'] . '{' . $args['property'] . ':\'+' . $value . '+\'' . $args['units'] . $args['suffix'] . ';}';
		if ( isset( $args['media_query'] ) ) {
			$css = $args['media_query'] . '{' . $css . '}';
		}
		return array(
			'script' => $property_script . $script,
			'css'    => $css,
		);
	}

	/**
	 * Processes script generation for fields that save an array.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 */
	protected function script_var_array( $args ) {

		$script          = ( 0 === $args['index_key'] ) ? 'css=\'\';' : '';
		$property_script = '';

		// Define choice.
		$choice = ( isset( $args['choice'] ) && '' !== $args['choice'] ) ? $args['choice'] : '';

		$value_key        = 'newval' . $args['index_key'];
		$property_script .= $value_key . '=newval;';

		$args = $this->get_args( $args );

		// Apply callback to the value if a callback is defined.
		if ( ! empty( $args['js_callback'] ) && is_array( $args['js_callback'] ) && isset( $args['js_callback'][0] ) && ! empty( $args['js_callback'][0] ) ) {
			$script .= $value_key . '=' . $args['js_callback'][0] . '(' . $value_key . ',' . $args['js_callback'][1] . ');';
		}
		$script .= '_.each(' . $value_key . ', function(subValue,subKey){';

		// Apply the value_pattern.
		if ( '' !== $args['value_pattern'] ) {
			$script .= $this->value_pattern_replacements( 'subValue', $args );
		}

		// Tweak to add url() for background-images.
		if ( '' === $choice || 'background-image' === $choice ) {
			$script .= 'if(\'background-image\'===\'' . $args['property'] . '\'||\'background-image\'===subKey){if(-1===subValue.indexOf(\'url(\')){subValue=\'url("\'+subValue+\'")\';}}';
		}

		// Apply prefix.
		$value = $value_key;
		if ( '' !== $args['prefix'] ) {
			$value = '\'' . $args['prefix'] . '\'+subValue';
		}

		// Mostly used for padding, margin & position properties.
		$direction_script  = 'if(_.contains([\'top\',\'bottom\',\'left\',\'right\'],subKey)){';
		$direction_script .= 'css+=\'' . $args['element'] . '{' . $args['property'] . '-\'+subKey+\':\'+subValue+\'' . $args['units'] . $args['suffix'] . ';}\';}';
		// Allows us to apply this just for a specific choice in the array of the values.
		if ( '' !== $choice ) {
			$choice_is_direction = ( false !== strpos( $choice, 'top' ) || false !== strpos( $choice, 'bottom' ) || false !== strpos( $choice, 'left' ) || false !== strpos( $choice, 'right' ) );
			// The script.
			$script .= 'if(\'' . $choice . '\'===subKey){';
			$script .= ( $choice_is_direction ) ? $direction_script . 'else{' : '';
			$script .= 'css+=\'' . $args['element'] . '{' . $args['property'] . ':\'+subValue+\';}\';';
			$script .= ( $choice_is_direction ) ? '}' : '';
			$script .= '}';
		} else {

			// This is where most object-based fields will go.
			$script .= $direction_script . 'else{css+=\'' . $args['element'] . '{\'+subKey+\':\'+subValue+\'' . $args['units'] . $args['suffix'] . ';}\';}';
		}
		$script .= '});';

		if ( isset( $args['media_query'] ) ) {
			$script .= 'css=\'' . $args['media_query'] . '{\'+css+\'}\';';
		}

		return array(
			'script' => $property_script . $script,
			'css'    => 'css',
		);
	}

	/**
	 * Processes script generation for typography fields.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 * @param array $field The field arguments.
	 */
	protected function script_var_typography( $args, $field ) {

		$args = $this->get_args( $args );

		$script = '';
		$css    = '';

		// Load the font using WenFontloader.
		// This is a bit ugly because wp_add_inline_script doesn't allow adding <script> directly.
		$webfont_loader = 'sc=\'a\';jQuery(\'head\').append(sc.replace(\'a\',\'<\')+\'script>if(!_.isUndefined(WebFont)&&fontFamily){WebFont.load({google:{families:["\'+fontFamily.replace( /\"/g, \'&quot;\' )+\':\'+variant+\'cyrillic,cyrillic-ext,devanagari,greek,greek-ext,khmer,latin,latin-ext,vietnamese,hebrew,arabic,bengali,gujarati,tamil,telugu,thai"]}});}\'+sc.replace(\'a\',\'<\')+\'/script>\');';

		// Add the css.
		$css_build_array  = array(
			'font-family'     => 'fontFamily',
			'font-size'       => 'fontSize',
			'line-height'     => 'lineHeight',
			'letter-spacing'  => 'letterSpacing',
			'word-spacing'    => 'wordSpacing',
			'text-align'      => 'textAlign',
			'text-transform'  => 'textTransform',
			'text-decoration' => 'textDecoration',
			'color'           => 'color',
			'font-weight'     => 'fontWeight',
			'font-style'      => 'fontStyle',
		);
		$choice_condition = ( isset( $args['choice'] ) && '' !== $args['choice'] && isset( $css_build_array[ $args['choice'] ] ) );
		$script          .= ( ! $choice_condition ) ? $webfont_loader : '';
		foreach ( $css_build_array as $property => $var ) {
			if ( $choice_condition && $property !== $args['choice'] ) {
				continue;
			}
			// Fixes https://github.com/aristath/kirki/issues/1436.
			if ( ! isset( $field['default'] ) || (
				( 'font-family' === $property && ! isset( $field['default']['font-family'] ) ) ||
				( 'font-size' === $property && ! isset( $field['default']['font-size'] ) ) ||
				( 'line-height' === $property && ! isset( $field['default']['line-height'] ) ) ||
				( 'letter-spacing' === $property && ! isset( $field['default']['letter-spacing'] ) ) ||
				( 'word-spacing' === $property && ! isset( $field['default']['word-spacing'] ) ) ||
				( 'text-align' === $property && ! isset( $field['default']['text-align'] ) ) ||
				( 'text-transform' === $property && ! isset( $field['default']['text-transform'] ) ) ||
				( 'text-decoration' === $property && ! isset( $field['default']['text-decoration'] ) ) ||
				( 'color' === $property && ! isset( $field['default']['color'] ) ) ||
				( 'font-weight' === $property && ! isset( $field['default']['variant'] ) && ! isset( $field['default']['font-weight'] ) ) ||
				( 'font-style' === $property && ! isset( $field['default']['variant'] ) && ! isset( $field['default']['font-style'] ) )
				) ) {
				continue;
			}
			$script .= ( $choice_condition && 'font-family' === $args['choice'] ) ? $webfont_loader : '';

			if ( 'font-family' === $property || ( isset( $args['choice'] ) && 'font-family' === $args['choice'] ) ) {
				$css .= 'fontFamilyCSS=fontFamily;if(0<fontFamily.indexOf(\' \')&&-1===fontFamily.indexOf(\'"\')){fontFamilyCSS=\'"\'+fontFamily+\'"\';}';
				$var  = 'fontFamilyCSS';
			}
			$var  = ( ( empty( $args['prefix'] ) ) ? '' : '\'' . $args['prefix'] . '\'+' ) . $var . ( ( empty( $args['units'] ) ) ? '' : '+\'' . $args['units'] . '\'' ) . ( ( empty( $args['suffix'] ) ) ? '' : '+\'' . $args['suffix'] . '\'' );
			$css .= 'css+=(\'\'!==' . $var . ')?\'' . $args['element'] . '\'+\'{' . $property . ':\'+' . $var . '+\';}\':\'\';';
		}

		$script .= $css;
		if ( isset( $args['media_query'] ) ) {
			$script .= 'css=\'' . $args['media_query'] . '{\'+css+\'}\';';
		}
		return array(
			'script' => $script,
			'css'    => 'css',
		);
	}

	/**
	 * Processes script generation for typography fields.
	 *
	 * @access protected
	 * @since 3.0.0
	 * @param array $args  The arguments for this js_var.
	 */
	protected function script_var_image( $args ) {
		$return = $this->script_var( $args );
		return array(
			'script' => 'newval=(!_.isUndefined(newval.url))?newval.url:newval;' . $return['script'],
			'css'    => $return['css'],
		);
	}

	/**
	 * Adds anything we need before the main script.
	 *
	 * @access private
	 * @since 3.0.0
	 * @param array $args The field args.
	 * @return string
	 */
	private function before_script( $args ) {

		$script = '';

		if ( isset( $args['type'] ) ) {
			switch ( $args['type'] ) {
				case 'kirki-typography':
					$script .= 'fontFamily=(_.isUndefined(newval[\'font-family\']))?\'\':newval[\'font-family\'];variant=(_.isUndefined(newval.variant))?\'400\':newval.variant;fontSize=(_.isUndefined(newval[\'font-size\']))?\'\':newval[\'font-size\'];lineHeight=(_.isUndefined(newval[\'line-height\']))?\'\':newval[\'line-height\'];letterSpacing=(_.isUndefined(newval[\'letter-spacing\']))?\'\':newval[\'letter-spacing\'];wordSpacing=(_.isUndefined(newval[\'word-spacing\']))?\'\':newval[\'word-spacing\'];textAlign=(_.isUndefined(newval[\'text-align\']))?\'\':newval[\'text-align\'];textTransform=(_.isUndefined(newval[\'text-transform\']))?\'\':newval[\'text-transform\'];textDecoration=(_.isUndefined(newval[\'text-decoration\']))?\'\':newval[\'text-decoration\'];color=(_.isUndefined(newval.color))?\'\':newval.color;fw=(!_.isString(newval.variant))?\'400\':newval.variant.match(/\d/g);fontWeight=(!_.isObject(fw))?400:fw.join(\'\');fontStyle=(-1!==variant.indexOf(\'italic\'))?\'italic\':\'normal\';css=\'\';';
					break;
			}
		}
		return $script;
	}

	/**
	 * Sanitizes the arguments and makes sure they are all there.
	 *
	 * @access private
	 * @since 3.0.0
	 * @param array $args The arguments.
	 * @return array
	 */
	private function get_args( $args ) {

		// Make sure everything is defined to avoid "undefined index" errors.
		$args = wp_parse_args(
			$args, array(
				'element'       => '',
				'property'      => '',
				'prefix'        => '',
				'suffix'        => '',
				'units'         => '',
				'js_callback'   => array( '', '' ),
				'value_pattern' => '',
			)
		);

		// Element should be a string.
		if ( is_array( $args['element'] ) ) {
			$args['element'] = implode( ',', $args['element'] );
		}

		// Make sure arguments that are passed-on to callbacks are strings.
		if ( is_array( $args['js_callback'] ) && isset( $args['js_callback'][1] ) && is_array( $args['js_callback'][1] ) ) {
			$args['js_callback'][1] = wp_json_encode( $args['js_callback'][1] );
		}

		if ( ! isset( $args['js_callback'][1] ) ) {
			$args['js_callback'][1] = '';
		}
		return $args;

	}

	/**
	 * Returns script for value_pattern & replacements.
	 *
	 * @access private
	 * @since 3.0.0
	 * @param string $value   The value placeholder.
	 * @param array  $js_vars The js_vars argument.
	 * @return string         The script.
	 */
	private function value_pattern_replacements( $value, $js_vars ) {
		$script = '';
		$alias  = $value;
		if ( ! isset( $js_vars['value_pattern'] ) ) {
			return $value;
		}
		$value = $js_vars['value_pattern'];
		if ( isset( $js_vars['pattern_replace'] ) ) {
			$script .= 'settings=window.wp.customize.get();';
			foreach ( $js_vars['pattern_replace'] as $search => $replace ) {
				$replace = '\'+settings["' . $replace . '"]+\'';
				$value   = str_replace( $search, $replace, $js_vars['value_pattern'] );
				$value   = trim( $value, '+' );
			}
		}
		$value_compiled = str_replace( '$', '\'+' . $alias . '+\'', $value );
		$value_compiled = trim( $value_compiled, '+' );

		return $script . $alias . '=\'' . $value_compiled . '\';';
	}

	/**
	 * Get the callback function/method we're going to use for this field.
	 *
	 * @access private
	 * @since 3.0.0
	 * @param array $args The field args.
	 * @return string|array A callable function or method.
	 */
	protected function get_callback( $args ) {

		switch ( $args['type'] ) {
			case 'kirki-background':
			case 'kirki-dimensions':
			case 'kirki-multicolor':
			case 'kirki-sortable':
				$callback = array( $this, 'script_var_array' );
				break;
			case 'kirki-typography':
				$callback = array( $this, 'script_var_typography' );
				break;
			case 'kirki-image':
				$callback = array( $this, 'script_var_image' );
				break;
			default:
				$callback = array( $this, 'script_var' );
		}
		return $callback;
	}
}
