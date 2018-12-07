wp.customize.controlConstructor['kirki-box-shadow'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function() {
		var control = this,
			container = control.container,
			inputs = jQuery( '.kirki-control-dimension input', container),
			color_picker = jQuery( '.color input', container ),
			value = control.setting._value;
		
		if ( !value && control.params.default )
			value = control.params.default;
		
		if ( value )
			control.fill_inputs( value );
		
		color_picker.attr( 'data-default-color', value['color'] )
			.data( 'default-color', value['color'] )
			.val( value['color'] )
			.wpColorPicker( {
				change: function(e, ui) {
					setTimeout(function(){
						control.save();
					}, 100);
				},
				clear: function (event) {
					setTimeout( function() {
						control.save();
					}, 100 );
				}
			});

		inputs.on( 'keyup change click', function() {
			var input = jQuery( this );
			var cur_val = input.val();
			var last_val = input.attr( 'last-val' );
			if ( cur_val != last_val )
			{
				input.attr( 'last-val', cur_val );
				control.save();
			}
		});
	},
	
	fill_inputs: function( value )
	{
		var control = this;
		_.each( ['h_offset', 'v_offset', 'blur', 'spread'], function( side )
		{
			if ( side == 'blur' || side == 'spread' )
				if ( _.isUndefined( control.params.default[side] ))
					return false;
			var input = jQuery( '[side="' + side + '"]', control.container ),
				val = kirki.util.parseNumber( value[side] );
			input.val( val );
		});
	},
	
	save: function()
	{
		var new_val = {};
		var control = this,
			container = this.container,
			input = jQuery( '.border-hidden-value', container ),
			color = jQuery( '.color input', container).val();
		
		_.each( ['h_offset', 'v_offset', 'blur', 'spread'], function ( side )
		{
			var val = jQuery( 'input[side="' + side + '"]', container).val();
			if ( side == 'blur' || side == 'spread' )
				if ( _.isUndefined( control.params.default[side] ))
					val = 0;
			if ( _.isEmpty( val ) )
				val = 0;
			new_val[side] = val + 'px';
		});
		
		new_val['color'] = color;
		input.attr( 'value', JSON.stringify ( new_val ) ).trigger( 'change' );
		control.setting.set( new_val );
	}
} );