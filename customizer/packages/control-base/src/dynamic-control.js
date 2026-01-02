/**
 * The majority of the code in this file
 * is derived from the wp-customize-posts plugin
 * and the work of @westonruter to whom I am very grateful.
 *
 * @see https://github.com/xwp/wp-customize-posts
 */

(function () {
	'use strict';

	/**
	 * A dynamic color-alpha control.
	 *
	 * @class
	 * @augments wp.customize.Control
	 * @augments wp.customize.Class
	 */
	wp.customize.kirkiDynamicControl = wp.customize.Control.extend({

		initialize: function (id, options) {
			let control = this;
			let args = options || {};

			args.params = args.params || {};

			if (!args.params.type) {
				args.params.type = 'kirki-generic';
			}

			let className;

			if (args.content) {
				let splits = args.content.split('class="');
				splits = splits[1].split('"');
				className = splits[0];
			} else {
				className = 'customize-control customize-control-' + args.params.type;
			}

			if (!args.params.wrapper_attrs && args.params.wrapper_atts) {
				args.params.wrapper_attrs = args.params.wrapper_atts;
			}

			// Hijack the container to add wrapper_attrs.
      args.params.content = jQuery("<li></li>");
			args.params.content.attr('id', 'customize-control-' + id.replace(/]/g, '').replace(/\[/g, '-'));
			args.params.content.attr('class', className);

			_.each(args.params.wrapper_attrs, function (val, key) {
				if ('class' === key) {
					val = val.replace('{default_class}', className);
				}

				args.params.content.attr(key, val);
			});

			control.propertyElements = [];
			wp.customize.Control.prototype.initialize.call(control, id, args);
			wp.hooks.doAction('kirki.dynamicControl.init.after', id, control, args);
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting(s).
		 *
		 * This is copied from wp.customize.Control.prototype.initialize(). It
		 * should be changed in Core to be applied once the control is embedded.
		 *
		 * @private
		 * @returns {void}
		 */
		_setUpSettingRootLinks: function () {
			var control = this,
				nodes = control.container.find('[data-customize-setting-link]');

			nodes.each(function () {
				var node = jQuery(this);

				wp.customize(node.data('customizeSettingLink'), function (setting) {
					var element = new wp.customize.Element(node);
					control.elements.push(element);
					element.sync(setting);
					element.set(setting());
				});
			});
		},

		/**
		 * Add bidirectional data binding links between inputs and the setting properties.
		 *
		 * @private
		 * @returns {void}
		 */
		_setUpSettingPropertyLinks: function () {
			var control = this,
				nodes;

			if (!control.setting) {
				return;
			}

			nodes = control.container.find('[data-customize-setting-property-link]');

			nodes.each(function () {
				var node = jQuery(this),
					element,
					propertyName = node.data('customizeSettingPropertyLink');

				element = new wp.customize.Element(node);
				control.propertyElements.push(element);
				element.set(control.setting()[propertyName]);

				element.bind(function (newPropertyValue) {
					var newSetting = control.setting();
					if (newPropertyValue === newSetting[propertyName]) {
						return;
					}
					newSetting = _.clone(newSetting);
					newSetting[propertyName] = newPropertyValue;
					control.setting.set(newSetting);
				});
				control.setting.bind(function (newValue) {
					if (newValue[propertyName] !== element.get()) {
						element.set(newValue[propertyName]);
					}
				});
			});
		},

		/**
		 * @inheritdoc
		 */
		ready: function () {
			var control = this;

			control._setUpSettingRootLinks();
			control._setUpSettingPropertyLinks();

			wp.customize.Control.prototype.ready.call(control);

			control.deferred.embedded.done(function () {
				control.initKirkiControl();
				wp.hooks.doAction('kirki.dynamicControl.ready.deferred.embedded.done', control);
			});
			wp.hooks.doAction('kirki.dynamicControl.ready.after', control);
		},

		/**
		 * Embed the control in the document.
		 *
		 * Override the embed() method to do nothing,
		 * so that the control isn't embedded on load,
		 * unless the containing section is already expanded.
		 *
		 * @returns {void}
		 */
		embed: function () {
			var control = this,
				sectionId = control.section();

			if (!sectionId) {
				return;
			}

			wp.customize.section(sectionId, function (section) {
				if ('kirki-expanded' === section.params.type || section.expanded() || wp.customize.settings.autofocus.control === control.id) {
					control.actuallyEmbed();
				} else {
					section.expanded.bind(function (expanded) {
						if (expanded) {
							control.actuallyEmbed();
						}
					});
				}
			});
			wp.hooks.doAction('kirki.dynamicControl.embed.after', control);
		},

		/**
		 * Deferred embedding of control when actually
		 *
		 * This function is called in Section.onChangeExpanded() so the control
		 * will only get embedded when the Section is first expanded.
		 *
		 * @returns {void}
		 */
		actuallyEmbed: function () {
			var control = this;
			if ('resolved' === control.deferred.embedded.state()) {
				return;
			}
			control.renderContent();
			control.deferred.embedded.resolve(); // This triggers control.ready().
			wp.hooks.doAction('kirki.dynamicControl.actuallyEmbed.after', control);
		},

		/**
		 * This is not working with autofocus.
		 *
		 * @param {object} [args] Args.
		 * @returns {void}
		 */
		focus: function (args) {
			var control = this;
			control.actuallyEmbed();
			wp.customize.Control.prototype.focus.call(control, args);
			wp.hooks.doAction('kirki.dynamicControl.focus.after', control);
		},

		/**
		 * Additional actions that run on ready.
		 *
		 * @param {object} control - The control object. If undefined fallsback to the this.
		 * @returns {void}
		 */
		initKirkiControl: function (control) {
			control = control || this;
			wp.hooks.doAction('kirki.dynamicControl.initKirkiControl', this);

			// Save the value
			control.container.on('change keyup paste click', 'input', function () {
				control.setting.set(jQuery(this).val());
			});
		}
	});
}());

(function (api) {

	/**
	 * Set the value and trigger all bound callbacks.
	 *
	 * @since 1.0
	 * @param {object} to - New value.
	 * @returns {Object} - this
	 */
	api.Value.prototype.set = function (to) {
		var from = this._value,
			parentSetting,
			newVal;

		to = this._setter.apply(this, arguments);
		to = this.validate(to);

		// Bail if the sanitized value is null or unchanged.
		if (null === to || _.isEqual(from, to)) {
			return this;
		}

		/**
		 * Start Kirki mod.
		 */
		if (this.id && api.control(this.id) && api.control(this.id).params && api.control(this.id).params.parent_setting) {
			parentSetting = api.control(this.id).params.parent_setting;
			newVal = {};
			newVal[this.id.replace(parentSetting + '[', '').replace(']', '')] = to;
			api.control(parentSetting).setting.set(jQuery.extend({}, api.control(parentSetting).setting._value, newVal));
		}

		/**
		 * End Kirki mod.
		 */

		this._value = to;
		this._dirty = true;

		this.callbacks.fireWith(this, [to, from]);

		return this;
	};

	/**
	 * Get the value.
	 *
	 * @returns {mixed} - Returns the value.
	 */
	api.Value.prototype.get = function () {

		// Start Kirki mod.
		var parentSetting;
		if (this.id && api.control(this.id) && api.control(this.id).params && api.control(this.id).params.parent_setting) {
			parentSetting = api.control(this.id).params.parent_setting;
			return api.control(parentSetting).setting.get()[this.id.replace(parentSetting + '[', '').replace(']', '')];
		}
		// End Kirki mod.

		return this._value;
	};
}(wp.customize));
