<?php

namespace Kirki\Controls;

class TabControl extends \WP_Customize_Control {

	public $mode = null;

	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-tabs' );
	}

	public function render_content() { ?>
		<label>
			<?php if ( ! empty( $this->label ) ) : ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif;
			if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php endif; ?>
		</label>
		<div class="kirki-tabs-wrapper">
			<ul>
				<?php foreach ( $this->choices as $choice ) : ?>
					<li><a href="#tab-<?php echo $this->id; ?>-<?php echo sanitize_key( $choice['label'] ); ?>"><?php echo esc_textarea( $choice['label'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<?php foreach ( $this->choices as $choice ) : ?>
				<div id="tab-<?php echo $this->id; ?>-<?php echo sanitize_key( $choice['label'] ); ?>"></div>
			<?php endforeach; ?>
		<?php
	}
}
