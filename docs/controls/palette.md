# palette

Palette controls are essentially radio controls. The difference between palette controls and radio controls is purely presentational: Palette controls allow you to define an array of colors for each option which will be used to show users a palette.

### Arguments

Argument            | Required | Type              | Description
:------------------ | :------: | :---------------- | :----------
`settings`          | Yes      | `string`          | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`          | Set to `palette`.
`label`             | Yes      | `string`          | The title that will be displayed in the control.
`description`       | No       | `string`          | An optional description.
`tooltip`           | No       | `string`          | Add a localized string to show an informative tooltip.
`section`           | Yes      | `string`          | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`         | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `string`          | Use the key of one of the items in the `choices` argument.
`choices`           | Yes      | `array`           | Use an array of elements. Format: `$key => array( $color1, $color2, $color3 )`.
`variables`         | No       | `array`           | If you're using a compiler you can use this to define the corresponding variable names. See `variables` documentation for more details.
`active_callback`   | No       | `string`, `array` | A callable function or method returning boolean (`true`/`false`) to define if the current field will be displayed or not. Overrides the `required` argument if one is defined.
`sanitize_callback` | No       | `string`, `array` | Not necessary since we already have a default sanitization callback in pace. If you want to override the default sanitization you can enter a callable function or method.
`required`          | No       | `array`           | Define field dependencies if you want to show or hide this field conditionally based on the values of other controls.
`capability`        | No       | `string`          | The capability required so that users can access this setting. This is automatically set by your configuration, and if none is defined in your config then falls-back to `edit_theme_options`. You can use this to override your config defaults on a per-field basis.
`option_type`       | No       | `string`          | `theme_mod`, `option`, `user_meta`. This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.
`option_name`       | No       | `string`          | This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'palette',
	'settings'    => 'my_setting',
	'label'       => __( 'Palette Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'light',
	'priority'    => 10,
	'choices'     => array(
		'light' => array(
			'#ECEFF1',
			'#333333',
			'#4DD0E1',
		),
		'dark' => array(
			'#37474F',
			'#FFFFFF',
			'#F9A825',
		),
	),
) );
```

## Usage

```php
<?php
$saved_palette = get_theme_mod( 'my_setting', 'light' );
if ( 'light' == $saved_palette ) {
	$background   = '#ECEFF1';
	$text_color   = '#333333';
	$border_color = '#4DD0E1';
} else if ( 'dark' == $saved_palette ) {
	$background   = '#37474F';
	$text_color   = '#FFFFFF';
	$border_color = '#F9A825';
}
$styles = "background-color:{$background}; color:{$text_color}; border-color:{$border_color};";
?>
<div style="<?php echo $styles; ?>">
	Some text here
</div>
```
