( function() {
	function initExpandedSections() {
		wp.customize.section.each( function( section ) {

			// Get the pane element.
			var pane      = document.querySelector( '#sub-accordion-section-' + section.id ),
				sectionLi = document.querySelector( '#accordion-section-' + section.id );

			// Check if elements exist and if the section is expanded.
			if ( pane && sectionLi && sectionLi.classList.contains( 'control-section-kirki-expanded' ) ) {

				// Only move if the pane is not already a child of sectionLi.
				// This prevents duplication when sections are reflowed.
				if ( pane.parentNode !== sectionLi ) {
					sectionLi.appendChild( pane );
				}

			}

		} );
	}

	// Run when DOM is ready and also on pane reflow.
	// This ensures expanded sections are positioned correctly after any DOM reflow.
	function handleExpandedSections() {
		// Use a small timeout to ensure DOM has settled after reflow.
		setTimeout( initExpandedSections, 0 );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', handleExpandedSections );
	} else {
		handleExpandedSections();
	}

	// Also handle expanded sections when pane contents are reflowed.
	wp.customize.bind( 'pane-contents-reflowed', handleExpandedSections );
}() );

/**
 * See https://github.com/justintadlock/trt-customizer-pro
 */
( function() {
	wp.customize.sectionConstructor['kirki-link'] = wp.customize.Section.extend( {
		attachEvents: function() {}, // eslint-disable-line no-empty-function
		isContextuallyActive: function() {
			return true;
		}
	} );
}() );

/**
 * @see https://wordpress.stackexchange.com/a/256103/17078
 */
( function() {

	var _sectionEmbed,
		_sectionIsContextuallyActive,
		_sectionAttachEvents;

	wp.customize.bind( 'pane-contents-reflowed', function() {

		var sections = [];

		// Reflow Sections.
		wp.customize.section.each( function( section ) {

			if ( 'kirki-nested' !== section.params.type || _.isUndefined( section.params.section ) ) {
				return;
			}
			sections.push( section );
		} );

		sections.sort( wp.customize.utils.prioritySort ).reverse();

		sections.forEach( function( section ) {
			var parentContainer = document.querySelector( '#sub-accordion-section-' + section.params.section ),
				sectionMeta,
				headContainer;

			if ( parentContainer && section.headContainer ) {
				sectionMeta = parentContainer.querySelector( '.section-meta' );
				// Handle both jQuery objects and DOM elements.
				headContainer = section.headContainer.jquery ? section.headContainer[0] : section.headContainer;
				if ( sectionMeta && headContainer ) {
					sectionMeta.insertAdjacentElement( 'afterend', headContainer );
				}
			}
		} );
	} );

	// Extend Section.
	_sectionEmbed = wp.customize.Section.prototype.embed;
	_sectionIsContextuallyActive = wp.customize.Section.prototype.isContextuallyActive;
	_sectionAttachEvents = wp.customize.Section.prototype.attachEvents;

	wp.customize.Section = wp.customize.Section.extend( {
		attachEvents: function() {

			var section = this;

			if ( 'kirki-nested' !== this.params.type || _.isUndefined( this.params.section ) ) {
				_sectionAttachEvents.call( section );
				return;
			}

			_sectionAttachEvents.call( section );

			section.expanded.bind( function( expanded ) {
				var parent = wp.customize.section( section.params.section ),
					contentContainer;

				if ( parent && parent.contentContainer ) {
					// Handle both jQuery objects and DOM elements.
					contentContainer = parent.contentContainer.jquery ? parent.contentContainer[0] : parent.contentContainer;
					if ( contentContainer ) {
						if ( expanded ) {
							contentContainer.classList.add( 'current-section-parent' );
						} else {
							contentContainer.classList.remove( 'current-section-parent' );
						}
					}
				}
			} );

			// Handle event listeners for the back button.
			var container = section.container,
				containerEl = container && container.jquery ? container[0] : container,
				backButton = containerEl ? containerEl.querySelector( '.customize-section-back' ) : null,
				backButtonHandler = function( event ) {
					if ( wp.customize.utils.isKeydownButNotEnterEvent( event ) ) {
						return;
					}
					event.preventDefault(); // Keep this AFTER the key filter above
					if ( section.expanded() ) {
						wp.customize.section( section.params.section ).expand();
					}
				};

			if ( backButton ) {
				// Remove existing listeners by cloning the element.
				var newBackButton = backButton.cloneNode( true );
				if ( backButton.parentNode ) {
					backButton.parentNode.replaceChild( newBackButton, backButton );
					backButton = newBackButton;
				}

				// Add new event listeners.
				backButton.addEventListener( 'click', backButtonHandler );
				backButton.addEventListener( 'keydown', backButtonHandler );
			}
		},

		embed: function() {

			var section = this,
				parentContainer;

			if ( 'kirki-nested' !== this.params.type || _.isUndefined( this.params.section ) ) {
				_sectionEmbed.call( section );
				return;
			}

			_sectionEmbed.call( section );

			parentContainer = document.querySelector( '#sub-accordion-section-' + this.params.section );

			if ( parentContainer && section.headContainer ) {
				// Handle both jQuery objects and DOM elements.
				var headContainer = section.headContainer.jquery ? section.headContainer[0] : section.headContainer;
				if ( headContainer ) {
					parentContainer.appendChild( headContainer );
				}
			}
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
			} );

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
			} );

			return ( 0 !== activeCount );
		}
	} );
}() );
