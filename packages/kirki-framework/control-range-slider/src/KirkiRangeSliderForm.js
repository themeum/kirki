import { useRef, useState } from "react";

const KirkiRangeSliderForm = (props) => {

	const { control, customizerSetting, choices } = props;

	let trigger = '';

	control.updateComponentState = (val) => {
		if ('slider' === trigger) {
			inputRef.current.value = val;
		} else if ('input' === trigger) {
			sliderRef.current.value = val;
		}
	};

	const handleChange = (e) => {
		trigger = 'range' === e.target.type ? 'slider' : 'input';
		customizerSetting.set(e.target.value);
	};

	const handleReset = (e) => {
		if ('' !== props.value) {
			sliderRef.current.value = props.value;
			inputRef.current.value = props.value;
		} else {
			sliderRef.current.value = 0;
			inputRef.current.value = '';
		}
	};

	// Preparing for the template.
	const fieldId = `kirki-control-input-${customizerSetting.id}`;
	const value = '' !== props.value ? props.value : 0;
	const inputRef = useRef(null);
	const sliderRef = useRef(null);

	return (
		<div className="kirki-control-form">
			<label className="kirki-control-label" htmlFor={fieldId}>
				<span className="customize-control-title">{props.label}</span>
				<span className="customize-control-description description">{props.description}</span>

				<button type="button" className="kirki-control-reset" onClick={handleReset}>
					<i className="dashicons dashicons-image-rotate"></i>
				</button>
			</label>

			<div className="customize-control-notifications-container" ref={props.setNotificationContainer}></div>

			<div className="kirki-control-cols">
				<div className="kirki-control-left-col">
					<input
						ref={sliderRef}
						type="range"
						id={fieldId}
						defaultValue={value}
						min={choices.min}
						max={choices.max}
						step={choices.step}
						className="kirki-control-range"
						onChange={handleChange}
					/>
				</div>
				<div className="kirki-control-right-col">
					<input
						ref={inputRef}
						type="number"
						defaultValue={'' !== props.value ? value : ''}
						min={choices.min}
						max={choices.max}
						step={choices.step}
						className="kirki-control-input"
						onChange={handleChange}
					/>
				</div>
			</div>
		</div>
	);

};

export default KirkiRangeSliderForm;
