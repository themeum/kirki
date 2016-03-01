<?php

class Kirki_Panels_Expanded_Panel extends WP_Customize_Panel {

	public $type = 'kirki-expanded';

	protected function render_template() {
		?>
		<li id="accordion-panel-{{ data.id }}" class="control-section control-panel control-panel-{{ data.type }}">
			<ul class="accordion-sub-container control-panel-content"></ul>
		</li>
		<?php
	}

	protected function content_template() {
		?>
		<li class="panel-meta customize-info accordion-section <# if ( ! data.description ) { #> cannot-expand<# } #>">
			<div class="accordion-section-title">
				<strong class="panel-title">{{ data.title }}</strong>
			</div>
			<# if ( data.description ) { #>
				<div class="description customize-panel-description">
					{{{ data.description }}}
				</div>
			<# } #>
		</li>
		<?php
	}
}
