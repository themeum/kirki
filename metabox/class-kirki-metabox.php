<?php
if ( !class_exists ( 'Kirki_Metabox' ) )
{
	require_once ABSPATH . 'wp-includes/class-wp-customize-manager.php';
	require_once ABSPATH . 'wp-includes/class-wp-customize-control.php';
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
			if (( $pagenow == 'customize.php' ))
				return;
			add_action ( 'add_meta_boxes', array ( $this, 'init' ), 999 );
			add_action ( 'save_post', array ( $this, 'save' ), 10, 3 );
			
			add_action ( 'admin_enqueue_scripts', array ( $this, 'enqueue_scripts' ), 10 );
			//add_action ( 'admin_enqueue_scripts', array ( $this, 'enqueue_control_scripts' ), 999 );
			
			add_filter ( 'kirki_values_get_value', array ( $this, 'get_metabox_value' ), 999, 2);
		}
		
		public function init()
		{
			require_once ABSPATH . 'wp-includes/class-wp-customize-manager.php';
			require_once ABSPATH . 'wp-includes/class-wp-customize-control.php';
			$GLOBALS['wp_customize'] = new WP_Customize_Manager();
			$this->controls = apply_filters( 'kirki_control_types' , array() );
			
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
		
		public function enqueue_required()
		{
			// Build the suffix for the script.
			$suffix  = '';
			$suffix .= ( ! defined( 'SCRIPT_DEBUG' ) || true !== SCRIPT_DEBUG ) ? '.min' : '';

			// The Kirki plugin URL.
			$kirki_url = trailingslashit( Kirki::$url );

			// Enqueue ColorPicker.
			wp_enqueue_script( 'wp-color-picker-alpha', trailingslashit( Kirki::$url ) . 'assets/vendor/wp-color-picker-alpha/wp-color-picker-alpha.js', array( 'wp-color-picker' ), KIRKI_VERSION, true );
			wp_enqueue_style( 'wp-color-picker' );

			// Enqueue selectWoo.
			wp_enqueue_script( 'selectWoo', trailingslashit( Kirki::$url ) . 'assets/vendor/selectWoo/js/selectWoo.full.js', array( 'jquery' ), '1.0.1', true );
			wp_enqueue_style( 'selectWoo', trailingslashit( Kirki::$url ) . 'assets/vendor/selectWoo/css/selectWoo.css', array(), '1.0.1' );
			wp_enqueue_style( 'kirki-selectWoo', trailingslashit( Kirki::$url ) . 'assets/vendor/selectWoo/kirki.css', array(), KIRKI_VERSION );
			// Enqueue elementor-icons.
			wp_enqueue_style( 'elementor-icons', trailingslashit( Kirki::$url ) . 'assets/vendor/elementor-icons/css/elementor-icons.min.css', null );
			// Enqueue the script.
			// wp_enqueue_script(
			// 	'kirki-script',
			// 	"{$kirki_url}controls/js/script{$suffix}.js",
			// 	array(
			// 		'jquery',
			// 		'customize-base',
			// 		'wp-color-picker-alpha',
			// 		'selectWoo',
			// 		'jquery-ui-button',
			// 		'jquery-ui-datepicker',
			// 	),
			// 	KIRKI_VERSION,
			// 	false
			// );

			wp_localize_script(
				'kirki-script',
				'kirkiL10n',
				array(
					'isScriptDebug'        => ( defined( 'SCRIPT_DEBUG' ) && true === SCRIPT_DEBUG ),
					'noFileSelected'       => esc_attr__( 'No File Selected', 'kirki' ),
					'remove'               => esc_attr__( 'Remove', 'kirki' ),
					'default'              => esc_attr__( 'Default', 'kirki' ),
					'selectFile'           => esc_attr__( 'Select File', 'kirki' ),
					'standardFonts'        => esc_attr__( 'Standard Fonts', 'kirki' ),
					'googleFonts'          => esc_attr__( 'Google Fonts', 'kirki' ),
					'defaultCSSValues'     => esc_attr__( 'CSS Defaults', 'kirki' ),
					'defaultBrowserFamily' => esc_attr__( 'Default Browser Font-Family', 'kirki' ),
				)
			);

			$suffix = str_replace( '.min', '', $suffix );
			// Enqueue the style.
			wp_enqueue_style(
				'kirki-styles',
				"{$kirki_url}controls/css/styles{$suffix}.css",
				array(),
				KIRKI_VERSION
			);
		}
		
		public function enqueue_scripts()
		{
			global $wp_customize;
			
			$this->enqueue_required();
			
			wp_enqueue_script( 'kirki-script-metabox' );
			// The Kirki plugin URL.
			$kirki_url = trailingslashit( Kirki::$url );
			$metabox_uri = $kirki_url . 'metabox/';
			
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
			$upload_dir = wp_upload_dir();
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
							update_post_meta ( $post_id, $id, $_POST[$id] );
						else
							delete_post_meta ( $post_id, $id );
					}
					else
						delete_post_meta ( $post_id, $id );
				}
			}
			$css .= $this->generate_css();
			file_put_contents ( $upload_dir['basedir'] . '/kirki-css/post-' + $post->ID . '.css', $css );
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
			// return;
			// $configs = Kirki::$config;
			// $css = '';
			// foreach ( $configs as $config_id => $args )
			// {
			// 	if ( true === $args['disable_output'] )
			// 		continue;
			// 	$styles = Kirki_Modules_CSS::loop_controls( $config_id );
			// 	$styles = apply_filters( "kirki_{$config_id}_dynamic_css", $styles );
			// 	$styles = str_replace( '<=', '&lt;=', $styles );
			// 	$styles = wp_kses_post( $styles );
			// 	$css .= strip_tags( str_replace( '&gt;', '>', $styles ) );
			// 	$css .= "\n";
			// }
			// return $css;
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
				return $a['priority'] < $b['priority'] ? -1 : 1;
			else if ( isset ( $a['priority'] ) && !isset ( $b['priority'] ) )
				return -1;
			else if ( !isset ( $a['priority'] ) && isset ( $b['priority'] ) )
				return 1;
			else
				return 0;
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
					<div class="tab-content active" href="#<?php echo $id ?>">
						<?php
						global $wp_customize;
						$generics = array( 'text', 'password', 'textarea', 'checkbox', 'radio' );
						$skip_prefix = array( 'repeater', 'image', 'cropped_image', 'upload', 'code_editor', 'checkbox' );
						foreach ( $val['fields'] as $sect_id => $field )
						{
							$type = $field['type'];
							$class_type = $type;
							if ( in_array ( $type, $generics ) )
								$class_type = 'generic';
							if ( !in_array( $class_type, $skip_prefix ) )
								$class_type = 'kirki-' . $class_type;
							$id    = 'customize-control-' . str_replace( array( '[', ']' ), array( '-', '' ), $field['settings']);
							$class = 'customize-control customize-control-' . $class_type;
							$container_class = 'metabox-' . esc_attr( $field['settings'] );
							printf( '<li id="%s" class="%s">', $container_class, esc_attr( $class ) );
								
							if ( array_key_exists ( $class_type, $this->controls ) )
							{
								$classname = $this->controls[$class_type];
								$control = new $classname ( $wp_customize, $field['settings'], $field );
								try{
								//$control->to_json();
								}
								catch (Exception $e )
								{
								}
								$args = array(
									'label' => $control->label,
									'description' => $control->description,
									'choices' => $control->choices,
									'inputAttr' => join( ' ', $control->input_attrs ),
									'required' => $control->required,
									'data-id' => $control->id,
									//'default' => isset( $control->json['default'] ) ? $control->json['default'] : ''
								);
								$control->print_template();
								?>
								<script>
								jQuery( document ).ready( function()
								{
									var template = wp.template( 'customize-control-<?php echo $type ?>-content' ),
										container = jQuery( '#metabox-<?php echo $field['settings'] ?>' );
									args = JSON.parse( '<?php echo json_encode($args) ?>' );
									console.log ( args );
									compiled = template( args );
									console.log( {
										'template': template,
										'container': container,
										'compiled': compiled
									});
									container.html( compiled );
								});
								</script>
								<?php
							}
							else
								echo 'MISSING: ' . $type . '<br>';
							echo '</li>';
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
				self::$sections[$args['section']]['fields'][] = $args;
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