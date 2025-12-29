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
		if ("" !== props.default && "undefined" !== typeof props.default) {
			customizerSetting.set(props.default);
		} else {
			customizerSetting.set(props.value);
		}
	};

	const size = choices.size + 2; // 2 here is 1px border on each side.

	return (
		<div className="kirki-control-form" tabIndex="1">
			<label className="kirki-control-label">
				<span className="customize-control-title">{props.label}</span>
				<span
					className="customize-control-description description"
					dangerouslySetInnerHTML={{ __html: props.description }}
				/>
			</label>

			<div
				className="customize-control-notifications-container"
				ref={props.setNotificationContainer}
			></div>

			<button
				type="button"
				className="kirki-control-reset"
				onClick={handleReset}
			>
				<i className="dashicons dashicons-image-rotate"></i>
			</button>

			<ul className={"kirki-colors kirki-" + choices.shape + "-colors"}>
				{choices.colors.map((color, index) => {
					const itemClassName =
						color === selectedItem ? "kirki-color is-selected" : "kirki-color";

					return (
						<li
							key={index.toString()}
							className={itemClassName}
							style={{
								width: size + "px",
								height: size + "px",
							}}
						>
							<div
								title={color}
								style={{
									backgroundColor: color,
								}}
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
