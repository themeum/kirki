var kirkiCompositeControlGetCombinedFieldArgs = function( control, field ) {
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
};

( function ( api ) {
	/**
	 * Set the value and trigger all bound callbacks.
	 *
	 * @since 1.0
	 * @param {object} to New value.
	 */
	api.Value.prototype.set = function( to ) {
		var from      = this._value,
			newValObj = {},
			parts;

		to = this._setter.apply( this, arguments );
		to = this.validate( to );

		// Bail if the sanitized value is null or unchanged.
		if ( null === to || _.isEqual( from, to ) ) {
			return this;
		}

		/**
		 * Start Kirki mod.
		 */
		if ( 'object' === typeof from && 'object' !== typeof to ) {

			// Kirki tweak: handle nested settings.
			if (
				this.element &&
				this.element[0] &&
				this.element[0].attributes &&
				this.element[0].attributes['data-kirki-customize-setting-link-key']
			) {
				newValObj[ this.element[0].attributes['data-kirki-customize-setting-link-key'].nodeValue ] = to;
				to = jQuery.extend( {}, from, newValObj );
			}
		// } else if ( 'object' !== typeof to && this.id && this.id.indexOf( '[' ) ) {

		// 	// Kirki tweak: handle composite control subcontrol changes.
		// 	if (
		// 		this.id.split( '[' )[1] &&
		// 		wp.customize.control( this.id.split( '[' )[0] ) &&
		// 		wp.customize.control( this.id.split( '[' )[0] ).setting &&
		// 		wp.customize.control( this.id.split( '[' )[0] ).setting.get
		// 	) {
		// 		newValObj = wp.customize.control( this.id.split( '[' )[0] ).setting.get();
		// 		newValObj[ this.id.split( '[' )[1].replace( ']', '' ) ] = to;
		// 		wp.customize.control( this.id.split( '[' )[0] ).setting.set( newValObj );
		// 		jQuery( '.composite-hidden-value[data-customize-setting-link="' + this.id.split( '[' )[0] + '"]' ).trigger( 'change' );
		// 		return;
		// 	}
		}
		/**
		 * End Kirki mod.
		 */

		this._value = to;
		this._dirty = true;

		this.callbacks.fireWith( this, [ to, from ] );

		return this;
	};
} )( wp.customize );

/**
 * Initialize sub-controls.
 *
 * @since 1.0
 */
wp.hooks.addAction( 'kirki.dynamicControl.init.after', 'kirki', function( id, control, args ) {
	_.each( control.params.fields, function( field ) {
		var subControl = wp.customize.control.add(
			new wp.customize.Control( field.settings, kirkiCompositeControlGetCombinedFieldArgs( control, field ) ) 
		);
		subControl.setting = new wp.customize.Setting( subControl.id, subControl.params.value, {
			transport: control.setting.transport
		} );
		// console.log( subControl );
		if ( subControl.params.type && wp.customize.controlConstructor[ subControl.params.type ] ) {
			if ( wp.customize.controlConstructor[ subControl.params.type ].prototype.initKirkiControl ) {
				wp.customize.controlConstructor[ subControl.params.type ].prototype.initKirkiControl.call( subControl, subControl );
			}
		}
	});
});

wp.customize.controlConstructor['kirki-composite'] = wp.customize.kirkiDynamicControl.extend( {} );
