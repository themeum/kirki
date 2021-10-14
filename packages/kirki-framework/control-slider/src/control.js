import "./control.scss";
import KirkiSliderControl from './KirkiSliderControl';


// Register control type with Customizer.
wp.customize.controlConstructor['kirki-slider'] = KirkiSliderControl;
