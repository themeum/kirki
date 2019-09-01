/* global wp */

import KirkiReactColorControl from './KirkiReactColorControl';

// Register control type with Customizer.
wp.customize.controlConstructor['kirki-react-color'] = KirkiReactColorControl;
