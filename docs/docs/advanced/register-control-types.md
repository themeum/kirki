---
layout: default
title: Register new Control Type
subtitle: Make custom controls available to Kirki
mainMaxWidth: 50rem;
bodyClasses: page
---

Though you can create new control types for the WordPress Customizer using its API, you may want to register your control with Kirki as well so you can define fields using that control type directly.

To do that you can write something like the example below:

```php
<?php
add_action( 'customize_register', function( $wp_customize ) {
	/**
	 * The custom control class
	 */
	class Kirki_Controls_Notice_Control extends WP_Customize_Control {
		public $type = 'notice';
		public function render_content() { ?>
			THE CONTROL CONTENT HERE
			<?php
		}
	}
	// Register our custom control with Kirki
	add_filter( 'kirki/control_types', function( $controls ) {
		$controls['notice'] = 'Kirki_Controls_Notice_Control';
		return $controls;
	} );

} );
?>
```

You can then create new fields using your own control simply by defining `notice` as your field's [`type`](https://aristath.github.io/kirki/docs/arguments/type).
