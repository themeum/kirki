/**
 * KIRKI CONTROL: REPEATER
 */
function RepeaterRow( rowIndex, element ) {
	this.rowIndex   = rowIndex;
	this.rowNumber  = rowIndex + 1;
	this.$el        = element;
	this.$dragger   = this.$el.find( '.repeater-row-header' );
	this.$minimizer = this.$el.find( '.repeater-row-minimize' );
	this.$remover   = this.$el.find( '.repeater-row-remove' );
	this.$number    = this.$el.find( '.repeater-row-number' );
	this.$fields    = this.$el.find( 'input,select,textarea' );

	var self = this;

	this.$minimizer.on( 'click', function() {
		self.toggleMinimize();
	});

	this.$remover.on( 'click', function() {
		self.remove();
	});

	this.$dragger.on( 'mousedown', function() {
		self.$el.trigger( 'row:start-dragging' );
	});


	this.$el.on( 'keyup change', 'input, select, textarea', function( e ) {
		self.$el.trigger( 'row:update', [ self.getRowIndex(), jQuery( e.target ).data( 'field' ), e.target ] );
	});

	this.renderNumber();

}

RepeaterRow.prototype.getRowIndex = function() {
	return this.rowIndex;
};

RepeaterRow.prototype.getRowNumber = function() {
	return this.rowNumber;
};

RepeaterRow.prototype.setRowNumber = function( rowNumber ) {
	this.rowNumber = rowNumber;
	this.renderNumber();
};

RepeaterRow.prototype.getElement = function() {
	return this.$el;
};

RepeaterRow.prototype.setRowIndex = function( rowIndex ) {
	this.rowIndex = rowIndex;
	this.$el.attr( 'data-row', rowIndex );
	this.$el.data( 'row', rowIndex );
};

RepeaterRow.prototype.toggleMinimize = function() {
	// Store the previous state
	this.$el.toggleClass( 'minimized' );
	this.$minimizer.find( '.repeater-minimize' ).toggleClass( 'dashicons-arrow-up' );
	this.$minimizer.find( '.repeater-minimize').toggleClass( 'dashicons-arrow-down' );
};

RepeaterRow.prototype.minimize = function() {
	this.$el.addClass( 'minimized' );
	this.$minimizer.find( '.repeater-minimize' ).removeClass( 'dashicons-arrow-up' );
	this.$minimizer.find( '.repeater-minimize').addClass( 'dashicons-arrow-down' );
};

RepeaterRow.prototype.remove = function() {
	// TODO: make this translatable
	if ( confirm( "Are you sure?" ) ) {
		this.$el.slideUp( 300, function() {
			jQuery( this ).detach();
		});
		this.$el.trigger( 'row:remove', [ this.getRowIndex() ] );
	}
};

RepeaterRow.prototype.renderNumber = function() {
	this.$number.text( this.getRowNumber() );
};

wp.customize.controlConstructor.repeater = wp.customize.Control.extend({
	ready: function() {
		var control = this;

		// The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
		var settingValue = this.params.value;

		// The hidden field that keeps the data saved (though we never update it)
		this.settingField = this.container.find( '[data-customize-setting-link]' ).first();

		// Set the field value for the first time, we'll fill it up later
		this.setValue( [], false );

		// The DIV that holds all the rows
		this.repeaterFieldsContainer = this.container.find( '.repeater-fields' ).first();

		// Set number of rows to 0
		this.currentIndex = 0;

		// Save the rows objects
		this.rows = [];

		// Default limit choice
		var limit = false;
		if ( undefined !== this.params.choices.limit ) {
			var limit = ( 0 >= this.params.choices.limit ) ? false : parseInt(this.params.choices.limit);
		}

		this.container.on( 'click', 'button.repeater-add', function( e ) {
			e.preventDefault();
			if ( ! limit || control.currentIndex < limit ) {
				control.addRow();
				jQuery( control.selector + ' .repeater-row' ).last().toggleClass( 'minimized' );
			} else {
				jQuery( control.selector + ' .limit' ).addClass( 'highlight' );
			}
		});

		this.container.on( 'click', '.repeater-row-remove', function( e ) {
			control.currentIndex--;
			if ( ! limit || control.currentIndex < limit ) {
				jQuery( control.selector + ' .limit' ).removeClass( 'highlight' );
			}
		});

		this.container.on( 'click keypress', '.repeater-field-image .upload-button,.repeater-field-cropped_image .upload-button', function ( e ) {
			e.preventDefault();
			control.$thisButton = jQuery( this );
			control.openFrame( e );
		});

		this.container.on( 'click keypress', '.repeater-field-image .remove-button,.repeater-field-cropped_image .remove-button', function ( e ) {
			e.preventDefault();
			control.$thisButton = jQuery(this);
			control.removeImage(e);
		});

		/**
		 * Function that loads the Mustache template
		 */
		this.repeaterTemplate = _.memoize( function() {
			var compiled,
			/*
			 * Underscore's default ERB-style templates are incompatible with PHP
			 * when asp_tags is enabled, so WordPress uses Mustache-inspired templating syntax.
			 *
			 * @see trac ticket #22344.
			 */
			options = {
				evaluate: /<#([\s\S]+?)#>/g,
				interpolate: /\{\{\{([\s\S]+?)\}\}\}/g,
				escape: /\{\{([^\}]+?)\}\}(?!\})/g,
				variable: 'data'
			};

			return function( data ) {
				compiled = _.template( control.container.find( '.customize-control-repeater-content' ).first().html(), null, options );
				return compiled( data );
			};
		});

		// When we load the control, the fields have not been filled up
		// This is the first time that we create all the rows
		if ( settingValue.length ) {
			for ( var i = 0; i < settingValue.length; i++ ) {
				control.addRow( settingValue[ i ] );
			}
		}

		this.repeaterFieldsContainer.sortable({
			handle: ".repeater-row-header",
			update: function( e, ui ) {
				control.sort();
			}
		});

	},

	/**
	 * Open the media modal.
	 */
	openFrame: function( event ) {

		if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
			return;
		}

		if ( this.$thisButton.closest( '.repeater-field' ).hasClass( 'repeater-field-cropped_image' ) ) {
			this.initCropperFrame();
		} else {
			this.initFrame();
		}

		this.frame.open();
	},

	initFrame : function() {

		this.frame = wp.media({
			states: [
			new wp.media.controller.Library({
					library:  wp.media.query({ type: 'image' }),
					multiple: false,
					date:     false
				})
			]
		});

		// When a file is selected, run a callback.
		this.frame.on( 'select', this.onSelect, this );
	},
	/**
	 * Create a media modal select frame, and store it so the instance can be reused when needed.
	 * This is mostly a copy/paste of Core api.CroppedImageControl in /wp-admin/js/customize-control.js
	 */
	 initCropperFrame : function() {

		// We get the field id from which this was called
		var currentFieldId = this.$thisButton.siblings( 'input.hidden-field' ).attr( 'data-field' );
		// Make sure we got it
		if ( 'string' === typeof currentFieldId && '' !== currentFieldId ) {
			// Make fields is defined and only do the hack for cropped_image
			if ( 'object' === typeof this.params.fields[ currentFieldId ] && 'cropped_image' === this.params.fields[ currentFieldId ].type ) {
				// A list of attributes to look for
				var attrs = [ 'width' , 'height' , 'flex_width' , 'flex_height' ];
				//Iterate over the list of attributes
				attrs.forEach( function( el , index ) {
					// If the attribute exists in the field
					if ( 'undefined' !== typeof this.params.fields[ currentFieldId ][ el ] ) {
						// Set the attribute in the main object
						this.params[ el ] = this.params.fields[ currentFieldId ][ el ];
					}
				}.bind(this));
			}
		}

		this.frame = wp.media({
			button: {
				text: 'Select and Crop',
				close: false
			},
			states: [
				new wp.media.controller.Library({
					library:         wp.media.query({ type: 'image' }),
					multiple:        false,
					date:            false,
					suggestedWidth:  this.params.width,
					suggestedHeight: this.params.height
				}),
				new wp.media.controller.CustomizeImageCropper({
					imgSelectOptions: this.calculateImageSelectOptions,
					control: this
				})
			]
		});

		this.frame.on( 'select', this.onSelectForCrop, this );
		this.frame.on( 'cropped', this.onCropped, this );
		this.frame.on( 'skippedcrop', this.onSkippedCrop, this );

	},

	onSelect : function() {
		var attachment = this.frame.state().get( 'selection' ).first().toJSON();

		this.setImageInReaperField( attachment );
	},

	/**
	 * After an image is selected in the media modal, switch to the cropper
	 * state if the image isn't the right size.
	 */

	onSelectForCrop: function() {

		var attachment = this.frame.state().get( 'selection' ).first().toJSON();

		if ( this.params.width === attachment.width && this.params.height === attachment.height && ! this.params.flex_width && ! this.params.flex_height ) {
			this.setImageInReaperField( attachment );
		} else {
			this.frame.setState( 'cropper' );
		}
	},

	/**
	 * After the image has been cropped, apply the cropped image data to the setting.
	 *
	 * @param {object} croppedImage Cropped attachment data.
	 */
	onCropped: function( croppedImage ) {
		this.setImageInReaperField( croppedImage );
	},

	/**
	 * Returns a set of options, computed from the attached image data and
	 * control-specific data, to be fed to the imgAreaSelect plugin in
	 * wp.media.view.Cropper.
	 *
	 * @param {wp.media.model.Attachment} attachment
	 * @param {wp.media.controller.Cropper} controller
	 * @returns {Object} Options
	 */
	calculateImageSelectOptions: function( attachment, controller ) {
		var control    = controller.get( 'control' ),
			flexWidth  = !! parseInt( control.params.flex_width, 10 ),
			flexHeight = !! parseInt( control.params.flex_height, 10 ),
			realWidth  = attachment.get( 'width' ),
			realHeight = attachment.get( 'height' ),
			xInit      = parseInt( control.params.width, 10 ),
			yInit      = parseInt( control.params.height, 10 ),
			ratio      = xInit / yInit,
			xImg       = realWidth,
			yImg       = realHeight,
			x1, y1, imgSelectOptions;

		controller.set( 'canSkipCrop', ! control.mustBeCropped( flexWidth, flexHeight, xInit, yInit, realWidth, realHeight ) );

		if ( xImg / yImg > ratio ) {
			yInit = yImg;
			xInit = yInit * ratio;
		} else {
			xInit = xImg;
			yInit = xInit / ratio;
		}

		x1 = ( xImg - xInit ) / 2;
		y1 = ( yImg - yInit ) / 2;

		imgSelectOptions = {
			handles:     true,
			keys:        true,
			instance:    true,
			persistent:  true,
			imageWidth:  realWidth,
			imageHeight: realHeight,
			x1:          x1,
			y1:          y1,
			x2:          xInit + x1,
			y2:          yInit + y1
		};

		if ( false === flexHeight && false === flexWidth ) {
			imgSelectOptions.aspectRatio = xInit + ':' + yInit;
		}
		if ( false === flexHeight ) {
			imgSelectOptions.maxHeight = yInit;
		}
		if ( false === flexWidth ) {
			imgSelectOptions.maxWidth = xInit;
		}

		return imgSelectOptions;
	},

	/**
	 * Return whether the image must be cropped, based on required dimensions.
	 *
	 * @param {bool} flexW
	 * @param {bool} flexH
	 * @param {int}  dstW
	 * @param {int}  dstH
	 * @param {int}  imgW
	 * @param {int}  imgH
	 * @return {bool}
	 */
	mustBeCropped: function( flexW, flexH, dstW, dstH, imgW, imgH ) {
		if ( true === flexW && true === flexH ) {
			return false;
		}

		if ( true === flexW && dstH === imgH ) {
			return false;
		}

		if ( true === flexH && dstW === imgW ) {
			return false;
		}

		if ( dstW === imgW && dstH === imgH ) {
			return false;
		}

		if ( imgW <= dstW ) {
			return false;
		}

		return true;
	},

	/**
	 * If cropping was skipped, apply the image data directly to the setting.
	 */
	onSkippedCrop: function() {
		var attachment = this.frame.state().get( 'selection' ).first().toJSON();
		this.setImageInReaperField( attachment );
	},

	/**
	 * Updates the setting and re-renders the control UI.
	 *
	 * @param {object} attachment
	 */
	setImageInReaperField: function( attachment ) {
		var $targetDiv = this.$thisButton.closest( '.repeater-field-image,.repeater-field-cropped_image' );

		$targetDiv.find( '.kirki-image-attachment' ).html( '<img src="'+ attachment.url +'">' ).hide().slideDown( 'slow' );

		$targetDiv.find( '.hidden-field' ).val( attachment.id );
		this.$thisButton.text( this.$thisButton.data( 'alt-label' ) );
		$targetDiv.find( '.remove-button' ).show();

		//This will activate the save button
		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );
		this.frame.close();
	},

	removeImage : function( event ) {
		if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
			return;
		}

		var $targetDiv = this.$thisButton.closest( '.repeater-field-image' );
		var $uploadButton = $targetDiv.find( '.upload-button' );

		$targetDiv.find( '.kirki-image-attachment' ).slideUp( 'fast', function() {
			jQuery(this).show().html( jQuery(this).data( 'placeholder' ) );
		});
		$targetDiv.find( '.hidden-field' ).val( '' );
		$uploadButton.text( $uploadButton.data( 'label' ) );
		this.$thisButton.hide();

		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );
	},

	/**
	 * Get the current value of the setting
	 *
	 * @return Object
	 */
	getValue: function() {
		// The setting is saved in JSON
		return JSON.parse( decodeURI( this.setting.get() ) );
	},

	/**
	 * Set a new value for the setting
	 *
	 * @param newValue Object
	 * @param refresh If we want to refresh the previewer or not
	 */
	setValue: function( newValue, refresh ) {
		this.setting.set( encodeURI( JSON.stringify( newValue ) ) );

		if ( refresh ) {
			// Trigger the change event on the hidden field so
			// previewer refresh the website on Customizer
			this.settingField.trigger('change');
		}
	},

	/**
	 * Add a new row to repeater settings based on the structure.
	 *
	 * @param data (Optional) Object of field => value pairs (undefined if you want to get the default values)
	 */
	addRow: function( data ) {
		var control = this,
			i,
			// The template for the new row (defined on Kirki_Customize_Repeater_Control::render_content() )
			template = control.repeaterTemplate(),
			// Get the current setting value
			settingValue = this.getValue(),
			// Saves the new setting data
			newRowSetting = {},
			// Data to pass to the template
			templateData;

		if ( template ) {

			// The control structure is going to define the new fields
			// We need to clone control.params.fields. Assigning it
			// ould result in a reference assignment.
			templateData = jQuery.extend( true, {}, control.params.fields );

			// But if we have passed data, we'll use the data values instead
			if ( data ) {
				for ( i in data ) {
					if ( data.hasOwnProperty( i ) && templateData.hasOwnProperty( i ) ) {
						templateData[ i ].default = data[ i ];
					}
				}
			}

			templateData.index = this.currentIndex;
			templateData.ControlId = this.id;

			// Append the template content
			template = template( templateData );

			// Create a new row object and append the element
			var newRow = new RepeaterRow(
				control.currentIndex,
				jQuery( template ).appendTo( control.repeaterFieldsContainer )
			);

			newRow.getElement().one( 'row:remove', function( e, rowIndex ) {
				control.deleteRow( rowIndex );
			});

			newRow.getElement().on( 'row:update', function( e, rowIndex, fieldName, element ) {
				control.updateField.call( control, e, rowIndex, fieldName, element );
			});

			newRow.getElement().on( 'row:start-dragging', function() {
				// Minimize all rows
				for ( i in control.rows ) {
					if ( control.rows.hasOwnProperty( i ) && control.rows[ i ] ) {
						control.rows[ i ].minimize();
					}
				}
			});

			// Add the row to rows collection
			this.rows[ this.currentIndex ] = newRow;

			for ( i in templateData ) {
				if ( templateData.hasOwnProperty( i ) ) {
					newRowSetting[ i ] = templateData[ i ].default;
				}
			}

			settingValue[ this.currentIndex ] = newRowSetting;
			this.setValue( settingValue, true );

			this.currentIndex++;

		}

	},

	sort: function() {
		var control  = this;
		var $rows    = this.repeaterFieldsContainer.find( '.repeater-row' );
		var newOrder = [];

		$rows.each( function( i, element ) {
			newOrder.push( jQuery( element ).data( 'row' ) );
		});

		var settings    = control.getValue();
		var newRows     = [];
		var newSettings = [];
		jQuery.each( newOrder, function( newPosition, oldPosition ) {
			newRows[ newPosition ] = control.rows[ oldPosition ];
			newRows[ newPosition ].setRowIndex( newPosition );
			newRows[ newPosition ].setRowNumber( newPosition + 1 );

			newSettings[ newPosition ] = settings[ oldPosition ];
		});

		control.rows = newRows;
		control.setValue( newSettings );
	},

	/**
	 * Delete a row in the repeater setting
	 *
	 * @param index Position of the row in the complete Setting Array
	 */
	deleteRow: function( index ) {
		var currentSettings = this.getValue();

		if ( currentSettings[ index ] ) {
			// Find the row
			var row = this.rows[ index ];
			if ( row ) {
				// The row exists, let's delete it

				// Remove the row settings
				delete currentSettings[ index ];

				// Remove the row from the rows collection
				delete this.rows[ index ];

				// Update the new setting values
				this.setValue( currentSettings, true );
			}
		}

		// Remap the row numbers
		var i = 1;
		for ( var prop in this.rows ) {
			if ( this.rows.hasOwnProperty( prop ) && this.rows[ prop ] ) {
				this.rows[ prop ].setRowNumber( i );
				i++;
			}
		}
	},

	/**
	 * Update a single field inside a row.
	 * Triggered when a field has changed
	 *
	 * @param e Event Object
	 */
	updateField: function( e, rowIndex, fieldId, element ) {
		if ( ! this.rows[ rowIndex ] )
			return;

		if ( ! this.params.fields[ fieldId ] )
			return;

		var type            = this.params.fields[ fieldId].type;
		var row             = this.rows[ rowIndex ];
		var currentSettings = this.getValue();

		element = jQuery( element );

		if ( undefined === typeof currentSettings[ row.getRowIndex() ][ fieldId ] ) {
			return;
		}

		if ( 'checkbox' === type ) {
			currentSettings[ row.getRowIndex() ][ fieldId ] = element.is( ':checked' );
		} else {
			// Update the settings
			currentSettings[ row.getRowIndex() ][ fieldId ] = element.val();
		}

		this.setValue( currentSettings, true );

	}

});
