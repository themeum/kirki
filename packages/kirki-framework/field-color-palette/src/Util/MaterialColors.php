<?php
/**
 * Helper methods for material-design colors.
 *
 * @package   kirki-framework/control-palette
 * @author    Ari Stathopoulos (@aristath)
 * @copyright Copyright (c) 2019, Ari Stathopoulos (@aristath)
 * @license   https://opensource.org/licenses/MIT
 * @since     1.0
 */

namespace Kirki\Util;

/**
 * A simple object containing static methods.
 *
 * @since 1.0
 */
class MaterialColors {

	/**
	 * Gets an array of material-design colors.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @param string $context Allows us to get subsets of the palette.
	 * @return array
	 */
	public static function get_colors( $context = 'primary' ) {
		$colors = [
			'primary'     => [ '#FFFFFF', '#000000', '#F44336', '#E91E63', '#9C27B0', '#673AB7', '#3F51B5', '#2196F3', '#03A9F4', '#00BCD4', '#009688', '#4CAF50', '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', '#FF5722', '#795548', '#9E9E9E', '#607D8B' ],
			'red'         => [ '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#D32F2F', '#C62828', '#B71C1C', '#FF8A80', '#FF5252', '#FF1744', '#D50000' ],
			'pink'        => [ '#FCE4EC', '#F8BBD0', '#F48FB1', '#F06292', '#EC407A', '#E91E63', '#D81B60', '#C2185B', '#AD1457', '#880E4F', '#FF80AB', '#FF4081', '#F50057', '#C51162' ],
			'purple'      => [ '#F3E5F5', '#E1BEE7', '#CE93D8', '#BA68C8', '#AB47BC', '#9C27B0', '#8E24AA', '#7B1FA2', '#6A1B9A', '#4A148C', '#EA80FC', '#E040FB', '#D500F9', '#AA00FF' ],
			'deep-purple' => [ '#EDE7F6', '#D1C4E9', '#B39DDB', '#9575CD', '#7E57C2', '#673AB7', '#5E35B1', '#512DA8', '#4527A0', '#311B92', '#B388FF', '#7C4DFF', '#651FFF', '#6200EA' ],
			'indigo'      => [ '#E8EAF6', '#C5CAE9', '#9FA8DA', '#7986CB', '#5C6BC0', '#3F51B5', '#3949AB', '#303F9F', '#283593', '#1A237E', '#8C9EFF', '#536DFE', '#3D5AFE', '#304FFE' ],
			'blue'        => [ '#E3F2FD', '#BBDEFB', '#90CAF9', '#64B5F6', '#42A5F5', '#2196F3', '#1E88E5', '#1976D2', '#1565C0', '#0D47A1', '#82B1FF', '#448AFF', '#2979FF', '#2962FF' ],
			'light-blue'  => [ '#E1F5FE', '#B3E5FC', '#81D4fA', '#4fC3F7', '#29B6FC', '#03A9F4', '#039BE5', '#0288D1', '#0277BD', '#01579B', '#80D8FF', '#40C4FF', '#00B0FF', '#0091EA' ],
			'cyan'        => [ '#E0F7FA', '#B2EBF2', '#80DEEA', '#4DD0E1', '#26C6DA', '#00BCD4', '#00ACC1', '#0097A7', '#00838F', '#006064', '#84FFFF', '#18FFFF', '#00E5FF', '#00B8D4' ],
			'teal'        => [ '#E0F2F1', '#B2DFDB', '#80CBC4', '#4DB6AC', '#26A69A', '#009688', '#00897B', '#00796B', '#00695C', '#004D40', '#A7FFEB', '#64FFDA', '#1DE9B6', '#00BFA5' ],
			'green'       => [ '#E8F5E9', '#C8E6C9', '#A5D6A7', '#81C784', '#66BB6A', '#4CAF50', '#43A047', '#388E3C', '#2E7D32', '#1B5E20', '#B9F6CA', '#69F0AE', '#00E676', '#00C853' ],
			'light-green' => [ '#F1F8E9', '#DCEDC8', '#C5E1A5', '#AED581', '#9CCC65', '#8BC34A', '#7CB342', '#689F38', '#558B2F', '#33691E', '#CCFF90', '#B2FF59', '#76FF03', '#64DD17' ],
			'lime'        => [ '#F9FBE7', '#F0F4C3', '#E6EE9C', '#DCE775', '#D4E157', '#CDDC39', '#C0CA33', '#A4B42B', '#9E9D24', '#827717', '#F4FF81', '#EEFF41', '#C6FF00', '#AEEA00' ],
			'yellow'      => [ '#FFFDE7', '#FFF9C4', '#FFF590', '#FFF176', '#FFEE58', '#FFEB3B', '#FDD835', '#FBC02D', '#F9A825', '#F57F17', '#FFFF82', '#FFFF00', '#FFEA00', '#FFD600' ],
			'amber'       => [ '#FFF8E1', '#FFECB3', '#FFE082', '#FFD54F', '#FFCA28', '#FFC107', '#FFB300', '#FFA000', '#FF8F00', '#FF6F00', '#FFE57F', '#FFD740', '#FFC400', '#FFAB00' ],
			'orange'      => [ '#FFF3E0', '#FFE0B2', '#FFCC80', '#FFB74D', '#FFA726', '#FF9800', '#FB8C00', '#F57C00', '#EF6C00', '#E65100', '#FFD180', '#FFAB40', '#FF9100', '#FF6D00' ],
			'deep-orange' => [ '#FBE9A7', '#FFCCBC', '#FFAB91', '#FF8A65', '#FF7043', '#FF5722', '#F4511E', '#E64A19', '#D84315', '#BF360C', '#FF9E80', '#FF6E40', '#FF3D00', '#DD2600' ],
			'brown'       => [ '#EFEBE9', '#D7CCC8', '#BCAAA4', '#A1887F', '#8D6E63', '#795548', '#6D4C41', '#5D4037', '#4E342E', '#3E2723' ],
			'grey'        => [ '#FAFAFA', '#F5F5F5', '#EEEEEE', '#E0E0E0', '#BDBDBD', '#9E9E9E', '#757575', '#616161', '#424242', '#212121', '#000000', '#ffffff' ],
			'blue-grey'   => [ '#ECEFF1', '#CFD8DC', '#B0BBC5', '#90A4AE', '#78909C', '#607D8B', '#546E7A', '#455A64', '#37474F', '#263238' ],
		];

		switch ( $context ) {
			case '50':
			case '100':
			case '200':
			case '300':
			case '400':
			case '500':
			case '600':
			case '700':
			case '800':
			case '900':
			case 'A100':
			case 'A200':
			case 'A400':
			case 'A700':
				$key = absint( $context ) / 100;
				if ( 'A100' === $context ) {
					$key = 10;
					unset( $colors['grey'] );
				} elseif ( 'A200' === $context ) {
					$key = 11;
					unset( $colors['grey'] );
				} elseif ( 'A400' === $context ) {
					$key = 12;
					unset( $colors['grey'] );
				} elseif ( 'A700' === $context ) {
					$key = 13;
					unset( $colors['grey'] );
				}
				unset( $colors['primary'] );
				$position_colors = [];
				foreach ( $colors as $color_family ) {
					if ( isset( $color_family[ $key ] ) ) {
						$position_colors[] = $color_family[ $key ];
					}
				}
				return $position_colors;
			case 'all':
				unset( $colors['primary'] );
				$all_colors = [];
				foreach ( $colors as $color_family ) {
					foreach ( $color_family as $color ) {
						$all_colors[] = $color;
					}
				}
				return $all_colors;
			case 'primary':
				return $colors['primary'];
			default:
				if ( isset( $colors[ $context ] ) ) {
					return $colors[ $context ];
				}
				return $colors['primary'];
		}
	}
}
