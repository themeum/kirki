<?php

if ( ! class_exists( 'Kirki_Customizer_Scripts_Loading' ) ) {

	class Kirki_Customizer_Scripts_Loading {

		public function __construct() {
			global $wp_customize;
			if ( ! $wp_customize ) {
				return;
			}
			/**
			 * Allow disabling the custom loader using the kirki/config filter
			 */
			$config = apply_filters( 'kirki/config', array() );
			if ( isset( $config['disable_loader'] ) && true === $config['disable_loader'] ) {
				return;
			}
			/**
			 * Add the "loading" icon
			 */
			add_action( 'wp_footer', array( $this, 'add_loader_to_footer' ) );
			add_action( 'wp_head', array( $this, 'add_loader_styles_to_header' ), 99 );
			$this->remove_default_loading_styles();
		}

		/**
		 * Adds a custom "loading" div $ its styles when changes are made to the customizer.
		 */
		public function add_loader_to_footer() { ?>
			<div class="kirki-customizer-loading-wrapper">
				<span class="kirki-customizer-loading"></span>
			</div>
			<?php
		}

		public function add_loader_styles_to_header() { ?>
			<style>
				body.wp-customizer-unloading {
					opacity: 1;
					cursor: progress !important;
					-webkit-transition: none;
					transition: none;
				}
				body.wp-customizer-unloading * {
					pointer-events: none !important;
				}
				.kirki-customizer-loading-wrapper {
					width: 100%;
					height: 100%;
					position: fixed;
					top: 0;
					left: 0;
					background: rgba(255,255,255,0.83);
					z-index: 999999;
					display: none;
					opacity: 0;
					-webkit-transition: opacity 0.5s;
					transition: opacity 0.5s;
					background-image: url("<?php echo Kirki::$url; ?>/assets/images/kirki-logo.svg");
					background-repeat: no-repeat;
					background-position: center center;
				}
				body.wp-customizer-unloading .kirki-customizer-loading-wrapper {
					display: block;
					opacity: 1;
				}
				.kirki-customizer-loading-wrapper .kirki-customizer-loading {
					position: absolute;
					width: 60px;
					height: 60px;
					top: 50%;
					left: 50%;
					margin: -30px;
					background-color: rgba(0,0,0,.83);
					border-radius: 100%;
					-webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
					animation: sk-scaleout 1.0s infinite ease-in-out;
				}
				@-webkit-keyframes sk-scaleout {
					0% { -webkit-transform: scale(0) }
					100% {
						-webkit-transform: scale(1.0);
						opacity: 0;
					}
				}
				@keyframes sk-scaleout {
					0% {
						-webkit-transform: scale(0);
						transform: scale(0);
					}
					100% {
						-webkit-transform: scale(1.0);
						transform: scale(1.0);
						opacity: 0;
					}
				}
			</style>
			<?php
		}

		public function remove_default_loading_styles() {
			global $wp_customize;
			remove_action( 'wp_head', array( $wp_customize, 'customize_preview_loading_style' ) );
		}

	}

}
