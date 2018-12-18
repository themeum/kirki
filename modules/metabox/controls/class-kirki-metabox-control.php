<?php
class Kirki_Metabox_Control
{
	public $field;
	public $kirki_field;
	public $initialized;
	
	public function __construct( $config_id, $field )
	{
		$this->field = $field;
		// Early exit if 'type' is not defined.
		if ( ! isset( $field['type'] ) ) {
			return;
		}

		// If the field is font-awesome, enqueue the icons on the frontend.
		if ( class_exists( 'Kirki_Modules_CSS' ) && ( 'fontawesome' === $field['type'] || 'kirki-fontawesome' === $field['type'] ) ) {
			Kirki_Modules_CSS::add_fontawesome_script();
		}
		
		//$this->field['theme_value'] = $this->get_theme_value();
		//$this->field['meta_value'] = $this->get_meta_value();
		
		$this->init();
	}
	
	public function init()
	{
		
	}
	
	public function field_label()
	{
		if ( isset ( $this->field['label'] ) ) {
		?><h3><?php echo $this->field['label'] ?></h3><?php
		}
		if ( isset ( $this->field['description'] ) ) {
		?><p><?php echo $this->field['description'] ?></p><?php
		}
	}

	public function get_field_id()
	{
		return esc_attr ( 'kirki_mb_' . $this->field['settings'] );
	}

	public function field_link ( $id_suffix = '' )
	{
		$id = $this->get_field_id ( $this->field );
		echo 'name="' . $id . '" id="' . $id . $id_suffix . '" kirki-metabox-link';
	}
	
	public function args()
	{
		echo 'kirki-args="' . esc_attr ( json_encode( $this->field ) ) . '"';
	}

	public function get_setting_id()
	{
		return $this->field['settings'];
	}

	public function setting_id()
	{
		$id = $this->get_setting_id();
		echo 'data-setting="' . $id . '"';
	}

	public function get_theme_value ( $encode=false )
	{
		$val = Kirki_Values::get_value ( $this->field['settings'] );

		if ( is_object ( $val ) && $encode_objs )
			$val = json_encode ( $val );
		return $val;
	}
	
	public function get_meta_value( $post, $default='' )
	{
		$val =  get_post_meta ( $post->ID, 'kirki_mb_'.$this->get_setting_id(), true );
		
		if ( empty ( $val ) )
			return $default;
		else if ( is_array( $val ) )
			return $val;
		else
		{
			$decoded_val = json_decode ( $val, true );
			if ( $decoded_val )
				return $decoded_val;
			return $val;
		}
	}
	
	public function render( $post )
	{
		
	}
}