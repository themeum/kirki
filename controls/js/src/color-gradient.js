wp.customize.controlConstructor['kirki-color-gradient'] = wp.customize.kirkiDynamicControl.extend( {
	// When we're finished loading continue processing
	ready: function() {
	
		'use strict';
		
		var control = this;

		// Init the control.
		if ( ! _.isUndefined( window.kirkiControlLoader ) && _.isFunction( kirkiControlLoader ) ) {
			kirkiControlLoader( control );
		} else {
			control.initKirkiControl();
		}
	},
	
	initKirkiControl: function() {
		var control = this,
			container = control.container,
			input = jQuery( '.color-gradient-hidden-value', container ),
			color1_picker = jQuery( '.color1 .color-picker', container ),
			color2_picker = jQuery( '.color2 .color-picker', container ),
			location = jQuery( '.location input', container ),
			textInput    = control.container.find( '.slider-wrapper .value input' ),
			sliderReset  = control.container.find( '.slider-reset' ),
			locationChangeAction = ( 'postMessage' === control.setting.transport ) ? 'mousemove change' : 'change',
			direction = container.find( '.direction select' ),
			value = control.setting._value;
		if ( !value )
			value = control.params.default;
		if ( !value )
		{
			value = {
				color1: '',
				color2: '',
				location: '0%',
				direction: ''
			};
		}
		color1_picker.attr( 'data-default-color', value['color1'] )
			.data( 'default-color', value['color1'] )
			.val( value['color1'] )
			.wpColorPicker( {
				change: function(e, ui)
				{
					setTimeout(function()
					{
						save();
					}, 100 );
				}
			});
		color2_picker.attr( 'data-default-color', value['color2'] )
			.data( 'default-color', value['color2'] )
			.val( value['color2'] )
			.wpColorPicker( {
				change: function(e, ui)
				{
					setTimeout(function()
					{
						save();
					}, 100 );
				}
			});
		location.val( value['location'].replace( '%', '' ) );
		direction.val( value['direction'] );
		
		location.on( locationChangeAction, function( e )
		{
			//e.preventDefault();
			textInput.attr( 'value', location.val() );
			save();
		});
		
		textInput.on( 'input paste change', function( e ) {
			//location.val( textInput.val() ).trigger( 'change' );
		} );
		
		direction.on( 'change', function( e ) {
			save();
		});
		
		sliderReset.click( function( e ) {
			var defVal = control.params.default['location'].replace( '%', '') || 0;
			location.val( defVal );
			textInput.val( defVal );
		});
		
		function save()
		{
			var data = {
				color1: color1_picker.val(),
				color2: color2_picker.val(),
				location: location.val() + '%',
				direction: direction.val()
			};
			//console.log( data );
			input.val( JSON.stringify( data ) ).trigger( 'change' );
			control.setting.set( data );
		}
	}
} );
