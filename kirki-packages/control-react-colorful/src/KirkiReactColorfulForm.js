import { useState, useRef } from "react";
import {
	HexColorPicker,
	RgbColorPicker,
	RgbaColorPicker,
	RgbStringColorPicker,
	RgbaStringColorPicker,
	HslColorPicker,
	HslaColorPicker,
	HslStringColorPicker,
	HslaStringColorPicker,
	HsvColorPicker,
	HsvaColorPicker,
	HsvStringColorPicker,
	HsvaStringColorPicker,
} from "react-colorful";
import KirkiReactColorfulInput from "./js/components/KirkiReactColorfulInput";
import KirkiReactColorfulSwatches from "./js/components/KirkiReactColorfulSwatches";
import convertColorForPicker from "./js/utils/convertColorForPicker";
import convertColorForCustomizer from "./js/utils/convertColorForCustomizer";
import convertColorForInput from "./js/utils/convertColorForInput";
import useClickOutside from "./js/hooks/useClickOutside";
import useFocusOutside from "./js/hooks/useFocusOutside";
import useWindowResize from "./js/hooks/useWindowResize";
import KirkiReactColorfulCircle from "./js/components/KirkiReactColorfulCircle";
import { colord } from "colord";

/**
 * The form component of Kirki React Colorful.
 *
 * Globals:
 * _, wp, React, ReactDOM
 *
 * @param {Object} props The props for the component.
 * @returns The component element.
 */
const KirkiReactColorfulForm = (props) => {
	const { control, customizerSetting, useHueMode, pickerComponent, choices } =
		props;

	const parseEmptyValue = () => (useHueMode ? 0 : "#000000");

	const parseHueModeValue = (hueValue) => {
		hueValue = hueValue || parseEmptyValue();
		hueValue = hueValue < 0 ? 0 : hueValue;

		return hueValue > 360 ? 360 : hueValue;
	};

	const parseInputValue = (value) => {
		if ("" === value) return "";

		return useHueMode
			? parseHueModeValue(value)
			: convertColorForInput(
					value,
					pickerComponent,
					choices.formComponent
			  ).replace(";", "");
	};

	const parseCustomizerValue = (value) => {
		if ("" === value) return "";

		return convertColorForCustomizer(
			value,
			pickerComponent,
			choices.formComponent
		);
	};

	const parsePickerValue = (value) => {
		value = value || parseEmptyValue();

		// Hard coded saturation and lightness when using hue mode.
		return useHueMode
			? { h: value, s: 100, l: 50 }
			: convertColorForPicker(value, pickerComponent);
	};

	const [inputValue, setInputValue] = useState(() => {
		return parseInputValue(props.value);
	});

	const [pickerValue, setPickerValue] = useState(() => {
		return parsePickerValue(props.value);
	});

	let currentInputValue = inputValue;
	let currentPickerValue = pickerValue;

	// This function will be called when this control's customizer value is changed.
	control.updateComponentState = (value) => {
		const valueForInput = parseInputValue(value);
		let changeInputValue = false;

		if (typeof valueForInput === "string" || useHueMode) {
			changeInputValue = valueForInput !== inputValue;
		} else {
			changeInputValue =
				JSON.stringify(valueForInput) !== JSON.stringify(currentInputValue);
		}

		if (changeInputValue) setInputValue(valueForInput);

		const valueForPicker = parsePickerValue(value);
		let changePickerValue = false;

		if (typeof valueForPicker === "string" || useHueMode) {
			changePickerValue = valueForPicker !== pickerValue;
		} else {
			changePickerValue =
				JSON.stringify(valueForPicker) !== JSON.stringify(currentPickerValue);
		}

		if (changePickerValue) setPickerValue(valueForPicker);
	};

	const saveToCustomizer = (value) => {
		if (useHueMode) {
			/**
			 * When using hue mode, the pickerComponent is HslColorPicker.
			 * If there is value.h, then value is set from the picker.
			 * Otherwise, value is set from the input or the customizer.
			 */
			value = value.h || 0 === value.h ? value.h : value;
			value = parseHueModeValue(value);
		} else {
			value = parseCustomizerValue(value);
		}

		customizerSetting.set(value);
	};

	const initialColor =
		"" !== props.default && "undefined" !== typeof props.default
			? props.default
			: props.value;

	/**
	 * Function to run on picker change.
	 *
	 * @param {string|Object} color The value returned by the picker. It can be a string or a color object.
	 */
	const handlePickerChange = (color) => {
		if (props.onChange) props.onChange(color);
		currentPickerValue = color;
		saveToCustomizer(color);
	};

	const handleInputChange = (value) => {
		currentInputValue = value;
		saveToCustomizer(value);
	};

	const handleReset = () => {
		if (!initialColor) {
			currentInputValue = "";
			currentPickerValue = "";
		}

		saveToCustomizer(initialColor);
	};

	const handleSwatchesClick = (swatchColor) => {
		saveToCustomizer(swatchColor);
	};

	const handleWindowResize = () => {
		setPickerContainerStyle(getPickerContainerStyle());
	};

	let controlLabel = (
		<span
			className="customize-control-title"
			dangerouslySetInnerHTML={{ __html: props.label }}
		/>
	);

	let controlDescription = (
		<span
			className="description customize-control-description"
			dangerouslySetInnerHTML={{ __html: props.description }}
		></span>
	);

	controlLabel = (
		<label className="kirki-control-label">
			{props.label ? controlLabel : ""}
			{props.description ? controlDescription : ""}
		</label>
	);

	controlLabel = props.label || props.description ? controlLabel : "";

	const formRef = useRef(null); // Reference to the form div.
	const pickerRef = useRef(null); // Reference to the picker popup.
	const resetRef = useRef(null); // Reference to the picker popup.

	const [isPickerOpen, setIsPickerOpen] = useState(false);

	const usePositionFixed = "default" !== choices.labelStyle ? true : false;

	const [pickerContainerStyle, setPickerContainerStyle] = useState({});

	const getPickerContainerStyle = () => {
		let pickerContainerStyle = {};

		if (!usePositionFixed) return pickerContainerStyle;

		let padding = window.getComputedStyle(
			control.container[0].parentNode
		).paddingLeft;
		padding = parseInt(padding, 10) * 2;

		pickerContainerStyle.width =
			control.container[0].parentNode.getBoundingClientRect().width - padding;

		const controlLeftOffset = (control.container[0].offsetLeft - 9) * -1;

		pickerContainerStyle.left = controlLeftOffset + "px";

		return pickerContainerStyle;
	};

	const convertInputValueTo6Digits = () => {
		if (4 === inputValue.length && inputValue.includes("#")) {
			setInputValue(colord(inputValue).toHex());
		}
	};

	const togglePicker = () => {
		if (isPickerOpen) {
			closePicker();
		} else {
			openPicker();
		}
	};

	const openPicker = () => {
		if (isPickerOpen) return;

		setPickerContainerStyle(getPickerContainerStyle());
		convertInputValueTo6Digits();
		setIsPickerOpen(true);
	};

	const closePicker = () => {
		if (!isPickerOpen) return;

		setIsPickerOpen(false);
		setTimeout(convertInputValueTo6Digits, 200);
	};

	let KirkiPickerComponent;

	// We can't just render `pickerComponent` directly, we need these lines so that the compiler will import them.
	switch (pickerComponent) {
		case "HexColorPicker":
			KirkiPickerComponent = HexColorPicker;
			break;
		case "RgbColorPicker":
			KirkiPickerComponent = RgbColorPicker;
			break;
		case "RgbStringColorPicker":
			KirkiPickerComponent = RgbStringColorPicker;
			break;
		case "RgbaColorPicker":
			KirkiPickerComponent = RgbaColorPicker;
			break;
		case "RgbaStringColorPicker":
			KirkiPickerComponent = RgbaStringColorPicker;
			break;
		// We treat HueColorPicker (hue mode) as HslColorPicker.
		case "HueColorPicker":
			KirkiPickerComponent = HslColorPicker;
			break;
		case "HslColorPicker":
			KirkiPickerComponent = HslColorPicker;
			break;
		case "HslStringColorPicker":
			KirkiPickerComponent = HslStringColorPicker;
			break;
		case "HslaColorPicker":
			KirkiPickerComponent = HslaColorPicker;
			break;
		case "HslaStringColorPicker":
			KirkiPickerComponent = HslaStringColorPicker;
			break;
		case "HsvColorPicker":
			KirkiPickerComponent = HsvColorPicker;
			break;
		case "HsvStringColorPicker":
			KirkiPickerComponent = HsvStringColorPicker;
			break;
		case "HsvaColorPicker":
			KirkiPickerComponent = HsvaColorPicker;
			break;
		case "HsvaStringColorPicker":
			KirkiPickerComponent = HsvaStringColorPicker;
			break;
		default:
			KirkiPickerComponent = HexColorPicker;
			break;
	}

	useWindowResize(handleWindowResize);

	// Handle outside focus to close the picker popup.
	useFocusOutside(formRef, closePicker);

	// Handle outside click to close the picker popup.
	useClickOutside(pickerRef, resetRef, closePicker);

	if (jQuery.wp && jQuery.wp.wpColorPicker) {
		const wpColorPickerSwatches =
			jQuery.wp.wpColorPicker.prototype.options.palettes;

		// If 3rd parties applied custom colors to wpColorPicker swatches, let's use them.
		if (Array.isArray(wpColorPickerSwatches)) {
			if (wpColorPickerSwatches.length < 8) {
				for (let i = wpColorPickerSwatches.length; i <= 8; i++) {
					wpColorPickerSwatches.push(choices.swatches[i]);
				}
			}

			choices.swatches = wpColorPickerSwatches;
		}
	}

	const controlHeader = (
		<>
			{controlLabel}
			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			/>
		</>
	);

	let formClassName = useHueMode
		? "kirki-control-form use-hue-mode"
		: "kirki-control-form";

	formClassName += " has-" + choices.labelStyle + "-label-style";

	let pickerContainerClassName = isPickerOpen
		? pickerComponent + " colorPickerContainer is-open"
		: pickerComponent + " colorPickerContainer";

	const pickerTrigger = (
		<>
			<button
				type="button"
				ref={resetRef}
				className="kirki-control-reset"
				onClick={handleReset}
				style={{ display: isPickerOpen ? "flex" : "none" }}
			>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			<KirkiReactColorfulCircle
				pickerComponent={pickerComponent}
				useHueMode={useHueMode}
				color={
					!useHueMode
						? inputValue
						: colord({ h: inputValue, s: 100, l: 50 }).toHex()
				}
				isPickerOpen={isPickerOpen}
				togglePickerHandler={togglePicker}
			/>
		</>
	);

	let pickerHeader;

	switch (choices.labelStyle) {
		case "tooltip":
			pickerHeader = (
				<>
					{pickerTrigger}
					{!isPickerOpen && (
						<div className="kirki-label-tooltip">{controlHeader}</div>
					)}
				</>
			);
			break;

		case "top":
			pickerHeader = (
				<>
					{controlHeader}
					{pickerTrigger}
				</>
			);
			break;

		default:
			pickerHeader = (
				<>
					<div className="kirki-control-cols">
						<div className="kirki-control-left-col">{controlHeader}</div>
						<div className="kirki-control-right-col">{pickerTrigger}</div>
					</div>
				</>
			);
			break;
	}

	return (
		<>
			<div className={formClassName} ref={formRef} tabIndex="1">
				{pickerHeader}
				<div
					ref={pickerRef}
					className={pickerContainerClassName}
					style={pickerContainerStyle}
				>
					{!useHueMode && (
						<KirkiReactColorfulSwatches
							colors={choices.swatches}
							onClick={handleSwatchesClick}
						/>
					)}

					<KirkiPickerComponent
						color={pickerValue}
						onChange={handlePickerChange}
					/>

					<KirkiReactColorfulInput
						pickerComponent={pickerComponent}
						useHueMode={useHueMode}
						color={inputValue}
						onChange={handleInputChange}
					/>
				</div>
			</div>
		</>
	);
};

export default KirkiReactColorfulForm;
