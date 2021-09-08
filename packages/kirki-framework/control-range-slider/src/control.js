import "./control.scss";
import KirkiRangeSliderControl from './KirkiRangeSliderControl';


// Register control type with Customizer.
wp.customize.controlConstructor['kirki-range-slider'] = KirkiRangeSliderControl;
