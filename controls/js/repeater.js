/* global kirkiControlLoader */
var RepeaterRow = function( rowIndex, container, label, control ) {

	'use strict';

	var self        = this;
	this.rowIndex   = rowIndex;
	this.container  = container;
	this.label      = label;
	this.header     = this.container.find( '.repeater-row-header' ),

	this.header.on( 'click', function() {
		self.toggleMinimize();
	});

	this.container.on( 'click', '.repeater-row-remove', function() {
		self.remove();
	});

	this.header.on( 'mousedown', function() {
		self.container.trigger( 'row:start-dragging' );
	});

	this.container.on( 'keyup change', 'input, select, textarea', function( e ) {
		self.container.trigger( 'row:update', [ self.rowIndex, jQuery( e.target ).data( 'field' ), e.target ] );
	});

	this.setRowIndex = function( rowIndex ) {
		this.rowIndex = rowIndex;
		this.container.attr( 'data-row', rowIndex );
		this.container.data( 'row', rowIndex );
		this.updateLabel();
	};

	this.toggleMinimize = function() {

		// Store the previous state.
		this.container.toggleClass( 'minimized' );
		this.header.find( '.dashicons' ).toggleClass( 'dashicons-arrow-up' ).toggleClass( 'dashicons-arrow-down' );
	};

	this.remove = function() {
		this.container.slideUp( 300, function() {
			jQuery( this ).detach();
		});
		this.container.trigger( 'row:remove', [ this.rowIndex ] );
	};

	this.updateLabel = function() {
		var rowLabelField,
		    rowLabel,
		    rowLabelSelector;

		if ( 'field' === this.label.type ) {
			rowLabelField = this.container.find( '.repeater-field [data-field="' + this.label.field + '"]' );
			if ( _.isFunction( rowLabelField.val ) ) {
				rowLabel = rowLabelField.val();
				if ( '' !== rowLabel ) {
					if ( ! _.isUndefined( control.params.fields[ this.label.field ] ) ) {
						if ( ! _.isUndefined( control.params.fields[ this.label.field ].type ) ) {
							if ( 'select' === control.params.fields[ this.label.field ].type ) {
								if ( ! _.isUndefined( control.params.fields[ this.label.field ].choices ) && ! _.isUndefined( control.params.fields[ this.label.field ].choices[ rowLabelField.val() ] ) ) {
									rowLabel = control.params.fields[ this.label.field ].choices[ rowLabelField.val() ];
								}
							} else if ( 'radio' === control.params.fields[ this.label.field ].type || 'radio-image' === control.params.fields[ this.label.field ].type ) {
								rowLabelSelector = control.selector + ' [data-row="' + this.rowIndex + '"] .repeater-field [data-field="' + this.label.field + '"]:checked';
								rowLabel = jQuery( rowLabelSelector ).val();
							}
						}
					}
					this.header.find( '.repeater-row-label' ).text( rowLabel );
					return;
				}
			}
		}
		this.header.find( '.repeater-row-label' ).text( this.label.value + ' ' + ( this.rowIndex + 1 ) );
	};
	this.updateLabel();
};

wp.customize.controlConstructor.repeater = wp.customize.Control.extend({

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

		'use strict';

		var control = this,
		    limit,
		    theNewRow;

		// The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
		var settingValue = this.params.value;

		control.container.find( '.kirki-controls-loading-spinner' ).hide();

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
		limit = false;
		if ( ! _.isUndefined( this.params.choices.limit ) ) {
			limit = ( 0 >= this.params.choices.limit ) ? false : parseInt( this.params.choices.limit, 10 );
		}

		this.container.on( 'click', 'button.repeater-add', function( e ) {
			e.preventDefault();
			if ( ! limit || control.currentIndex < limit ) {
				theNewRow = control.addRow();
				theNewRow.toggleMinimize();
				control.initColorPicker();
				control.initSelect( theNewRow );
			} else {
				jQuery( control.selector + ' .limit' ).addClass( 'highlight' );
			}
		});

		this.container.on( 'click', '.repeater-row-remove', function() {
			control.currentIndex--;
			if ( ! limit || control.currentIndex < limit ) {
				jQuery( control.selector + ' .limit' ).removeClass( 'highlight' );
			}
		});

		this.container.on( 'click keypress', '.repeater-field-image .upload-button,.repeater-field-cropped_image .upload-button,.repeater-field-upload .upload-button', function( e ) {
			e.preventDefault();
			control.$thisButton = jQuery( this );
			control.openFrame( e );
		});

		this.container.on( 'click keypress', '.repeater-field-image .remove-button,.repeater-field-cropped_image .remove-button', function( e ) {
			e.preventDefault();
			control.$thisButton = jQuery( this );
			control.removeImage( e );
		});

		this.container.on( 'click keypress', '.repeater-field-upload .remove-button', function( e ) {
			e.preventDefault();
			control.$thisButton = jQuery( this );
			control.removeFile( e );
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
			_.each( settingValue, function( subValue ) {
				theNewRow = control.addRow( subValue );
				control.initColorPicker();
				control.initSelect( theNewRow, subValue );
			});
		}

		// Once we have displayed the rows, we cleanup the values
		this.setValue( settingValue, true, true );

		this.repeaterFieldsContainer.sortable({
			handle: '.repeater-row-header',
			update: function() {
				control.sort();
			}
		});

	},

	/**
	 * Open the media modal.
	 */
	openFrame: function( event ) {

		'use strict';

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

	initFrame: function() {

		'use strict';

		var libMediaType = this.getMimeType();

		this.frame = wp.media({
			states: [
			new wp.media.controller.Library({
					library:  wp.media.query({ type: libMediaType }),
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
	initCropperFrame: function() {

		'use strict';

		// We get the field id from which this was called
		var currentFieldId = this.$thisButton.siblings( 'input.hidden-field' ).attr( 'data-field' ),
		    attrs          = [ 'width', 'height', 'flex_width', 'flex_height' ], // A list of attributes to look for
		    libMediaType   = this.getMimeType();

		// Make sure we got it
		if ( _.isString( currentFieldId ) && '' !== currentFieldId ) {

			// Make fields is defined and only do the hack for cropped_image
			if ( _.isObject( this.params.fields[ currentFieldId ] ) && 'cropped_image' === this.params.fields[ currentFieldId ].type ) {

				//Iterate over the list of attributes
				attrs.forEach( function( el ) {

					// If the attribute exists in the field
					if ( ! _.isUndefined( this.params.fields[ currentFieldId ][ el ] ) ) {

						// Set the attribute in the main object
						this.params[ el ] = this.params.fields[ currentFieldId ][ el ];
					}
				}.bind( this ) );
			}
		}

		this.frame = wp.media({
			button: {
				text: 'Select and Crop',
				close: false
			},
			states: [
				new wp.media.controller.Library({
					library:         wp.media.query({ type: libMediaType }),
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

	onSelect: function() {

		'use strict';

		var attachment = this.frame.state().get( 'selection' ).first().toJSON();

		if ( this.$thisButton.closest( '.repeater-field' ).hasClass( 'repeater-field-upload' ) ) {
			this.setFileInRepeaterField( attachment );
		} else {
			this.setImageInRepeaterField( attachment );
		}
	},

	/**
	 * After an image is selected in the media modal, switch to the cropper
	 * state if the image isn't the right size.
	 */

	onSelectForCrop: function() {

		'use strict';

		var attachment = this.frame.state().get( 'selection' ).first().toJSON();

		if ( this.params.width === attachment.width && this.params.height === attachment.height && ! this.params.flex_width && ! this.params.flex_height ) {
			this.setImageInRepeaterField( attachment );
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

		'use strict';

		this.setImageInRepeaterField( croppedImage );

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

		'use strict';

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
		    x1,
		    y1,
		    imgSelectOptions;

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

		'use strict';

		if ( ( true === flexW && true === flexH ) || ( true === flexW && dstH === imgH ) || ( true === flexH && dstW === imgW ) || ( dstW === imgW && dstH === imgH ) || ( imgW <= dstW ) ) {
			return false;
		}

		return true;
	},

	/**
	 * If cropping was skipped, apply the image data directly to the setting.
	 */
	onSkippedCrop: function() {

		'use strict';

		var attachment = this.frame.state().get( 'selection' ).first().toJSON();
		this.setImageInRepeaterField( attachment );

	},

	/**
	 * Updates the setting and re-renders the control UI.
	 *
	 * @param {object} attachment
	 */
	setImageInRepeaterField: function( attachment ) {

		'use strict';

		var $targetDiv = this.$thisButton.closest( '.repeater-field-image,.repeater-field-cropped_image' );

		$targetDiv.find( '.kirki-image-attachment' ).html( '<img src="' + attachment.url + '">' ).hide().slideDown( 'slow' );

		$targetDiv.find( '.hidden-field' ).val( attachment.id );
		this.$thisButton.text( this.$thisButton.data( 'alt-label' ) );
		$targetDiv.find( '.remove-button' ).show();

		//This will activate the save button
		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );
		this.frame.close();

	},

	/**
	 * Updates the setting and re-renders the control UI.
	 *
	 * @param {object} attachment
	 */
	setFileInRepeaterField: function( attachment ) {

		'use strict';

		var $targetDiv = this.$thisButton.closest( '.repeater-field-upload' );

		$targetDiv.find( '.kirki-file-attachment' ).html( '<span class="file"><span class="dashicons dashicons-media-default"></span> ' + attachment.filename + '</span>' ).hide().slideDown( 'slow' );

		$targetDiv.find( '.hidden-field' ).val( attachment.id );
		this.$thisButton.text( this.$thisButton.data( 'alt-label' ) );
		$targetDiv.find( '.upload-button' ).show();
		$targetDiv.find( '.remove-button' ).show();

		//This will activate the save button
		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );
		this.frame.close();

	},

	getMimeType: function() {

		'use strict';

		// We get the field id from which this was called
		var currentFieldId = this.$thisButton.siblings( 'input.hidden-field' ).attr( 'data-field' );

		// Make sure we got it
		if ( _.isString( currentFieldId ) && '' !== currentFieldId ) {

			// Make fields is defined and only do the hack for cropped_image
			if ( _.isObject( this.params.fields[ currentFieldId ] ) && 'upload' === this.params.fields[ currentFieldId ].type ) {

				// If the attribute exists in the field
				if ( ! _.isUndefined( this.params.fields[ currentFieldId ].mime_type ) ) {

					// Set the attribute in the main object
					return this.params.fields[ currentFieldId ].mime_type;
				}
			}
		}
		return 'image';

	},

	removeImage: function( event ) {

		'use strict';

		var $targetDiv,
		    $uploadButton;

		if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
			return;
		}

		$targetDiv = this.$thisButton.closest( '.repeater-field-image,.repeater-field-cropped_image,.repeater-field-upload' );
		$uploadButton = $targetDiv.find( '.upload-button' );

		$targetDiv.find( '.kirki-image-attachment' ).slideUp( 'fast', function() {
			jQuery( this ).show().html( jQuery( this ).data( 'placeholder' ) );
		});
		$targetDiv.find( '.hidden-field' ).val( '' );
		$uploadButton.text( $uploadButton.data( 'label' ) );
		this.$thisButton.hide();

		$targetDiv.find( 'input, textarea, select' ).trigger( 'change' );

	},

	removeFile: function( event ) {

		'use strict';

		var $targetDiv,
		    $uploadButton;

		if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
			return;
		}

		$targetDiv = this.$thisButton.closest( '.repeater-field-upload' );
		$uploadButton = $targetDiv.find( '.upload-button' );

		$targetDiv.find( '.kirki-file-attachment' ).slideUp( 'fast', function() {
			jQuery( this ).show().html( jQuery( this ).data( 'placeholder' ) );
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

		'use strict';

		// The setting is saved in JSON
		return JSON.parse( decodeURI( this.setting.get() ) );

	},

	/**
	 * Set a new value for the setting
	 *
	 * @param newValue Object
	 * @param refresh If we want to refresh the previewer or not
	 */
	setValue: function( newValue, refresh, filtering ) {

		'use strict';

		// We need to filter the values after the first load to remove data requrired for diplay but that we don't want to save in DB
		var filteredValue = newValue,
		    filter        = [];

		if ( filtering ) {
			jQuery.each( this.params.fields, function( index, value ) {
				if ( 'image' === value.type || 'cropped_image' === value.type || 'upload' === value.type ) {
					filter.push( index );
				}
			});
			jQuery.each( newValue, function( index, value ) {
				jQuery.each( filter, function( ind, field ) {
					if ( ! _.isUndefined( value[ field ] ) && ! _.isUndefined( value[ field ].id ) ) {
						filteredValue[index][ field ] = value[ field ].id;
					}
				});
			});
		}

		this.setting.set( encodeURI( JSON.stringify( filteredValue ) ) );

		if ( refresh ) {

			// Trigger the change event on the hidden field so
			// previewer refresh the website on Customizer
			this.settingField.trigger( 'change' );
		}
	},

	/**
	 * Add a new row to repeater settings based on the structure.
	 *
	 * @param data (Optional) Object of field => value pairs (undefined if you want to get the default values)
	 */
	addRow: function( data ) {

		'use strict';

		var control       = this,
		    template      = control.repeaterTemplate(), // The template for the new row (defined on Kirki_Customize_Repeater_Control::render_content() ).
		    settingValue  = this.getValue(), // Get the current setting value.
		    newRowSetting = {}, // Saves the new setting data.
		    templateData, // Data to pass to the template
		    newRow,
		    i;

		if ( template ) {

			// The control structure is going to define the new fields
			// We need to clone control.params.fields. Assigning it
			// ould result in a reference assignment.
			templateData = jQuery.extend( true, {}, control.params.fields );

			// But if we have passed data, we'll use the data values instead
			if ( data ) {
				for ( i in data ) {
					if ( data.hasOwnProperty( i ) && templateData.hasOwnProperty( i ) ) {
						templateData[ i ]['default'] = data[ i ];
					}
				}
			}

			templateData.index = this.currentIndex;

			// Append the template content
			template = template( templateData );

			// Create a new row object and append the element
			newRow = new RepeaterRow(
				control.currentIndex,
				jQuery( template ).appendTo( control.repeaterFieldsContainer ),
				control.params.row_label,
				control
			);

			newRow.container.on( 'row:remove', function( e, rowIndex ) {
				control.deleteRow( rowIndex );
			});

			newRow.container.on( 'row:update', function( e, rowIndex, fieldName, element ) {
				control.updateField.call( control, e, rowIndex, fieldName, element );
				newRow.updateLabel();
			});

			// Add the row to rows collection
			this.rows[ this.currentIndex ] = newRow;

			for ( i in templateData ) {
				if ( templateData.hasOwnProperty( i ) ) {
					newRowSetting[ i ] = templateData[ i ]['default'];
				}
			}

			settingValue[ this.currentIndex ] = newRowSetting;
			this.setValue( settingValue, true );

			this.currentIndex++;

			return newRow;
		}
	},

	sort: function() {

		'use strict';

		var control     = this,
		    $rows       = this.repeaterFieldsContainer.find( '.repeater-row' ),
		    newOrder    = [],
		    settings    = control.getValue(),
		    newRows     = [],
		    newSettings = [];

		$rows.each( function( i, element ) {
			newOrder.push( jQuery( element ).data( 'row' ) );
		});

		jQuery.each( newOrder, function( newPosition, oldPosition ) {
			newRows[ newPosition ] = control.rows[ oldPosition ];
			newRows[ newPosition ].setRowIndex( newPosition );

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

		'use strict';

		var currentSettings = this.getValue(),
		    row,
		    i,
		    prop;

		if ( currentSettings[ index ] ) {

			// Find the row
			row = this.rows[ index ];
			if ( row ) {

				// Remove the row settings
				delete currentSettings[ index ];

				// Remove the row from the rows collection
				delete this.rows[ index ];

				// Update the new setting values
				this.setValue( currentSettings, true );

			}

		}

		// Remap the row numbers
		i = 1;
		for ( prop in this.rows ) {
			if ( this.rows.hasOwnProperty( prop ) && this.rows[ prop ] ) {
				this.rows[ prop ].updateLabel();
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

		'use strict';

		var type,
		    row,
		    currentSettings;

		if ( ! this.rows[ rowIndex ] ) {
			return;
		}

		if ( ! this.params.fields[ fieldId ] ) {
			return;
		}

		type            = this.params.fields[ fieldId].type;
		row             = this.rows[ rowIndex ];
		currentSettings = this.getValue();

		element = jQuery( element );

		if ( _.isUndefined( currentSettings[ row.rowIndex ][ fieldId ] ) ) {
			return;
		}

		if ( 'checkbox' === type ) {
			currentSettings[ row.rowIndex ][ fieldId ] = element.is( ':checked' );
		} else {

			// Update the settings
			currentSettings[ row.rowIndex ][ fieldId ] = element.val();
		}
		this.setValue( currentSettings, true );
	},

	/**
	 * Init the color picker on color fields
	 * Called after AddRow
	 *
	 */
	initColorPicker: function() {

		'use strict';

		var control     = this,
		    colorPicker = control.container.find( '.color-picker-hex' ),
		    options     = {},
		    fieldId     = colorPicker.data( 'field' );

		// We check if the color palette parameter is defined.
		if ( ! _.isUndefined( fieldId ) && ! _.isUndefined( control.params.fields[ fieldId ] ) && ! _.isUndefined( control.params.fields[ fieldId ].palettes ) && _.isObject( control.params.fields[ fieldId ].palettes ) ) {
			options.palettes = control.params.fields[ fieldId ].palettes;
		}

		// When the color picker value is changed we update the value of the field
		options.change = function( event, ui ) {

			var currentPicker   = jQuery( event.target ),
			    row             = currentPicker.closest( '.repeater-row' ),
			    rowIndex        = row.data( 'row' ),
			    currentSettings = control.getValue();

			currentSettings[ rowIndex ][ currentPicker.data( 'field' ) ] = ui.color.toString();
			control.setValue( currentSettings, true );

		};

		// Init the color picker
		if ( 0 !== colorPicker.length ) {
			colorPicker.wpColorPicker( options );
		}
	},

	/**
	 * Init the dropdown-pages field with selectWoo
	 * Called after AddRow
	 *
	 * @param {object} theNewRow the row that was added to the repeater
	 * @param {object} data the data for the row if we're initializing a pre-existing row
	 *
	 */
	initSelect: function( theNewRow, data ) {

		'use strict';

		var control  = this,
		    dropdown = theNewRow.container.find( '.repeater-field select' ),
		    $select,
		    dataField,
		    multiple,
		    selectWooOptions = {};

		if ( 0 === dropdown.length ) {
			return;
		}

		dataField = dropdown.data( 'field' );
		multiple  = jQuery( dropdown ).data( 'multiple' );
		if ( 'undefed' !== multiple && jQuery.isNumeric( multiple ) ) {
			multiple = parseInt( multiple, 10 );
			if ( 1 < multiple ) {
				selectWooOptions.maximumSelectionLength = multiple;
			}
		}
		$select   = jQuery( dropdown ).selectWoo( selectWooOptions ).val( data[ dataField ] );

		this.container.on( 'change', '.repeater-field select', function( event ) {

			var currentDropdown = jQuery( event.target ),
			    row             = currentDropdown.closest( '.repeater-row' ),
			    rowIndex        = row.data( 'row' ),
			    currentSettings = control.getValue();

			currentSettings[ rowIndex ][ currentDropdown.data( 'field' ) ] = jQuery( this ).val();
			control.setValue( currentSettings );
		});
	}
});
