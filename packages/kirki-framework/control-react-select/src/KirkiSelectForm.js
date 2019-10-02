/* globals _, wp, React */

import Select from 'react-select';

const KirkiSelectForm = ( props ) => {
console.log(props);
	const handleChangeComplete = ( val ) => {
		wp.customize( props.customizerSetting.id ).set( val.value );
	};

	const options = () => {
		let options = [];
		let choicesKeys = Object.keys( props.choices );
		for ( var i = 0; i < choicesKeys.length; i++ ) {
			if ( 'object' === typeof props.choices[ choicesKeys[ i ] ] ) {
				let optGroup = {
					label: props.choices[ choicesKeys[ i ] ][ 0 ],
					options: []
				};
				let optGroupOptionKeys = Object.keys( props.choices[ choicesKeys[ i ] ][ 1 ] );
				console.log( props );
				for ( var l = 0; l < optGroupOptionKeys.length; l++ ) {
					optGroup.options.push( {
						value: optGroupOptionKeys[ l ],
						label: props.choices[ choicesKeys[ i ] ][ 1 ][ optGroupOptionKeys[ l ] ]
					} );
				}

				options.push( optGroup );
			} else if ( 'string' === typeof props.choices[ choicesKeys[ i ] ] ) {
				options.push( {
					value: choicesKeys[ i ],
					label: props.choices[ choicesKeys[ i ] ]
				} );
			}
		}
		return options;
	};

	const theme = ( theme ) => ( {
		...theme,
		borderRadius: 0,
		colors: {
			...theme.colors,
			primary: '#0073aa',
			primary75: '#33b3db',
			primary50: '#99d9ed',
			primary24: '#e5f5fa'
		},
	} );

	const getLabelFromValue = ( val ) => {
		let choicesKeys = Object.keys( props.choices );
		for ( var i = 0; i < choicesKeys.length; i++ ) {
			if ( 'object' === typeof props.choices[ choicesKeys[ i ] ] ) {
				for ( var l = 0; l < optGroupOptionKeys.length; l++ ) {
					if ( val === optGroupOptionKeys[ l ] ) {
						return props.choices[ choicesKeys[ i ] ][ 1 ][ optGroupOptionKeys[ l ] ];
					}
				}
			} else if ( 'string' === typeof props.choices[ choicesKeys[ i ] ] ) {
				if ( val === choicesKeys[ i ] ) {
					return props.choices[ choicesKeys[ i ] ];
				}
			}
		}
	};

	const multi = ( 2 <= props.multiple );

	const value = {
		value: props.value,
		label: getLabelFromValue( props.value )
	};

	return (
		<div>
			<label className="customize-control-title">{ props.label }</label>
			<span class="description customize-control-description" dangerouslySetInnerHTML={{ __html: props.description }}></span>
			<div className="customize-control-notifications-container" ref={ props.setNotificationContainer }></div>
			<Select
				options={ options() }
				theme={ theme }
				isMulti={ multi }
				onChange={ handleChangeComplete }
				value={ value }
				isOptionDisabled={ props.isOptionDisabled }
			/>
		</div>
	);
};

export default KirkiSelectForm;
