import { useState } from "react";

const KirkiColorPaletteForm = (props) => {

	const { control, customizerSetting, choices } = props;

	const [selectedItem, setSelectedItem] = useState(props.value);

	control.updateComponentState = (val) => {
		setSelectedItem(val);
	};

	const handleSelect = (e) => {
		customizerSetting.set(e.target.title);
	};

	const handleReset = () => {
		setSelectedItem(props.value);
	};

	return (
		<div className="kirki-control-form" tabIndex="1">
			<label className="kirki-control-label" htmlFor={fieldId}>
				<span className="customize-control-title">{props.label}</span>
				<span className="customize-control-description description">{props.description}</span>
			</label>

			<div className="customize-control-notifications-container" ref={props.setNotificationContainer}></div>

			<button type="button" className="kirki-control-reset" onClick={handleReset}>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			<ul className={"kirki-colors kirki-" + choices.shape + "-colors"}>
				{choices.colors.map((color) => {
					const itemClassName = color === selectedItem ? "kirki-color is-selected" : "kirki-color";

					return (
						<li className={itemClassName}>
							<div
								title={color}
								style={
									{
										width: choices.size + 'px',
										height: choices.size + 'px',
										backgroundColor: color
									}
								}
								onClick={handleSelect}
							></div>
						</li>
					);
				})}
			</ul>
		</div>
	);

};

export default KirkiColorPaletteForm;
