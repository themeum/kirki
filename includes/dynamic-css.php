<?php

if ( ! class_exists( 'Kirki' ) ) {
	die( 'File can\'t be accessed directly' );
}

echo Kirki_Styles_Frontend::loop_controls();
