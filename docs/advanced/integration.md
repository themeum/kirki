---
layout: docs
title: Integrating Kirki
edit: docs/advanced/integration.md
---

There are currently 2 ways to include Kirki in a theme:

* By recommending its installation
	* Using a custom setting in the customizer
	* Using [TGMPA](http://tgmpluginactivation.com/)
* By including a copy of the plugin files in your theme.

There are plans to add a dependencies manager in WordPress core but this is still under discussion so for the time being the best way to include Kirki is by using a custom setting in your customizer or using TGMPA.

This way your users will always have the latest version of the plugin, including all improvements and bugfixes that they would otherwise not get if the plugin files were included in your theme.

<ul class="tabs" data-tabs id="integration-methods">
	<li class="tabs-title is-active"><a href="#default" aria-selected="true">Customizer Setting (recommended)</a></li>
	<li class="tabs-title"><a href="#tgmpa">Using TGMPA</a></li>
	<li class="tabs-title"><a href="#embedding">Embedding in the theme</a></li>
</ul>

<div class="tabs-content" data-tabs-content="integration-methods">
	<div class="tabs-panel is-active" id="default">
		<h3>Using a custom setting in the customizer (recommended)</h3>
		<p>This method requires you to add a few lines of code in your theme that will create a custom section and a custom control.</p>
		<p>When the user visits the customizer, if they don't have Kirki installed they will see a button prompting them to install it.</p>
		<p>You can configure the description and add whatever you want so that it suits your use-case.</p>
		<p>Please visit the <a href="https://github.com/aristath/kirki-helpers" target="_blank">Kirki Helpers</a> repository for detailed instructions.</p>
		<p>If you are starting a new theme, we recommend you start using our <a href="https://github.com/aristath/_s" target="_blank">fork of the _s theme</a> as a starting point for your project, as this has already been implemented for you there.</p>
	</div>
	<div class="tabs-panel" id="tgmpa">
		<h3>Using TGMPA</h3>
		<p>For instructions on how to use TGMPA, please <a href="http://tgmpluginactivation.com/" target="_blank">visit the TGMPA site</a> and recommend your users to install Kirki from <a href="https://wordpress.org/plugins/kirki" target="_blank">wordpress.org</a>.</p>
	</div>
	<div class="tabs-panel" id="embedding">
		<h3>Embedding in your theme</h3>
		<p>Though not recommended, in some cases we understand that you may need to instead include it as a library in your theme/plugin.</p>
		<p>In order to properly do that, please follow the instructions below:</p>
		<ul>
			<li>Copy the plugin folder in your theme (for example in <code>{theme_folder}/includes/kirki</code>).</li>
			<li>Include the main plugin file in your theme's functions.php file:
				<pre>include_once( dirname( __FILE__ ) . '/includes/kirki/kirki.php' );</pre>
			</li>
		</ul>
		<p>Kirki will auto-detect that it's embedded in a theme and the URLs & paths will automatically be adjusted.</p>
		<p>If for some reason the URLs are not properly detected in your setup, you can add the following code in your theme:</p>


<pre>
if ( ! function_exists( 'my_theme_kirki_update_url' ) ) {
    function my_theme_kirki_update_url( $config ) {
        $config['url_path'] = get_stylesheet_directory_uri() . '/inc/kirki/';
        return $config;
    }
}
add_filter( 'kirki/config', 'my_theme_kirki_update_url' );
</pre>

	</div>
</div>
