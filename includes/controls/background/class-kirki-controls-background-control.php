<?php
/**
 * Typography control class.
 *
 * @since  1.0.0
 * @access public
 */
class Kirki_Controls_Background_Control extends WP_Customize_Control {

	/**
	 * The type of customize control being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'background';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function to_json() {
		parent::to_json();
		$i18n = Kirki_Toolkit::i18n();

		// Loop through each of the settings and set up the data for it.
		foreach ( $this->settings as $setting_key => $setting_id ) {

			$this->json[$setting_key] = array(
				'link'  => $this->get_link( $setting_key ),
				'value' => $this->value( $setting_key ),
				'label' => '',
			);

			if ( 'repeat' === $setting_key ) {
				$this->json[$setting_key]['choices'] = array(
					'no-repeat' => $i18n['no-repeat'],
					'repeat'    => $i18n['repeat-all'],
					'repeat-x'  => $i18n['repeat-x'],
					'repeat-y'  => $i18n['repeat-y'],
					'inherit'   => $i18n['inherit'],
				);
			} elseif ( 'size' === $setting_key ) {
				$this->json[$setting_key]['choices'] = array(
					'inherit' => $i18n['inherit'],
					'cover'   => $i18n['cover'],
					'contain' => $i18n['contain'],
				);
			} elseif ( 'attach' === $setting_key ) {
				$this->json[$setting_key]['choices'] = array(
					'inherit' => $i18n['inherit'],
					'fixed'   => $i18n['fixed'],
					'scroll'  => $i18n['scroll'],
				);
			} elseif ( 'position' === $setting_key ) {
				$this->json[$setting_key]['choices'] = array(
					'left-top'      => $i18n['left-top'],
					'left-center'   => $i18n['left-center'],
					'left-bottom'   => $i18n['left-bottom'],
					'right-top'     => $i18n['right-top'],
					'right-center'  => $i18n['right-center'],
					'right-bottom'  => $i18n['right-bottom'],
					'center-top'    => $i18n['center-top'],
					'center-center' => $i18n['center-center'],
					'center-bottom' => $i18n['center-bottom'],
				);
			}

		}
	}

	/**
	 * Underscore JS template to handle the control's output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function content_template() { ?>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<ul>

		<# if ( data.repeat && data.repeat.choices ) { #>
			<li class="kirki-background-repeat">
				<# if ( data.repeat.label ) { #>
					<span class="customize-control-title">{{ data.repeat.label }}</span>
				<# } #>
				<select {{{ data.repeat.link }}}>
					<# _.each( data.repeat.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.repeat.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		<# if ( data.size && data.size.choices ) { #>
			<li class="kirki-background-size">
				<# if ( data.size.label ) { #>
					<span class="customize-control-title">{{ data.size.label }}</span>
				<# } #>
				<select {{{ data.size.link }}}>
					<# _.each( data.size.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.size.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		<# if ( data.attach && data.attach.choices ) { #>
			<li class="kirki-background-attach">
				<# if ( data.attach.label ) { #>
					<span class="customize-control-title">{{ data.attach.label }}</span>
				<# } #>
				<select {{{ data.attach.link }}}>
					<# _.each( data.attach.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.attach.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		<# if ( data.position && data.position.choices ) { #>
			<li class="kirki-background-position">
				<# if ( data.position.label ) { #>
					<span class="customize-control-title">{{ data.position.label }}</span>
				<# } #>
				<select {{{ data.position.link }}}>
					<# _.each( data.position.choices, function( label, choice ) { #>
						<option value="{{ choice }}" <# if ( choice === data.position.value ) { #> selected="selected" <# } #>>{{ label }}</option>
					<# } ) #>
				</select>
			</li>
		<# } #>

		</ul>
	<?php }

}
