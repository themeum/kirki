<?php

class Kirki_Sections_Expanded_Section extends WP_Customize_Section {

	public $type = 'kirki-expanded';

	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
			<ul class="accordion-section-content">
				<li class="customize-section-description-container">
					<div class="customize-section-title">
						<h3>
							{{ data.title }}
						</h3>
					</div>
					<# if ( data.description ) { #>
						<div class="description customize-section-description">
							{{{ data.description }}}
						</div>
					<# } #>
				</li>
			</ul>
		</li>
		<?php
	}
}
