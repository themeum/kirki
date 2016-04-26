<?php
/**
 * Customizer Control: dashicons.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.4
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Dashicons_Control' ) ) {

	/**
	 * Dashicons control (modified radio).
	 */
	class Kirki_Controls_Dashicons_Control extends Kirki_Customize_Control {

		/**
		 * The control type.
		 *
		 * @access public
		 * @var string
		 */
		public $type = 'kirki-dashicons';

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @access public
		 */
		public function to_json() {
			parent::to_json();
			$this->json['icons'] = Kirki_Helper::get_dashicons();
		}

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @access public
		 */
		public function enqueue() {
			wp_enqueue_script( 'kirki-dashicons' );
		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see Kirki_Customize_Control::to_json()}.
		 *
		 * @see WP_Customize_Control::print_template()
		 *
		 * @access protected
		 */
		protected function content_template() {
			?>
			<# if ( data.tooltip ) { #>
				<a href="#" class="tooltip hint--left" data-hint="{{ data.tooltip }}"><span class='dashicons dashicons-info'></span></a>
			<# } #>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
			<div class="icons-wrapper">
				<h4>Admin Menu</h4>
				<# for ( key in data.icons['admin-menu'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['admin-menu'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['admin-menu'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['admin-menu'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['admin-menu'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['admin-menu'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Welcome Screen</h4>
				<# for ( key in data.icons['welcome-screen'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['welcome-screen'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['welcome-screen'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['welcome-screen'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['welcome-screen'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['welcome-screen'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Post Formats</h4>
				<# for ( key in data.icons['post-formats'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['post-formats'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['post-formats'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['post-formats'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['post-formats'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['post-formats'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Media</h4>
				<# for ( key in data.icons['media'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['media'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['media'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['media'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['media'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['media'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Image Editing</h4>
				<# for ( key in data.icons['image-editing'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['image-editing'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['image-editing'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['image-editing'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['image-editing'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['image-editing'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>TinyMCE</h4>
				<# for ( key in data.icons['tinymce'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['tinymce'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['tinymce'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['tinymce'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['tinymce'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['tinymce'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Posts</h4>
				<# for ( key in data.icons['posts'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['posts'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['posts'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['posts'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['posts'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['posts'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Sorting</h4>
				<# for ( key in data.icons['sorting'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['sorting'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['sorting'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['sorting'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['sorting'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['sorting'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Social</h4>
				<# for ( key in data.icons['social'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['social'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['social'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['social'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['social'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['social'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>WordPress</h4>
				<# for ( key in data.icons['wordpress_org'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['wordpress_org'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['wordpress_org'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['wordpress_org'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['wordpress_org'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['wordpress_org'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Products</h4>
				<# for ( key in data.icons['products'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['products'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['products'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['products'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['products'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['products'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Taxonomies</h4>
				<# for ( key in data.icons['taxonomies'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['taxonomies'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['taxonomies'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['taxonomies'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['taxonomies'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['taxonomies'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Widgets</h4>
				<# for ( key in data.icons['widgets'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['widgets'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['widgets'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['widgets'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['widgets'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['widgets'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Notifications</h4>
				<# for ( key in data.icons['notifications'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['notifications'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['notifications'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['notifications'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['notifications'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['notifications'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
				<h4>Misc</h4>
				<# for ( key in data.icons['misc'] ) { #>
					<input class="dashicons-select" type="radio" value="{{ data.icons['misc'][ key ] }}" name="_customize-dashicons-radio-{{ data.id }}" id="{{ data.id }}{{ data.icons['misc'][ key ] }}" {{{ data.link }}}<# if ( data.value === data.icons['misc'][ key ] ) { #> checked="checked"<# } #>>
						<label for="{{ data.id }}{{ data.icons['misc'][ key ] }}">
							<span class="dashicons dashicons-{{ data.icons['misc'][ key ] }}"></span>
						</label>
					</input>
				<# } #>
			</div>
			<?php
		}
	}
}
