import "./control.scss";

var kirkiCheckboxScript = {

	initKirkiControl: function( control ) {
		control = control || this;
		var container = control.container[0] || control.container;
		
		// Use event delegation for dynamically added inputs
		container.addEventListener( 'change', function( event ) {
			if ( event.target && event.target.tagName === 'INPUT' ) {
				control.setting.set( event.target.checked );
			}
		} );
	}
};

wp.customize.controlConstructor['kirki-checkbox'] = wp.customize.kirkiDynamicControl.extend( kirkiCheckboxScript );
wp.customize.controlConstructor['kirki-switch']   = wp.customize.kirkiDynamicControl.extend( kirkiCheckboxScript );
wp.customize.controlConstructor['kirki-toggle']   = wp.customize.kirkiDynamicControl.extend( kirkiCheckboxScript );
