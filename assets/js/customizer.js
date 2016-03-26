function kirkiArrayToObject( arr ) {
	var obj = {};
	if ( null !== arr ) {
		for ( var i = 0; i < arr.length; ++i ) {
			if ( undefined !== arr[ i ] ) {
				obj[ i ] = arr[ i ];
			}
		}
	}
	return obj;
}

function kirkiObjectToArray( obj ) {
	var arr = [];
	if ( null !== obj ) {
		for ( var i = 0; i < obj.length; ++i ) {
			if ( undefined !== obj[ i ] ) {
				arr.push( obj[ i ] );
			}
		}
	}
	return arr;
}

function kirkiValidateCSSValue( value ) {
	// 0 is always a valid value
	if ( '0' == value ) {
		return true;
	}
	// if we're using calc() just return true.
	if ( 0 <= value.indexOf( 'calc(' ) && 0 <= value.indexOf( ')' ) ) {
		return true;
	}

	var validUnits   = ['rem', 'em', 'ex', '%', 'px', 'cm', 'mm', 'in', 'pt', 'pc', 'ch', 'vh', 'vw', 'vmin', 'vmax'];
	// Get the numeric value
	var numericValue = parseFloat( value );
	// Get the unit
	var unit = value.replace( numericValue, '' );
	// Check the validity of the numeric value
	if ( NaN === numericValue ) {
		return false;
	}
	// Check the validity of the units
	if ( -1 === jQuery.inArray( unit, validUnits ) ) {
		return false;
	}
	return true;
}

function kirkiSetValue( setting, value ) {
	/**
	 * Get the control of the sub-setting.
	 * This will be used to get properties we need from that control,
	 * and determine if we need to do any further work based on those.
	 */
	var sub_control = wp.customize.settings.controls[ setting ];
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
	var control_type = sub_control['type'];

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
	if ( 'checkbox' == control_type || 'switch' == control_type || 'toggle' == control_type || 'kirki-checkbox' == control_type ) {

		if ( 1 == value ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "checked", true );
			// Update the value in the customizer object
			wp.customize.instance( setting ).set( true );
		} else {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "checked", false );
			// Update the value in the customizer object
			wp.customize.instance( setting ).set( false );
		}

	}
	/**
	 * Control types:
	 *     select
	 *     select2
	 *     select2-multiple
	 *     kirki-select
	 */
	else if ( 'select' == control_type || 'select2' == control_type || 'select2-multiple' == control_type || 'kirki-select' == control_type || 'preset' == control_type ) {

		// Update the value visually in the control
		var $select = jQuery( wp.customize.control( setting ).container.find( 'select' ) ).selectize();
		var selectize = $select[0].selectize;
		selectize.setValue( value, true );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     slider
	 */
	else if ( 'slider' == control_type ) {

		// Update the value visually in the control (slider)
		jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "value", value );
		// Update the value visually in the control (number)
		jQuery( wp.customize.control( setting ).container.find( '.kirki_range_value .value' ) ).html( value );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     textarea
	 *     kirki-textarea
	 */
	else if ( 'textarea' == control_type || 'kirki-textarea' == control_type ) {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'textarea' ) ).prop( "value", value );
		// Update the value in the customizer object
		wp.customize( setting ).set( value );

	}
	/**
	 * Control types:
	 *     color
	 *     kirki-color
	 *     color-alpha
	 */
	else if ( 'color-alpha' == control_type || 'kirki-color' == control_type || 'color' == control_type ) {

		// Update the value visually in the control
		var alphaColorControl = wp.customize.control( setting ).container.find( '.kirki-color-control' );

		alphaColorControl
			.attr( 'data-default-color', value )
			.data( 'default-color', value )
			.wpColorPicker( 'color', value );

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     multicheck
	 */
	else if ( 'multicheck' == control_type ) {

		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );
		/**
		 * Update the value visually in the control.
		 * This value is an array so we'll have to go through each one of the items
		 * in order to properly apply the value and check each checkbox separately.
		 *
		 * First we uncheck ALL checkboxes in the control
		 * Then we check the ones that we want.
		 */
		wp.customize.control( setting ).container.find( 'input' ).each(function() {
			jQuery( this ).prop( "checked", false );
		});

		for	( index = 0; index < value.length; index++ ) {
			jQuery( wp.customize.control( setting ).container.find( 'input[value="' + value[ index ] + '"]' ) ).prop( "checked", true );
		}

	}
	/**
	 * Control types:
	 *     radio-buttonset
	 *     radio-image
	 *     radio
	 *     kirki-radio
	 *     dashicons
	 *     color-pallette
	 *     palette
	 */
	else if ( 'radio-buttonset' == control_type || 'radio-image' == control_type || 'radio' == control_type || 'kirki-radio' == control_type || 'dashicons' == control_type || 'color-palette' == control_type || 'palette' == control_type ) {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'input[value="' + value + '"]' ) ).prop( "checked", true );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}
	/**
	 * Control types:
	 *     typography
	 */
	else if ( 'typography' == control_type ) {
		if ( undefined !== value['font-family'] ) {
			var $select = jQuery( wp.customize.control( setting ).container.find( '.font-family select' ) ).selectize();
			var selectize = $select[0].selectize;
			// Update the value visually in the control
			selectize.setValue( value['font-family'], true );
		}
		if ( undefined !== value['variant'] ) {
			var $select = jQuery( wp.customize.control( setting ).container.find( '.variant select' ) ).selectize();
			var selectize = $select[0].selectize;
			// Update the value visually in the control
			selectize.setValue( value['variant'], true );
		}
		if ( undefined !== value['subset'] ) {
			var $select = jQuery( wp.customize.control( setting ).container.find( '.subset select' ) ).selectize();
			var selectize = $select[0].selectize;
			// Update the value visually in the control
			selectize.setValue( value['subset'], true );
		}
		if ( undefined !== value['font-size'] ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.font-size input' ) ).prop( "value", value['font-size'] );
		}
		if ( undefined !== value['line-height'] ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.line-height input' ) ).prop( "value", value['line-height'] );
		}
		if ( undefined !== value['letter-spacing'] ) {
			// Update the value visually in the control
			jQuery( wp.customize.control( setting ).container.find( '.letter-spacing input' ) ).prop( "value", value['letter-spacing'] );
		}
		if ( undefined !== value['color'] ) {
			// Update the value visually in the control
			var typographyColor = wp.customize.control( setting ).container.find( '.kirki-color-control' );

			typographyColor
				.attr( 'data-default-color', value )
				.data( 'default-color', value )
				.wpColorPicker( 'color', value );
		}
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );
	}
	/**
	 * Control types:
	 *     repeater
	 */
	else if ( 'repeater' == control_type ) {
		// Do nothing
	}
	/**
	 * Fallback for all other controls.
	 */
	else {

		// Update the value visually in the control
		jQuery( wp.customize.control( setting ).container.find( 'input' ) ).prop( "value", value );
		// Update the value in the customizer object
		wp.customize.instance( setting ).set( value );

	}

}
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

		if ( undefined !== control.params.choices ) {
			picker.wpColorPicker( control.params.choices );
		}

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
 * KIRKI CONTROL: COLOR PALETTE
 */
wp.customize.controlConstructor['color-palette'] = wp.customize.Control.extend( {
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
wp.customize.controlConstructor['dashicons'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'click', 'input', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: DATETIME
 */
wp.customize.controlConstructor['kirki-datetime'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		var selector = control.selector + ' input.datepicker';
		jQuery( selector ).datepicker({
			inline: true
		});

		this.container.on( 'change keyup paste', 'input.datepicker', function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
/**
 * KIRKI CONTROL: DIMENSION
 */
wp.customize.controlConstructor['dimension'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		// Validate the value and show a warning if it's invalid
		if ( false === kirkiValidateCSSValue( control.setting._value ) ) {
			jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );
		} else {
			jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );
		}

		this.container.on( 'change keyup paste', 'input', function() {
			var value = jQuery( this ).val();
			// Validate the value and show a warning if it's invalid
			if ( false === kirkiValidateCSSValue( value ) ) {
				jQuery( control.selector + ' .input-wrapper' ).addClass( 'invalid' );
			} else {
				jQuery( control.selector + ' .input-wrapper' ).removeClass( 'invalid' );
				// Set the value to the customizer
				control.setting.set( value );
			}
		});
	}
});
/**
 * KIRKI CONTROL: DROPDOWN-PAGES
 */
wp.customize.controlConstructor['dropdown-pages'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;

		var element  = this.container.find( 'select' );
		jQuery( element ).selectize();
		this.container.on( 'change', 'select', function() {
			control.setting.set( jQuery( this ).val() );
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
 * KIRKI CONTROL: GENERIC
 */
wp.customize.controlConstructor['kirki-generic'] = wp.customize.Control.extend( {
	ready: function() {
		var control = this;
		this.container.on( 'change keyup paste', control.params.choices.element, function() {
			control.setting.set( jQuery( this ).val() );
		});
	}
});
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
				if ( control.container.find( 'input[value="' + key + '"]' ).is( ':checked' ) ) {
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
		if ( control.params.choices.max ) {
			jQuery( element ).spinner( 'option', 'max', control.params.choices.max );
		}
		if ( control.params.choices.step ) {
			if ( 'any' == control.params.choices.step ) {
				jQuery( element ).spinner( 'option', 'step', '0.001' );
			} else {
				jQuery( element ).spinner( 'option', 'step', control.params.choices.step );
			}
		}
		// On change
		this.container.on( 'change click keyup paste', 'input', function() {
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
						kirkiSetValue( preset_setting, preset_setting_value );
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
        this.repeaterFieldsContainer = this.container.find('.repeater-fields').first();

        // Set number of rows to 0
        this.currentIndex = 0;

        // Save the rows objects
        this.rows = [];

        // Default limit choice
        if ( this.params.choices.limit !== undefined ) {
            if ( this.params.choices.limit <= 0 ) {
                var limit = false;
            } else {
                var limit = parseInt(this.params.choices.limit);
            }
        } else {
            var limit = false;
        }

        this.container.on('click', 'button.repeater-add', function (e) {
            e.preventDefault();
            if ( !limit || control.currentIndex < limit ) {
                control.addRow();
                jQuery( control.selector + ' .repeater-row' ).last().toggleClass( 'minimized' );
            } else {
                jQuery( control.selector + ' .limit' ).addClass( 'highlight' );
            }
        });

        this.container.on('click', '.repeater-row-remove', function (e) {
            control.currentIndex--;
            if ( !limit || control.currentIndex < limit ) {
                jQuery( control.selector + ' .limit' ).removeClass( 'highlight' );
            }
        });

        this.container.on('click keypress', '.repeater-field-image .upload-button', function (e) {
            e.preventDefault();
            control.$thisButton = jQuery(this);
            control.openFrame(e);
        });

        this.container.on('click keypress', '.repeater-field-image .remove-button', function (e) {
            e.preventDefault();
            control.$thisButton = jQuery(this);
            control.removeImage(e);
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
     * Open the media modal.
     */
    openFrame: function( event ) {
        if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) return;

        if ( ! this.frame ) {
            this.initFrame();
        }

        this.frame.open();
    },

    initFrame : function()
    {
        var control = this;

        this.frame = wp.media({
            states: [
                new wp.media.controller.Library({
                    library:   wp.media.query({ type: 'image' }),
                    multiple:  false,
                    date:      false
                })
            ]
        });

        // When a file is selected, run a callback.
        this.frame.on( 'select', function(e){
            control.selectImage();
        });
    },

    selectImage : function()
    {
        var attachment = this.frame.state().get( 'selection' ).first().toJSON();

        var image_src = attachment.url;

        var $targetDiv = this.$thisButton.closest('.repeater-field-image');

        $targetDiv.find('.kirki-image-attachment').html( '<img src="'+ image_src +'">' )
        .hide().slideDown('slow');
        $targetDiv.find('.hidden-field').val(image_src);
        this.$thisButton.text( this.$thisButton.data('alt-label') );
        $targetDiv.find('.remove-button').show();

        //This will activate the save button
        $targetDiv.find('input, textarea, select').trigger('change');
    },

    removeImage : function( event )
    {
        if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) return;

        var $targetDiv = this.$thisButton.closest('.repeater-field-image');
        var $uploadButton = $targetDiv.find('.upload-button');

        $targetDiv.find('.kirki-image-attachment').slideUp( 'fast', function(){
            jQuery(this).show().html( jQuery(this).data('placeholder') );
        });
        $targetDiv.find('.hidden-field').val('');
        $uploadButton.text($uploadButton.data('label'));
        this.$thisButton.hide();

        $targetDiv.find('input, textarea, select').trigger('change');
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
		$( this ).closest( 'label' ).find( '.kirki_range_value .value' ).text( input_default );
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

		jQuery.each( ['top', 'bottom', 'left', 'right'], function( index, dimension ) {

			// get initial values and pre-populate the object
			if ( control.container.has( '.' + dimension ).size() ) {
				compiled_value[ dimension ] = control.setting._value[ dimension ];
				// Validate the value and show a warning if it's invalid
				if ( false === kirkiValidateCSSValue( control.setting._value[ dimension ] ) ) {
					jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).addClass( 'invalid' );
				} else {
					jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).removeClass( 'invalid' );
				}
			}

			if ( control.container.has( '.' + dimension ).size() ) {
				control.container.on( 'change keyup paste', '.' + dimension + ' input', function() {
					subValue = jQuery( this ).val();
					// Validate the value and show a warning if it's invalid
					if ( false === kirkiValidateCSSValue( subValue ) ) {
						jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).addClass( 'invalid' );
					} else {
						jQuery( control.selector + ' .' + dimension + '.input-wrapper' ).removeClass( 'invalid' );
						// only proceed if value is valid
						compiled_value[ dimension ] = subValue;
						control.setting.set( compiled_value );
						wp.customize.previewer.refresh();
					}
				});
			}
		});
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
		var fontFamilySelector = control.selector + ' .font-family select';
		var variantSelector    = control.selector + ' .variant select';
		var subsetSelector     = control.selector + ' .subset select';
		// Get initial values
		var value = {};
		value['font-family']    = ( undefined !== control.setting._value['font-family'] ) ? control.setting._value['font-family'] : '';
		value['font-size']      = ( undefined !== control.setting._value['font-size'] ) ? control.setting._value['font-size'] : '';
		value['variant']        = ( undefined !== control.setting._value['variant'] ) ? control.setting._value['variant'] : '';
		value['subset']         = ( undefined !== control.setting._value['subset'] ) ? control.setting._value['subset'] : '';
		value['line-height']    = ( undefined !== control.setting._value['line-height'] ) ? control.setting._value['line-height'] : '';
		value['letter-spacing'] = ( undefined !== control.setting._value['letter-spacing'] ) ? control.setting._value['letter-spacing'] : '';
		value['color']          = ( undefined !== control.setting._value['color'] ) ? control.setting._value['color'] : '';

		var renderSubControl = function( fontFamily, sub, startValue ) {
			subSelector = ( 'variant' == sub ) ? variantSelector : subsetSelector;
			var is_standard = false;
			var subList = {}
			// destroy
			if ( undefined !== jQuery( subSelector ).selectize()[0] ) {
				jQuery( subSelector ).selectize()[0].selectize.destroy();
			}
			// Get all items in the sub-list for the active font-family
			for ( var i = 0, len = kirkiAllFonts.length; i < len; i++ ) {
				if ( fontFamily === kirkiAllFonts[ i ]['family'] ) {
					if ( undefined !== kirkiAllFonts[ i ]['is_standard'] && true === kirkiAllFonts[ i ]['is_standard'] ) {
						is_standard = true;
					}
					subList = kirkiAllFonts[ i ][ sub + 's' ]; // the 's' is for plural (variant/variants, subset/subsets)
				}
			}
			if ( false === is_standard || 'subset' !== sub ) {
				// Determine the initial value we have to use
				if ( null === startValue  ) {
					if ( 'variant' == sub ) { // the context here is variants
						for ( var i = 0, len = subList.length; i < len; i++ ) {
							if ( undefined !== subList[ i ]['id'] ) {
								var activeItem = value['variant'];
							} else {
								var defaultValue = 'regular';
								if ( defaultValue == subList[ i ]['id'] ) {
									var hasDefault = true;
								} else if ( undefined === firstAvailable ) {
									var firstAvailable = subList[ i ]['id'];
								}
							}
						}
					} else if ( 'subset' == sub ) { // The context here is subsets
						var subsetValues = {};
						for ( var i = 0, len = subList.length; i < len; i++ ) {
							if ( null !== value['subset'] ) {
								for ( var s = 0, len = value['subset'].length; s < len; s++ ) {
									if ( undefined !== subList[ i ] && value['subset'][ s ] == subList[ i ]['id'] ) {
										subsetValues[ value['subset'][ s ] ] = value['subset'][ s ];
									}
								}
							}
						}
						if ( 0 == subsetValues.length ) {
							activeItem = ['latin']
						} else {
							var subsetValuesArray = jQuery.map( subsetValues, function(value, index) {
								return [value];
							});
							activeItem = subsetValuesArray;
						}
					}
					// If we have a valid setting, use it.
					// If not, check if the default value exists.
					// If not, then use the 1st available option.
					subValue = ( undefined !== activeItem ) ? activeItem : ( undefined !== hasDefault ) ? 'regular' : firstAvailable;
				} else {
					subValue = startValue;
				}
				// create
				var subSelectize;
				subSelectize = jQuery( subSelector ).selectize({
					maxItems:    ( 'variant' == sub ) ? 1 : null,
					valueField:  'id',
					labelField:  'label',
					searchField: ['label'],
					options:     subList,
					items:       ( 'variant' == sub ) ? [ subValue ] : subValue,
					create:      false,
					plugins:     ( 'variant' == sub ) ? '' : ['remove_button'],
					render: {
						item: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; },
						option: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; }
					},
				}).data( 'selectize' );
			}


			// If only 1 option is available then there's no reason to show this.
			if ( 'variant' == sub ) {
				if ( 1 === subList.length || 0 === subList.length ) {
					control.container.find( '.kirki-variant-wrapper' ).css( 'display', 'none' );
				} else {
					control.container.find( '.kirki-variant-wrapper' ).css( 'display', 'block' );
				}
			} else if ( 'subset' == sub ) {
				if ( 0 === subList.length ) {
					control.container.find( '.kirki-subset-wrapper' ).css( 'display', 'none' );
				} else {
					control.container.find( '.kirki-subset-wrapper' ).css( 'display', 'block' );
				}
			}

			if ( true === is_standard ) {
				control.container.find( '.hide-on-standard-fonts' ).css( 'display', 'none' );
			} else {
				control.container.find( '.hide-on-standard-fonts' ).css( 'display', 'block' );
			}
		};

		// Render the font-family
		jQuery( fontFamilySelector ).selectize({
			options:     kirkiAllFonts,
			items:       [ control.setting._value['font-family'] ],
			persist:     false,
			maxItems:    1,
			valueField:  'family',
			labelField:  'label',
			searchField: ['family', 'label', 'subsets'],
			create:      false,
			render: {
				item: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; },
				option: function( item, escape ) { return '<div>' + escape( item.label ) + '</div>'; }
			},
		});

		// Render the variants
		// Please note that when the value of font-family changes,
		// this will be destroyed and re-created.
		renderSubControl( value['font-family'], 'variant', value['variant'] );

		// Render the subsets
		// Please note that when the value of font-family changes,
		// this will be destroyed and re-created.
		renderSubControl( value['font-family'], 'subset', value['subset'] );

		this.container.on( 'change', '.font-family select', function() {
			// add the value to the array and set the setting's value
			value['font-family'] = jQuery( this ).val();
			control.setting.set( value );
			// trigger changes to variants & subsets
			renderSubControl( jQuery( this ).val(), 'variant', null );
			renderSubControl( jQuery( this ).val(), 'subset', null );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change', '.variant select', function() {
			// add the value to the array and set the setting's value
			value['variant'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change', '.subset select', function() {
			// add the value to the array and set the setting's value.
			value['subset'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change keyup paste', '.font-size input', function() {
			// add the value to the array and set the setting's value
			value['font-size'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change keyup paste', '.line-height input', function() {
			// add the value to the array and set the setting's value
			value['line-height'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		this.container.on( 'change keyup paste', '.letter-spacing input', function() {
			// add the value to the array and set the setting's value
			value['letter-spacing'] = jQuery( this ).val();
			control.setting.set( value );
			// refresh the preview
			wp.customize.previewer.refresh();
		});

		var picker = this.container.find ( '.kirki-color-control' );
		picker.wpColorPicker ( {
			change: function() {
				setTimeout ( function() {
					// add the value to the array and set the setting's value
					value[ 'color' ] = picker.val ();
					control.setting.set ( value );
					// refresh the preview
					wp.customize.previewer.refresh ();
				}, 100 );
			}
		} );
	}
});
jQuery(document).ready(function($) { "use strict";

	jQuery( 'a.kirki-reset-section' ).on( 'click', function() {
		// var reset = confirm( "Reset all settings in section" );
		// if ( reset == true ) {

			// Get the section ID
			var id = jQuery( this ).data( 'reset-section-id' );
			// Get controls inside the section
			var controls = wp.customize.section( id ).controls();
			// Loop controls
			for ( var i = 0, len = controls.length; i < len; i++ ) {
				// set value to default
				kirkiSetValue( controls[ i ]['id'], controls[ i ]['params']['default'] );
			};

		// }

	});


});
