wp.customize.controlConstructor['kirki-fontawesome'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function() {

		var control  = this,
		    element  = this.container.find( 'select' ),
		    icons    = jQuery.parseJSON( fontAwesomeJSON ),
		    selectValue,
		    select2Options = {
				data: [],
				escapeMarkup: function( markup ) {
					return markup;
				},
				templateResult: function( val ) {
					return '<i class="fa fa-lg fa-' + val.id + '" aria-hidden="true"></i>' + ' ' + val.text;
				},
				templateSelection: function( val ) {
					return '<i class="fa fa-lg fa-' + val.id + '" aria-hidden="true"></i>' + ' ' + val.text;
				}
		    },
		    select;

		_.each( icons.icons, function( icon ) {
			select2Options.data.push({
				id: icon.id,
				text: icon.name
			});
		});

		select = jQuery( element ).select2( select2Options );

		select.on( 'change', function() {
			selectValue = jQuery( this ).val();
			control.setting.set( selectValue );
		});
		select.val( control.setting._value ).trigger( 'change' );
	}
});
