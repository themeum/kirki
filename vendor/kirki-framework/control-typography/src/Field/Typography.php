<?php
/**
 * Override field methods
 *
 * @package   kirki-framework/control-typography
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Field;

use Kirki\Core\Field;
use Kirki;
use Kirki\URL;
use Kirki\GoogleFonts;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Typography extends Field {

	/**
	 * Has the glogal gfonts var been added already?
	 *
	 * @static
	 * @access private
	 * @since 1.0
	 * @var bool
	 */
	private static $gfonts_var_added = false;

	/**
	 * An array of typography controls.
	 *
	 * This is used by the typography script for any custom logic
	 * that has to be applied to typography controls.
	 *
	 * @static
	 * @access private
	 * @since 1.0
	 * @var array
	 */
	private static $typography_controls = [];

	/**
	 * The class constructor.
	 * Parses and sanitizes all field arguments.
	 * Then it adds the field to Kirki::$fields.
	 *
	 * @access public
	 * @param string $config_id    The ID of the config we want to use.
	 *                             Defaults to "global".
	 *                             Configs are handled by the Kirki\Core\Config class.
	 * @param array  $args         The arguments of the field.
	 */
	public function __construct( $config_id = 'global', $args = [] ) {

		self::$typography_controls[] = $args['settings'];

		$this->add_main_field( $config_id, $args );
		$this->add_sub_fields( $config_id, $args );

		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Adds the main field.
	 *
	 * @access private
	 * @since 1.0
	 * @param string $config_id The config-ID.
	 * @param array  $args      The field arguments.
	 * @return void
	 */
	private function add_main_field( $config_id, $args ) {

		/**
		 * Add a hidden field, the label & description.
		 */
		Kirki::add_field(
			$config_id,
			wp_parse_args(
				[
					'type'              => 'kirki-generic',
					'sanitize_callback' => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : [ __CLASS__, 'sanitize' ],
					'choices'           => [
						'type'        => 'hidden',
						'parent_type' => 'kirki-typography',
					],
				],
				$args
			)
		);
	}

	/**
	 * Adds sub-fields.
	 *
	 * @access private
	 * @since 1.0
	 * @param string $config_id The config-ID.
	 * @param array  $args      The field arguments.
	 * @return void
	 */
	private function add_sub_fields( $config_id, $args ) {

		$args['parent_setting'] = $args['settings'];
		$args['output']         = [];
		$args['wrapper_atts']   = [
			'data-kirki-parent-control-type' => 'kirki-typography',
		];

		if ( isset( $args['transport'] ) && 'auto' === $args['transport'] ) {
			$args['transport'] = 'postMessage';
		}

		/**
		 * Add font-family selection controls.
		 * These include font-family, font-weight and font-style.
		 * They are grouped here because all 3 of them are required
		 * in order to get the right googlefont variant.
		 */
		if ( isset( $args['default']['font-family'] ) ) {

			// Figure out how to sort the fonts.
			$sorting   = 'alpha';
			$max_fonts = 9999;
			if ( isset( $args['choices'] ) && isset( $args['choices']['fonts'] ) && isset( $args['choices']['fonts']['google'] ) ) {
				if ( isset( $args['choices']['fonts']['google'][0] ) && in_array( $args['choices']['fonts']['google'][0], [ 'alpha', 'popularity', 'trending' ], true ) ) {
					$sorting = $args['choices']['fonts']['google'][0];
				}
				if ( isset( $args['choices']['fonts']['google'][1] ) && is_int( $args['choices']['fonts']['google'][1] ) ) {
					$max_fonts = (int) $args['choices']['fonts']['google'][1];
				}
			}
			$google  = new GoogleFonts();
			$g_fonts = $google->get_google_fonts_by_args(
				[
					'sort'  => $sorting,
					'count' => $max_fonts,
				]
			);

			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'font-family';

			/**
			 * Add font-family control.
			 */
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'type'        => 'select',
						'label'       => esc_html__( 'Font Family', 'kirki' ),
						'description' => '',
						'settings'    => $args['settings'] . '[font-family]',
						'choices'     => [
							'google' => [
								esc_html__( 'Google Fonts', 'kirki' ),
								array_combine( array_values( $g_fonts ), array_values( $g_fonts ) ),
							],
						],
					],
					$args
				)
			);

			/**
			 * Add font-weight.
			 */
			$font_weight = 400;
			$font_weight = isset( $args['default']['variant'] ) ? $args['default']['variant'] : 400;
			$font_weight = isset( $args['default']['font-weight'] ) ? $args['default']['font-weight'] : $font_weight;
			$font_weight = 'regular' === $font_weight || 'italic' === $font_weight ? 400 : (int) $font_weight;
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'font-weight';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Font Weight', 'kirki' ),
						'description' => '',
						'type'        => 'radio-buttonset',
						'settings'    => $args['settings'] . '[font-weight]',
						'default'     => $font_weight,
						'choices'     => [
							'100' => '100',
							'200' => '200',
							'300' => '300',
							'400' => '400',
							'500' => '500',
							'600' => '600',
							'700' => '700',
							'800' => '800',
							'900' => '900',
							/**
							 * WIP - Still thinking about the best way to present these.
							 * Below is the same array we have above, but with proper names
							 * in case we decide to switch to some other control-type.
							 *
							'100' => esc_html__( '100 - Thin', 'kirki' ),
							'200' => esc_html__( '200 - Extra Light, Ultra Light', 'kirki' ),
							'300' => esc_html__( '300 - Light', 'kirki' ),
							'400' => esc_html__( '400 - Normal, Book, Regular', 'kirki' ),
							'500' => esc_html__( '500 - Medium', 'kirki' ),
							'600' => esc_html__( '600 - Semi Bold, Demi Bold', 'kirki' ),
							'700' => esc_html__( '700 - Bold', 'kirki' ),
							'800' => esc_html__( '800 - Extra Bold, Ultra Bold', 'kirki' ),
							'900' => esc_html__( '900 - Black, Heavy', 'kirki' ),
							*/
						],
					],
					$args
				)
			);

			/**
			 * Add font-style.
			 */
			$is_italic = isset( $args['default']['variant'] ) && false !== strpos( $args['default']['variant'], 'i' );
			$is_italic = isset( $args['default']['font-style'] ) && 'italic' === $args['default']['font-style'];
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'font-style';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Font Style', 'kirki' ),
						'description' => '',
						'type'        => 'radio-buttonset',
						'settings'    => $args['settings'] . '[font-style]',
						'default'     => $is_italic ? 'italic' : 'normal',
						'choices'     => [
							'normal' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M22 0h-20v6h1.999c0-1.174.397-3 2.001-3h4v16.874c0 1.174-.825 2.126-2 2.126h-1v2h9.999v-2h-.999c-1.174 0-2-.952-2-2.126v-16.874h4c1.649 0 2.02 1.826 2.02 3h1.98v-6z"/></svg><span class="screen-reader-text">' . esc_html__( 'Normal', 'kirki' ) . '</span>',
							'italic' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9.565 20.827c-.361.732-.068 1.173.655 1.173h1.78v2h-9v-2h.897c1.356 0 1.673-.916 2.157-1.773l8.349-16.89c.403-.852-.149-1.337-.855-1.337h-1.548v-2h9v2h-.84c-1.169 0-1.596.646-2.06 1.516l-8.535 17.311z"/></svg><span class="screen-reader-text">' . esc_html__( 'Italic', 'kirki' ) . '</span>',
						],
					],
					$args
				)
			);
		}

		/**
		 * Add font-size.
		 */
		if ( isset( $args['default']['font-size'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'font-size';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Font Size', 'kirki' ),
						'description' => '',
						'type'        => 'dimension',
						'settings'    => $args['settings'] . '[font-size]',
						'default'     => $args['default']['font-size'],
					],
					$args
				)
			);
		}

		/**
		 * Line-Height.
		 */
		if ( isset( $args['default']['line-height'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'line-height';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Line Height', 'kirki' ),
						'description' => '',
						'type'        => 'dimension',
						'settings'    => $args['settings'] . '[line-height]',
						'default'     => $args['default']['line-height'],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['letter-spacing'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'letter-spacing';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Letter Spacing', 'kirki' ),
						'description' => '',
						'type'        => 'dimension',
						'settings'    => $args['settings'] . '[letter-spacing]',
						'default'     => $args['default']['letter-spacing'],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['word-spacing'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'word-spacing';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Word Spacing', 'kirki' ),
						'description' => '',
						'type'        => 'dimension',
						'settings'    => $args['settings'] . '[word-spacing]',
						'default'     => $args['default']['word-spacing'],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['text-transform'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'text-transform';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Text Transform', 'kirki' ),
						'description' => '',
						'type'        => 'select',
						'settings'    => $args['settings'] . '[text-transform]',
						'default'     => $args['default']['text-transform'],
						'choices'     => [
							'capitalize' => esc_html__( 'Capitalize', 'kirki' ),
							'uppercase'  => esc_html__( 'Uppercase', 'kirki' ),
							'lowercase'  => esc_html__( 'Lowercase', 'kirki' ),
							'initial'    => esc_html__( 'Initial', 'kirki' ),
							'inherit'    => esc_html__( 'Inherit', 'kirki' ),
						],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['text-decoration'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'text-decoration';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Text Decoration', 'kirki' ),
						'description' => '',
						'type'        => 'select',
						'settings'    => $args['settings'] . '[text-decoration]',
						'default'     => $args['default']['text-decoration'],
						'choices'     => [
							'underline'    => esc_html__( 'Underline', 'kirki' ),
							'overline'     => esc_html__( 'Overline', 'kirki' ),
							'line-through' => esc_html__( 'Line-Through', 'kirki' ),
							'initial'      => esc_html__( 'Initial', 'kirki' ),
							'inherit'      => esc_html__( 'Inherit', 'kirki' ),
						],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['text-align'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'text-align';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Text Align', 'kirki' ),
						'description' => '',
						'type'        => 'radio-buttonset',
						'settings'    => $args['settings'] . '[text-align]',
						'default'     => $args['default']['text-align'],
						'choices'     => [
							'inherit' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M23.954 21.03l-9.184-9.095 9.092-9.174-2.832-2.807-9.09 9.179-9.176-9.088-2.81 2.81 9.186 9.105-9.095 9.184 2.81 2.81 9.112-9.192 9.18 9.1z"/></svg><span class="screen-reader-text">' . esc_html__( 'Inherit', 'kirki' ) . '</span>',
							'left'    => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 3h-24v-2h24v2zm-12 3h-12v2h12v-2zm12 5h-24v2h24v-2zm-12 5h-12v2h12v-2zm12 5h-24v2h24v-2z"/></svg><span class="screen-reader-text">' . esc_html__( 'Left', 'kirki' ) . '</span>',
							'center'  => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M24 3h-24v-2h24v2zm-6 3h-12v2h12v-2zm6 5h-24v2h24v-2zm-6 5h-12v2h12v-2zm6 5h-24v2h24v-2z"/></svg><span class="screen-reader-text">' . esc_html__( 'Center', 'kirki' ) . '</span>',
							'right'   => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 1h24v2h-24v-2zm12 7h12v-2h-12v2zm-12 5h24v-2h-24v2zm12 5h12v-2h-12v2zm-12 5h24v-2h-24v2z"/></svg><span class="screen-reader-text">' . esc_html__( 'Right', 'kirki' ) . '</span>',
							'justify' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 1h24v2h-24v-2zm0 7h24v-2h-24v2zm0 5h24v-2h-24v2zm0 5h24v-2h-24v2zm0 5h24v-2h-24v2z"/></svg><span class="screen-reader-text">' . esc_html__( 'Justify', 'kirki' ) . '</span>',
						],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['margin-top'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'margin-top';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Top Margin', 'kirki' ),
						'description' => '',
						'type'        => 'dimension',
						'settings'    => $args['settings'] . '[margin-top]',
						'default'     => $args['default']['margin-top'],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['margin-bottom'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'margin-bottom';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Bottom Margin', 'kirki' ),
						'description' => '',
						'type'        => 'dimension',
						'settings'    => $args['settings'] . '[margin-bottom]',
						'default'     => $args['default']['margin-bottom'],
					],
					$args
				)
			);
		}

		if ( isset( $args['default']['color'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'color';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => '',
						'description' => '',
						'type'        => 'color',
						'settings'    => $args['settings'] . '[color]',
						'default'     => $args['default']['color'],
					],
					$args
				)
			);
		}

		Kirki::add_field(
			$config_id,
			[
				'label'           => '',
				'description'     => '',
				'type'            => 'custom',
				'default'         => '<div class="kirki-typography-end"><hr></div>',
				'section'         => $args['section'],
				'active_callback' => isset( $args['active_callback'] ) ? $args['active_callback'] : '',
			]
		);
	}

	/**
	 * Sanitizes typography controls
	 *
	 * @static
	 * @since 1.0
	 * @param array $value The value.
	 * @return array
	 */
	public static function sanitize( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}

		foreach ( $value as $key => $val ) {
			switch ( $key ) {
				case 'font-family':
					$value['font-family'] = sanitize_text_field( $val );
					break;
				case 'font-weight':
					if ( isset( $value['variant'] ) ) {
						break;
					}
					$value['variant'] = $val;
					if ( isset( $value['font-style'] ) && 'italic' === $value['font-style'] ) {
						$value['variant'] = ( '400' !== $val || 400 !== $val ) ? $value['variant'] . 'italic' : 'italic';
					}
					break;
				case 'variant':
					// Use 'regular' instead of 400 for font-variant.
					$value['variant'] = ( 400 === $val || '400' === $val ) ? 'regular' : $val;

					// Get font-weight from variant.
					$value['font-weight'] = filter_var( $value['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = ( 'regular' === $value['variant'] || 'italic' === $value['variant'] ) ? 400 : (string) absint( $value['font-weight'] );

					// Get font-style from variant.
					if ( ! isset( $value['font-style'] ) ) {
						$value['font-style'] = ( false === strpos( $value['variant'], 'italic' ) ) ? 'normal' : 'italic';
					}
					break;
				case 'font-size':
				case 'letter-spacing':
				case 'word-spacing':
				case 'line-height':
					$value[ $key ] = '' === trim( $value[ $key ] ) ? '' : sanitize_text_field( $val );
					break;
				case 'text-align':
					if ( ! in_array( $val, [ '', 'inherit', 'left', 'center', 'right', 'justify' ], true ) ) {
						$value['text-align'] = '';
					}
					break;
				case 'text-transform':
					if ( ! in_array( $val, [ '', 'none', 'capitalize', 'uppercase', 'lowercase', 'initial', 'inherit' ], true ) ) {
						$value['text-transform'] = '';
					}
					break;
				case 'text-decoration':
					if ( ! in_array( $val, [ '', 'none', 'underline', 'overline', 'line-through', 'initial', 'inherit' ], true ) ) {
						$value['text-transform'] = '';
					}
					break;
				case 'color':
					$value['color'] = '' === $value['color'] ? '' : \ariColor::newColor( $val )->toCSS( 'hex' );
					break;
			}
		}

		return $value;
	}

	/**
	 * Enqueue scripts & styles.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'kirki-control-typography-style', URL::get_from_path( dirname( __DIR__ ) . '/assets/styles/style.css' ), [], '1.0' );

		wp_enqueue_script( 'kirki-typography', URL::get_from_path( dirname( __DIR__ ) . '/assets/scripts/script.js' ), [], '1.0', true );
		wp_localize_script( 'kirki-typography', 'kirkiTypographyControls', self::$typography_controls );

		if ( ! self::$gfonts_var_added ) {
			echo '<script>kirkiGoogleFonts=';
			$google = new GoogleFonts();
			$google->print_googlefonts_json( false );
			echo ';</script>';
			self::$gfonts_var_added = true;
		}
	}
}
