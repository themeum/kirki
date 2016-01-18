<?php

if ( ! class_exists( 'Kirki_Customizer_Scripts_Loading' ) ) {
	class Kirki_Customizer_Scripts_Loading extends Kirki_Customizer {
		public function __construct() {
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
			<div class="kirki-customizer-loading-wrapper"/><span class="kirki-customizer-loading"></span></div>
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
				.kirki-customizer-loading {
					position: absolute;
					top: 50%;
					left: 50%;
					margin: -35px 0 0 -35px;
					color: transparent;
					font-size: 10px;
					border-top: 0.5em solid rgba(0, 0, 0, 0.2);
					border-right: 0.5em solid rgba(0, 0, 0, 0.2);
					border-bottom: 0.5em solid #333;
					border-left: 0.5em solid rgba(0, 0, 0, 0.2);
					-webkit-animation: fusion-rotate 0.8s infinite linear;
					animation: fusion-rotate 0.8s infinite linear;
				}
				.kirki-customizer-loading .kirki-customizer-loading-text {
					position: absolute;
				}
				.no-cssanimations .kirki-customizer-loading {
					padding-left: 5px;
					padding-top: 15px;
					color: #000;
				}
				.kirki-customizer-loading,
				.kirki-customizer-loading:after {
					width: 70px;
					height: 70px;
					border-radius: 50%;
					/* Fix to make border-radius work for transparent colors */
					background-clip: padding-box;
				}
				@-webkit-keyframes fusion-rotate {
					0% {
						-webkit-transform: rotate(0deg);
						transform: rotate(0deg);
					}
					100% {
						-webkit-transform: rotate(360deg);
						transform: rotate(360deg);
					}
				}
				@keyframes fusion-rotate {
					0% {
						-webkit-transform: rotate(0deg);
						transform: rotate(0deg);
					}
					100% {
						-webkit-transform: rotate(360deg);
						transform: rotate(360deg);
					}
				}
			</style>
			<?php
		}

		public function remove_default_loading_styles() {
			remove_action( 'wp_head', array( $this->wp_customize, 'customize_preview_loading_style' ) );
		}
	}
}
