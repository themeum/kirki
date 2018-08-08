<?php
include_once ABSPATH . 'wp-includes/class-wp-customize-control.php';
if ( !class_exists ( 'Kirki_Metabox' ) )
{
	class Kirki_Metabox
	{
		public static $panels = [];
		public static $sections = [];
		public static $fields = [];

		public $controls;

		public function __construct()
		{
			global $pagenow;
			//Do not allow additional loading if we're not in customizer to avoid conflictions.
			if (( $pagenow == 'customize.php' )) {
				return;
			}
			
			add_action ( 'add_meta_boxes', array ( $this, 'init' ), 999 );
			add_action ( 'save_post', array ( $this, 'save' ), 10, 3 );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'enqueue_scripts' ), 10 );
			//add_action ( 'admin_enqueue_scripts', array ( $this, 'enqueue_control_scripts' ), 999 );

			add_filter ( 'kirki_values_get_value', array ( $this, 'get_metabox_value' ), 999, 2);

			$this->controls = [
				'background' => [
					'classname' => 'Kirki_Metabox_Background',
					'filename' => 'class-kirki-metabox-background.php',
					'jsfile' => 'controls/js/background.js'
				],
				'generic' => [
					'classname' => 'Kirki_Metabox_Generic',
					'filename' => 'class-kirki-metabox-generic.php'
				],
				'radio-buttonset' => [
					'classname' => 'Kirki_Metabox_Radio_Buttonset',
					'filename' => 'class-kirki-metabox-radio-buttonset.php'
				],
				'switch' => [
					'classname' => 'Kirki_Metabox_Switch',
					'filename' => 'class-kirki-metabox-switch.php'
				],
				'slider' => [
					'classname' => 'Kirki_Metabox_Slider',
					'filename' => 'class-kirki-metabox-slider.php',
					'jsfile' => 'controls/js/slider.js'
				],
				'color' => [
					'classname' => 'Kirki_Metabox_Color',
					'filename' => 'class-kirki-metabox-color.php',
					'jsfile' => 'controls/js/color.js'
				],
				'select' => [
					'classname' => 'Kirki_Metabox_Select',
					'filename' => 'class-kirki-metabox-select.php',
					'jsfile' => 'controls/js/select.js'
				],
				'upload' => [
					'classname' => 'Kirki_Metabox_Upload',
					'filename' => 'class-kirki-metabox-upload.php',
					'jsfile' => 'controls/js/upload.js'
				],
				'link' => [
					'classname' => 'Kirki_Metabox_Link',
					'filename' => 'class-kirki-metabox-link.php',
					'jsfile' => 'controls/js/link.js'
				],
				'multicolor' => [
					'classname' => 'Kirki_Metabox_Multi_Color',
					'filename' => 'class-kirki-metabox-multicolor.php',
					'jsfile' => 'controls/js/multicolor.js'
				],
				'sortable' => [
					'classname' => 'Kirki_Metabox_Sortable',
					'filename' => 'class-kirki-metabox-sortable.php',
					'jsfile' => 'controls/js/sortable.js'
				],
				'multicheck' => [
					'classname' => 'Kirki_Metabox_Multi_Check',
					'filename' => 'class-kirki-metabox-multicheck.php',
					'jsfile' => 'controls/js/multicheck.js'
				],
				/*'typography' => [
					'classname' => 'Kirki_Metabox_Typography',
					'filename' => 'class-kirki-metabox-typography.php',
					'jsfile' => 'controls/js/typography.js'
				],*/
				'border' => [
					'classname' => 'Kirki_Metabox_Border',
					'filename' => 'class-kirki-metabox-border.php',
					'jsfile' => 'controls/js/border.js'
				],
				// 'spacing2' => [
				// 	'classname' => 'Kirki_Metabox_Spacing',
				// 	'filename' => 'class-kirki-metabox-spacing.php',
				// 	'jsfile' => 'controls/js/spacing.js'
				// ],
			];

			apply_filters ( 'kiki_metabox_controls', $this->controls );

			// require ( 'controls/class-kirki-metabox-control.php' );
			// foreach ( $this->controls as $control )
			// {
			// 	require ( 'controls/' . $control['filename'] );
			// }
		}

		public function init()
		{
			add_meta_box (
				'page-options',
				__( 'Page Options', 'kirki' ),
				array ( $this, 'tabs' ),
				array( 'post', 'page' ),
				'normal', // add this line
				'high',
				null
			);
		}

		public function enqueue_control_scripts()
		{
			wp_localize_script( 'kirki_mb_image', 'kirki_mb_image', [
				'upload_image' => esc_attr__ ( 'Select or Upload Media', 'kirki' ),
				'upload_text' => esc_attr__ ( 'Use this media', 'kirki' )
			 ] );
			// Enqueued script with localized data.
			wp_enqueue_script( 'kirki_mb_image' );

			// The Kirki plugin URL.
			$kirki_url = trailingslashit( Kirki::$url );
			$metabox_uri = $kirki_url . '../kirki-metabox';
			foreach ( $this->controls as $id => $control )
			{
				if ( !isset ( $control['jsfile'] ) )
					continue;

					wp_enqueue_script ( 'kirki_mb_' . $id, $metabox_uri . '/' . $control['jsfile'],
					 array ( 'jquery',
						'wp-color-picker-alpha',
						'jquery-ui-button',
						'jquery-ui-datepicker'
					), null );
			}
		}

		public function enqueue_scripts()
		{
			$control_base = new Kirki_Control_Base(null,null);
			$control_base->enqueue();
			
			wp_enqueue_script( 'kirki-script-metabox' );
			// The Kirki plugin URL.
			$kirki_url = trailingslashit( Kirki::$url );
			$metabox_uri = $kirki_url . '../kirki-metabox/';

			//Enqueue Kirki Metabox styles
			wp_enqueue_style ( 'kirki-metabox-styles', $metabox_uri . 'kirki-metabox.css' );

			//Register our front-end metabox handler.
			wp_register_script ( 'kirki-metabox',
				$metabox_uri . 'kirki-metabox.js',
				array(
					'jquery',
					'selectWoo'
				), '1.0', true );
			
			// //Load our translations.
			// wp_localize_script(
			// 	'kirki-metabox',
			// 	'kirkiL10n',
			// 	array(
			// 		'isScriptDebug'        => ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ),
			// 		'noFileSelected'       => esc_attr__( 'No File Selected', 'kirki' ),
			// 		'remove'               => esc_attr__( 'Remove', 'kirki' ),
			// 		'default'              => esc_attr__( 'Default', 'kirki' ),
			// 		'selectFile'           => esc_attr__( 'Select File', 'kirki' ),
			// 		'standardFonts'        => esc_attr__( 'Standard Fonts', 'kirki' ),
			// 		'googleFonts'          => esc_attr__( 'Google Fonts', 'kirki' ),
			// 		'defaultCSSValues'     => esc_attr__( 'CSS Defaults', 'kirki' ),
			// 		'defaultBrowserFamily' => esc_attr__( 'Default Browser Font-Family', 'kirki' ),
			// 		'selectImage' => esc_attr__( 'Select Image', 'kirki' ),
			// 		'useThisMedia' => esc_attr__( 'Use this media', 'kirki' )
			// 	)
			// );
			
			//Load our core script.
			wp_enqueue_script( 'kirki-metabox' );
		}

		public function save ( $post_id, $post, $update )
		{
			$css = '';
			foreach ( self::$sections as $sect_id => $section )
			{
				foreach ( $section['fields'] as $field )
				{
					$id = 'kirki_mb_' . $field['settings'];
					if ( isset ( $_POST[$id] ) )
					{
						$val = $_POST[$id];
						if ( $val == 0 || $val )
						{
							update_post_meta ( $post_id, $id, $_POST[$id] );
						}
						else
						{
							delete_post_meta ( $post_id, $id );
						}
					}
					else
					{
						delete_post_meta ( $post_id, $id );
					}
				}
			}
			// ob_start();
			// include ( get_template_directory() . '/includes/admin/theme-options/styles-config.php' );
			// $css .= ob_get_clean();
			$css .= $this->generate_css();
			file_put_contents ( get_template_directory() . '/assets/css/post-' . $post->ID . '.css', $css );
		}

		public function generate_css()
		{
			$css     = array();
			$configs = Kirki::$config;
			foreach ( $configs as $config_id => $args ) {
				// Get the CSS we want to write.
				$css[ $config_id ] = apply_filters( "kirki_{$config_id}_dynamic_css", Kirki_Modules_CSS::loop_controls( $config_id ) );
			}
			$css = implode( $css, '' );
			return $css;
			return;
			$configs = Kirki::$config;
			$css = '';
			foreach ( $configs as $config_id => $args ) {
				if ( true === $args['disable_output'] ) {
					continue;
				}
				$styles = Kirki_Modules_CSS::loop_controls( $config_id );
				$styles = apply_filters( "kirki_{$config_id}_dynamic_css", $styles );
				$styles = str_replace( '<=', '&lt;=', $styles );
				$styles = wp_kses_post( $styles );
				$css .= strip_tags( str_replace( '&gt;', '>', $styles ) );
				$css .= "\n";
			}
			return $css;
		}

		public function get_metabox_value ( $value, $field_id )
		{
			global $post;
			if ( !$post || is_customize_preview() )
				return $value;
			$post_meta = get_post_meta ( $post->ID, 'kirki_mb_'.$field_id, true );
			if ( empty ( $post_meta ) && $post_meta !== false )
				return $value;
			$post_meta_unseralized = json_decode ( $post_meta, true );
				if ( $post_meta_unseralized )
					return $post_meta_unseralized;
			return $post_meta;
		}

		function priority_cmp ( $a, $b )
		{
			if ( isset ( $a['priority'], $b['priority'] ) )
			{
				return $a['priority'] < $b['priority'] ? -1 : 1;
			}
			else if ( isset ( $a['priority'] ) && !isset ( $b['priority'] ) )
			{
				return -1;
			}
			else if ( !isset ( $a['priority'] ) && isset ( $b['priority'] ) )
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		public function tabs()
		{
			global $post;
			
			usort ( self::$panels, array( $this, 'priority_cmp' ) );
			usort ( self::$sections, array( $this, 'priority_cmp' ) );
			usort ( self::$fields, array( $this, 'priority_cmp' ) );
			?>
			<div class="kirki-multi-tabs">
				<div class="tabs-container">
					<div class="header">
						<div class="back-outer">
							<button type="button" class="back-button hidden"></button>
						</div>
						<div class="breadcrumbs-outer">
							<h3 class="breadcrumbs-title"></h3>
							<ul class="breadcrumbs"></ul>
						</div>
					</div>
					<div class="tabs-outer">
						<div class="tabs active" type="panel" id="kirki-tab-home">
							<?php foreach ( self::$panels as $id => $val ):
								if ( $val['parent'] != NULL)
									continue;
								$args = $val['args'];
							?>
							<a class="tab-trigger" href="#<?php echo $id ?>" tab-title="<?php echo $args['title']; ?>"><span><?php echo $args['title']?></span></a>
							<?php endforeach; ?>
						</div>
						<?php foreach ( self::$panels as $panel_id => $panel_val ):
							if ( empty ( $panel_val['sections'] ) )
								continue;
							$args = $val['args'];
						?>
						<div class="tabs" type="section" id="<?php echo $panel_id ?>">
							<?php foreach ( $panel_val['sections'] as $section ): ?>
							<a class="tab-trigger" href="#<?php echo $section['id'] ?>" tab-title="<?php echo $section['title']; ?>"><span><?php echo $section['title']; ?></span></a>
							<?php endforeach; ?>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="tab-content-outer">
					<div class="tab-content kirki-default active">
						<h3>Select your option sections from the left and edit them here.</h3>
					</div>
					<?php foreach ( self::$sections as $id => $val ):
						$args = $val['args'];
					?>
					<div class="tab-content" href="#<?php echo $id ?>">
						<?php
						foreach ( $val['fields'] as $sect_id => $field )
						{
							$type = $field['type'];

							if ( in_array ( $type, ['text', 'password', 'textarea', 'checkbox', 'radio'] ) )
							{
								$type = 'generic';
							}
							else if ( $type == 'image' )
							{
								$type = 'upload';
							}

							if ( array_key_exists ( $type, $this->controls ) )
							{
								$classname = $this->controls[$type]['classname'];

								$control = new $classname ( null/*$field['config_id']*/, $field );
								$control->render ( $post );
							}
							else
							{
								echo 'MISSING: ' . $type . '<br>';
							}
						}
						?>
					</div>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
			// echo '<pre>';
			// var_dump ( self::$panels );
			// var_dump ( self::$sections );
			// var_dump ( self::$fields );
			// echo '</pre>';
		}

		public function tabs_dev()
		{
			global $post;
			?>
			<div class="kirki-multi-tabs">
				<div class="tabs-container">
					<div class="header">
						<div class="back-outer">
							<button type="button" class="back-button hidden"></button>
						</div>
						<div class="breadcrumbs-outer">
							<h3 class="breadcrumbs-title"></h3>
							<ul class="breadcrumbs"></ul>
						</div>
					</div>
					<div class="tabs-outer">
						<div class="tabs active" type="panel" id="kirki-tab-home" title="<?php echo _e ( 'Home', 'kirki' )?>">
							<a class="tab-trigger" href="#panel1">Panel 1</a>
							<a class="tab-trigger" href="#panel_standalone">Panel 2</a>
						</div>
						<div class="tabs" type="panel" id="panel1" title="<?php echo _e( 'Panel 1', 'kirki' ) ?>">
							<a class="tab-trigger" href="#panel2">Sub Panel 1</a>
							<a class="tab-trigger" href="#panel3">Sub Panel 2</a>
						</div>
						<div class="tabs" type="section" id="panel2" parent="panel1" title="<?php echo _e( 'Sub Panel 2', 'kirki' ) ?>">
							<a class="tab-trigger" href="#sect4">Section 1 ( Sub Panel 1 )</a>
							<a class="tab-trigger" href="#sect5">Section 2 ( Sub Panel 1 )</a>
						</div>
						<div class="tabs" type="section" id="panel3" parent="panel2" title="<?php echo _e( 'Panel 3', 'kirki' ) ?>">
							<a class="tab-trigger" href="#sect6">Section 1 ( Sub Panel 2 )</a>
							<a class="tab-trigger" href="#sect7">Section 2 ( Sub Panel 2 )</a>
						</div>
						<!--Standalone-->
						<div class="tabs" type="section" id="panel_standalone" title="<?php echo _e( 'Standalone', 'kirki' ) ?>">
							<a class="tab-trigger" href="#sect1">Section 1 (Standalone)</a>
							<a class="tab-trigger" href="#sect2">Section 2 (Standalone)</a>
							<a class="tab-trigger" href="#sect3">Section 3 (Standalone)</a>
						</div>
					</div>
				</div>
				<div class="tab-content-outer">
					<div class="tab-content kirki-default active">
						<h3>Select your option sections from the left and edit them here.</h3>
					</div>
					<div class="tab-content" href="#sect1">
						1
					</div>
					<div class="tab-content" href="#sect2">
						2
					</div>
					<div class="tab-content" href="#sect3">
						3
					</div>

					<div class="tab-content" href="#sect4">
						4
					</div>
					<div class="tab-content" href="#sect5">
						5
					</div>

					<div class="tab-content" href="#sect6">
						6
					</div>
					<div class="tab-content" href="#sect7">
						7
					</div>
				</div>
			</div>
			<?php
		}

		public static function add_panel ( $id, $args )
		{
			assert ( !empty ( $id ) );
			assert ( isset ( $args['title'] ) );

			$priority = 10;

			if ( isset ( $args['priority'] ) )
				$priority = intval ( $args['priority'] );

			self::$panels[$id] = [
				'parent' => isset ( $args['panel'] ) ? $args['panel'] : null,
				'priority' => $priority,
				'args' => $args,
				'sections' => []
			];
		}

		public static function add_section ( $id, $args )
		{
			assert ( !empty ( $id ) );
			assert ( isset ( $args['title'] ) );
			$priority = 10;
			if ( isset ( $args['priority'] ) )
				$priority = intval ( $args['priority'] );

			$panel = $args['panel'];

			self::$panels[$panel]['sections'][] = [
				'id' => $id,
				'title' => $args['title']
			];
			self::$sections[$id] = [
				'parent' => isset ( $args['panel'] ) ? $args['panel'] : $id,
				'priority' => $priority,
				'args' => $args,
				'fields' => []
			];
		}

		public static function add_field ( $config_id, $args )
		{
			//assert ( $config_id );
			//assert ( isset ( $args['title'] ) );
			$priority = 10;
			if ( isset ( $args['priority'] ) )
				$priority = intval ( $args['priority'] );
			$args['priority'] = $priority;
			if ( isset ( self::$sections[$args['section']] ) )
			{
				self::$sections[$args['section']]['fields'][] = $args;
			}
		}
		
		public static function current_uri($base_path)
		{
			$path = wp_normalize_path( dirname( $base_path ) );
			$content_url = untrailingslashit( dirname( dirname( get_stylesheet_directory_uri() ) ) );
			$content_dir = wp_normalize_path( untrailingslashit( WP_CONTENT_DIR ) );
			$url = str_replace( $content_dir, $content_url, wp_normalize_path( $path ) );
			$url = set_url_scheme( $url );
			return $url;
		}
	}
}
$kirki_metabox = new Kirki_Metabox();