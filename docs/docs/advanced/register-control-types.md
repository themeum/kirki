---
layout: default
title: Register new Control Type
subtitle: Make custom controls available to Kirki
mainMaxWidth: 55rem;
bodyClasses: page
---

Though you can create new control types for the WordPress Customizer using its API, you may want to register your control with Kirki instead so you can define fields using that control type directly.

To do that you can write something like the example below:

```php
<?php
add_action( 'customize_register', function( $wp_customize ) {
	/**
	 * The custom control class
	 */
	class Kirki_Controls_Notice_Control extends Kirki_Control_Base {
		public $type = 'notice';
		public function render_content() { ?>
			THE CONTROL CONTENT HERE
			<?php
		}
	}
	// Register our custom control with Kirki
	add_filter( 'kirki_control_types', function( $controls ) {
		$controls['notice'] = 'Kirki_Controls_Notice_Control';
		return $controls;
	} );

} );
?>
```

You can then create new fields using your own control simply by defining `notice` as your field's [`type`](https://kirki.org/docs/arguments/type).

By extending `Kirki_Control_Base` instead of WordPress' core `WP_Customize_Control` you give your custom control access to all Kirki's arguments such as <a href="https://kirki.org/docs/arguments/output">output</a>.
