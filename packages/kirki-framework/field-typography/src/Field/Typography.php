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
use Kirki;
use Kirki\URL;
use Kirki\GoogleFonts;
use Kirki\Module\Webfonts\Fonts;

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
	 * Extra logic for the field.
	 *
	 * Adds all sub-fields.
	 *
	 * @access public
	 * @param array $args The arguments of the field.
	 */
	public function init( $args = [] ) {

		self::$typography_controls[] = $args['settings'];

		$config_id = isset( $args['kirki_config'] ) ? $args['kirki_config'] : 'global';

		$this->add_sub_fields( $config_id, $args );

		add_action( 'customize_controls_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Add sub-fields.
	 *
	 * @access private
	 * @since 1.0
	 * @param string $config_id The config-ID.
	 * @param array  $args      The field arguments.
	 * @return void
	 */
	private function add_sub_fields( $config_id, $args ) {

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

			$standard_fonts = Fonts::get_standard_fonts();
			$std_fonts      = [];
			foreach ( $standard_fonts as $font ) {
				$std_fonts[ $font['stack'] ] = $font['label'];
			}

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
							'standard' => [
								esc_html__( 'Standard Fonts', 'kirki' ),
								$std_fonts,
							],
							'google'   => [
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
							'100' => '<span class="indicator" title="' . esc_html__( '100 - Thin', 'kirki' ) . '"><span class="sublabel">100</span></span>',
							'200' => '<span class="indicator" title="' . esc_html__( '200 - Extra Light, Ultra Light', 'kirki' ) . '"><span class="sublabel">200</span></span>',
							'300' => '<span class="indicator" title="' . esc_html__( '300 - Light', 'kirki' ) . '"><span class="sublabel">300</span></span>',
							'400' => '<span class="indicator" title="' . esc_html__( '400 - Normal, Book, Regular', 'kirki' ) . '"><span class="sublabel">400</span></span>',
							'500' => '<span class="indicator" title="' . esc_html__( '500 - Medium', 'kirki' ) . '"><span class="sublabel">500</span></span>',
							'600' => '<span class="indicator" title="' . esc_html__( '600 - Semi Bold, Demi Bold', 'kirki' ) . '"><span class="sublabel">600</span></span>',
							'700' => '<span class="indicator" title="' . esc_html__( '700 - Bold', 'kirki' ) . '"><span class="sublabel">700</span></span>',
							'800' => '<span class="indicator" title="' . esc_html__( '800 - Extra Bold, Ultra Bold', 'kirki' ) . '"><span class="sublabel">800</span></span>',
							'900' => '<span class="indicator" title="' . esc_html__( '900 - Black, Heavy', 'kirki' ) . '"><span class="sublabel">900</span></span>',
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
							'normal' => '<span class="dashicons dashicons-no-alt"></span><span class="screen-reader-text">' . esc_html__( 'Normal', 'kirki' ) . '</span>',
							'italic' => '<span class="dashicons dashicons-editor-italic"></span><span class="screen-reader-text">' . esc_html__( 'Italic', 'kirki' ) . '</span>',
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

		if ( isset( $args['default']['text-decoration'] ) ) {
			$args['wrapper_atts']['kirki-typography-subcontrol-type'] = 'text-decoration';
			Kirki::add_field(
				$config_id,
				wp_parse_args(
					[
						'label'       => esc_html__( 'Text Decoration', 'kirki' ),
						'description' => '',
						'type'        => 'radio-buttonset',
						'settings'    => $args['settings'] . '[text-decoration]',
						'default'     => $args['default']['text-decoration'],
						'choices'     => [
							''          => '<span class="dashicons dashicons-no-alt"></span><span class="screen-reader-text">' . esc_html__( 'Inherit', 'kirki' ) . '</span>',
							'underline' => '<span class="dashicons dashicons-editor-underline"></span><span class="screen-reader-text">' . esc_html__( 'Underline', 'kirki' ) . '</span>',
						],
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
						'type'        => 'radio-buttonset',
						'settings'    => $args['settings'] . '[text-transform]',
						'default'     => $args['default']['text-transform'],
						'choices'     => [
							''           => '<span title="' . esc_html__( 'None', 'kirki' ) . '"><span class="dashicons dashicons-no-alt"><span class="screen-reader-text">' . esc_html__( 'None', 'kirki' ) . '</span></span>',
							'capitalize' => '<span title="' . esc_html__( 'Capitalize', 'kirki' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 24 24" width="24" height="24"><g clip-path="url(#_clipPath_6mY59hWt2X6wMJkW0bF8bQ3uzZwcpH2O)"><clipPath id="_clipPath_zFrweGjD0u7iDCfkr4sg6tiHFLf3CNfH"><rect x="0.5" y="0.5" width="23" height="23" transform="matrix(1,0,0,1,0,0)" fill="rgb(255,255,255)"/></clipPath><g clip-path="url(#_clipPath_zFrweGjD0u7iDCfkr4sg6tiHFLf3CNfH)"><g><path d=" M 10.52 17.941 L 9.552 15.067 L 4.515 15.067 L 3.556 17.941 L 0.5 17.941 L 5.693 3.994 L 8.355 3.994 L 13.576 17.941 L 10.52 17.941 Z  M 7.024 7.519 L 5.289 12.739 L 8.777 12.739 L 7.024 7.519 Z  M 23.5 17.941 L 20.702 17.941 L 20.702 17.941 Q 20.511 17.568 20.424 17.012 L 20.424 17.012 L 20.424 17.012 Q 19.418 18.132 17.81 18.132 L 17.81 18.132 L 17.81 18.132 Q 16.286 18.132 15.286 17.251 L 15.286 17.251 L 15.286 17.251 Q 14.284 16.37 14.284 15.029 L 14.284 15.029 L 14.284 15.029 Q 14.284 13.381 15.506 12.5 L 15.506 12.5 L 15.506 12.5 Q 16.728 11.618 19.036 11.61 L 19.036 11.61 L 20.309 11.61 L 20.309 11.016 L 20.309 11.016 Q 20.309 10.297 19.941 9.867 L 19.941 9.867 L 19.941 9.867 Q 19.572 9.435 18.776 9.435 L 18.776 9.435 L 18.776 9.435 Q 18.077 9.435 17.681 9.77 L 17.681 9.77 L 17.681 9.77 Q 17.283 10.105 17.283 10.689 L 17.283 10.689 L 14.514 10.689 L 14.514 10.689 Q 14.514 9.789 15.07 9.023 L 15.07 9.023 L 15.07 9.023 Q 15.625 8.257 16.641 7.821 L 16.641 7.821 L 16.641 7.821 Q 17.657 7.385 18.921 7.385 L 18.921 7.385 L 18.921 7.385 Q 20.836 7.385 21.961 8.348 L 21.961 8.348 L 21.961 8.348 Q 23.088 9.31 23.088 11.053 L 23.088 11.053 L 23.088 15.546 L 23.088 15.546 Q 23.096 17.021 23.5 17.778 L 23.5 17.778 L 23.5 17.941 Z  M 18.413 16.015 L 18.413 16.015 L 18.413 16.015 Q 19.026 16.015 19.543 15.742 L 19.543 15.742 L 19.543 15.742 Q 20.06 15.47 20.309 15.009 L 20.309 15.009 L 20.309 13.228 L 19.275 13.228 L 19.275 13.228 Q 17.196 13.228 17.063 14.664 L 17.063 14.664 L 17.053 14.828 L 17.053 14.828 Q 17.053 15.345 17.417 15.68 L 17.417 15.68 L 17.417 15.68 Q 17.78 16.015 18.413 16.015 Z " fill="rgb(0,0,0)"/></g></g></g></svg><span class="screen-reader-text">' . esc_html__( 'Capitalize', 'kirki' ) . '</span></span>',
							'uppercase'  => '<span title="' . esc_html__( 'Uppercase', 'kirki' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 24 24" width="24" height="24"><g clip-path="url(#_clipPath_hCczLZ7PvaZ0P2xWKjUWS6vKnewKF4MY)"><clipPath id="_clipPath_aPpwGwqOQs4HQfvKjxFrZNwoYdDKQbJb"><rect x="0" y="0" width="24" height="24" transform="matrix(1,0,0,1,0,0)" fill="rgb(255,255,255)"/></clipPath><g clip-path="url(#_clipPath_aPpwGwqOQs4HQfvKjxFrZNwoYdDKQbJb)"><g><path d=" M 9.271 18.105 L 8.423 15.589 L 4.013 15.589 L 3.174 18.105 L 0.5 18.105 L 5.045 5.895 L 7.375 5.895 L 11.946 18.105 L 9.271 18.105 Z  M 6.21 8.981 L 4.692 13.552 L 7.745 13.552 L 6.21 8.981 Z  M 20.826 18.105 L 19.978 15.589 L 15.568 15.589 L 14.729 18.105 L 12.054 18.105 L 16.6 5.895 L 18.931 5.895 L 23.5 18.105 L 20.826 18.105 Z  M 17.765 8.981 L 16.247 13.552 L 19.3 13.552 L 17.765 8.981 Z " fill="rgb(0,0,0)"/></g></g></g></svg><span class="screen-reader-text">' . esc_html__( 'Uppercase', 'kirki' ) . '</span></span>',
							'lowercase'  => '<span title="' . esc_html__( 'Lowercase', 'kirki' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 24 24" width="24" height="24"><g clip-path="url(#_clipPath_CLUYXygJXnDYLCChOsSJ6haUMut687yO)"><clipPath id="_clipPath_fyOJFEyPm9SH7cciRPiBMpoNFA1I5PXi"><rect x="0" y="0" width="24" height="24" transform="matrix(1,0,0,1,0,0)" fill="rgb(255,255,255)"/></clipPath><g clip-path="url(#_clipPath_fyOJFEyPm9SH7cciRPiBMpoNFA1I5PXi)"><g><path d=" M 11.241 18.04 L 7.98 18.04 L 7.98 18.04 Q 7.757 17.605 7.657 16.957 L 7.657 16.957 L 7.657 16.957 Q 6.484 18.264 4.609 18.264 L 4.609 18.264 L 4.609 18.264 Q 2.834 18.264 1.666 17.236 L 1.666 17.236 L 1.666 17.236 Q 0.5 16.209 0.5 14.646 L 0.5 14.646 L 0.5 14.646 Q 0.5 12.725 1.924 11.698 L 1.924 11.698 L 1.924 11.698 Q 3.347 10.672 6.038 10.661 L 6.038 10.661 L 7.523 10.661 L 7.523 9.968 L 7.523 9.968 Q 7.523 9.13 7.094 8.629 L 7.094 8.629 L 7.094 8.629 Q 6.662 8.126 5.736 8.126 L 5.736 8.126 L 5.736 8.126 Q 4.921 8.126 4.457 8.516 L 4.457 8.516 L 4.457 8.516 Q 3.995 8.907 3.995 9.588 L 3.995 9.588 L 0.768 9.588 L 0.768 9.588 Q 0.768 8.539 1.416 7.646 L 1.416 7.646 L 1.416 7.646 Q 2.063 6.752 3.247 6.244 L 3.247 6.244 L 3.247 6.244 Q 4.43 5.736 5.905 5.736 L 5.905 5.736 L 5.905 5.736 Q 8.137 5.736 9.449 6.858 L 9.449 6.858 L 9.449 6.858 Q 10.76 7.98 10.76 10.012 L 10.76 10.012 L 10.76 15.249 L 10.76 15.249 Q 10.772 16.968 11.241 17.85 L 11.241 17.85 L 11.241 18.04 Z  M 5.312 15.796 L 5.312 15.796 L 5.312 15.796 Q 6.027 15.796 6.63 15.477 L 6.63 15.477 L 6.63 15.477 Q 7.232 15.16 7.523 14.623 L 7.523 14.623 L 7.523 12.547 L 6.318 12.547 L 6.318 12.547 Q 3.894 12.547 3.737 14.221 L 3.737 14.221 L 3.727 14.412 L 3.727 14.412 Q 3.727 15.015 4.15 15.405 L 4.15 15.405 L 4.15 15.405 Q 4.575 15.796 5.312 15.796 Z  M 23.5 18.04 L 20.24 18.04 L 20.24 18.04 Q 20.016 17.605 19.917 16.957 L 19.917 16.957 L 19.917 16.957 Q 18.744 18.264 16.867 18.264 L 16.867 18.264 L 16.867 18.264 Q 15.093 18.264 13.926 17.236 L 13.926 17.236 L 13.926 17.236 Q 12.759 16.209 12.759 14.646 L 12.759 14.646 L 12.759 14.646 Q 12.759 12.725 14.182 11.698 L 14.182 11.698 L 14.182 11.698 Q 15.606 10.672 18.296 10.661 L 18.296 10.661 L 19.783 10.661 L 19.783 9.968 L 19.783 9.968 Q 19.783 9.13 19.351 8.629 L 19.351 8.629 L 19.351 8.629 Q 18.922 8.126 17.996 8.126 L 17.996 8.126 L 17.996 8.126 Q 17.181 8.126 16.717 8.516 L 16.717 8.516 L 16.717 8.516 Q 16.253 8.907 16.253 9.588 L 16.253 9.588 L 13.027 9.588 L 13.027 9.588 Q 13.027 8.539 13.674 7.646 L 13.674 7.646 L 13.674 7.646 Q 14.323 6.752 15.505 6.244 L 15.505 6.244 L 15.505 6.244 Q 16.689 5.736 18.162 5.736 L 18.162 5.736 L 18.162 5.736 Q 20.397 5.736 21.708 6.858 L 21.708 6.858 L 21.708 6.858 Q 23.02 7.98 23.02 10.012 L 23.02 10.012 L 23.02 15.249 L 23.02 15.249 Q 23.031 16.968 23.5 17.85 L 23.5 17.85 L 23.5 18.04 Z  M 17.571 15.796 L 17.571 15.796 L 17.571 15.796 Q 18.287 15.796 18.889 15.477 L 18.889 15.477 L 18.889 15.477 Q 19.492 15.16 19.783 14.623 L 19.783 14.623 L 19.783 12.547 L 18.576 12.547 L 18.576 12.547 Q 16.153 12.547 15.997 14.221 L 15.997 14.221 L 15.985 14.412 L 15.985 14.412 Q 15.985 15.015 16.41 15.405 L 16.41 15.405 L 16.41 15.405 Q 16.835 15.796 17.571 15.796 Z " fill="rgb(0,0,0)"/></g></g></g></svg><span class="screen-reader-text">' . esc_html__( 'Lowercase', 'kirki' ) . '</span></span>',
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
							''        => '<span class="dashicons dashicons-no-alt"><span class="screen-reader-text">' . esc_html__( 'None', 'kirki' ) . '</span>',
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
			$google = new GoogleFonts();
			wp_localize_script( 'kirki-typography', 'kirkiGoogleFonts', $google->get_array() );
			self::$gfonts_var_added = true;
		}
	}
}
