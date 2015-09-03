<?php
/**
 * sortable Customizer Control.
 *
 * @package     Kirki
 * @subpackage  Controls
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Early exit if the class already exists
if ( class_exists( 'Kirki_Controls_Sortable_Control' ) ) {
	return;
}

class Kirki_Controls_Sortable_Control extends WP_Customize_Control {

	public $type = 'sortable';

	public function enqueue() {

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_enqueue_script( 'kirki-sortable', trailingslashit( kirki_url() ).'includes/controls/sortable/kirki-sortable.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ) );
		wp_enqueue_style( 'kirki-sortable', trailingslashit( kirki_url() ).'includes/controls/sortable/style.css' );

	}


	public function render_content() {
		if ( ! is_array( $this->choices ) || ! count( $this->choices ) ) {
			return;
		}

		?>
		<label class='kirki-sortable'>
			<span class="customize-control-title">
				<?php echo esc_attr( $this->label ); ?>
				<?php if ( ! empty( $this->description ) ) : ?>
					<?php // The description has already been sanitized in the Fields class, no need to re-sanitize it. ?>
					<span class="description customize-control-description"><?php echo $this->description; ?></span>
				<?php endif; ?>
			</span>
			<?php
				$values = $this->value();
				$values = $values == '' ? array_keys( $this->choices ) : $values;
				$values = maybe_unserialize( $values );
				$this->visible_button = count( $values ) != count( $this->choices ) ? true : '';
				$visibleButton = '<i class="dashicons dashicons-visibility visibility"></i>';

				$filtered_values = array();
				foreach ( $values as $key => $value ) {
					if ( in_array( $key, $this->choices ) ) {
						$filtered_values[ $key ] = $value;
					}
				}
			?>
			<ul>
				<?php foreach ( $filtered_values as $key => $value ) : ?>
					<?php printf( "<li class='kirki-sortable-item' data-value='%s'><i class='dashicons dashicons-menu'></i>%s%s</li>", esc_attr( $value ), $visibleButton, $this->choices[ $value ] ); ?>
				<?php endforeach; ?>
				<?php $invisibleKeys = array_diff( array_keys( $this->choices ), $filtered_values ); ?>
				<?php foreach ( $invisibleKeys as $key => $value ) : ?>
					<?php printf( "<li class='kirki-sortable-item' data-value='%s'><i class='dashicons dashicons-menu'></i>%s%s</li>", esc_attr( $value ), $visibleButton, $this->choices[ $value ] ); ?>
				<?php endforeach; ?>
			</ul>
			<div style='clear: both'></div>
			<?php $values = maybe_serialize( $values ); ?>
			<input type='hidden' <?php $this->link(); ?> value='<?php echo esc_attr( $values )  ?>'/>
		</label>
		<?php
	}
}
