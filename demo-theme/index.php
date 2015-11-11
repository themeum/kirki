<?php
/**
 * This is just a demo to showcase the settings of the Kirki plugin.
 * It is not an actual theme and it will not show any content.
 *
 * Please visit the WordPress Customizer
 */

if ( ! class_exists( 'Kirki' ) ) {
	die( esc_attr__( 'Please enable the Kirki Plugin in order to see the demo in the Customizer', 'kirki-demo' ) );
}
global $wp_customize;
if ( ! $wp_customize ) {
	wp_redirect( trailingslashit( admin_url() ) . 'customize.php' );
	exit;
}
?>
<head>
	<?php wp_head(); ?>
	<style>
		<?php
		/**
		 * Code control demo
		 */
		echo get_theme_mod( 'code_demo', 'body{ background: #fff; }' );
		?>
	</style>
</head>

<body>
	<div class="wrapper checkbox-controls">
		<?php
		/**
		 * Checkbox control demo
		 */
		?>
		<div class="checkbox demo">
			<div style="color:#fff;<?php echo ( get_theme_mod( 'checkbox_demo', true ) ) ? 'background-color:#4CAF50;' : 'background-color:#D32F2F;"'; ?>">
				<h4><?php _e( 'checkbox:', 'kirki-demo' ); ?></h4>
				<?php printf( esc_attr__( 'Checkbox is %s', 'kirki-demo' ), ( get_theme_mod( 'checkbox_demo', true ) ) ? esc_attr__( 'ON', 'kirki-demo' ) : esc_attr__( 'OFF', 'kirki-demo' ) ); ?>
			</div>
			<div style="color:#fff;<?php echo ( get_theme_mod( 'switch_demo', true ) ) ? 'background-color:#4CAF50;' : 'background-color:#D32F2F;"'; ?>">
				<h4><?php _e( 'switch:', 'kirki-demo' ); ?></h4>
				<?php printf( esc_attr__( 'Switch is %s', 'kirki-demo' ), ( get_theme_mod( 'switch_demo', true ) ) ? esc_attr__( 'ON', 'kirki-demo' ) : esc_attr__( 'OFF', 'kirki-demo' ) ); ?>
			</div>
			<div style="color:#fff;<?php echo ( get_theme_mod( 'toggle_demo', true ) ) ? 'background-color:#4CAF50;' : 'background-color:#D32F2F;"'; ?>">
				<h4><?php _e( 'toggle:', 'kirki-demo' ); ?></h4>
				<?php printf( esc_attr__( 'Toggle is %s', 'kirki-demo' ), ( get_theme_mod( 'toggle_demo', true ) ) ? esc_attr__( 'ON', 'kirki-demo' ) : esc_attr__( 'OFF', 'kirki-demo' ) ); ?>
			</div>
		</div>
		<?php
		/**
		 * Multicheck control demo
		 */
		 ?>
		<div class="multicheck demo">
			<h4><?php _e( 'multicheck:', 'kirki-demo' ); ?></h4>
			<?php $multicheck_value = get_theme_mod( 'multicheck_demo', array( 'option-1', 'option-3' ) ); ?>
			<?php if ( ! empty( $multicheck_value ) ) : ?>
				<ul>
					<?php foreach ( $multicheck_value as $checked_value ) : ?>
						<li><?php echo $checked_value; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<p><?php printf( esc_attr__( 'Total number of options selected: %s', 'kirki-demo' ), intval( count( $multicheck_value ) ) ); ?></p>
			<p>
				<?php if ( in_array( 'option-2', $multicheck_value ) ) : ?>
					<?php _e( 'Option 2 is selected', 'kirki-demo' ); ?>
				<?php else : ?>
					<?php _e( 'Option 2 is not selected', 'kirki-demo' ); ?>
				<?php endif; ?>
			</p>
		</div>
		<?php
		/**
		 * Sortable control demo
		 */
		 ?>
		<div class="sortable demo">
			<h4><?php _e( 'sortable:', 'kirki-demo' ); ?></h4>
			<?php $sortable_value = maybe_unserialize( get_theme_mod( 'sortable_demo', array( 'option-1', 'option-3' ) ) ); ?>
			<?php if ( ! empty( $sortable_value ) ) : ?>
				<ul>
					<?php foreach ( $sortable_value as $checked_value ) : ?>
						<li><?php echo $checked_value; ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<p><?php printf( esc_attr__( 'Total number of options selected: %s', 'kirki-demo' ), intval( count( $sortable_value ) ) ); ?></p>
			<p>
				<?php if ( in_array( 'option-2', $sortable_value ) ) : ?>
					<?php _e( 'Option 2 is selected', 'kirki-demo' ); ?>
				<?php else : ?>
					<?php _e( 'Option 2 is not selected', 'kirki-demo' ); ?>
				<?php endif; ?>
			</p>
		</div>
	</div>
	<div class="wrapper text-controls">
		<?php
		/**
		 * Text control demo
		 */
		 ?>
		<div class="text demo">
			<h4><?php _e( 'text:', 'kirki-demo' ); ?></h4>
			<?php echo esc_html( get_theme_mod( 'text_demo', esc_attr__( 'This text is entered in the "text" control.', 'kirki-demo' ) ) ); ?>
		</div>
		<?php
		/**
		 * Textarea control demo
		 */
		 ?>
		<div class="textarea demo">
			<h4><?php _e( 'textarea:', 'kirki-demo' ); ?></h4>
			<?php echo esc_html( get_theme_mod( 'textarea_demo', esc_attr__( 'This text is entered in the "textarea" control.', 'kirki-demo' ) ) ); ?>
		</div>
		<?php
		/**
		 * Editor control demo
		 */
		 ?>
		<div class="editor demo">
			<h4><?php _e( 'editor:', 'kirki-demo' ); ?></h4>
			<?php echo html_entity_decode( get_theme_mod( 'editor_demo', esc_attr__( 'This text is entered in the "editor" control.', 'kirki-demo' ) ) ); ?>
		</div>
		<div class="code demo invalid">
			<p><?php _e( 'The "code" control has its CSS applied directly to the page for the purposes of this demo. In order to see the changes, please write some valid CSS and you will see the changes take effect immediately.', 'kirki-demo' ); ?></p>
		</div>
	</div>
	<div class="wrapper color-controls">
		<?php
		/**
		 * Color & Color-Alpha control demos
		 */
		?>
		<div class="color demo">
			<h4><?php _e( 'color & color-alpha:', 'kirki-demo' ); ?></h4>
			<p><?php _e( 'Change the "color" control to make the color of this text change', 'kirki-demo' ); ?></p>
			<p><?php _e( 'Change the "color-alpha" control to make the background of this text change' ); ?></p>
		</div>
	</div>
	<div class="wrapper numeric-controls">
		<?php
		/**
		 * Number control demo
		 */
		?>
		<div class="number demo">
			<h4><?php _e( 'number', 'kirki-demo' ); ?></h4>
			<p><?php printf( esc_attr__( 'Number selected: %s', 'kirki-demo' ), intval( get_theme_mod( 'number_demo', '10' ) ) ); ?></p>
			<p><?php _e( 'The border-radius of this colored div will change depending on the value you select', 'kirki-demo' ); ?></p>
			<div class="number-demo-border-radius"></div>
		</div>
		<?php
		/**
		 * slider control demo
		 */
		?>
		<div class="slider demo">
			<h4><?php _e( 'slider', 'kirki-demo' ); ?></h4>
			<p><?php printf( esc_attr__( 'Number selected: %s', 'kirki-demo' ), intval( get_theme_mod( 'slider_demo', '10' ) ) ); ?></p>
			<p><?php _e( 'The border-radius of this colored div will change depending on the value you select', 'kirki-demo' ); ?></p>
			<div class="slider-demo-border-radius"></div>
		</div>
	</div>
	<div class="wrapper radio-controls">
		<?php
		/**
		 * Radio & radio-buttonset controls demo
		 */
		?>
		<div class="radio demo">
			<h4><?php _e( 'radio:', 'kirki-demo' ); ?></h4>
			<?php printf( esc_attr__( 'selected option: %s', 'kirki-demo' ), '<span style="color:' . esc_attr( get_theme_mod( 'radio_demo', 'red' ) ) . '">' . esc_attr( get_theme_mod( 'radio_demo', 'red' ) ) . '</span>' ); ?>
			<h4><?php _e( 'radio-buttonset:', 'kirki-demo' ); ?></h4>
			<?php printf( esc_attr__( 'selected option: %s', 'kirki-demo' ), '<span style="color:' . esc_attr( get_theme_mod( 'radio_buttonset_demo', 'green' ) ) . '">' . esc_attr( get_theme_mod( 'radio_buttonset_demo', 'green' ) ) . '</span>' ); ?>
		</div>
		<?php
		/**
		 * Radio-image control demo
		 */
		?>
		<div class="radio-image demo">
			<h4><?php _e( 'radio-image:', 'kirki-demo' ); ?></h4>
			<p><?php _e( 'The word below is aligned according to your selection', 'kirki-demo' ); ?></p>
			<p style="text-align:<?php echo esc_attr( get_theme_mod( 'radio_image_demo', 'left' ) ); ?>">
				<?php echo esc_attr( get_theme_mod( 'radio_image_demo', 'left' ) ); ?>
			</p>
		</div>
		<?php
		/**
		 * Palette control demo
		 */
		?>
		<div class="palette demo">
			<h4><?php _e( 'palette:', 'kirki-demo' ); ?></h4>
			<?php $selected_palette = get_theme_mod( 'palette_demo', 'light' ); ?>
			<p><?php printf( esc_attr__( 'selected palette: %s', 'kirki-demo' ), esc_attr( $selected_palette ) ); ?></p>
			<?php $all_palettes = kirki_demo_get_palettes(); ?>
			<?php foreach ( $all_palettes[$selected_palette] as $color ) : ?>
				<div class="palette-demo-color" style="background-color:<?php echo esc_attr( $color ); ?>"></div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="wrapper select-controls">
		<?php
		/**
		 * Select controls demo
		 */
		?>
		<div class="select demo">
			<h4><?php _e( 'select:', 'kirki-demo' ); ?></h4>
			<?php printf( esc_attr__( 'selected option: %s', 'kirki-demo' ), '<span style="color:' . esc_attr( get_theme_mod( 'select_demo', 'red' ) ) . '">' . esc_attr( get_theme_mod( 'select_demo', 'red' ) ) . '</span>' ); ?>
		</div>
		<div class="select-multiple demo">
			<h4><?php _e( 'Multiple Select:', 'kirki-demo' ); ?></h4>
			<?php $value = get_theme_mod( 'select_multiple_demo', array( 'option-1' ) ); ?>
			<?php if ( ! empty( $value ) ) : ?>
				<ul>
					<?php foreach ( get_theme_mod( 'select_multiple_demo', array( 'option-1' ) ) as $option ) : ?>
						<li><?php echo esc_attr( $option ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
	<div class="wrapper composite-controls">
		<div class="dimension demo invalid">
			<p><?php _e( 'The "dimension" control has its value applied directly as the body\'s width', 'kirki-demo' ); ?></p>
		</div>
		<div class="typography demo invalid">
			<p><?php _e( 'The "typography" control has its values applied directly as the body\'s typography ooptions. By changing its value you will see the changes applied to all text on this page.', 'kirki-demo' ); ?></p>
		</div>
		<?php
		/**
		 * Repeater control demo
		 */
		?>
		<div class="repeater demo">
			<h4><?php _e( 'repeater:', 'kirki-demo' ); ?></h4>
			<?php $repeater_value = get_theme_mod( 'repeater_demo', array(
				array(
					'link_text' => esc_attr__( 'Kirki Site', 'kirki-demo' ),
					'link_url'  => 'https://kirki.org',
				),
				array(
					'link_text' => esc_attr__( 'Kirki Repository', 'kirki-demo' ),
					'link_url'  => 'https://github.com/aristath/kirki',
				),
			) ); ?>
			<ul>
			<?php foreach ( $repeater_value as $row ) : ?>
				<li>
					<?php if ( isset( $row['link_url'] ) && ! empty( $row['link_url'] ) ) : ?><a href="<?php echo esc_url_raw( $row['link_url'] ); ?>"><?php endif; ?>
						<?php echo esc_html( $row['link_text'] ); ?>
					<?php if ( isset( $row['link_url'] ) && ! empty( $row['link_url'] ) ) : ?></a><?php endif; ?>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</body>

<?php
wp_footer();
// ALWAYS ommit the closing PHP tag at the end of PHP files in WordPress.
// See http://aristeides.com/blog/wordpress-headers-already-sent-by/ for details
