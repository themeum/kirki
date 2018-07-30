<?php
class Kirki_Metabox_Switch extends Kirki_Metabox_Radio_Buttonset
{
	public function __construct ( $config_id, $field )
	{
		parent::__construct ( $config_id, $field );
		
		$this->field['choices'] = [
			'0' => __( 'On', 'kirki' ),
			'1' => __( 'Off', 'kirki' ),
		];
	}
}