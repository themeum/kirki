wp.customize.controlConstructor['kirki-color'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function( control ) {
		var picker,
			clear;

		control = control || this;
		picker  = control.container.find( '.kirki-color-control' );

		control.choices = control.choices || {};
		control.choices = ( _.isEmpty( control.choices ) && control.params.choices ) ? control.params.choices : control.choices;

		control.choices.palettes = control.choices.palettes || jQuery( picker ).attr( 'data-palette' );
		if ( 'string' === typeof control.choices.palettes ) {
			try {
				control.choices.palettes = JSON.parse( control.choices.palettes );
			} catch ( e ) {
				control.choices.palettes = [ '#000000', '#ffffff', '#f78da7', '#cf2e2e', '#ff6900', '#fcb900', '#7bdcb5', '#00d084', '#8ed1fc', '#0693e3', '#eeeeee', '#abb8c3', '#546E7A', '#313131' ];
			}
		}

		// If we have defined any extra choices, make sure they are passed-on to Iris.
		if ( ! _.isEmpty( control.choices ) ) {
			picker.wpColorPicker( control.choices );
		}

		// Tweaks to make the "clear" buttons work.
		setTimeout( function() {
			clear = control.container.find( '.wp-picker-clear' );
			if ( clear.length ) {
				clear.click( function() {
					control.setting.set( '' );
				} );
			}
		}, 200 );

		// Saves our settings to the WP API
		picker.wpColorPicker( {
			change: function() {

				// Small hack: the picker needs a small delay
				setTimeout( function() {
					control.setting.set( picker.val() );
				}, 20 );
			}
		} );
	}
} );
