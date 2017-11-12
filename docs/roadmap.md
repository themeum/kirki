---
layout: default
title: Kirki Roadmap
subtitle: Plan big
mainMaxWidth: 50rem;
bodyClasses: roadmap
---

Below is a list of things I want to accomplish in the next versions. The items on this list are in no particular order and at this point there are no ETAs or versions. This is just a rough draft of my goals regarding Kirki

#### Rewrite the `postMessage` module

<span class="secondary label">Planned for</span><span class="alert label">future version</span>


When Kirki started almost 4 years ago WordPress's APIs for the customizer were limited.
However these past 4 years a lot has changed and unfortunately the code behind this module hasn't changed a lot.
This module requires a complete rewrite, and it will all be in JS. No more auto-generating scripts.
Instead we can simply have a JS file that will parse the controls, check their arguments and apply any CSS (or HTML) rules directly. It will be a lot faster & cleaner this way.

---

#### Move markup for controls from PHP to JS

<span class="secondary label">Planned for</span><span class="warning label">3.1.0</span>

I recently introduced a `kirkiDynamicControl` object in Kirki - derived from the [wp-customize-posts](https://github.com/xwp/wp-customize-posts) plugin. When a Kirki control extends that object we're able to initialize the control not when the customizer loads, but when the control's section is activated. This makes the initial customizer load a lot faster, but the actual markup for many controls is still added on load. By moving the markup to the JS files we'll be able to render the controls only when they are needed instead of on load.

---

#### Abstract controls by creating a global `kirki` object

<span class="secondary label">Planned for</span><span class="warning label">3.1.0</span>

This is far from final, but the current idea looks something like this:

```js
kirki = {
	control: {
		/**
		 * This is added from each individual control.
		 */
		{controlType}: {
			/**
			 * Init the control.
			 * This involves adding the HTML
			 * and triggering any additional scripts/actions required.
			 * Note that one of the params here will have to be
			 * the container element for the control.
			 */
			init: function( args ) {
				var self = this;

				self.template( params );
			},

			/**
			 * Get the HTML for this control.
			 * It should accept the same params as the init function
			 * to make things easier.
			 */
			template : function( args ) {
				var html = '';

				// Add the HTML to the container.
				jQuery( args.container ).html( html );
			},

			utils: {
				/**
				 * Set a value.
				 * This is ONLY for the visual part of setting the value.
				 * For example image controls must get the URL of the image,
				 * select2 elements may need re-triggering etc.
				 * The params argument should contain the setting-id & the value.
				 */
				setValue: function( id, value ) {}
			}
		},

		/**
		 * Set a value.
		 * This is ONLY for the visual part of setting the value.
		 * Necessary as a fallback for the kirki.control.{controlType}.setValue method
		 * since some simple controls won't need anything complicated
		 * and can share this method.
		 */
		setValue: function( args ) {}
	},

	input: {
		/**
		 * Get the template for an input field.
		 */
		getTemplate: function( args ) {
			args.type = args.type || 'text';
			switch ( args.type ) {
				case 'textarea':
					break;
				case 'select':
					break;
				case 'radio':
					break;
				case 'color':
					break;
				case 'checkbox':
					break;
				default:
			}
		}

		/**
		 * Init the code needed for the field.
		 */
		init: function( args ) {

		}
	},

	/**
	 * This will be global in the kirki object.
	 * Will contain functions for getting & setting values.
	 */
	setting: {
		/**
		 * Get the value of a setting.
		 * The reason we'll need this abstraction is for repeaters
		 * and other complex controls where we need to get setting[subsetting]
		 * or even setting[0][subsetting], and the customizer setting is 'setting'.
		 * This is just a proxy to figure out things.
		 */
		get: function( id ) {},

		/**
		 * Sets the value of a setting.
		 * The reasons for creating this method are similar to the ones for the get method.
		 */
		set: function( id, value ) {}
	},
}
```

What that will allow us to do is have a standardised way to add input fields. That would allow us for example to create complex controls easier and more effectively. For example the `typography` control wouldn't need to create everything from scratch. Instead we'd add all input fields that consitute the typography control using the `kirki` object, and everything else would be taken care of automatically. Repeaters would be able to act as wrapper for complete control structures instead of wrappers for simple input elements.

---
