<?php

namespace Kirki\Controls;

class NumberControl extends \WP_Customize_Control {

	public $type = 'number';

	public function content_template() { ?>

		<label class="customizer-text">
			<span class="customize-control-title">
				<# if ( data.label ) { #>{{ data.label }}<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{ data.description }}</span>
				<# } #>
			</span>
			<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>"/>
			<# if ( data.help ) { #>
				<a href="#" class="button tooltip hint--left" data-hint="{{ data.help }}">?</a>
			<# } #>
		</label>
		<?php
	}
}
