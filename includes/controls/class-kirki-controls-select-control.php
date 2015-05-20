<?php

/**
 * Creates a new select2 control.
 */
class Kirki_Controls_Select_Control extends Kirki_Control {

	public $type = 'select2';

	protected function render() {
		$id = str_replace( '[', '-', str_replace( ']', '', $this->id ) );
		$class = 'customize-control customize-control-' . $this->type; ?>
		<li id="customize-control-<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li>
	<?php }

	public function render_content() { 
		$id = str_replace( '[', '-', str_replace( ']', '', $this->id ) ); ?>
		
		<label>
			<?php 
			if ( $this->label ) { ?>
				<span class="customize-control-title"><?php echo $this->label; ?></span>
			<?php } 
			if ( $this->description ) { ?>
				<span class="description customize-control-description"><?php echo $this->description; ?></span>
			<?php } ?>
			
			<select data-customize-setting-link="<?php echo esc_attr( $id ); ?>" class="select2">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>

		<script>
		jQuery(document).ready(function($) {
	  	$('.select2').select2();
	  });
		</script>
		<?php 
		}

}
