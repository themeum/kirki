jQuery( document ).ready( function() {

	wp.customize.section.each( function( section ) {

		// Get the pane element.
		var pane      = jQuery( '#sub-accordion-section-' + section.id ),
		    sectionLi = jQuery( '#accordion-section-' + section.id );

		// Check if the section is expanded.
		if ( sectionLi.hasClass( 'control-section-kirki-expanded' ) ) {

			// Move element.
			pane.appendTo( sectionLi );

		}

	} );

} );

/**
 * @see https://wordpress.stackexchange.com/a/256103/17078
 */
( function() {

	var _panelEmbed,
	    _panelIsContextuallyActive,
	    _panelAttachEvents,
	    _sectionEmbed,
	    _sectionIsContextuallyActive,
	    _sectionAttachEvents;

	wp.customize.bind( 'pane-contents-reflowed', function() {

		var panels   = [],
		    sections = [];

		// Reflow Sections.
		wp.customize.section.each( function( section ) {

			if ( 'kirki-nested' !== section.params.type || _.isUndefined( section.params.section ) ) {
				return;
			}
			sections.push( section );
		});

		sections.sort( wp.customize.utils.prioritySort ).reverse();

		jQuery.each( sections, function( i, section ) {
			var parentContainer = jQuery( '#sub-accordion-section-' + section.params.section );

			parentContainer.children( '.section-meta' ).after( section.headContainer );
		});

		// Reflow Panels.
		wp.customize.panel.each( function( panel ) {
			if ( 'kirki-nested' !== panel.params.type || _.isUndefined( panel.params.panel ) ) {
				return;
			}
			panels.push( panel );
		});

		panels.sort( wp.customize.utils.prioritySort ).reverse();

		jQuery.each( panels, function( i, panel ) {
			var parentContainer = jQuery( '#sub-accordion-panel-' + panel.params.panel );

			parentContainer.children( '.panel-meta' ).after( panel.headContainer );
		});
	});

	// Extend Panel.
	_panelEmbed = wp.customize.Panel.prototype.embed;
	_panelIsContextuallyActive = wp.customize.Panel.prototype.isContextuallyActive;
	_panelAttachEvents = wp.customize.Panel.prototype.attachEvents;

	wp.customize.Panel = wp.customize.Panel.extend({
		attachEvents: function() {
			var panel;

			if ( 'kirki-nested' !== this.params.type || _.isUndefined( this.params.panel ) ) {
				_panelAttachEvents.call( this );
				return;
			}

			_panelAttachEvents.call( this );

			panel = this;

			panel.expanded.bind( function( expanded ) {
				var parent = wp.customize.panel( panel.params.panel );

				if ( expanded ) {
					parent.contentContainer.addClass( 'current-panel-parent' );
				} else {
					parent.contentContainer.removeClass( 'current-panel-parent' );
				}
			});

			panel.container.find( '.customize-panel-back' ).off( 'click keydown' ).on( 'click keydown', function( event ) {
				if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
					return;
				}
				event.preventDefault(); // Keep this AFTER the key filter above

				if ( panel.expanded() ) {
					wp.customize.panel( panel.params.panel ).expand();
				}
			});
		},

		embed: function() {

			var panel = this,
			    parentContainer;
			if ( 'kirki-nested' !== this.params.type || _.isUndefined( this.params.panel ) ) {
				_panelEmbed.call( this );
				return;
			}

			_panelEmbed.call( this );

			parentContainer = jQuery( '#sub-accordion-panel-' + this.params.panel );

			parentContainer.append( panel.headContainer );
		},

		isContextuallyActive: function() {

			var panel = this,
			    children,
			    activeCount = 0;

			if ( 'kirki-nested' !== this.params.type ) {
				return _panelIsContextuallyActive.call( this );
			}

			children = this._children( 'panel', 'section' );

			wp.customize.panel.each( function( child ) {
				if ( ! child.params.panel ) {
					return;
				}

				if ( child.params.panel !== panel.id ) {
					return;
				}

				children.push( child );
			});

			children.sort( wp.customize.utils.prioritySort );

			_( children ).each( function( child ) {
				if ( child.active() && child.isContextuallyActive() ) {
					activeCount += 1;
				}
			});
			return ( 0 !== activeCount );
		}
	});

	// Extend Section.
	_sectionEmbed = wp.customize.Section.prototype.embed;
	_sectionIsContextuallyActive = wp.customize.Section.prototype.isContextuallyActive;
	_sectionAttachEvents = wp.customize.Section.prototype.attachEvents;

	wp.customize.Section = wp.customize.Section.extend({
		attachEvents: function() {

			var section = this;

			if ( 'kirki-nested' !== this.params.type || _.isUndefined( this.params.section ) ) {
				_sectionAttachEvents.call( section );
				return;
			}

			_sectionAttachEvents.call( section );

			section.expanded.bind( function( expanded ) {
				var parent = wp.customize.section( section.params.section );

				if ( expanded ) {
					parent.contentContainer.addClass( 'current-section-parent' );
				} else {
					parent.contentContainer.removeClass( 'current-section-parent' );
				}
			});

			section.container.find( '.customize-section-back' ).off( 'click keydown' ).on( 'click keydown', function( event ) {
				if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
					return;
				}
				event.preventDefault(); // Keep this AFTER the key filter above
				if ( section.expanded() ) {
					wp.customize.section( section.params.section ).expand();
				}
			});
		},

		embed: function() {

			var section = this,
			    parentContainer;

			if ( 'kirki-nested' !== this.params.type || _.isUndefined( this.params.section ) ) {
				_sectionEmbed.call( section );
				return;
			}

			_sectionEmbed.call( section );

			parentContainer = jQuery( '#sub-accordion-section-' + this.params.section );

			parentContainer.append( section.headContainer );
		},

		isContextuallyActive: function() {
			var section = this,
			    children,
			    activeCount = 0;
			if ( 'kirki-nested' !== this.params.type ) {
				return _sectionIsContextuallyActive.call( this );
			}

			children = this._children( 'section', 'control' );

			wp.customize.section.each( function( child ) {
				if ( ! child.params.section ) {
					return;
				}

				if ( child.params.section !== section.id ) {
					return;
				}
				children.push( child );
			});

			children.sort( wp.customize.utils.prioritySort );

			_( children ).each( function( child ) {
				if ( 'undefined' !== typeof child.isContextuallyActive ) {
					if ( child.active() && child.isContextuallyActive() ) {
						activeCount += 1;
					}
				} else {
					if ( child.active() ) {
						activeCount += 1;
					}
				}
			});

			return ( 0 !== activeCount );
		}
	});
})( jQuery );
