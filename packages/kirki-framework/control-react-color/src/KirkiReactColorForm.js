/* globals _, wp, React */
import { AlphaPicker } from 'react-color';
import { BlockPicker } from 'react-color';
import { ChromePicker } from 'react-color';
import { CirclePicker } from 'react-color';
import { CompactPicker } from 'react-color';
import { GithubPicker } from 'react-color';
import { HuePicker } from 'react-color';
import { MaterialPicker } from 'react-color';
import { PhotoshopPicker } from 'react-color';
import { SketchPicker } from 'react-color';
import { SliderPicker } from 'react-color';
import { SwatchesPicker } from 'react-color';
import { TwitterPicker } from 'react-color';
const KirkiReactColorForm = ( props ) => {
	const handleChangeComplete = ( color ) => {
		wp.customize.control( props.customizerSetting.id ).setting.set( color.hex );
	};

	switch ( props.choices.formComponent ) {
		case 'AlphaPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<AlphaPicker
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'BlockPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<BlockPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'ChromePicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<ChromePicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'CirclePicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<CirclePicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'CompactPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<CompactPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'GithubPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<GithubPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'HuePicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<HuePicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'MaterialPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<MaterialPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'PhotoshopPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<PhotoshopPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'SketchPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<SketchPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'SliderPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<SliderPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'SwatchesPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<SwatchesPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
		case 'TwitterPicker':
			return (
				<div>
					<label className="customize-control-title">{ props.label }</label>
					<span class="description customize-control-description">{ props.description }</span>
					<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
					<TwitterPicker
						width="300"
						{ ...props.choices }
						color={ props.value }
						onChangeComplete={ handleChangeComplete }
					/>
				</div>
			);
	}
};

export default KirkiReactColorForm;
