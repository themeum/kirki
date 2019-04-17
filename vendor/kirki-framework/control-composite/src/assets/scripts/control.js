wp.customize.controlConstructor['kirki-composite'] = wp.customize.Control.extend( {

	ready: function() {
		var control = this;
		_.each( this.params.fields, function( field ) {
			wp.customize.control.add(
				new wp.customize.Control( field.settings, control.getCombinedFieldArgs( control, field ) ) 
			);
		});
	},

	getCombinedFieldArgs: function( control, field ) {
		var params = control.params;
		_.each( field, function( v, k ) {
			params[ k ] = v;
		});
		if ( ! field.description ) {
			params.description = '';
		}
		if ( ! field.label ) {
			params.label = '';
		}
		params.id      = field.settings;
		params.value   = control.setting._value[ params.id.replace( control.id + '[', '' ).replace( ']', '' ) ];
		params.content = '<li id="customize-control-' + field.settings.replace( /]/g, '' ).replace( /\[/g, '-' ) + '" class="customize-control customize-control-' + field.type + '"></li>';
		params.link    = 'data-customize-setting-link="' + control.id + '" data-kirki-customize-setting-link-key="' + params.id.replace( control.id + '[', '' ).replace( ']', '' ) + '"';
		
		return params;
	},

} );

( function ( api ) {
	/**
	 * Set the value and trigger all bound callbacks.
	 *
	 * @since 1.0
	 * @param {object} to New value.
	 */
	api.Value.prototype.set = function( to ) {
		var from      = this._value,
			newValObj = {};

		to = this._setter.apply( this, arguments );
		to = this.validate( to );

		// Bail if the sanitized value is null or unchanged.
		if ( null === to || _.isEqual( from, to ) ) {
			return this;
		}

		// Kirki tweak: handle nested settings.
		if ( 'object' === typeof from && 'object' !== typeof to ) {
			if ( this.element && this.element[0] && this.element[0].attributes && this.element[0].attributes['data-kirki-customize-setting-link-key'] ) {
				newValObj[ this.element[0].attributes['data-kirki-customize-setting-link-key'].nodeValue ] = to;
				to = jQuery.extend( {}, from, newValObj );
			}
		}

		this._value = to;
		this._dirty = true;

		this.callbacks.fireWith( this, [ to, from ] );

		return this;
	};
} )( wp.customize );