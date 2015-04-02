<?php

namespace Kirki\Scripts;

use Kirki\Scripts\Customizer\Dependencies;
use Kirki\Scripts\Customizer\Branding;
use Kirki\Scripts\Customizer\PostMessage;
use Kirki\Scripts\Customizer\Required;
use Kirki\Scripts\Customizer\Tooltips;
use Kirki\Scripts\Customizer\Select2;
use Kirki\Scripts\Frontend\GoogleFonts;

class ScriptRegistry {

	public function __construct() {

		$dependencies = new Dependencies();
		$branding     = new Branding();
		$postmessage  = new PostMessage();
		$required     = new Required();
		$tooltips     = new Tooltips();
		$select2      = new Select2();
		$googlefonts  = new GoogleFonts();

	}

}
