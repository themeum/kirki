<?php

class Kirki_Customize_Control extends WP_Customize_Control {
	public $type;
	public $description;
	public $mode;
	public $subtitle;

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
	}

	public function description() { ?>
		<?php if ( isset( $this->description ) && '' != $this->description ) : ?>
			<a href="#" class="button tooltip hint--left" data-hint="<?php echo strip_tags( esc_html( $this->description ) ); ?>">?</a>
		<?php endif;
	}

	public function subtitle() { ?>
		<?php if ( '' != $this->subtitle ) : ?>
			<div class="customizer-subtitle"><?php echo $this->subtitle; ?></div>
		<?php endif;
	}
}
