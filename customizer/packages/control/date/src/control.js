import "./control.scss";

/**
 * Vanilla JavaScript Date Picker
 */
var KirkiDatePicker = function(input, options) {
	this.input = input;
	this.options = options || {};
	this.currentDate = new Date();
	this.selectedDate = null;
	this.picker = null;
	this.isOpen = false;
	
	// Parse initial value if present
	if (this.input.value) {
		var parsed = this.parseDate(this.input.value);
		if (parsed) {
			this.selectedDate = parsed;
			this.currentDate = new Date(parsed);
		}
	}
	
	this.init();
};

KirkiDatePicker.prototype = {
	init: function() {
		var self = this;
		
		// Create picker element
		this.picker = document.createElement('div');
		this.picker.className = 'kirki-datepicker-popup';
		this.picker.style.display = 'none';
		document.body.appendChild(this.picker);
		
		// Handle input focus
		this.input.addEventListener('focus', function(e) {
			self.show();
		});
		
		// Handle input click
		this.input.addEventListener('click', function(e) {
			self.show();
		});
		
		// Handle manual input changes
		this.input.addEventListener('change', function(e) {
			var parsed = self.parseDate(e.target.value);
			if (parsed) {
				self.selectedDate = parsed;
				self.currentDate = new Date(parsed);
			}
		});
		
		// Close on outside click
		document.addEventListener('click', function(e) {
			if (!self.input.contains(e.target) && !self.picker.contains(e.target)) {
				self.hide();
			}
		});
		
		// Render initial calendar
		this.render();
	},
	
	parseDate: function(dateString) {
		// Parse YYYY-MM-DD format
		var parts = dateString.match(/^(\d{4})-(\d{2})-(\d{2})$/);
		if (parts) {
			var date = new Date(parseInt(parts[1], 10), parseInt(parts[2], 10) - 1, parseInt(parts[3], 10));
			if (!isNaN(date.getTime())) {
				return date;
			}
		}
		return null;
	},
	
	formatDate: function(date) {
		if (!date) return '';
		var year = date.getFullYear();
		var month = String(date.getMonth() + 1).padStart(2, '0');
		var day = String(date.getDate()).padStart(2, '0');
		return year + '-' + month + '-' + day;
	},
	
	show: function() {
		if (this.isOpen) return;
		
		this.isOpen = true;
		this.render();
		this.position();
		this.picker.style.display = 'block';
		
		// Set width to match input
		this.picker.style.width = this.input.clientWidth + 'px';
	},
	
	hide: function() {
		if (!this.isOpen) return;
		
		this.isOpen = false;
		this.picker.style.display = 'none';
	},
	
	position: function() {
		var rect = this.input.getBoundingClientRect();
		var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
		var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
		
		// Get viewport dimensions
		var viewportHeight = window.innerHeight || document.documentElement.clientHeight;
		var viewportWidth = window.innerWidth || document.documentElement.clientWidth;
		
		// Get picker dimensions (need to show it temporarily to measure)
		var wasVisible = this.picker.style.display !== 'none';
		if (!wasVisible) {
			this.picker.style.visibility = 'hidden';
			this.picker.style.display = 'block';
		}
		var pickerHeight = this.picker.offsetHeight;
		var pickerWidth = this.picker.offsetWidth;
		if (!wasVisible) {
			this.picker.style.visibility = '';
			this.picker.style.display = 'none';
		}
		
		// Calculate available space
		var spaceBelow = viewportHeight - rect.bottom;
		var spaceAbove = rect.top;
		
		// Add some padding (5px gap)
		var gap = 5;
		var requiredSpace = pickerHeight + gap;
		
		// Determine position: prefer bottom, but use top if not enough space
		var positionAbove = false;
		if (spaceBelow < requiredSpace && spaceAbove > spaceBelow) {
			positionAbove = true;
		}
		
		this.picker.style.position = 'absolute';
		this.picker.style.zIndex = '500001';
		
		if (positionAbove) {
			// Position above the input
			this.picker.style.top = (rect.top + scrollTop - pickerHeight - gap) + 'px';
			this.picker.classList.add('kirki-datepicker-above');
			this.picker.classList.remove('kirki-datepicker-below');
		} else {
			// Position below the input (default)
			this.picker.style.top = (rect.bottom + scrollTop + gap) + 'px';
			this.picker.classList.add('kirki-datepicker-below');
			this.picker.classList.remove('kirki-datepicker-above');
		}
		
		// Horizontal positioning - keep left aligned, but adjust if it would go off-screen
		var leftPosition = rect.left + scrollLeft;
		if (leftPosition + pickerWidth > viewportWidth + scrollLeft) {
			leftPosition = viewportWidth + scrollLeft - pickerWidth;
		}
		if (leftPosition < scrollLeft) {
			leftPosition = scrollLeft;
		}
		this.picker.style.left = leftPosition + 'px';
	},
	
	render: function() {
		var self = this;
		var year = this.currentDate.getFullYear();
		var month = this.currentDate.getMonth();
		
		// Get first day of month and number of days
		var firstDay = new Date(year, month, 1);
		var lastDay = new Date(year, month + 1, 0);
		var daysInMonth = lastDay.getDate();
		var startingDayOfWeek = firstDay.getDay();
		
		// Month names
		var monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
			'July', 'August', 'September', 'October', 'November', 'December'];
		
		// Day names
		var dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
		
		var html = '<div class="kirki-datepicker-header">';
		html += '<button type="button" class="kirki-datepicker-prev" aria-label="Previous month"></button>';
		html += '<div class="kirki-datepicker-title">' + monthNames[month] + ' ' + year + '</div>';
		html += '<button type="button" class="kirki-datepicker-next" aria-label="Next month"></button>';
		html += '</div>';
		
		html += '<table class="kirki-datepicker-calendar">';
		html += '<thead><tr>';
		for (var i = 0; i < dayNames.length; i++) {
			html += '<th>' + dayNames[i] + '</th>';
		}
		html += '</tr></thead>';
		html += '<tbody><tr>';
		
		// Empty cells for days before month starts
		for (var i = 0; i < startingDayOfWeek; i++) {
			html += '<td></td>';
		}
		
		// Days of the month
		var today = new Date();
		today.setHours(0, 0, 0, 0);
		
		for (var day = 1; day <= daysInMonth; day++) {
			var date = new Date(year, month, day);
			var isToday = date.getTime() === today.getTime();
			var isSelected = this.selectedDate && 
				date.getTime() === new Date(this.selectedDate.getFullYear(), this.selectedDate.getMonth(), this.selectedDate.getDate()).getTime();
			
			var cellClass = 'kirki-datepicker-day';
			if (isToday) cellClass += ' kirki-datepicker-today';
			if (isSelected) cellClass += ' kirki-datepicker-selected';
			
			html += '<td class="' + (isToday ? 'kirki-datepicker-today' : '') + '">';
			html += '<a href="#" class="' + cellClass + '" data-day="' + day + '" data-month="' + month + '" data-year="' + year + '">' + day + '</a>';
			html += '</td>';
			
			// New row after Saturday
			if ((startingDayOfWeek + day) % 7 === 0 && day < daysInMonth) {
				html += '</tr><tr>';
			}
		}
		
		html += '</tr></tbody></table>';
		
		this.picker.innerHTML = html;
		
		// Attach event listeners
		var prevBtn = this.picker.querySelector('.kirki-datepicker-prev');
		var nextBtn = this.picker.querySelector('.kirki-datepicker-next');
		var dayLinks = this.picker.querySelectorAll('.kirki-datepicker-day');
		
		prevBtn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			self.currentDate.setMonth(self.currentDate.getMonth() - 1);
			var wasOpen = self.isOpen;
			self.render();
			if (wasOpen) {
				// Small delay to ensure DOM is updated before measuring
				setTimeout(function() {
					self.picker.style.display = 'block';
					self.position();
				}, 0);
			}
		});
		
		nextBtn.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			self.currentDate.setMonth(self.currentDate.getMonth() + 1);
			var wasOpen = self.isOpen;
			self.render();
			if (wasOpen) {
				// Small delay to ensure DOM is updated before measuring
				setTimeout(function() {
					self.picker.style.display = 'block';
					self.position();
				}, 0);
			}
		});
		
		for (var i = 0; i < dayLinks.length; i++) {
			dayLinks[i].addEventListener('click', function(e) {
				e.preventDefault();
				var day = parseInt(this.getAttribute('data-day'), 10);
				var month = parseInt(this.getAttribute('data-month'), 10);
				var year = parseInt(this.getAttribute('data-year'), 10);
				
				var selectedDate = new Date(year, month, day);
				self.selectedDate = selectedDate;
				self.input.value = self.formatDate(selectedDate);
				self.input.dispatchEvent(new Event('change', { bubbles: true }));
				self.hide();
			});
		}
	},
	
	destroy: function() {
		if (this.picker && this.picker.parentNode) {
			this.picker.parentNode.removeChild(this.picker);
		}
	}
};

wp.customize.controlConstructor['kirki-date'] = wp.customize.kirkiDynamicControl.extend({

	initKirkiControl: function (control) {
		control = control || this;
		var container = control.container[0] || control.container;
		var input = container.querySelector('input.datepicker');

		if (!input) {
			return;
		}

		// Initialize vanilla JS date picker
		var datePicker = new KirkiDatePicker(input, {
			dateFormat: 'yy-mm-dd'
		});
		
		// Store reference for cleanup if needed
		control.datePicker = datePicker;

		// Save the changes using vanilla JS event listeners
		var handleInputChange = function (event) {
			if (event.target && event.target.classList.contains('datepicker')) {
				control.setting.set(event.target.value);
			}
		};

		container.addEventListener('change', handleInputChange);
		container.addEventListener('keyup', handleInputChange);
		container.addEventListener('paste', handleInputChange);
	}
});
