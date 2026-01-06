import "./control.scss";

wp.customize.controlConstructor['kirki-sortable'] = wp.customize.Control.extend({

	// When we're finished loading continue processing
	ready: function() {

		var control = this;
		var container = control.container[0] || control.container;
		var sortableList = container.querySelector( 'ul.sortable' );

		if ( ! sortableList ) {
			return;
		}

		// Add ui-sortable class for CSS compatibility
		sortableList.classList.add( 'ui-sortable' );

		// Initialize drag and drop sortable functionality
		control.initSortable( sortableList );

		// Setup visibility toggle handlers
		control.setupVisibilityHandlers( sortableList );

		// Setup click handler for list items
		control.setupClickHandlers( sortableList );
	},

	/**
	 * Initialize vanilla JS sortable (drag and drop)
	 *
	 * @param {HTMLElement} sortableList - The sortable list element.
	 * @returns {void}
	 */
	initSortable: function( sortableList ) {
		var control = this;
		var draggedElement = null;
		var placeholder = null;
		var dragOverElement = null;

		// Make all list items draggable
		var listItems = sortableList.querySelectorAll( 'li' );
		listItems.forEach( function( item ) {
			item.draggable = true;
			item.style.cursor = 'move';

			// Drag start
			item.addEventListener( 'dragstart', function( e ) {
				draggedElement = this;
				e.dataTransfer.effectAllowed = 'move';
				e.dataTransfer.setData( 'text/html', this.innerHTML );
				this.classList.add( 'dragging' );
			});

			// Drag end
			item.addEventListener( 'dragend', function( e ) {
				this.classList.remove( 'dragging' );
				
				if ( placeholder && placeholder.parentNode ) {
					placeholder.parentNode.removeChild( placeholder );
				}
				
				// Remove drag over class from all items
				listItems.forEach( function( li ) {
					li.classList.remove( 'drag-over' );
				});

				// Update value after sorting
				control.setting.set( control.getNewVal() );
				
				draggedElement = null;
				placeholder = null;
				dragOverElement = null;
			});

			// Drag over
			item.addEventListener( 'dragover', function( e ) {
				if ( e.preventDefault ) {
					e.preventDefault();
				}
				e.dataTransfer.dropEffect = 'move';

				if ( draggedElement && this !== draggedElement ) {
					// Remove drag-over class from all items
					listItems.forEach( function( li ) {
						li.classList.remove( 'drag-over' );
					});

					// Add drag-over class to current item
					this.classList.add( 'drag-over' );
					dragOverElement = this;

					// Determine if we should insert before or after
					var rect = this.getBoundingClientRect();
					var midpoint = rect.top + ( rect.height / 2 );
					
					if ( placeholder ) {
						placeholder.parentNode.removeChild( placeholder );
					}

					placeholder = document.createElement( 'li' );
					placeholder.className = 'sortable-placeholder';
					placeholder.style.height = draggedElement.offsetHeight + 'px';
					placeholder.style.border = '2px dashed #ccc';
					placeholder.style.background = '#f0f0f0';
					placeholder.style.margin = '0';
					placeholder.style.padding = '0';
					placeholder.style.listStyle = 'none';

					if ( e.clientY < midpoint ) {
						sortableList.insertBefore( placeholder, this );
					} else {
						if ( this.nextSibling ) {
							sortableList.insertBefore( placeholder, this.nextSibling );
						} else {
							sortableList.appendChild( placeholder );
						}
					}
				}

				return false;
			});

			// Drag enter
			item.addEventListener( 'dragenter', function( e ) {
				if ( draggedElement && this !== draggedElement ) {
					this.classList.add( 'drag-over' );
				}
			});

			// Drag leave
			item.addEventListener( 'dragleave', function( e ) {
				// Only remove class if we're actually leaving the element
				if ( ! this.contains( e.relatedTarget ) ) {
					this.classList.remove( 'drag-over' );
				}
			});

			// Drop
			item.addEventListener( 'drop', function( e ) {
				if ( e.stopPropagation ) {
					e.stopPropagation();
				}

				if ( draggedElement && this !== draggedElement && placeholder && placeholder.parentNode ) {
					// Remove dragged element from its current position if it's still in the list
					if ( draggedElement.parentNode === sortableList ) {
						sortableList.removeChild( draggedElement );
					}
					
					// Insert dragged element where placeholder is
					placeholder.parentNode.insertBefore( draggedElement, placeholder );
					placeholder.parentNode.removeChild( placeholder );
				}

				// Remove drag-over class
				this.classList.remove( 'drag-over' );

				return false;
			});
		});

		// Prevent default drag behavior on the list itself
		sortableList.addEventListener( 'dragover', function( e ) {
			if ( e.preventDefault ) {
				e.preventDefault();
			}
			e.dataTransfer.dropEffect = 'move';
			return false;
		});

		sortableList.addEventListener( 'drop', function( e ) {
			if ( e.stopPropagation ) {
				e.stopPropagation();
			}
			
			// Handle drop on empty area of list (append to end)
			if ( draggedElement && placeholder && placeholder.parentNode ) {
				// Remove dragged element from its current position if it's still in the list
				if ( draggedElement.parentNode === sortableList ) {
					sortableList.removeChild( draggedElement );
				}
				
				// Insert dragged element where placeholder is
				placeholder.parentNode.insertBefore( draggedElement, placeholder );
				placeholder.parentNode.removeChild( placeholder );
				
				// Update value after sorting
				control.setting.set( control.getNewVal() );
			}
			
			return false;
		});
	},

	/**
	 * Setup visibility toggle handlers
	 *
	 * @param {HTMLElement} sortableList - The sortable list element.
	 * @returns {void}
	 */
	setupVisibilityHandlers: function( sortableList ) {
		var control = this;
		var visibilityIcons = sortableList.querySelectorAll( 'i.visibility' );

		visibilityIcons.forEach( function( icon ) {
			icon.addEventListener( 'click', function( e ) {
				e.stopPropagation();
				
				// Toggle classes
				this.classList.toggle( 'dashicons-visibility-faint' );
				
				// Find parent li element
				var listItem = this.closest( 'li' );
				if ( listItem ) {
					listItem.classList.toggle( 'invisible' );
					
					// Update value after visibility change
					control.setting.set( control.getNewVal() );
				}
			});
		});
	},

	/**
	 * Setup click handlers for list items
	 *
	 * @param {HTMLElement} sortableList - The sortable list element.
	 * @returns {void}
	 */
	setupClickHandlers: function( sortableList ) {
		var control = this;
		var listItems = sortableList.querySelectorAll( 'li' );

		listItems.forEach( function( item ) {
			item.addEventListener( 'click', function( e ) {
				// Don't trigger on visibility icon clicks (handled separately)
				if ( e.target.classList.contains( 'visibility' ) || e.target.closest( 'i.visibility' ) ) {
					return;
				}
				
				// Update value on click
				control.setting.set( control.getNewVal() );
			});
		});
	},

	/**
	 * Gets the new value.
	 *
	 * @since 3.0.35
	 * @returns {Array} - Returns the value as an array.
	 */
	getNewVal: function() {
		var control = this;
		var container = control.container[0] || control.container;
		var listItems = container.querySelectorAll( 'li' );
		var newVal = [];

		listItems.forEach( function( item ) {
			if ( ! item.classList.contains( 'invisible' ) ) {
				var value = item.getAttribute( 'data-value' );
				if ( value ) {
					newVal.push( value );
				}
			}
		});

		return newVal;
	}
});
