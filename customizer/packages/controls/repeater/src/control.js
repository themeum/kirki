import "./control.scss";

/* global kirkiControlLoader */
/* eslint max-depth: 0 */
/* eslint no-useless-escape: 0 */

/**
 * Helper function to get DOM element from jQuery object or DOM element
 */
function getElement(el) {
  if (el && el[0]) {
    return el[0]; // jQuery object
  }
  return el; // Already a DOM element
}

/**
 * Helper function to query selector within an element
 */
function querySelector(el, selector) {
  var domEl = getElement(el);
  return domEl ? domEl.querySelector(selector) : null;
}

/**
 * Helper function to query selector all within an element
 */
function querySelectorAll(el, selector) {
  var domEl = getElement(el);
  return domEl ? Array.from(domEl.querySelectorAll(selector)) : [];
}

/**
 * Helper function to get data attribute
 */
function getData(el, name) {
  var domEl = getElement(el);
  if (!domEl) return null;
  // Try dataset first (for data-field, data-row, etc.)
  var camelCase = name.replace(/-([a-z])/g, function (g) {
    return g[1].toUpperCase();
  });
  if (domEl.dataset && domEl.dataset[camelCase] !== undefined && domEl.dataset[camelCase] !== "") {
    return domEl.dataset[camelCase];
  }
  // Fallback to getAttribute
  return domEl.getAttribute("data-" + name);
}

/**
 * Helper function to set data attribute
 */
function setData(el, name, value) {
  var domEl = getElement(el);
  if (!domEl) return;
  var camelCase = name.replace(/-([a-z])/g, function (g) {
    return g[1].toUpperCase();
  });
  if (domEl.dataset) {
    domEl.dataset[camelCase] = value;
  }
  domEl.setAttribute("data-" + name, value);
}

/**
 * Helper function to trigger custom event
 */
function triggerEvent(el, eventName, detail) {
  var domEl = getElement(el);
  if (!domEl) return;
  var event = new CustomEvent(eventName, {
    bubbles: true,
    cancelable: true,
    detail: detail || [],
  });
  domEl.dispatchEvent(event);
}

/**
 * Helper function for slide animation
 */
function slideUp(el, duration, callback) {
  var domEl = getElement(el);
  if (!domEl) return;
  domEl.style.transition = "max-height " + duration + "ms ease-out, opacity " + duration + "ms ease-out, padding " + duration + "ms ease-out, margin " + duration + "ms ease-out";
  var height = domEl.offsetHeight;
  domEl.style.maxHeight = height + "px";
  domEl.style.overflow = "hidden";
  // Force reflow
  domEl.offsetHeight;
  domEl.style.maxHeight = "0";
  domEl.style.opacity = "0";
  domEl.style.paddingTop = "0";
  domEl.style.paddingBottom = "0";
  domEl.style.marginTop = "0";
  domEl.style.marginBottom = "0";
  setTimeout(function () {
    if (callback) {
      callback.call(domEl);
    }
  }, duration);
}

/**
 * Helper function for slide down animation
 */
function slideDown(el, duration, callback) {
  var domEl = getElement(el);
  if (!domEl) return;
  domEl.style.display = "block";
  domEl.style.overflow = "hidden";
  domEl.style.opacity = "0";
  var height = domEl.scrollHeight;
  domEl.style.maxHeight = "0";
  domEl.style.transition = "max-height " + duration + "ms ease-in, opacity " + duration + "ms ease-in, padding " + duration + "ms ease-in, margin " + duration + "ms ease-in";
  // Force reflow
  domEl.offsetHeight;
  domEl.style.maxHeight = height + "px";
  domEl.style.opacity = "1";
  setTimeout(function () {
    domEl.style.maxHeight = "";
    domEl.style.overflow = "";
    if (callback) {
      callback.call(domEl);
    }
  }, duration);
}

var RepeaterRow = function (rowIndex, container, label, control) {
  var self = this;
  this.rowIndex = rowIndex;
  this.container = container;
  // Ensure we get the actual DOM element
  if (container && container.nodeType) {
    this.containerEl = container;
  } else if (container && container[0] && container[0].nodeType) {
    this.containerEl = container[0]; // jQuery object
  } else {
    this.containerEl = container;
  }
  this.label = label;
  
  // Set the data-row attribute immediately to ensure it's correct
  if (this.containerEl) {
    setData(this.containerEl, "row", rowIndex);
  }
  
  this.header = this.containerEl ? this.containerEl.querySelector(".repeater-row-header") : null;
  this.headerEl = this.header;

  if (this.header) {
    this.header.addEventListener("click", function () {
      self.toggleMinimize();
    });

    this.header.addEventListener("mousedown", function () {
      triggerEvent(self.containerEl, "row:start-dragging");
    });
  }

  // Event delegation for remove button
  if (this.containerEl) {
    this.containerEl.addEventListener("click", function (e) {
      if (e.target && e.target.closest && e.target.closest(".repeater-row-remove")) {
        self.remove();
      }
    });

    // Event delegation for input changes
    this.containerEl.addEventListener("keyup", function (e) {
      if (e.target && (e.target.tagName === "INPUT" || e.target.tagName === "SELECT" || e.target.tagName === "TEXTAREA")) {
        var fieldName = getData(e.target, "field");
        // Only trigger if we have a valid field name
        if (fieldName) {
          triggerEvent(self.containerEl, "row:update", [
            self.rowIndex,
            fieldName,
            e.target,
          ]);
        }
      }
    });

    this.containerEl.addEventListener("change", function (e) {
      if (e.target && (e.target.tagName === "INPUT" || e.target.tagName === "SELECT" || e.target.tagName === "TEXTAREA")) {
        var fieldName = getData(e.target, "field");
        // Fallback to getAttribute if getData returns null
        if (!fieldName) {
          fieldName = e.target.getAttribute("data-field");
        }
        // Only trigger if we have a valid field name
        if (fieldName) {
          triggerEvent(self.containerEl, "row:update", [
            self.rowIndex,
            fieldName,
            e.target,
          ]);
        }
      }
    });
  }

  this.setRowIndex = function (rowNum) {
    this.rowIndex = rowNum;
    if (this.containerEl) {
      setData(this.containerEl, "row", rowNum);
    }
    this.updateLabel();
  };

  this.toggleMinimize = function () {
    if (!this.containerEl) return;
    // Store the previous state.
    this.containerEl.classList.toggle("minimized");
    if (this.header) {
      var dashicons = this.header.querySelector(".dashicons");
      if (dashicons) {
        dashicons.classList.toggle("dashicons-arrow-up");
        dashicons.classList.toggle("dashicons-arrow-down");
      }
    }
  };

  this.remove = function () {
    var self = this;
    var rowIndex = self.rowIndex;
    var containerEl = self.containerEl;
    
    // Trigger event immediately (before animation)
    if (containerEl) {
      triggerEvent(containerEl, "row:remove", [rowIndex]);
    }
    
    slideUp(this.containerEl, 300, function () {
      // Remove from DOM after animation
      if (containerEl && containerEl.parentNode) {
        containerEl.parentNode.removeChild(containerEl);
      }
    });
  };

  this.updateLabel = function () {
    var rowLabelField, rowLabel, rowLabelSelector, rowLabelEl;

    if ("field" === this.label.type && this.containerEl) {
      rowLabelField = this.containerEl.querySelector(
        '.repeater-field [data-field="' + this.label.field + '"]'
      );
      if (rowLabelField) {
        if (rowLabelField.tagName === "SELECT" || rowLabelField.tagName === "INPUT" || rowLabelField.tagName === "TEXTAREA") {
          rowLabel = rowLabelField.value;
        } else {
          rowLabel = rowLabelField.textContent || rowLabelField.innerText || "";
        }
        if ("" !== rowLabel) {
          if (!_.isUndefined(control.params.fields[this.label.field])) {
            if (!_.isUndefined(control.params.fields[this.label.field].type)) {
              if ("select" === control.params.fields[this.label.field].type) {
                if (
                  !_.isUndefined(
                    control.params.fields[this.label.field].choices
                  ) &&
                  !_.isUndefined(
                    control.params.fields[this.label.field].choices[rowLabel]
                  )
                ) {
                  rowLabel =
                    control.params.fields[this.label.field].choices[rowLabel];
                }
              } else if (
                "radio" === control.params.fields[this.label.field].type ||
                "radio-image" === control.params.fields[this.label.field].type
              ) {
                rowLabelSelector =
                  control.selector +
                  ' [data-row="' +
                  this.rowIndex +
                  '"] .repeater-field [data-field="' +
                  this.label.field +
                  '"]:checked';
                rowLabelEl = document.querySelector(rowLabelSelector);
                if (rowLabelEl) {
                  rowLabel = rowLabelEl.value;
                }
              }
            }
          }
          if (this.header) {
            rowLabelEl = this.header.querySelector(".repeater-row-label");
            if (rowLabelEl) {
              rowLabelEl.textContent = rowLabel;
            }
          }
          return;
        }
      }
    }
    if (this.header) {
      rowLabelEl = this.header.querySelector(".repeater-row-label");
      if (rowLabelEl) {
        rowLabelEl.textContent = this.label.value + " " + (this.rowIndex + 1);
      }
    }
  };
  this.updateLabel();
};

wp.customize.controlConstructor.repeater = wp.customize.Control.extend({
  // When we're finished loading continue processing
  ready: function () {
    var control = this;

    // Init the control.
    if (
      !_.isUndefined(window.kirkiControlLoader) &&
      _.isFunction(kirkiControlLoader)
    ) {
      kirkiControlLoader(control);
    } else {
      control.initKirkiControl();
    }
  },

  initKirkiControl: function (control) {
    var limit, theNewRow, settingValue;
    control = control || this;
    var containerEl = getElement(control.container);

    // The current value set in Control Class (set in Kirki_Customize_Repeater_Control::to_json() function)
    settingValue = control.params.value;

    // The hidden field that keeps the data saved (though we never update it)
    var containerEl = getElement(control.container);
    if (containerEl) {
      control.settingField = containerEl.querySelector("[data-customize-setting-link]");
    } else if (control.container && control.container.find && typeof control.container.find === 'function') {
      var $field = control.container.find("[data-customize-setting-link]").first();
      control.settingField = $field && $field[0] ? $field[0] : null;
    } else {
      control.settingField = querySelector(control.container, "[data-customize-setting-link]");
    }

    // Set the field value for the first time, we'll fill it up later
    control.setValue([], false);

    // The DIV that holds all the rows
    // Handle both jQuery and DOM elements
    var containerEl = getElement(control.container);
    if (containerEl) {
      control.repeaterFieldsContainer = containerEl.querySelector(".repeater-fields");
    } else if (control.container && control.container.find && typeof control.container.find === 'function') {
      // jQuery object
      var $container = control.container.find(".repeater-fields").first();
      control.repeaterFieldsContainer = $container && $container[0] ? $container[0] : null;
    } else {
      control.repeaterFieldsContainer = querySelector(control.container, ".repeater-fields");
    }
    control.repeaterFieldsContainerEl = control.repeaterFieldsContainer;

    // Set number of rows to 0
    control.currentIndex = 0;

    // Save the rows objects
    control.rows = [];

    // Default limit choice
    limit = false;
    if (!_.isUndefined(control.params.choices.limit)) {
      limit =
        0 >= control.params.choices.limit
          ? false
          : parseInt(control.params.choices.limit, 10);
    }

    // Event delegation for add button
    if (containerEl) {
      containerEl.addEventListener("click", function (e) {
        var addButton = e.target.closest("button.repeater-add");
        if (addButton) {
          e.preventDefault();
          if (!limit || control.currentIndex < limit) {
            theNewRow = control.addRow();
            // Row expansion is handled in addRow, but ensure it's expanded
            if (theNewRow && theNewRow.containerEl && theNewRow.containerEl.classList.contains("minimized")) {
              theNewRow.toggleMinimize();
            }
            control.initColorPicker();
            control.initSelect(theNewRow);
          } else {
            var limitEl = document.querySelector(control.selector + " .limit");
            if (limitEl) {
              limitEl.classList.add("highlight");
            }
          }
        }
      });

      // Event delegation for remove button (to update limit highlight)
      containerEl.addEventListener("click", function (e) {
        if (e.target && e.target.closest && e.target.closest(".repeater-row-remove")) {
          control.currentIndex--;
          if (!limit || control.currentIndex < limit) {
            var limitEl = document.querySelector(control.selector + " .limit");
            if (limitEl) {
              limitEl.classList.remove("highlight");
            }
          }
        }
      });

      // Event delegation for upload buttons
      containerEl.addEventListener("click", function (e) {
        var uploadButton = e.target.closest(".repeater-field-image .upload-button, .repeater-field-cropped_image .upload-button, .repeater-field-upload .upload-button");
        if (uploadButton) {
          e.preventDefault();
          control.thisButton = uploadButton;
          control.openFrame(e);
        }
      });

      containerEl.addEventListener("keypress", function (e) {
        var uploadButton = e.target.closest(".repeater-field-image .upload-button, .repeater-field-cropped_image .upload-button, .repeater-field-upload .upload-button");
        if (uploadButton && (e.key === "Enter" || e.keyCode === 13)) {
          e.preventDefault();
          control.thisButton = uploadButton;
          control.openFrame(e);
        }
      });

      // Event delegation for remove image buttons
      containerEl.addEventListener("click", function (e) {
        var removeButton = e.target.closest(".repeater-field-image .remove-button, .repeater-field-cropped_image .remove-button");
        if (removeButton) {
          e.preventDefault();
          control.thisButton = removeButton;
          control.removeImage(e);
        }
      });

      containerEl.addEventListener("keypress", function (e) {
        var removeButton = e.target.closest(".repeater-field-image .remove-button, .repeater-field-cropped_image .remove-button");
        if (removeButton && (e.key === "Enter" || e.keyCode === 13)) {
          e.preventDefault();
          control.thisButton = removeButton;
          control.removeImage(e);
        }
      });

      // Event delegation for remove file buttons
      containerEl.addEventListener("click", function (e) {
        var removeButton = e.target.closest(".repeater-field-upload .remove-button");
        if (removeButton) {
          e.preventDefault();
          control.thisButton = removeButton;
          control.removeFile(e);
        }
      });

      containerEl.addEventListener("keypress", function (e) {
        var removeButton = e.target.closest(".repeater-field-upload .remove-button");
        if (removeButton && (e.key === "Enter" || e.keyCode === 13)) {
          e.preventDefault();
          control.thisButton = removeButton;
          control.removeFile(e);
        }
      });
    }

    /**
     * Function that loads the Mustache template
     */
    control.repeaterTemplate = _.memoize(function () {
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
          variable: "data",
        };

      return function (data) {
        var containerEl = getElement(control.container);
        var templateEl = containerEl ? containerEl.querySelector(".customize-control-repeater-content") : null;
        if (!templateEl && control.container && control.container.find && typeof control.container.find === 'function') {
          // Try jQuery method
          var $template = control.container.find(".customize-control-repeater-content").first();
          templateEl = $template && $template[0] ? $template[0] : null;
        }
        if (!templateEl) {
          // Try document-wide search as fallback
          templateEl = document.querySelector(".customize-control-repeater-content");
        }
        var templateHtml = templateEl ? templateEl.innerHTML : "";
        if (!templateHtml) {
          console.warn('Repeater template not found');
          return "";
        }
        compiled = _.template(templateHtml, null, options);
        return compiled(data);
      };
    });

    // When we load the control, the fields have not been filled up
    // This is the first time that we create all the rows
    if (settingValue && Array.isArray(settingValue) && settingValue.length) {
      _.each(settingValue, function (subValue, index) {
        // Temporarily set currentIndex to match the loaded index
        var originalIndex = control.currentIndex;
        control.currentIndex = index;
        theNewRow = control.addRow(subValue);
        if (theNewRow) {
          // Ensure the row index matches - this is critical
          theNewRow.setRowIndex(index);
          // Verify the data-row attribute is correct
          var actualRowIndex = getData(theNewRow.containerEl, "row");
          if (actualRowIndex !== String(index)) {
            setData(theNewRow.containerEl, "row", index);
          }
          // Update label to show correct row number
          theNewRow.updateLabel();
          // Existing rows should remain in their saved state (minimized or not)
          // Don't force expand them
          control.initColorPicker();
          control.initSelect(theNewRow, subValue);
        }
        // Restore and increment
        control.currentIndex = originalIndex;
      });
      // After loading all rows, set currentIndex to the next available
      control.currentIndex = settingValue.length;
    }

    // Initialize sortable (drag and drop) after rows are loaded
    if (control.repeaterFieldsContainer) {
      // Delay sortable init to ensure all rows are rendered
      setTimeout(function() {
        control.initSortable();
      }, 100);
    }
  },

  /**
   * Initialize vanilla JS sortable (drag and drop)
   *
   * @returns {void}
   */
  initSortable: function () {
    var control = this;
    var container = this.repeaterFieldsContainer;
    if (!container) return;

    // Remove existing sortable handlers if any
    if (control._sortableInitialized) {
      return; // Already initialized
    }
    control._sortableInitialized = true;

    var draggedElement = null;
    var placeholder = null;
    var startY = 0;
    var startOffset = 0;
    var isDragging = false;
    var handleMouseMove, handleMouseUp;

    function setupRow(row) {
      var header = querySelector(row, ".repeater-row-header");
      if (!header) return;

      header.style.cursor = "move";

      header.addEventListener("mousedown", function (e) {
        // Don't start drag on click (let click handler work for minimize)
        // Only start drag if mouse moves a bit
        if (e.button !== 0) return; // Only left mouse button
        
        startY = e.clientY;
        startOffset = row.offsetTop;
        isDragging = false;
        draggedElement = row;

        handleMouseMove = function (e) {
          if (!draggedElement) return;
          
          var deltaY = Math.abs(e.clientY - startY);
          
          // Only start dragging if mouse moved more than 5px
          if (!isDragging && deltaY > 5) {
            isDragging = true;
            
            // Prevent click event on header
            header.style.pointerEvents = "none";
            
            // Create placeholder
            placeholder = document.createElement("div");
            placeholder.className = "repeater-row-placeholder";
            placeholder.style.height = row.offsetHeight + "px";
            placeholder.style.border = "2px dashed #ccc";
            placeholder.style.margin = "0.5rem 0";
            placeholder.style.background = "#f0f0f0";
            placeholder.style.minHeight = row.offsetHeight + "px";
            
            // Insert placeholder where row is
            row.parentNode.insertBefore(placeholder, row);
            
            // Style the dragged element
            row.style.opacity = "0.5";
            row.style.cursor = "grabbing";
            row.style.position = "fixed";
            row.style.zIndex = "10000";
            row.style.width = row.offsetWidth + "px";
            row.style.pointerEvents = "none";
            
            // Remove from normal flow and append to body
            // Store the original parent for safety
            var currentParent = draggedElement.parentNode;
            draggedElement._originalParent = currentParent;
            draggedElement._originalNextSibling = draggedElement.nextSibling;
            
            // Use draggedElement instead of row to ensure we're working with current element
            if (currentParent && currentParent !== document.body) {
              currentParent.removeChild(draggedElement);
              document.body.appendChild(draggedElement);
            }
          }
          
          if (isDragging && placeholder) {
            // Get original position
            var containerRect = container.getBoundingClientRect();
            var originalLeft = containerRect.left;
            
            // Update dragged element position to follow mouse
            row.style.top = (e.clientY - 10) + "px";
            row.style.left = originalLeft + "px";
            
            // Find where to place the placeholder
            var rows = Array.from(container.querySelectorAll(".repeater-row"));
            var placeholderIndex = -1;
            
            // Remove placeholder temporarily to get accurate positions
            var placeholderParent = placeholder.parentNode;
            placeholderParent.removeChild(placeholder);
            
            for (var i = 0; i < rows.length; i++) {
              var box = rows[i].getBoundingClientRect();
              var mouseY = e.clientY;
              
              if (mouseY < box.top + box.height / 2) {
                placeholderIndex = i;
                break;
              }
            }
            
            // Re-insert placeholder at the correct position
            if (placeholderIndex >= 0 && placeholderIndex < rows.length) {
              container.insertBefore(placeholder, rows[placeholderIndex]);
            } else if (rows.length > 0) {
              // Append to end
              container.appendChild(placeholder);
            } else {
              // No rows, just append
              container.appendChild(placeholder);
            }
          }
        };

        handleMouseUp = function (e) {
          if (!draggedElement) {
            document.removeEventListener("mousemove", handleMouseMove);
            document.removeEventListener("mouseup", handleMouseUp);
            return;
          }
          
          // Always reset styles first
          draggedElement.style.opacity = "";
          draggedElement.style.cursor = "";
          draggedElement.style.position = "";
          draggedElement.style.zIndex = "";
          draggedElement.style.width = "";
          draggedElement.style.top = "";
          draggedElement.style.left = "";
          draggedElement.style.pointerEvents = "";
          header.style.pointerEvents = "";
          
          if (isDragging) {
            // Insert dragged element back into container
            try {
              if (placeholder && placeholder.parentNode) {
                // Normal case: insert where placeholder is
                placeholder.parentNode.insertBefore(draggedElement, placeholder);
                placeholder.parentNode.removeChild(placeholder);
              } else {
                // Fallback: placeholder is gone, restore to original position or append
                if (draggedElement._originalParent) {
                  if (draggedElement._originalNextSibling && draggedElement._originalNextSibling.parentNode) {
                    draggedElement._originalParent.insertBefore(draggedElement, draggedElement._originalNextSibling);
                  } else {
                    draggedElement._originalParent.appendChild(draggedElement);
                  }
                } else {
                  container.appendChild(draggedElement);
                }
              }
              
              // Clean up stored references
              delete draggedElement._originalParent;
              delete draggedElement._originalNextSibling;
              
              // Wait a tick to ensure DOM is fully updated before sorting
              setTimeout(function() {
                control.sort();
              }, 0);
            } catch (error) {
              // Last resort: make sure element is somewhere in the container
              if (draggedElement.parentNode === document.body || !draggedElement.parentNode) {
                container.appendChild(draggedElement);
              }
              
              // Remove placeholder if it exists
              if (placeholder && placeholder.parentNode) {
                try {
                  placeholder.parentNode.removeChild(placeholder);
                } catch (e) {
                  // Silently handle error
                }
              }
              
              // Clean up stored references
              delete draggedElement._originalParent;
              delete draggedElement._originalNextSibling;
            }
          } else if (!isDragging) {
            // If we didn't drag, make sure element is back in container
            if (draggedElement.parentNode === document.body) {
              // Try to restore to original position
              if (draggedElement._originalParent && draggedElement._originalNextSibling) {
                try {
                  draggedElement._originalParent.insertBefore(draggedElement, draggedElement._originalNextSibling);
                } catch (e) {
                  container.appendChild(draggedElement);
                }
              } else {
                container.appendChild(draggedElement);
              }
            }
            
            // Clean up stored references
            delete draggedElement._originalParent;
            delete draggedElement._originalNextSibling;
          }
          
          draggedElement = null;
          placeholder = null;
          isDragging = false;

          document.removeEventListener("mousemove", handleMouseMove);
          document.removeEventListener("mouseup", handleMouseUp);
        };

        document.addEventListener("mousemove", handleMouseMove);
        document.addEventListener("mouseup", handleMouseUp);
      });
    }

    // Setup existing rows
    var rows = querySelectorAll(container, ".repeater-row");
    rows.forEach(setupRow);

    // Watch for new rows being added
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        mutation.addedNodes.forEach(function (node) {
          if (node.nodeType === 1 && node.classList && node.classList.contains("repeater-row")) {
            setupRow(node);
          }
        });
      });
    });

    observer.observe(container, { childList: true });
    control._sortableObserver = observer;
  },

  /**
   * Open the media modal.
   *
   * @param {Object} event - The JS event.
   * @returns {void}
   */
  openFrame: function (event) {
    if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
      return;
    }

    var fieldContainer = this.thisButton ? this.thisButton.closest(".repeater-field") : null;
    if (fieldContainer && fieldContainer.classList.contains("repeater-field-cropped_image")) {
      this.initCropperFrame();
    } else {
      this.initFrame();
    }

    this.frame.open();
  },

  initFrame: function () {
    var libMediaType = this.getMimeType();

    this.frame = wp.media({
      states: [
        new wp.media.controller.Library({
          library: wp.media.query({ type: libMediaType }),
          multiple: false,
          date: false,
        }),
      ],
    });

    // When a file is selected, run a callback.
    this.frame.on("select", this.onSelect, this);
  },

  /**
   * Create a media modal select frame, and store it so the instance can be reused when needed.
   * This is mostly a copy/paste of Core api.CroppedImageControl in /wp-admin/js/customize-control.js
   *
   * @returns {void}
   */
  initCropperFrame: function () {
    // We get the field id from which this was called
    var hiddenField = this.thisButton ? this.thisButton.parentElement.querySelector("input.hidden-field") : null;
    var currentFieldId = hiddenField ? getData(hiddenField, "field") : null;
    var attrs = ["width", "height", "flex_width", "flex_height"]; // A list of attributes to look for
    var libMediaType = this.getMimeType();

    // Make sure we got it
    if (_.isString(currentFieldId) && "" !== currentFieldId) {
      // Make fields is defined and only do the hack for cropped_image
      if (
        _.isObject(this.params.fields[currentFieldId]) &&
        "cropped_image" === this.params.fields[currentFieldId].type
      ) {
        //Iterate over the list of attributes
        attrs.forEach(
          function (el) {
            // If the attribute exists in the field
            if (!_.isUndefined(this.params.fields[currentFieldId][el])) {
              // Set the attribute in the main object
              this.params[el] = this.params.fields[currentFieldId][el];
            }
          }.bind(this)
        );
      }
    }

    this.frame = wp.media({
      button: {
        text: "Select and Crop",
        close: false,
      },
      states: [
        new wp.media.controller.Library({
          library: wp.media.query({ type: libMediaType }),
          multiple: false,
          date: false,
          suggestedWidth: this.params.width,
          suggestedHeight: this.params.height,
        }),
        new wp.media.controller.CustomizeImageCropper({
          imgSelectOptions: this.calculateImageSelectOptions,
          control: this,
        }),
      ],
    });

    this.frame.on("select", this.onSelectForCrop, this);
    this.frame.on("cropped", this.onCropped, this);
    this.frame.on("skippedcrop", this.onSkippedCrop, this);
  },

  onSelect: function () {
    var attachment = this.frame.state().get("selection").first().toJSON();
    var fieldContainer = this.thisButton ? this.thisButton.closest(".repeater-field") : null;

    if (fieldContainer && fieldContainer.classList.contains("repeater-field-upload")) {
      this.setFileInRepeaterField(attachment);
    } else {
      this.setImageInRepeaterField(attachment);
    }
  },

  /**
   * After an image is selected in the media modal, switch to the cropper
   * state if the image isn't the right size.
   */

  onSelectForCrop: function () {
    var attachment = this.frame.state().get("selection").first().toJSON();

    if (
      this.params.width === attachment.width &&
      this.params.height === attachment.height &&
      !this.params.flex_width &&
      !this.params.flex_height
    ) {
      this.setImageInRepeaterField(attachment);
    } else {
      this.frame.setState("cropper");
    }
  },

  /**
   * After the image has been cropped, apply the cropped image data to the setting.
   *
   * @param {object} croppedImage Cropped attachment data.
   * @returns {void}
   */
  onCropped: function (croppedImage) {
    this.setImageInRepeaterField(croppedImage);
  },

  /**
   * Returns a set of options, computed from the attached image data and
   * control-specific data, to be fed to the imgAreaSelect plugin in
   * wp.media.view.Cropper.
   *
   * @param {wp.media.model.Attachment} attachment - The attachment from the WP API.
   * @param {wp.media.controller.Cropper} controller - Media controller.
   * @returns {Object} - Options.
   */
  calculateImageSelectOptions: function (attachment, controller) {
    var control = controller.get("control"),
      flexWidth = !!parseInt(control.params.flex_width, 10),
      flexHeight = !!parseInt(control.params.flex_height, 10),
      realWidth = attachment.get("width"),
      realHeight = attachment.get("height"),
      xInit = parseInt(control.params.width, 10),
      yInit = parseInt(control.params.height, 10),
      ratio = xInit / yInit,
      xImg = realWidth,
      yImg = realHeight,
      x1,
      y1,
      imgSelectOptions;

    controller.set(
      "canSkipCrop",
      !control.mustBeCropped(
        flexWidth,
        flexHeight,
        xInit,
        yInit,
        realWidth,
        realHeight
      )
    );

    if (xImg / yImg > ratio) {
      yInit = yImg;
      xInit = yInit * ratio;
    } else {
      xInit = xImg;
      yInit = xInit / ratio;
    }

    x1 = (xImg - xInit) / 2;
    y1 = (yImg - yInit) / 2;

    imgSelectOptions = {
      handles: true,
      keys: true,
      instance: true,
      persistent: true,
      imageWidth: realWidth,
      imageHeight: realHeight,
      x1: x1,
      y1: y1,
      x2: xInit + x1,
      y2: yInit + y1,
    };

    if (false === flexHeight && false === flexWidth) {
      imgSelectOptions.aspectRatio = xInit + ":" + yInit;
    }
    if (false === flexHeight) {
      imgSelectOptions.maxHeight = yInit;
    }
    if (false === flexWidth) {
      imgSelectOptions.maxWidth = xInit;
    }

    return imgSelectOptions;
  },

  /**
   * Return whether the image must be cropped, based on required dimensions.
   *
   * @param {bool} flexW - The flex-width.
   * @param {bool} flexH - The flex-height.
   * @param {int}  dstW - Initial point distance in the X axis.
   * @param {int}  dstH - Initial point distance in the Y axis.
   * @param {int}  imgW - Width.
   * @param {int}  imgH - Height.
   * @returns {bool} - Whether the image must be cropped or not based on required dimensions.
   */
  mustBeCropped: function (flexW, flexH, dstW, dstH, imgW, imgH) {
    return !(
      (true === flexW && true === flexH) ||
      (true === flexW && dstH === imgH) ||
      (true === flexH && dstW === imgW) ||
      (dstW === imgW && dstH === imgH) ||
      imgW <= dstW
    );
  },

  /**
   * If cropping was skipped, apply the image data directly to the setting.
   *
   * @returns {void}
   */
  onSkippedCrop: function () {
    var attachment = this.frame.state().get("selection").first().toJSON();
    this.setImageInRepeaterField(attachment);
  },

  /**
   * Updates the setting and re-renders the control UI.
   *
   * @param {object} attachment - The attachment object.
   * @returns {void}
   */
  setImageInRepeaterField: function (attachment) {
    var targetDiv = this.thisButton ? this.thisButton.closest(".repeater-field-image, .repeater-field-cropped_image") : null;
    if (!targetDiv) return;

    var imageAttachment = querySelector(targetDiv, ".kirki-image-attachment");
    if (imageAttachment) {
      imageAttachment.innerHTML = '<img src="' + attachment.url + '">';
      imageAttachment.style.display = "none";
      slideDown(imageAttachment, 400);
    }

    var hiddenField = querySelector(targetDiv, ".hidden-field");
    if (hiddenField) {
      hiddenField.value = attachment.id;
    }

    var altLabel = getData(this.thisButton, "alt-label");
    if (altLabel && this.thisButton) {
      this.thisButton.textContent = altLabel;
    }

    var removeButton = querySelector(targetDiv, ".remove-button");
    if (removeButton) {
      removeButton.style.display = "";
    }

    //This will activate the save button
    var inputs = querySelectorAll(targetDiv, "input, textarea, select");
    inputs.forEach(function (input) {
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });
    this.frame.close();
  },

  /**
   * Updates the setting and re-renders the control UI.
   *
   * @param {object} attachment - The attachment object.
   * @returns {void}
   */
  setFileInRepeaterField: function (attachment) {
    var targetDiv = this.thisButton ? this.thisButton.closest(".repeater-field-upload") : null;
    if (!targetDiv) return;

    var fileAttachment = querySelector(targetDiv, ".kirki-file-attachment");
    if (fileAttachment) {
      fileAttachment.innerHTML =
        '<span class="file"><span class="dashicons dashicons-media-default"></span> ' +
        attachment.filename +
        "</span>";
      fileAttachment.style.display = "none";
      slideDown(fileAttachment, 400);
    }

    var hiddenField = querySelector(targetDiv, ".hidden-field");
    if (hiddenField) {
      hiddenField.value = attachment.id;
    }

    var altLabel = getData(this.thisButton, "alt-label");
    if (altLabel && this.thisButton) {
      this.thisButton.textContent = altLabel;
    }

    var uploadButton = querySelector(targetDiv, ".upload-button");
    if (uploadButton) {
      uploadButton.style.display = "";
    }

    var removeButton = querySelector(targetDiv, ".remove-button");
    if (removeButton) {
      removeButton.style.display = "";
    }

    //This will activate the save button
    var inputs = querySelectorAll(targetDiv, "input, textarea, select");
    inputs.forEach(function (input) {
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });
    this.frame.close();
  },

  getMimeType: function () {
    // We get the field id from which this was called
    var hiddenField = this.thisButton ? this.thisButton.parentElement.querySelector("input.hidden-field") : null;
    var currentFieldId = hiddenField ? getData(hiddenField, "field") : null;

    // Make sure we got it
    if (_.isString(currentFieldId) && "" !== currentFieldId) {
      // Make fields is defined and only do the hack for cropped_image
      if (
        _.isObject(this.params.fields[currentFieldId]) &&
        "upload" === this.params.fields[currentFieldId].type
      ) {
        // If the attribute exists in the field
        if (!_.isUndefined(this.params.fields[currentFieldId].mime_type)) {
          // Set the attribute in the main object
          return this.params.fields[currentFieldId].mime_type;
        }
      }
    }
    return "image";
  },

  removeImage: function (event) {
    if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
      return;
    }

    var targetDiv = this.thisButton ? this.thisButton.closest(".repeater-field-image, .repeater-field-cropped_image, .repeater-field-upload") : null;
    if (!targetDiv) return;

    var uploadButton = querySelector(targetDiv, ".upload-button");
    var imageAttachment = querySelector(targetDiv, ".kirki-image-attachment");
    var placeholder = imageAttachment ? getData(imageAttachment, "placeholder") : "";

    if (imageAttachment) {
      slideUp(imageAttachment, 200, function () {
        this.style.display = "";
        this.innerHTML = placeholder || "";
      });
    }

    var hiddenField = querySelector(targetDiv, ".hidden-field");
    if (hiddenField) {
      hiddenField.value = "";
    }

    var label = uploadButton ? getData(uploadButton, "label") : "";
    if (label && uploadButton) {
      uploadButton.textContent = label;
    }

    if (this.thisButton) {
      this.thisButton.style.display = "none";
    }

    var inputs = querySelectorAll(targetDiv, "input, textarea, select");
    inputs.forEach(function (input) {
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });
  },

  removeFile: function (event) {
    if (wp.customize.utils.isKeydownButNotEnterEvent(event)) {
      return;
    }

    var targetDiv = this.thisButton ? this.thisButton.closest(".repeater-field-upload") : null;
    if (!targetDiv) return;

    var uploadButton = querySelector(targetDiv, ".upload-button");
    var fileAttachment = querySelector(targetDiv, ".kirki-file-attachment");
    var placeholder = fileAttachment ? getData(fileAttachment, "placeholder") : "";

    if (fileAttachment) {
      slideUp(fileAttachment, 200, function () {
        this.style.display = "";
        this.innerHTML = placeholder || "";
      });
    }

    var hiddenField = querySelector(targetDiv, ".hidden-field");
    if (hiddenField) {
      hiddenField.value = "";
    }

    var label = uploadButton ? getData(uploadButton, "label") : "";
    if (label && uploadButton) {
      uploadButton.textContent = label;
    }

    if (this.thisButton) {
      this.thisButton.style.display = "none";
    }

    var inputs = querySelectorAll(targetDiv, "input, textarea, select");
    inputs.forEach(function (input) {
      input.dispatchEvent(new Event("change", { bubbles: true }));
    });
  },

  /**
   * Get the current value of the setting
   *
   * @returns {Object} - Returns the value.
   */
  getValue: function () {
    // The setting is saved in JSON
    return JSON.parse(decodeURI(this.setting.get()));
  },

  /**
   * Set a new value for the setting
   *
   * @param {Object} newValue - The new value.
   * @param {bool} refresh - If we want to refresh the previewer or not
   * @param {bool} filtering - If we want to filter or not.
   * @returns {void}
   */
  setValue: function (newValue, refresh, filtering) {
    // We need to filter the values after the first load to remove data required for display but that we don't want to save in DB
    var filteredValue = newValue,
      filter = [];

    if (filtering) {
      Object.keys(this.params.fields).forEach(function (index) {
        var value = this.params.fields[index];
        if (
          "image" === value.type ||
          "cropped_image" === value.type ||
          "upload" === value.type
        ) {
          filter.push(index);
        }
      }.bind(this));
      newValue.forEach(function (value, index) {
        filter.forEach(function (field) {
          if (!_.isUndefined(value[field]) && !_.isUndefined(value[field].id)) {
            filteredValue[index][field] = value[field].id;
          }
        });
      });
    }

    this.setting.set(encodeURI(JSON.stringify(filteredValue)));

    if (refresh) {
			// Check active_callback in every change
			// Only call if KirkiRepeaterDependencies is available
			if (typeof KirkiRepeaterDependencies !== 'undefined' && KirkiRepeaterDependencies && typeof KirkiRepeaterDependencies.init === 'function') {
				KirkiRepeaterDependencies.init();
			}
      // Trigger the change event on the hidden field so
      // previewer refresh the website on Customizer
      if (this.settingField) {
        this.settingField.dispatchEvent(new Event("change", { bubbles: true }));
      }
    }
  },

  /**
   * Add a new row to repeater settings based on the structure.
   *
   * @param {Object} data - (Optional) Object of field => value pairs (undefined if you want to get the default values)
   * @returns {Object} - Returns the new row.
   */
  addRow: function (data) {
    var control = this,
      template = control.repeaterTemplate(), // The template for the new row (defined on Kirki_Customize_Repeater_Control::render_content() ).
      settingValue = this.getValue(), // Get the current setting value.
      newRowSetting = {}, // Saves the new setting data.
      templateData, // Data to pass to the template
      newRow,
      i;

    if (template) {
      // Ensure settingValue is an array
      if (!Array.isArray(settingValue)) {
        settingValue = [];
      }
      
      // Ensure currentIndex is correct (should be the length of the array)
      // This handles cases where rows were deleted and currentIndex might be wrong
      if (this.currentIndex !== settingValue.length) {
        this.currentIndex = settingValue.length;
      }
      
      // The control structure is going to define the new fields
      // We need to clone control.params.fields. Assigning it
      // would result in a reference assignment.
      templateData = JSON.parse(JSON.stringify(control.params.fields));

      // But if we have passed data, we'll use the data values instead
      if (data) {
        for (i in data) {
          if (data.hasOwnProperty(i) && templateData.hasOwnProperty(i)) {
            templateData[i].default = data[i];
          }
        }
      }

      templateData.index = this.currentIndex;
      
      // Ensure the template data has the correct structure
      // The template expects data.index to be the row index

      // Append the template content
      var templateHtml = template(templateData);
      
      // Check if template is valid
      if (!templateHtml || typeof templateHtml !== 'string') {
        console.warn('Repeater template returned invalid HTML');
        return;
      }

      // Create a new row object and append the element
      // The template returns HTML string, we need to parse it
      var tempDiv = document.createElement("div");
      tempDiv.innerHTML = templateHtml.trim();
      var templateElement = tempDiv.firstElementChild || tempDiv.firstChild;
      
      // If we got a text node or something else, try getting the li element
      if (!templateElement || templateElement.nodeType !== 1) {
        templateElement = tempDiv.querySelector("li.repeater-row");
      }
      
      if (!templateElement) {
        console.warn('Repeater template did not produce a valid row element');
        return;
      }
      
      if (control.repeaterFieldsContainer) {
        control.repeaterFieldsContainer.appendChild(templateElement);
        newRow = new RepeaterRow(
          control.currentIndex,
          templateElement,
          control.params.row_label,
          control
        );
        
        // Verify and fix the data-row attribute if needed
        var actualRowIndex = getData(templateElement, "row");
        if (actualRowIndex !== String(control.currentIndex)) {
          setData(templateElement, "row", control.currentIndex);
        }
        
        // Ensure the row is expanded (not minimized) when first added
        // The template starts with "minimized" class, so we remove it to expand
        if (newRow.containerEl && newRow.containerEl.classList.contains("minimized")) {
          newRow.containerEl.classList.remove("minimized");
          // Update the arrow icon to show it's expanded
          if (newRow.header) {
            var dashicons = newRow.header.querySelector(".dashicons");
            if (dashicons) {
              dashicons.classList.remove("dashicons-arrow-down");
              dashicons.classList.add("dashicons-arrow-up");
            }
          }
        }
        
        // Force label update to show correct row number
        newRow.updateLabel();

        // Set up event listeners for this specific row (events bubble from row to container)
        if (newRow.containerEl) {
          // Use a unique handler per row to avoid conflicts
          newRow._removeHandler = function (e) {
            var rowIndex = e.detail && e.detail[0] !== undefined ? e.detail[0] : newRow.rowIndex;
            control.deleteRow(rowIndex);
          };
          
          newRow._updateHandler = function (e) {
            var detail = e.detail || [];
            var eventRowIndex = detail[0];
            var fieldName = detail[1];
            var element = detail[2];
            // Always use this row's index, not the event index (which might be wrong)
            // The event is triggered from this row, so we know it's for this row
            control.updateField.call(control, e, newRow.rowIndex, fieldName, element); // eslint-disable-line no-useless-call
            newRow.updateLabel();
          };
          
          newRow.containerEl.addEventListener("row:remove", newRow._removeHandler);
          newRow.containerEl.addEventListener("row:update", newRow._updateHandler);
        }
      }

      // Add the row to rows collection
      this.rows[this.currentIndex] = newRow;

      for (i in templateData) {
        if (templateData.hasOwnProperty(i) && i !== 'index') {
          // Skip the index property, only include field data
          newRowSetting[i] = templateData[i].default;
        }
      }

      // Ensure settingValue is an array
      if (!Array.isArray(settingValue)) {
        settingValue = [];
      }
      
      // Ensure currentIndex is correct (should be the length of the array)
      // This handles cases where rows were deleted and currentIndex might be wrong
      if (this.currentIndex !== settingValue.length) {
        this.currentIndex = settingValue.length;
      }
      
      settingValue[this.currentIndex] = newRowSetting;
      this.setValue(settingValue, true);

      this.currentIndex++;

      return newRow;
    }
  },

  sort: function () {
    var control = this;
    var rows = querySelectorAll(this.repeaterFieldsContainer, ".repeater-row");
    var newOrder = [];
    var settings = control.getValue();
    var newRows = [];
    var newSettings = [];

    // CRITICAL: If DOM rows don't match our data, don't sort - something went wrong
    if (rows.length !== control.rows.length || rows.length !== settings.length) {
      // Don't modify anything if row counts don't match
      return;
    }

    // Build the new order based on current DOM order
    rows.forEach(function (element, index) {
      var rowIndex = getData(element, "row");
      // Fallback to getAttribute if getData returns null
      if (!rowIndex && rowIndex !== 0) {
        rowIndex = element.getAttribute("data-row");
      }
      
      // Convert to integer
      if (rowIndex !== null && rowIndex !== undefined && rowIndex !== "") {
        rowIndex = parseInt(rowIndex, 10);
        if (!isNaN(rowIndex)) {
          newOrder.push(rowIndex);
        }
      }
    });

    // Only proceed if we have the same number of rows
    if (newOrder.length !== rows.length) {
      return;
    }

    // Reorder rows and settings based on new order
    newOrder.forEach(function (oldPosition, newPosition) {
      if (control.rows[oldPosition]) {
        newRows[newPosition] = control.rows[oldPosition];
        newRows[newPosition].setRowIndex(newPosition);
        // Also update DOM attribute
        if (newRows[newPosition].containerEl) {
          setData(newRows[newPosition].containerEl, "row", newPosition);
        }
        // Update label immediately
        newRows[newPosition].updateLabel();
      }

      if (settings[oldPosition]) {
        newSettings[newPosition] = settings[oldPosition];
      }
    });

    control.rows = newRows;
    control.setValue(newSettings, true);
    
    // Update currentIndex to match the new array length
    control.currentIndex = newSettings.length;
  },

  /**
   * Delete a row in the repeater setting
   *
   * @param {int} index - Position of the row in the complete Setting Array
   * @returns {void}
   */
  deleteRow: function (index) {
    var currentSettings = this.getValue(),
      row,
      prop,
      newSettings = [],
      newRows = [],
      i = 0;

    if (currentSettings[index] !== undefined) {
      // Find the row
      row = this.rows[index];
      if (row) {
        // Remove the row settings and reindex the array
        // We need to create a new array without the deleted index
        for (var j = 0; j < currentSettings.length; j++) {
          if (j !== index) {
            newSettings[i] = currentSettings[j];
            newRows[i] = this.rows[j];
            if (newRows[i]) {
              // Update the row index - this is critical for correct labeling
              newRows[i].setRowIndex(i);
              // Also update the DOM attribute to ensure it's in sync
              if (newRows[i].containerEl) {
                setData(newRows[i].containerEl, "row", i);
                // Force update the label immediately
                newRows[i].updateLabel();
              }
            }
            i++;
          }
        }

        // Update the rows array and settings
        this.rows = newRows;
        this.setValue(newSettings, true);
        
        // Update currentIndex to be the next available index (length of new array)
        this.currentIndex = newSettings.length;
        
        // Update all row labels to ensure they're correct
        // This must happen after setValue to ensure data is saved
        for (var k = 0; k < newRows.length; k++) {
          if (newRows[k]) {
            newRows[k].updateLabel();
          }
        }
      }
    } else {
      // If index doesn't exist, rebuild the rows array properly
      // This can happen if indices are out of sync
      var actualRows = querySelectorAll(this.repeaterFieldsContainer, ".repeater-row");
      var rebuiltRows = [];
      var rebuiltSettings = [];
      
      actualRows.forEach(function(rowEl, idx) {
        var rowIndex = parseInt(getData(rowEl, "row"), 10);
        if (!isNaN(rowIndex) && this.rows[rowIndex]) {
          rebuiltRows[idx] = this.rows[rowIndex];
          rebuiltRows[idx].setRowIndex(idx);
          setData(rowEl, "row", idx);
          rebuiltSettings[idx] = currentSettings[rowIndex] || {};
        }
      }.bind(this));
      
      this.rows = rebuiltRows;
      this.currentIndex = rebuiltRows.length;
      
      // Update all row labels
      for (var m = 0; m < rebuiltRows.length; m++) {
        if (rebuiltRows[m]) {
          rebuiltRows[m].updateLabel();
        }
      }
      
      if (rebuiltSettings.length > 0) {
        this.setValue(rebuiltSettings, true);
      }
    }
  },

  /**
   * Update a single field inside a row.
   * Triggered when a field has changed
   *
   * @param {Object} e - Event Object
   * @param {int} rowIndex - The row's index as an integer.
   * @param {string} fieldId - The field ID.
   * @param {string|Object} element - The element's identifier, or jQuery Object of the element.
   * @returns {void}
   */
  updateField: function (e, rowIndex, fieldId, element) {
    var type, row, currentSettings;

    // Validate rowIndex
    if (rowIndex === null || rowIndex === undefined || isNaN(rowIndex)) {
      return;
    }

    rowIndex = parseInt(rowIndex, 10);

    if (!this.rows[rowIndex]) {
      return;
    }

    if (!this.params.fields[fieldId]) {
      return;
    }

    type = this.params.fields[fieldId].type;
    row = this.rows[rowIndex];
    currentSettings = this.getValue();

    // Ensure currentSettings is an array
    if (!Array.isArray(currentSettings)) {
      currentSettings = [];
    }

    var elementEl = getElement(element);
    if (!elementEl) {
      elementEl = typeof element === "string" ? document.querySelector(element) : element;
    }

    // Ensure the settings array has the correct structure
    if (!currentSettings[rowIndex]) {
      currentSettings[rowIndex] = {};
    }

    // Initialize the field if it doesn't exist
    if (_.isUndefined(currentSettings[rowIndex][fieldId])) {
      currentSettings[rowIndex][fieldId] = "";
    }

    if ("checkbox" === type) {
      currentSettings[rowIndex][fieldId] = elementEl.checked;
    } else {
      // Update the settings - use rowIndex parameter
      currentSettings[rowIndex][fieldId] = elementEl.value;
    }
    
    this.setValue(currentSettings, true);
  },

  /**
   * Init the color picker on color fields
   * Called after AddRow
   *
   * @returns {void}
   */
  initColorPicker: function () {
    var control = this;
    // Find all color pickers that haven't been initialized
    var colorPickers = querySelectorAll(control.container, ".kirki-classic-color-picker");
    
    colorPickers.forEach(function(colorPicker) {
      // Skip if already initialized (has wpColorPicker instance)
      if (colorPicker.closest('.wp-picker-container')) {
        return;
      }

      // WordPress color picker requires jQuery, so we need to wrap it
      // This is the only place where we still need jQuery
      var $colorPicker = jQuery(colorPicker);
      var fieldId = getData(colorPicker, "field");
      var options = {};

      // We check if the color palette parameter is defined.
      if (
        !_.isUndefined(fieldId) &&
        !_.isUndefined(control.params.fields[fieldId]) &&
        !_.isUndefined(control.params.fields[fieldId].palettes) &&
        _.isObject(control.params.fields[fieldId].palettes)
      ) {
        options.palettes = control.params.fields[fieldId].palettes;
      }

      // When the color picker value is changed we update the value of the field
      options.change = function (event, ui) {
        var currentPicker = event.target;
        var row = currentPicker.closest(".repeater-row");
        var rowIndex = row ? parseInt(getData(row, "row"), 10) : null;
        var currentSettings = control.getValue();
        var value = ui.color._alpha < 1 ? ui.color.to_s() : ui.color.toString();

        if (rowIndex !== null && !_.isUndefined(currentSettings[rowIndex])) {
          var pickerField = getData(currentPicker, "field");
          currentSettings[rowIndex][pickerField] = value;
          control.setValue(currentSettings, true);
        }

        // By default if the alpha is 1, the input will be rgb.
        // We setTimeout to 50ms to prevent race value set.
        setTimeout(function() {
          event.target.value = value;
        }, 50);
      };

      // Init the color picker (WordPress requires jQuery for this)
      $colorPicker.wpColorPicker(options);
    });
  },

  /**
   * Init the dropdown-pages field.
   * Called after AddRow
   *
   * @param {object} theNewRow the row that was added to the repeater
   * @param {object} data the data for the row if we're initializing a pre-existing row
   * @returns {void}
   */
  initSelect: function (theNewRow, data) {
    var control = this;
    // Use containerEl to ensure we have the DOM element
    var rowContainer = theNewRow.containerEl || theNewRow.container;
    // Find ALL select elements, not just the first one
    var dropdowns = querySelectorAll(rowContainer, ".repeater-field select");
    
    if (!dropdowns || dropdowns.length === 0) {
      return;
    }

    data = data || {};

    // Process each select element
    dropdowns.forEach(function(dropdown) {
      // Try getData first, then fallback to getAttribute
      var dataField = getData(dropdown, "field");
      if (!dataField) {
        dataField = dropdown.getAttribute("data-field");
      }
      
      var multiple = getData(dropdown, "multiple");

      // Set the value if it exists in data, otherwise keep the default from template
      if (dataField && data[dataField] !== undefined && data[dataField] !== null && data[dataField] !== '') {
        dropdown.value = data[dataField];
      }
      
      // Add a direct change event listener to each select
      // This ensures select changes are captured and saved correctly
      if (dataField) {
        dropdown.addEventListener('change', function(e) {
          // Stop the event from bubbling to prevent double-handling
          e.stopPropagation();
          
          var currentSettings = control.getValue();
          var rowIndex = theNewRow.rowIndex;
          
          if (currentSettings[rowIndex]) {
            currentSettings[rowIndex][dataField] = e.target.value;
            control.setValue(currentSettings, true);
            
            // Update the row label if needed
            if (theNewRow.updateLabel) {
              theNewRow.updateLabel();
            }
          }
        });
      }
    });
  },
});
