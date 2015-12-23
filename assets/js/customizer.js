/**
 * KIRKI CONTROL: CHECKBOX
 */
wp.customize.controlConstructor['kirki-checkbox'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Get the initial value
		var checkbox_value = control.setting._value;

		this.container.on( 'change', 'input', function() {
			checkbox_value = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkbox_value );
		});
	}
});
/**
 * KIRKI CONTROL: CODE
 */
wp.customize.controlConstructor['code'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = control.container.find( '#kirki-codemirror-editor-' + control.id );
		var editor  = CodeMirror.fromTextArea( element[0] );

		if ( control.params.choices.language == 'html' ) {
			var language = { name: "htmlmixed" };
		} else {
			language = control.params.choices.language;
		}

		editor.setOption( "value", control.setting._value );
		editor.setOption( "mode", language );
		editor.setOption( "lineNumbers", true );
		editor.setOption( "theme", control.params.choices.theme );
		editor.setOption( "height", control.params.choices.height + 'px' );

		editor.on('change', function() {
			control.setting.set( editor.getValue() );
		});

		element.parents('.accordion-section').on('click', function(){
		    editor.refresh();
		});
	}
});
/**
 * KIRKI CONTROL: COLOR-ALPHA
 */
wp.customize.controlConstructor['color-alpha'] = wp.customize.Control.extend( {
	ready: function() {
		var control   = this;
		var picker    = this.container.find( '.kirki-color-control' );
		var new_color = picker.val();

		picker.wpColorPicker({
			change: function( event, ui ) {
				setTimeout( function(){
					control.setting.set( picker.val() );
				}, 100 );
			},
		});
	}
});
/**
 * KIRKI CONTROL: DIMENSION
 */
wp.customize.controlConstructor['dimension'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var numeric_value = control.container.find('input[type=number]' ).val();
		var units_value   = control.container.find('select' ).val();

		jQuery( '.customize-control-dimension select' ).selectize();

		this.container.on( 'change', 'input', function() {
			numeric_value = jQuery( this ).val();
			control.setting.set( numeric_value + units_value );
		});
		this.container.on( 'change', 'select', function() {
			units_value = jQuery( this ).val();
			control.setting.set( numeric_value + units_value );
		});
	}
});
/**
 * KIRKI CONTROL: EDITOR
 */
( function( $ ) {
	wp.customizerCtrlEditor = {
		init: function() {
			$( window ).load( function() {
				$( 'textarea.wp-editor-area' ).each( function() {
					var tArea  = $( this ),
					    id     = tArea.attr( 'id' ),
						editor = tinyMCE.get( id ),
						setChange,
						content;

					if ( editor ) {
						editor.onChange.add( function(ed, e) {
							ed.save();
							content = editor.getContent();
							clearTimeout( setChange );
							setChange = setTimeout( function() {
								tArea.val( content ).trigger( 'change' );
							}, 500 );
						});
					}

					tArea.css({ visibility: 'visible' }).on('keyup', function() {
						content = tArea.val();
						clearTimeout( setChange );
						setChange = setTimeout( function() {
							content.trigger( 'change' );
						}, 500 );
					});
				});
			});
		}
	};
	wp.customizerCtrlEditor.init();
})( jQuery );
/**
 * KIRKI CONTROL: MULTICHECK
 */
wp.customize.controlConstructor['multicheck'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Modified values
		control.container.on( 'change', 'input', function() {
			var compiled_value = [];
			var i = 0;
			jQuery.each( control.params.choices, function( key, value ) {
				if ( jQuery( 'input[value="' + key + '"' ).is( ':checked' ) ) {
					compiled_value[i] = key;
					i++;
				}
			});
			control.setting.set( compiled_value );
			wp.customize.previewer.refresh();
		});
	}
});
/**
 * KIRKI CONTROL: NUMBER
 */
wp.customize.controlConstructor['number'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = this.container.find( 'input' );

		jQuery( element ).spinner();
		if ( control.params.choices.min ) {
			jQuery( element ).spinner( 'option', 'min', control.params.choices.min );
		}
		if ( control.params.choices.min ) {
			jQuery( element ).spinner( 'option', 'max', control.params.choices.max );
		}
		if ( control.params.choices.min ) {
			var control_step = ( 'any' == control.params.choises.step ) ? '0.001' : control.params.choices.step;
			jQuery( element ).spinner( 'option', 'step', control_step );
		}
		// On change
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
		// On click
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
		// On keyup
		this.container.on( 'keyup', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: PALETTE
 */
wp.customize.controlConstructor['palette'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: PRESET
 */

wp.customize.controlConstructor['preset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var element = this.container.find( 'select' );

		jQuery( element ).selectize();

		this.container.on( 'change', 'select', function() {

			/**
			 * First of all we have to get the control's value
			 */
			var select_value = jQuery( this ).val();
			/**
			 * Update the value using the customizer API and trigger the "save" button
			 */
			control.setting.set( select_value );
			/**
			 * We have to get the choices of this control
			 * and then start parsing them to see what we have to do for each of the choices.
			 */
			jQuery.each( control.params.choices, function( key, value ) {
				/**
				 * If the current value of the control is the key of the choice,
				 * then we can continue processing.
				 * Otherwise there's no reason to do anything.
				 */
				if ( select_value == key ) {
					/**
					 * Each choice has an array of settings defined in it.
					 * We'll have to loop through them all and apply the changes needed to them.
					 */
					jQuery.each( value['settings'], function( preset_setting, preset_setting_value ) {
						/**
						 * Get the control of the sub-setting.
						 * This will be used to get properties we need from that control,
						 * and determine if we need to do any further work based on those.
						 */
						var sub_control = wp.customize.settings.controls[ preset_setting ];
						/**
						 * Check if the control we want to affect actually exists.
						 * If not then skip the item,
						 */
						if ( typeof sub_control === undefined ) {
							return true;
						}

						/**
						 * Get the control-type of this sub-setting.
						 * We want the value to live-update on the controls themselves,
						 * so depending on the control's type we'll need to do different things.
						 */
						var sub_control_type = sub_control['type'];

						/**
						 * Below we're starting to check the control tyype and depending on what that is,
						 * make the necessary adjustments to it.
						 */

						/**
						 * Control types:
						 *     checkbox
						 *     switch
						 *     toggle
						 *     kirki-checkbox
						 */
						if ( 'checkbox' == sub_control_type || 'switch' == sub_control_type || 'toggle' == sub_control_type || 'kirki-checkbox' == sub_control_type ) {

							var input_element = wp.customize.control( preset_setting ).container.find( 'input' );
							if ( 1 == preset_setting_value ) {
								/**
								 * Update the value visually in the control
								 */
								jQuery( input_element ).prop( "checked", true );
								/**
								 * Update the value in the customizer object
								 */
								wp.customize.instance( preset_setting ).set( true );
							} else {
								/**
								 * Update the value visually in the control
								 */
								jQuery( input_element ).prop( "checked", false );
								/**
								 * Update the value in the customizer object
								 */
								wp.customize.instance( preset_setting ).set( false );
							}

						}
						/**
						 * Control types:
						 *     select
						 *     select2
						 *     select2-multiple
						 *     kirki-select
						 */
						else if ( 'select' == sub_control_type || 'select2' == sub_control_type || 'select2-multiple' == sub_control_type || 'kirki-select' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'select' );
							var $select = jQuery( input_element ).selectize();
							var selectize = $select[0].selectize;
							selectize.setValue( preset_setting_value, true );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     slider
						 */
						else if ( 'slider' == sub_control_type ) {

							/**
							 * Update the value visually in the control (slider)
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input' );
							jQuery( input_element ).prop( "value", preset_setting_value );
							/**
							 * Update the value visually in the control (number)
							 */
							var numeric_element = wp.customize.control( preset_setting ).container.find( '.kirki_range_value .value' );
							jQuery( numeric_element ).html( preset_setting_value );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     textarea
						 *     kirki-textarea
						 */
						else if ( 'textarea' == sub_control_type || 'kirki-textarea' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'textarea' );
							jQuery( input_element ).prop( "value", preset_setting_value );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     color
						 *     kirki-color
						 */
						else if ( 'color' == sub_control_type || 'kirki-color' == sub_control_type ) {

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );
							/**
							 * Update the value visually in the control
							 */

							wp.customize.control( preset_setting ).container.find( '.color-picker-hex' )
								.attr( 'data-default-color', preset_setting_value )
								.data( 'default-color', preset_setting_value )
								.wpColorPicker( 'color', preset_setting_value );

						}
						else if ( 'color-alpha' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var alphaColorControl = wp.customize.control( preset_setting ).container.find( '.kirki-color-control' );

							alphaColorControl
								.attr( 'data-default-color', preset_setting_value )
								.data( 'default-color', preset_setting_value )
								.wpColorPicker( 'color', preset_setting_value );

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Control types:
						 *     dimension
						 */
						else if ( 'dimension' == sub_control_type ) {

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );
							/**
							 * Update the numeric value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input[type=number]' );
							var numeric_value = parseFloat( preset_setting_value );
							jQuery( input_element ).prop( "value", numeric_value );
							/**
							 * Update the units value visually in the control
							 */
							var select_element = wp.customize.control( preset_setting ).container.find( 'select' );
							var units_value    = preset_setting_value.replace( parseFloat( preset_setting_value ), '' );
							jQuery( select_element ).prop( "value", units_value );

						}
						/**
						 * Control types:
						 *     multicheck
						 */
						else if ( 'multicheck' == sub_control_type ) {

							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );
							/**
							 * Update the value visually in the control.
							 * This value is an array so we'll have to go through each one of the items
							 * in order to properly apply the value and check each checkbox separately.
							 *
							 * First we uncheck ALL checkboxes in the control
							 * Then we check the ones that we want.
							 */
							wp.customize.control( preset_setting ).container.find( 'input' ).each(function() {
								jQuery( this ).prop( "checked", false );
							});

							for	( index = 0; index < preset_setting_value.length; index++ ) {
								var input_element = wp.customize.control( preset_setting ).container.find( 'input[value="' + preset_setting_value[ index ] + '"]' );
								jQuery( input_element ).prop( "checked", true );
							}

						}
						/**
						 * Control types:
						 *     radio-buttonset
						 *     radio-image
						 *     radio
						 *     kirki-radio
						 */
						else if ( 'radio-buttonset' == sub_control_type || 'radio-image' == sub_control_type || 'radio' == sub_control_type || 'kirki-radio' == sub_control_type ) {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input[value="' + preset_setting_value + '"]' );
							jQuery( input_element ).prop( "checked", true );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}
						/**
						 * Fallback for all other controls.
						 */
						else {

							/**
							 * Update the value visually in the control
							 */
							var input_element = wp.customize.control( preset_setting ).container.find( 'input' );
							jQuery( input_element ).prop( "value", preset_setting_value );
							/**
							 * Update the value in the customizer object
							 */
							wp.customize.instance( preset_setting ).set( preset_setting_value );

						}

					});

				}

			});

			wp.customize.previewer.refresh();

		});

	}
});
/**
 * KIRKI CONTROL: RADIO-BUTTONSET
 */
wp.customize.controlConstructor['radio-buttonset'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: RADIO-IMAGE
 */
wp.customize.controlConstructor['radio-image'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: RADIO
 */
wp.customize.controlConstructor['kirki-radio'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: REPEATER
 */
function RepeaterRow( rowIndex, element ) {
    this.rowIndex = rowIndex;
    this.rowNumber = rowIndex + 1;
    this.$el = element;
    this.$dragger = this.$el.find( '.repeater-row-move' );
    this.$minimizer = this.$el.find( '.repeater-row-minimize' );
    this.$remover = this.$el.find( '.repeater-row-remove' );
    this.$number = this.$el.find( '.repeater-row-number' );
    this.$fields = this.$el.find( 'input,select,textarea' );

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
    if ( confirm( "Are you sure?" ) ) {
        this.$el.slideUp( 300, function() {
            jQuery(this).detach();
        });
        this.$el.trigger( 'row:remove', [ this.getRowIndex() ] );
    }
};

RepeaterRow.prototype.renderNumber = function() {
    this.$number.text( this.getRowNumber() );
};

wp.customize.controlConstructor['repeater'] = wp.customize.Control.extend({
    ready: function() {
        var control = this;

        // The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
        var settingValue = this.params.value;

        // The hidden field that keeps the data saved (though we never update it)
        this.settingField = this.container.find('[data-customize-setting-link]').first();

        // Set the field value for the first time, we'll fill it up later
        this.setValue( [], false );

        // The DIV that holds all the rows
        this.repeaterFieldsContainer = control.container.find('.repeater-fields').first();

        // Set number of rows to 0
        this.currentIndex = 0;

        // Save the rows objects
        this.rows = [];


        control.container.on('click', 'button.repeater-add', function (e) {
            e.preventDefault();
            control.addRow();
        });

        /**
         * Function that loads the Mustache template
         */
        this.repeaterTemplate = _.memoize(function () {
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

            return function (data) {
                compiled = _.template(control.container.find('.customize-control-repeater-content').first().html(), null, options);
                return compiled(data);
            };
        });

        // When we load the control, the fields have not been filled up
        // This is the first time that we create all the rows
        if (settingValue.length) {
            for (var i = 0; i < settingValue.length; i++) {
                control.addRow(settingValue[i]);
            }
        }

        this.repeaterFieldsContainer.sortable({
            handle: ".repeater-row-move",
            update: function( e, ui ) {
                control.sort();
            }
        });

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
            row,

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
                        templateData[i].default = data[i];
                    }
                }
            }

            templateData['index'] = this.currentIndex;
            templateData['ControlId'] = this.id;

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
                    if ( control.rows.hasOwnProperty( i ) && control.rows[i] ) {
                        control.rows[i].minimize();
                    }
                }
            });

            // Add the row to rows collection
            this.rows[ this.currentIndex ] = newRow;

            for ( i in templateData ) {
                if ( templateData.hasOwnProperty( i ) ) {
                    newRowSetting[ i ] = templateData[i].default;
                }
            }

            settingValue[this.currentIndex] = newRowSetting;
            this.setValue( settingValue, true );

            this.currentIndex++;

        }

    },

    sort: function() {
        var control = this;
        var $rows = this.repeaterFieldsContainer.find( '.repeater-row' );
        var newOrder = [];

        $rows.each( function( i, element ) {
            newOrder.push( jQuery( element ).data( 'row' ) );
        });

        var settings = control.getValue();
        var newRows = [];
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
                delete currentSettings[index];

                // Remove the row from the rows collection
                delete this.rows[index];

                // Update the new setting values
                this.setValue( currentSettings, true );
            }
        }

        // Remap the row numbers
        var i = 1;
        for ( prop in this.rows ) {
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

        var type = this.params.fields[ fieldId].type;
        var row = this.rows[ rowIndex ];
        var currentSettings = this.getValue();
        element = jQuery( element );

        if (typeof currentSettings[row.getRowIndex()][fieldId] == undefined) {
            return;
        }

        if ( type == 'checkbox' ) {
            currentSettings[row.getRowIndex()][fieldId] = element.is( ':checked' );
        }
        else {
            // Update the settings
            currentSettings[row.getRowIndex()][fieldId] = element.val();
        }

        this.setValue( currentSettings, true );

    }
});
/**
 * KIRKI CONTROL: KIRKI-SELECT
 */
function kirkiArrayToObject( arr ) {
	var rv = {};
	if ( null !== arr ) {
		for ( var i = 0; i < arr.length; ++i ) {
			if ( arr[i] !== undefined ) rv[i] = arr[i];
		}
	}
	return rv;
}

wp.customize.controlConstructor['kirki-select'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		var element  = this.container.find( 'select' );
		var multiple = parseInt( element.data( 'multiple' ) );

		if ( multiple > 1 ) {
			jQuery( element ).selectize({
				maxItems: multiple,
				plugins: ['remove_button', 'drag_drop']
			});
		} else {
			jQuery( element ).selectize();
		}

		this.container.on( 'change', 'select', function() {
			if ( multiple > 1 ) {
				var select_value = kirkiArrayToObject( jQuery( this ).val() );
			} else {
				var select_value = jQuery( this ).val();
			}
			control.setting.set( select_value );
		});
	}
});
/**
 * KIRKI CONTROL: SLIDER
 */
jQuery(document).ready(function($) {

	$( 'input[type=range]' ).on( 'mousedown', function() {
		value = $( this ).attr( 'value' );
		$( this ).mousemove(function() {
			value = $( this ).attr( 'value' );
			$( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( value );
		});
	});

	$( '.kirki-slider-reset' ).click( function () {
		var $this_input   = $( this ).closest( 'label' ).find( 'input' ),
			input_name    = $this_input.data( 'customize-setting-link' ),
			input_default = $this_input.data( 'reset_value' );

		$this_input.val( input_default );
		$this_input.change();
	});

});

wp.customize.controlConstructor['slider'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
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
/**
 * KIRKI CONTROL: SPACING
 */
wp.customize.controlConstructor['spacing'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		// get initial values and pre-populate the object
		if ( control.container.has( '.top' ).size() ) {
			compiled_value['top'] = control.setting._value['top'];
		}
		if ( control.container.has( '.bottom' ).size() ) {
			compiled_value['bottom'] = control.setting._value['bottom'];
		}
		if ( control.container.has( '.left' ).size() ) {
			compiled_value['left']  = control.setting._value['left'];
		}
		if ( control.container.has( '.right' ).size() ) {
			compiled_value['right']    = control.setting._value['right'];
		}

		// use selectize
		jQuery( '.customize-control-spacing select' ).selectize();

		// top
		if ( control.container.has( '.top' ).size() ) {
			var top_numeric_value = control.container.find('.top input[type=number]' ).val();
			var top_units_value   = control.container.find('.top select' ).val();

			this.container.on( 'change', '.top input', function() {
				top_numeric_value = jQuery( this ).val();
				compiled_value['top'] = top_numeric_value + top_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.top select', function() {
				top_units_value = jQuery( this ).val();
				compiled_value['top'] = top_numeric_value + top_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// bottom
		if ( control.container.has( '.bottom' ).size() ) {
			var bottom_numeric_value = control.container.find('.bottom input[type=number]' ).val();
			var bottom_units_value   = control.container.find('.bottom select' ).val();

			this.container.on( 'change', '.bottom input', function() {
				bottom_numeric_value = jQuery( this ).val();
				compiled_value['bottom'] = bottom_numeric_value + bottom_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.bottom select', function() {
				bottom_units_value = jQuery( this ).val();
				compiled_value['bottom'] = bottom_numeric_value + bottom_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// left
		if ( control.container.has( '.left' ).size() ) {
			var left_numeric_value = control.container.find('.left input[type=number]' ).val();
			var left_units_value   = control.container.find('.left select' ).val();

			this.container.on( 'change', '.left input', function() {
				left_numeric_value = jQuery( this ).val();
				compiled_value['left'] = left_numeric_value + left_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.left select', function() {
				left_units_value = jQuery( this ).val();
				compiled_value['left'] = left_numeric_value + left_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// right
		if ( control.container.has( '.right' ).size() ) {
			var right_numeric_value = control.container.find('.right input[type=number]' ).val();
			var right_units_value   = control.container.find('.right select' ).val();

			this.container.on( 'change', '.right input', function() {
				right_numeric_value = jQuery( this ).val();
				compiled_value['right'] = right_numeric_value + right_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.right select', function() {
				right_units_value = jQuery( this ).val();
				compiled_value['right'] = right_numeric_value + right_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}
	}
});
/**
 * KIRKI CONTROL: SWITCH
 */
wp.customize.controlConstructor['switch'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Get the initial value
		var checkbox_value = control.setting._value;

		this.container.on( 'change', 'input', function() {
			checkbox_value = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkbox_value );
		});
	}
});
/**
 * KIRKI CONTROL: TEXT
 */
wp.customize.controlConstructor['kirki-text'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change keyup paste', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: TEXTAREA
 */
wp.customize.controlConstructor['kirki-textarea'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change keyup paste', '.textarea', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: TOGGLE
 */
wp.customize.controlConstructor['toggle'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Get the initial value
		var checkbox_value = control.setting._value;

		this.container.on( 'change', 'input', function() {
			checkbox_value = ( jQuery( this ).is( ':checked' ) ) ? true : false;
			control.setting.set( checkbox_value );
		});
	}
});
/**
 * KIRKI CONTROL: TYPOGRAPHY
 */
wp.customize.controlConstructor['typography'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var compiled_value = {};

		// get initial values and pre-populate the object
		if ( control.container.has( '.bold' ).size() ) {
			compiled_value['bold']           = control.setting._value['bold'];
		}
		if ( control.container.has( '.italic' ).size() ) {
			compiled_value['italic']         = control.setting._value['italic'];
		}
		if ( control.container.has( '.underline' ).size() ) {
			compiled_value['underline']      = control.setting._value['underline'];
		}
		if ( control.container.has( '.strikethrough' ).size() ) {
			compiled_value['strikethrough']  = control.setting._value['strikethrough'];
		}
		if ( control.container.has( '.font-family' ).size() ) {
			compiled_value['font-family']    = control.setting._value['font-family'];
		}
		if ( control.container.has( '.font-size' ).size() ) {
			compiled_value['font-size']      = control.setting._value['font-size'];
		}
		if ( control.container.has( '.font-weight' ).size() ) {
			compiled_value['font-weight']    = control.setting._value['font-weight'];
		}
		if ( control.container.has( '.line-height' ).size() ) {
			compiled_value['line-height']    = control.setting._value['line-height'];
		}
		if ( control.container.has( '.letter-spacing' ).size() ) {
			compiled_value['letter-spacing'] = control.setting._value['letter-spacing'];
		}

		// use selectize
		jQuery( '.customize-control-typography select' ).selectize();

		// bold
		if ( control.container.has( '.bold' ).size() ) {
			this.container.on( 'change', '.bold input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['bold'] = true;
				} else {
					compiled_value['bold'] = false;
				}
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// italic
		if ( control.container.has( '.italic' ).size() ) {
			this.container.on( 'change', '.italic input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['italic'] = true;
				} else {
					compiled_value['italic'] = false;
				}
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// underline
		if ( control.container.has( '.underline' ).size() ) {
			this.container.on( 'change', '.underline input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['underline'] = true;
				} else {
					compiled_value['underline'] = false;
				}
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// strikethrough
		if ( control.container.has( '.strikethrough' ).size() ) {
			this.container.on( 'change', '.strikethrough input', function() {
				if ( jQuery( this ).is( ':checked' ) ) {
					compiled_value['strikethrough'] = true;
				} else {
					compiled_value['strikethrough'] = false;
				}
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// font-family
		if ( control.container.has( '.font-family' ).size() ) {
			this.container.on( 'change', '.font-family select', function() {
				compiled_value['font-family'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// font-size
		if ( control.container.has( '.font-size' ).size() ) {
			var font_size_numeric_value = control.container.find('.font-size input[type=number]' ).val();
			var font_size_units_value   = control.container.find('.font-size select' ).val();

			this.container.on( 'change', '.font-size input', function() {
				font_size_numeric_value = jQuery( this ).val();
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.font-size select', function() {
				font_size_units_value = jQuery( this ).val();
				compiled_value['font-size'] = font_size_numeric_value + font_size_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// font-weight
		if ( control.container.has( '.font-weight' ).size() ) {
			this.container.on( 'change', '.font-weight select', function() {
				compiled_value['font-weight'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// line-height
		if ( control.container.has( '.line-height' ).size() ) {
			this.container.on( 'change', '.line-height input', function() {
				compiled_value['line-height'] = jQuery( this ).val();
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}

		// letter-spacing
		if ( control.container.has( '.letter-spacing' ).size() ) {
			var letter_spacing_numeric_value = control.container.find('.letter-spacing input[type=number]' ).val();
			var letter_spacing_units_value   = control.container.find('.letter-spacing select' ).val();

			this.container.on( 'change', '.letter-spacing input', function() {
				letter_spacing_numeric_value = jQuery( this ).val();
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
			this.container.on( 'change', '.letter-spacing select', function() {
				letter_spacing_units_value = jQuery( this ).val();
				compiled_value['letter-spacing'] = letter_spacing_numeric_value + letter_spacing_units_value;
				control.setting.set( compiled_value );
				wp.customize.previewer.refresh();
			});
		}
	}
});
