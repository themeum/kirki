<?php
/**
 * Embeds webfonts in styles.
 *
 * @package     Kirki
 * @category    Core
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2017, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       3.0
 */

/**
 * Manages the way Google Fonts are enqueued.
 */
final class Kirki_Modules_Webfonts_Embed {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 3.0
	 */
	public function __construct( $config_id, $webfonts, $googlefonts ) {
		add_filter( "kirki/{$config_id}/dynamic_css", array( $this, 'embed_css' ) );
	}
}
