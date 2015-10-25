/**
 * KIRKI CONTROL: SORTABLE
 */
wp.customize.controlConstructor['sortable'] = wp.customize.Control.extend({
	ready: function() {
		var control = this;

		// The hidden field that keeps the data saved
		this.settingField = this.container.find('[data-customize-setting-link]').first();

		// The sortable container
		this.sortableContainer = this.container.find( 'ul.sortable').first();

		// Set the field value for the first time
		this.setValue( this.setting.get(), false );


		// Init the sortable container
		this.sortableContainer.sortable()
			.disableSelection()
			.on("sortstop", function(event, ui) {
				control.sort();
			})
			.find('li').each(function() {
				jQuery(this).find('i.visibility').click(function() {
					jQuery(this).toggleClass('dashicons-visibility-faint').parents('li:eq(0)').toggleClass('invisible');
				});
			})
			.click(function() {
				control.sort();
			});
	},

	/**
	 * Updates the sorting list
	 */
	sort: function() {
		var newValue = [];
		this.sortableContainer.find( 'li' ).each( function() {
			var $this = jQuery(this);
			if ( ! $this.is( '.invisible' ) ) {
				newValue.push( $this.data('value' ) );
			}
		});

		this.setValue( newValue, true );
	},

	/**
	 * Get the current value of the setting
	 *
	 * @return Object
	 */
	getValue: function() {
		// The setting is saved in PHP serialized format
		return unserialize( this.setting.get() );
	},

	/**
	 * Set a new value for the setting
	 *
	 * @param newValue Object
	 * @param refresh If we want to refresh the previewer or not
	 */
	setValue: function( newValue, refresh ) {
		newValue = serialize( newValue );
		this.setting.set( newValue );

		// Update the hidden field
		this.settingField.val( newValue );

		if ( refresh ) {
			// Trigger the change event on the hidden field so
			// previewer refresh the website on Customizer
			this.settingField.trigger('change');
		}
	}

});
