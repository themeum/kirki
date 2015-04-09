<?php

namespace Kirki\Controls;

use Kirki\Control;

class CustomControl extends Control {

	public $type = 'custom';

	public function render_content() { ?>
		<label>
			<?php $this->title(); ?>
			<?php
				/**
				 * The value is defined by the developer in the field configuration as the default value.
				 * There is no user input on this field, it's a raw HTML/JS field and we don not sanitize it.
				 * Do not be alarmed, this is not a security issue.
				 * In order for someone to be able to change this they would have to have access to your filesystem.
				 * If that happens, they can change whatever they want anyways. This field is not a concern.
				 */
			?>
			<?php echo $this->value(); ?>
		</label>
		<?php

	}

}
