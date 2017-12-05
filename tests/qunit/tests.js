/* global QUnit, kirki */
QUnit.test( 'kirki.input.textarea.getTemplate: data-id', function( assert ) {

	_.each(
		[
			'setting',
			'setting[subetting]',
			'somethingExtremelyLongAndIrrationalThatNobodyWouldEverUseNoMatterWhatsWrongWithTheirHead',
			'something[Extremely][Long][AndIrrational][That][Nobody][Would][Ever][Use][NoMatter][WhatsWrong][With][Their][Head]'
		],
		function( setting ) {
			assert.ok( setting === jQuery( kirki.input.textarea.getTemplate( {
				label: 'label',
				id: setting
			} ) ).attr( 'data-id' ), 'Passed!' );
		}
	);
});
