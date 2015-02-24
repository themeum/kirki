<?php

class Kirki_Customize_Checkbox_Control extends Kirki_Customize_Control {

	public function __construct( $manager, $id, $args = array() ) {
		$this->type = 'checkbox';
		$this->mode = ( ! isset( $this->mode ) || empty( $this->mode ) ) ? 'checkbox' : $this->mode;
		parent::__construct( $manager, $id, $args );
	}

	public function render_content() { ?>
		<?php $display = ( 'switch' == $this->mode || 'toggle' == $this->mode ) ? ' style="display: none;"' : ''; ?>
		<label class="customizer-checkbox">
			<?php if ( 'switch' == $this->mode || 'toggle' == $this->mode ) : ?><div class="switch-info"><?php endif; ?>
			<input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" id="<?php echo $this->id . esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?><?php echo $display; ?> />
			<?php if ( 'switch' == $this->mode || 'toggle' == $this->mode ) : ?></div><?php endif; ?>
			<strong><?php echo esc_html( $this->label ); ?></strong>
			<?php if ( 'switch' == $this->mode || 'toggle' == $this->mode ) : ?>
				<?php $classes = ( esc_attr( $this->value() ) ) ? ' On' : ' Off'; ?>
				<?php $classes .= 'toggle' == $this->mode ? ' Round' : ''; ?>
				<div class="Switch <?php echo $classes; ?>">
					<div class="Toggle"></div>
					<?php if ( 'toggle' != $this->mode ) : ?>
						<span class="On"><?php _e( 'ON', 'kirki' ); ?></span>
						<span class="Off"><?php _e( 'OFF', 'kirki' ); ?></span>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php $this->description(); ?>
			<?php $this->subtitle(); ?>
		</label>
		<?php
	}
}
