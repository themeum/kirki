<?php
/**
 * Dropdown Pages Control
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2016, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       2.2.8
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Kirki_Controls_Dropdown_Pages_Control' ) ) {

	class Kirki_Controls_Dropdown_Pages_Control extends Kirki_Customize_Control {

		public $type = 'dropdown-pages';

		public function enqueue() {
			wp_enqueue_script( 'kirki-dropdown-pages' );
		}

		protected function render_content() { ?>
			<?php if ( '' != $this->tooltip ) : ?>
				<a href="#" class="tooltip hint--left" data-hint="<?php echo esc_html( $this->tooltip ); ?>"><span class='dashicons dashicons-info'></span></a>
			<?php endif; ?>
			<label>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif;
				if ( ! empty( $this->description ) ) : ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>

				<?php
				$l10n = Kirki_l10n::get_strings();
				$dropdown = wp_dropdown_pages(
					array(
						'name'              => '_customize-dropdown-pages-' . $this->id,
						'echo'              => 0,
						'show_option_none'  => $l10n['select-page'],
						'option_none_value' => '0',
						'selected'          => $this->value(),
					)
				);

				// Hackily add in the data link parameter.
				$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );
				echo $dropdown;
				?>
			</label>
			<?php

		}

	}

}
