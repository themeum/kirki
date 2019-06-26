wp.customize.controlConstructor['kirki-select'] = wp.customize.kirkiDynamicControl.extend( {
	initKirkiControl: function( control ) {
		var element, multiple, selectValue, selectWooOptions;
		control          = control || this;
		element          = control.container.find( 'select' );
		multiple         = parseInt( element.data( 'multiple' ), 10 );
		selectWooOptions = {
			escapeMarkup: function( markup ) {
				return markup;
			}
		};
		if ( control.params.placeholder ) {
			selectWooOptions.placeholder = control.params.placeholder;
			selectWooOptions.allowClear  = true;
		}

		if ( 1 < multiple ) {
			selectWooOptions.maximumSelectionLength = multiple;
		}

		if ( control.params.select_args ) {
			selectWooOptions = jQuery.extend( selectWooOptions, control.params.select_args );
			if ( 'string' === typeof selectWooOptions.data ) {
				if ( 'function' === typeof window[ selectWooOptions.data ] ) {
					selectWooOptions.data = window[ selectWooOptions.data ]();
				} else if ( 'object' === typeof window[ selectWooOptions.data ] ) {
					selectWooOptions.data = window[ selectWooOptions.data ];
				}
			}
			if ( selectWooOptions.ajax ) {
				if ( 'string' === typeof selectWooOptions.ajax.processResults && 'function' === typeof window[ selectWooOptions.ajax.processResults ] ) {
					selectWooOptions.ajax.processResults = window[ selectWooOptions.ajax.processResults ]( control );
				}
			}
		}

		this.selectElement    = element;
		this.selectWooOptions = selectWooOptions;

		jQuery( element ).selectWoo( selectWooOptions ).on( 'change', function() {
			selectValue = jQuery( this ).val();
			selectValue = ( null === selectValue && 1 < multiple ) ? [] : selectValue;
			control.setting.set( selectValue );
		} );
	},

	doSelectAction: function( action, arg ) {
		var control = this;

		if ( ! this.selectElement ) {
			return;
		}
		switch ( action ) {

			case 'disableOption':
				_.each( this.selectElement[0], function( option ) {
					if ( jQuery( option ).attr( 'value' ) === arg ) {
						jQuery( option ).attr( 'disabled', 'disabled' );
					}
				} );
				break;

			case 'enableOption':
				_.each( this.selectElement[0], function( option ) {
					if ( jQuery( option ).attr( 'value' ) === arg ) {
						jQuery( option ).attr( 'disabled', false );
					}
				} );
				break;

			case 'selectOption':
				jQuery( this.selectElement ).val( arg );
				jQuery( this.selectElement ).trigger( 'change' );
				break;
		}
		jQuery( this.selectElement ).selectWoo( 'destroy' );
		jQuery( this.selectElement ).selectWoo( this.selectWooOptions ).on( 'change', function() {
			var selectValue = jQuery( this ).val();
			selectValue = ( null === selectValue && 1 < parseInt( control.selectElement.data( 'multiple' ), 10 ) ) ? [] : selectValue;
			control.setting.set( selectValue );
		} );
	}
} );
