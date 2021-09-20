import { useState, useEffect, useCallback } from "react";
import reactCSS from 'reactcss';

const KirkiReactColorfulInput = (props) => {
	const { onChange, onReset, triggerStyle, color = "" } = props;
	const [value, setValue] = useState(() => color);

	const handleChange = useCallback(
		(e) => {
			onChange(e.target.value); // Run onChange handler passed by `KirkiReactColorfulForm` component.
		},
		[onChange]
	);

	const resetColor = () => {
		onReset(props.initialColor); // Run onReset handler passed by `KirkiReactColorfulForm` component.
	};

	const togglePickerHandler = 'button' === triggerStyle ? () => { } : props.togglePickerHandler;
	const openPickerHandler = 'button' === triggerStyle ? () => { } : props.openPickerHandler;

	// Update the local state when `color` property value is changed.
	useEffect(() => {
		// We don't need to convert the color since it's already handled in parent component.
		setValue(color);
	}, [color]);

	const pickersWithAlpha = ['RgbaColorPicker', 'RgbaStringColorPicker', 'HslaColorPicker', 'HslaStringColorPicker', 'HsvaColorPicker', 'HsvaStringColorPicker'];

	const styles = reactCSS({
		'default': {
			colorPreviewWrapper: {
				backgroundImage: (pickersWithAlpha.includes(props.pickerComponent) ? 'url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAIAAAHnlligAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAHJJREFUeNpi+P///4EDBxiAGMgCCCAGFB5AADGCRBgYDh48CCRZIJS9vT2QBAggFBkmBiSAogxFBiCAoHogAKIKAlBUYTELAiAmEtABEECk20G6BOmuIl0CIMBQ/IEMkO0myiSSraaaBhZcbkUOs0HuBwDplz5uFJ3Z4gAAAABJRU5ErkJggg==")' : 'none'),
			},
			colorPreview: {
				backgroundColor: value,
			}
		},
	});

	return (
		<div className="kirki-color-input-wrapper">
			<div className="kirki-color-input-control">
				{!props.useHueMode &&
					<div className="kirki-color-preview-wrapper" style={styles.colorPreviewWrapper}>
						<button type="button" className="kirki-color-preview" style={styles.colorPreview} onClick={togglePickerHandler}></button>
					</div>
				}
				<input
					ref={props.inputRef}
					type="text"
					value={value}
					className="kirki-color-input"
					spellCheck="false"
					onFocus={openPickerHandler}
					onChange={handleChange}
				/>
				{'input' === triggerStyle &&
					<button type="button" className="kirki-control-reset" onClick={resetColor} style={{ display: props.isPickerOpen ? 'flex' : 'none' }}>
						<i className="dashicons dashicons-image-rotate"></i>
					</button>
				}
			</div>
		</div>
	);
};

export default KirkiReactColorfulInput;
