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

use Kirki\Field;
use Kirki\GoogleFonts;
use Kirki\Module\Webfonts\Fonts;

/**
 * Field overrides.
 *
 * @since 1.0
 */
class Typography extends Field {

	/**
	 * The field type.
	 *
	 * @access public
	 * @since 1.0
	 * @var string
	 */
	public $type = 'kirki-typography';

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
	 * Extra logic for the field.
	 *
	 * Adds all sub-fields.
	 *
	 * @access public
	 * @param array $args The arguments of the field.
	 */
	public function init( $args = [] ) {

		self::$typography_controls[] = $args['settings'];

		$this->add_sub_fields( $args );

		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_control_scripts' ] );
		add_action( 'customize_preview_init', [ $this, 'enqueue_preview_scripts' ] );
		add_filter( 'kirki_output_control_classnames', [ $this, 'output_control_classnames' ] );
	}

	/**
	 * Add sub-fields.
	 *
	 * @access private
	 * @since 1.0
	 * @param array $args The field arguments.
	 * @return void
	 */
	private function add_sub_fields( $args ) {

		$args['kirki_config'] = isset( $args['kirki_config'] ) ? $args['kirki_config'] : 'global';

		$defaults = isset( $args['default'] ) ? $args['default'] : [];

		/**
		 * Add a hidden field, the label & description.
		 */
		new \Kirki\Field\Generic(
			wp_parse_args(
				[
					'sanitize_callback' => isset( $args['sanitize_callback'] ) ? $args['sanitize_callback'] : [ __CLASS__, 'sanitize' ],
					'wrapper_opts'      => [
						'gap' => 'small',
					],
					'input_attrs'       => '',
					'choices'           => [
						'type'        => 'hidden',
						'parent_type' => 'kirki-typography',
					],
				],
				$args
			)
		);

		$args['parent_setting'] = $args['settings'];
		$args['output']         = [];
		$args['wrapper_attrs']  = [
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

			$std_fonts = [];

			if ( ! isset( $args['choices']['fonts'] ) || ! isset( $args['choices']['fonts']['standard'] ) ) {
				$standard_fonts = Fonts::get_standard_fonts();
				foreach ( $standard_fonts as $font ) {
					$std_fonts[ $font['stack'] ] = $font['label'];
				}
			} elseif ( is_array( $args['choices']['fonts']['standard'] ) ) {
				foreach ( $args['choices']['fonts']['standard'] as $key => $val ) {
					$key               = ( \is_int( $key ) ) ? $val : $key;
					$std_fonts[ $key ] = $val;
				}
			}

			$choices = [
				'standard' => [
					esc_html__( 'Standard Fonts', 'kirki' ),
					$std_fonts,
				],
				'google'   => [
					esc_html__( 'Google Fonts', 'kirki' ),
					array_combine( array_values( $g_fonts ), array_values( $g_fonts ) ),
				],
			];

			if ( empty( $choices['standard'][1] ) ) {
				$choices = array_combine( array_values( $g_fonts ), array_values( $g_fonts ) );
			} elseif ( empty( $choices['google'][1] ) ) {
				$choices = $std_fonts;
			}

			$args['wrapper_attrs']['kirki-typography-subcontrol-type'] = 'font-family';

			/**
			 * Add font-family control.
			 */
			new \Kirki\Field\ReactSelect(
				wp_parse_args(
					[
						'label'       => esc_html__( 'Font Family', 'kirki' ),
						'description' => '',
						'settings'    => $args['settings'] . '[font-family]',
						'default'     => isset( $args['default']['font-family'] ) ? $args['default']['font-family'] : '',
						'input_attrs' => $this->filter_preferred_choice_setting( 'input_attrs', 'font-family', $args ),
						'choices'     => $choices,
						'css_vars'    => [],
						'output'      => [],
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
			$args['wrapper_attrs']['kirki-typography-subcontrol-type'] = 'font-weight';

			new \Kirki\Field\ReactSelect(
				wp_parse_args(
					[
						'label'       => esc_html__( 'Font Weight', 'kirki' ),
						'description' => '',
						'settings'    => $args['settings'] . '[font-weight]',
						'default'     => $font_weight,
						'input_attrs' => $this->filter_preferred_choice_setting( 'input_attrs', 'font-weight', $args ),
						'choices'     => [
							'100' => esc_html__( '100 - Thin', 'kirki' ),
							'200' => esc_html__( '200 - Extra Light, Ultra Light', 'kirki' ),
							'300' => esc_html__( '300 - Light', 'kirki' ),
							'400' => esc_html__( '400 - Normal, Book, Regular', 'kirki' ),
							'500' => esc_html__( '500 - Medium', 'kirki' ),
							'600' => esc_html__( '600 - Semi Bold, Demi Bold', 'kirki' ),
							'700' => esc_html__( '700 - Bold', 'kirki' ),
							'800' => esc_html__( '800 - Extra Bold, Ultra Bold', 'kirki' ),
							'900' => esc_html__( '900 - Black, Heavy', 'kirki' ),
						],
						'css_vars'    => [],
						'output'      => [],
					],
					$args
				)
			);

		}

		$font_size_field_specified  = isset( $defaults['font-size'] );
		$font_style_field_specified = isset( $defaults['font-style'] );

		if ( $font_size_field_specified || $font_style_field_specified ) {
			$group = [
				'font-size' => [
					'type'         => 'dimension',
					'label'        => esc_html__( 'Font Size', 'kirki' ),
					'is_specified' => $font_size_field_specified,
				],
				'font-style' => [
					'type'         => 'react-select',
					'label'        => esc_html__( 'Font Style', 'kirki' ),
					'is_specified' => $font_style_field_specified,
					'choices'      => [
						'normal' => esc_html__( 'Normal', 'kirki' ),
						'italic' => esc_html__( 'Italic', 'kirki' ),
					],
				],
			];

			$this->generate_controls_group( $group, $args );
		}

		$text_transform_field_specified  = isset( $defaults['text-transform'] );
		$text_decoration_field_specified = isset( $defaults['text-decoration'] );

		if ( $text_transform_field_specified || $text_decoration_field_specified ) {
			$group = [
				'text-transform' => [
					'type'         => 'react-select',
					'label'        => esc_html__( 'Text Transform', 'kirki' ),
					'is_specified' => $text_transform_field_specified,
					'choices'      => [
						'none'       => esc_html__( 'None', 'kirki' ),
						'capitalize' => esc_html__( 'Capitalize', 'kirki' ),
						'uppercase'  => esc_html__( 'Uppercase', 'kirki' ),
						'lowercase'  => esc_html__( 'Lowercase', 'kirki' ),
					],
				],
				'text-decoration' => [
					'type'         => 'react-select',
					'label'        => esc_html__( 'Text Decoration', 'kirki' ),
					'is_specified' => $text_decoration_field_specified,
					'choices'      => [
						'none'         => esc_html__( 'None', 'kirki' ),
						'underline'    => esc_html__( 'Underline', 'kirki' ),
						'line-through' => esc_html__( 'Line Through', 'kirki' ),
						'overline'     => esc_html__( 'Overline', 'kirki' ),
						'solid'        => esc_html__( 'Solid', 'kirki' ),
						'wavy'         => esc_html__( 'Wavy', 'kirki' ),
					],
				],
			];

			$this->generate_controls_group( $group, $args );
		}

		$text_align_field_specified = isset( $defaults['text-align'] );
		$color_field_specified      = isset( $defaults['color'] );

		if ( $text_align_field_specified || $color_field_specified ) {
			$group = [
				'text-align' => [
					'type'         => 'react-select',
					'label'        => esc_html__( 'Text Align', 'kirki' ),
					'is_specified' => $text_align_field_specified,
					'choices'      => [
						'initial' => esc_html__( 'Initial', 'kirki' ),
						'left'    => esc_html__( 'Left', 'kirki' ),
						'center'  => esc_html__( 'Center', 'kirki' ),
						'right'   => esc_html__( 'Right', 'kirki' ),
						'justify' => esc_html__( 'Justify', 'kirki' ),
					],
				],
				'color'      => [
					'type'         => 'react-colorful',
					'label'        => esc_html__( 'Text Color', 'kirki' ),
					'is_specified' => $color_field_specified,
					'choices'      => [
						'alpha'       => true,
						'label_style' => 'top',
					],
				],
			];

			$this->generate_controls_group( $group, $args );
		}

		$line_height_field_specified    = isset( $defaults['line-height'] );
		$letter_spacing_field_specified = isset( $defaults['letter-spacing'] );

		if ( $line_height_field_specified || $letter_spacing_field_specified ) {
			$group = [
				'line-height'    => [
					'type'         => 'dimension',
					'label'        => esc_html__( 'Line Height', 'kirki' ),
					'is_specified' => $line_height_field_specified,
					'choices'      => [
						'label_position' => 'bottom',
					],
				],
				'letter-spacing' => [
					'type'         => 'dimension',
					'label'        => esc_html__( 'Letter Spacing', 'kirki' ),
					'is_specified' => $letter_spacing_field_specified,
					'choices'      => [
						'label_position' => 'bottom',
					],
				],
			];

			$this->generate_controls_group( $group, $args );
		}

		$margin_top_field_specified    = isset( $defaults['margin-top'] );
		$margin_bottom_field_specified = isset( $defaults['margin-bottom'] );

		if ( $margin_top_field_specified || $margin_bottom_field_specified ) {
			$group = [
				'margin-top'    => [
					'type'         => 'dimension',
					'label'        => esc_html__( 'Margin Top', 'kirki' ),
					'is_specified' => $margin_top_field_specified,
					'choices'      => [
						'label_position' => 'bottom',
					],
				],
				'margin-bottom' => [
					'type'         => 'dimension',
					'label'        => esc_html__( 'Margin Bottom', 'kirki' ),
					'is_specified' => $margin_bottom_field_specified,
					'choices'      => [
						'label_position' => 'bottom',
					],
				],
			];

			$this->generate_controls_group( $group, $args );
		}

		new \Kirki\Field\Custom(
			[
				'settings'        => 'kirki_group_end_' . $args['settings'],
				'label'           => '',
				'description'     => '',
				'default'         => '<div class="kirki-typography-end"><hr></div>',
				'section'         => $args['section'],
				'active_callback' => isset( $args['active_callback'] ) ? $args['active_callback'] : '',
				'css_vars'        => [],
				'output'          => [],
			]
		);

	}

	/**
	 * Generate controls group.
	 *
	 * @param array $group The group data.
	 * @param array $args The field args.
	 */
	public function generate_controls_group( $group, $args ) {

		$total_specified = 0;
		$field_width     = 100;

		foreach ( $group as $css_prop => $control ) {
			if ( $control['is_specified'] ) {
				$total_specified++;
			}
		}

		if ( $total_specified > 1 ) {
			$field_width = floor( 100 / $total_specified );
		}

		$group_count = 0;

		foreach ( $group as $css_prop => $control ) {
			if ( $control['is_specified'] ) {
				$group_count++;

				$group_classname  = 'kirki-group-item';
				$group_classname .= 1 === $group_count ? ' kirki-group-start' : ( $group_count === $total_specified ? ' kirki-group-end' : '' );

				$control_class = str_ireplace( '-', ' ', $control['type'] );
				$control_class = ucwords( $control_class );
				$control_class = str_replace( ' ', '', $control_class );
				$control_class = '\\Kirki\\Field\\' . $control_class;

				new $control_class(
					wp_parse_args(
						[
							'label'         => isset( $control['label'] ) ? $control['label'] : '',
							'description'   => isset( $control['description'] ) ? $control['description'] : '',
							'settings'      => $args['settings'] . '[' . $css_prop . ']',
							'default'       => $args['default'][ $css_prop ],
							'wrapper_attrs' => wp_parse_args(
								[
									'data-kirki-typography-css-prop' => $css_prop,
									'kirki-typography-subcontrol-type' => $css_prop,
									'class' => '{default_class} ' . $group_classname . ' kirki-w' . $field_width,
								],
								$args['wrapper_attrs']
							),
							'input_attrs'   => $this->filter_preferred_choice_setting( 'input_attrs', $css_prop, $args ),
							'choices'       => ( isset( $control['choices'] ) ? $control['choices'] : [] ),
							'css_vars'      => [],
							'output'        => [],
						],
						$args
					)
				);

			}
		}

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

					$value['variant'] = (string) $val;

					if ( isset( $value['font-style'] ) && 'italic' === $value['font-style'] ) {
						$value['variant'] = ( '400' !== $val || 400 !== $val ) ? $value['variant'] . 'italic' : 'italic';
					}

					break;

				case 'variant':
					// Use 'regular' instead of 400 for font-variant.
					$value['variant'] = ( 400 === $val || '400' === $val ) ? 'regular' : $val;

					// Get font-weight from variant.
					$value['font-weight'] = filter_var( $value['variant'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
					$value['font-weight'] = ( 'regular' === $value['variant'] || 'italic' === $value['variant'] ) ? '400' : (string) absint( $value['font-weight'] );

					// Get font-style from variant.
					if ( ! isset( $value['font-style'] ) ) {
						$value['font-style'] = ( false === strpos( $value['variant'], 'italic' ) ) ? 'normal' : 'italic';
					}
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
					if ( ! in_array( $val, [ '', 'none', 'underline', 'overline', 'line-through', 'solid', 'wavy', 'initial', 'inherit' ], true ) ) {
						$value['text-transform'] = '';
					}
					break;

				case 'color':
					$value['color'] = '' === $value['color'] ? '' : \Kirki\Field\ReactColorful::sanitize( $value['color'] );
					break;

				default:
					$value[ $key ] = sanitize_text_field( $value[ $key ] );
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
	public function enqueue_control_scripts() {

		wp_enqueue_style( 'kirki-control-typography', \Kirki\URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/control.css' ), [], '1.0' );

		wp_enqueue_script( 'kirki-control-typography', \Kirki\URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/control.js' ), [], '1.0', true );

		wp_localize_script( 'kirki-control-typography', 'kirkiTypographyControls', self::$typography_controls );

		wp_localize_script(
			'kirki-control-typography',
			'kirkiFontWeights',
			[
				'100' => esc_html__( '100 - Thin', 'kirki' ),
				'200' => esc_html__( '200 - Extra Light, Ultra Light', 'kirki' ),
				'300' => esc_html__( '300 - Light', 'kirki' ),
				'400' => esc_html__( '400 - Normal, Book, Regular', 'kirki' ),
				'500' => esc_html__( '500 - Medium', 'kirki' ),
				'600' => esc_html__( '600 - Semi Bold, Demi Bold', 'kirki' ),
				'700' => esc_html__( '700 - Bold', 'kirki' ),
				'800' => esc_html__( '800 - Extra Bold, Ultra Bold', 'kirki' ),
				'900' => esc_html__( '900 - Black, Heavy', 'kirki' ),
			]
		);

		if ( ! self::$gfonts_var_added ) {
			$google = new GoogleFonts();
			wp_localize_script( 'kirki-control-typography', 'kirkiGoogleFonts', $google->get_array() );
			self::$gfonts_var_added = true;
		}

	}

	/**
	 * Enqueue scripts for customize_preview_init.
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function enqueue_preview_scripts() {

		wp_enqueue_script( 'kirki-preview-typography', \Kirki\URL::get_from_path( dirname( dirname( __DIR__ ) ) . '/dist/preview.js' ), [ 'wp-hooks' ], '1.0', true );

	}

	/**
	 * Prefer control specific value over field value
	 *
	 * @access public
	 * @since 4.0
	 * @param $setting
	 * @param $choice
	 * @param $args
	 *
	 * @return string
	 */
	public function filter_preferred_choice_setting( $setting, $choice, $args ) {

		// Fail early
		if ( ! isset( $args[ $setting ] ) ) {
			return '';
		}

		// If a specific field for the choice is set
		if ( isset( $args[ $setting ][ $choice ] ) ) {
			return $args[ $setting ][ $choice ];
		}

		// Unset input_attrs of all other choices
		foreach ( $args['choices'] as $id => $set ) {
			if ( $id !== $choice && isset( $args[ $setting ][ $id ] ) ) {
				unset( $args[ $setting ][ $id ] );
			} elseif ( ! isset( $args[ $setting ][ $id ] ) ) {
				$args[ $setting ] = '';
			}
		}

		return $args[ $setting ];

	}

	/**
	 * Adds a custom output class for typography fields.
	 *
	 * @access public
	 * @since 1.0
	 * @param array $classnames The array of classnames.
	 * @return array
	 */
	public function output_control_classnames( $classnames ) {

		$classnames['kirki-typography'] = '\Kirki\Field\CSS\Typography';
		return $classnames;

	}

	/**
	 * Override parent method. No need to register any setting.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function add_setting( $wp_customize ) {}

	/**
	 * Override the parent method. No need for a control.
	 *
	 * @access public
	 * @since 0.1
	 * @param WP_Customize_Manager $wp_customize The customizer instance.
	 * @return void
	 */
	public function add_control( $wp_customize ) {}

}
