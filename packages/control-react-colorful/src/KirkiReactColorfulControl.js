import ReactDOM from "react-dom";
import KirkiReactColorfulForm from "./KirkiReactColorfulForm";

/**
 * KirkiReactColorfulControl.
 *
 * @class
 * @augments wp.customize.Control
 * @augments wp.customize.Class
 */
const KirkiReactColorfulControl = wp.customize.Control.extend({
	/**
	 * Initialize.
	 *
	 * @param {string} id - Control ID.
	 * @param {object} params - Control params.
	 */
	initialize: function (id, params) {
		const control = this;

		// Bind functions to this control context for passing as React props.
		control.setNotificationContainer =
			control.setNotificationContainer.bind(control);

		wp.customize.Control.prototype.initialize.call(control, id, params);

		// The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.
		function onRemoved(removedControl) {
			if (control === removedControl) {
				control.destroy();
				control.container.remove();
				wp.customize.control.unbind("removed", onRemoved);
			}
		}
		wp.customize.control.bind("removed", onRemoved);
	},

	/**
	 * Set notification container and render.
	 *
	 * This is called when the React component is mounted.
	 *
	 * @param {Element} element - Notification container.
	 * @returns {void}
	 */
	setNotificationContainer: function setNotificationContainer(element) {
		const control = this;
		control.notifications.container = jQuery(element);
		control.notifications.render();
	},

	/**
	 * Render the control into the DOM.
	 *
	 * This is called from the Control#embed() method in the parent class.
	 *
	 * @returns {void}
	 */
	renderContent: function renderContent() {
		const control = this;
		const useHueMode = "hue" === control.params.mode;
		const choices = control.params.choices;

		let pickerComponent;

		if (choices.formComponent) {
			pickerComponent = choices.formComponent;
		} else {
			pickerComponent = choices.alpha
				? "RgbaStringColorPicker"
				: "HexColorPicker";
		}

		pickerComponent = useHueMode ? "HueColorPicker" : pickerComponent;

		const form = (
			<KirkiReactColorfulForm
				{...control.params}
				control={control}
				customizerSetting={control.setting}
				useHueMode={useHueMode}
				pickerComponent={pickerComponent}
				value={control.params.value}
				setNotificationContainer={control.setNotificationContainer}
			/>
		);

		ReactDOM.render(form, control.container[0]);
	},

	/**
	 * After control has been first rendered, start re-rendering when setting changes.
	 *
	 * React is able to be used here instead of the wp.customize.Element abstraction.
	 *
	 * @returns {void}
	 */
	ready: function ready() {
		const control = this;

		/**
		 * Update component state when customizer setting changes.
		 *
		 * There was an issue (which was fixed):
		 *
		 * Let's say we have other color picker ("x" color picker) and this current color picker ("y" color picker).
		 * Let's say there's a script that bind to that "x" color picker to make change to this "y" color picker.
		 *
		 * When "x" color picker is changed fast (by dragging the color, for example),
		 * then the re-render of this "y" color picker will be messy.
		 * There was something like "function-call race" between component re-render and function call inside the component.
		 *
		 * When that happens, the "x" color picker becomes unresponsive and un-usable.
		 *
		 * How we fixed that:
		 * - Provide a updateComponentState property to this file.
		 * - Inside the component, assign the updateComponentState with a function to update some states.
		 * - Then inside the binding below, call updateComponentState instead of re-rendering the component.
		 *
		 * The result: Even though the "x" color picker becomes very slow, it's still usable and responsive enough.
		 */
		control.setting.bind((val) => {
			control.updateComponentState(val);
		});
	},

	updateComponentState: () => {},

	/**
	 * Handle removal/de-registration of the control.
	 *
	 * This is essentially the inverse of the Control#embed() method.
	 *
	 * @link https://core.trac.wordpress.org/ticket/31334
	 * @returns {void}
	 */
	destroy: function destroy() {
		const control = this;

		// Garbage collection: undo mounting that was done in the embed/renderContent method.
		ReactDOM.unmountComponentAtNode(control.container[0]);

		// Call destroy method in parent if it exists (as of #31334).
		if (wp.customize.Control.prototype.destroy) {
			wp.customize.Control.prototype.destroy.call(control);
		}
	},
});

export default KirkiReactColorfulControl;
