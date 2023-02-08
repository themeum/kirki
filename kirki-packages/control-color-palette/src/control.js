import "./control.scss";
import KirkiColorPaletteControl from './KirkiColorPaletteControl';


// Register control type with Customizer.
wp.customize.controlConstructor['kirki-color-palette'] = KirkiColorPaletteControl;
