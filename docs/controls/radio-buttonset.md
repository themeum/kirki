# radio-buttonset

You can define the available options using the `choices` argument and formating them as an array `key => label`.

### Arguments

Argument            | Required | Type              | Description
:------------------ | :------: | :---------------- | :----------
`settings`          | Yes      | `string`          | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`          | Set to `radio-buttonset`.
`label`             | Yes      | `string`          | The title that will be displayed in the control.
`description`       | No       | `string`          | An optional description.
`tooltip`           | No       | `string`          | Add a localized string to show an informative tooltip.
`section`           | Yes      | `string`          | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`         | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `string`          | Use the key of one of the items in the `choices` argument.
`choices`           | Yes      | `array`           | Use an array of elements. Format: `$key => $label`.
`transport`         | No       | `string`          | `refresh` or `postMessage`. defaults to `refresh`.
`output`            | No       | `array`           | Define an array of elements & properties to auto-generate and apply the CSS to your frontend. See `output` documentation for more details.
`js_vars`           | No       | `array`           | Define an array of elements & properties to auto-generate and apply the necessary JS in order for postMessage to work. Requires that `transport` is set to `postMessage`.
`variables`         | No       | `array`           | If you're using a compiler you can use this to define the corresponding variable names. See `variables` documentation for more details.
`active_callback`   | No       | `string`, `array` | A callable function or method returning boolean (`true`/`false`) to define if the current field will be displayed or not. Overrides the `required` argument if one is defined.
`sanitize_callback` | No       | `string`, `array` | Not necessary since we already have a default sanitization callback in pace. If you want to override the default sanitization you can enter a callable function or method.
`required`          | No       | `array`           | Define field dependencies if you want to show or hide this field conditionally based on the values of other controls.
`capability`        | No       | `string`          | The capability required so that users can access this setting. This is automatically set by your configuration, and if none is defined in your config then falls-back to `edit_theme_options`. You can use this to override your config defaults on a per-field basis.
`option_type`       | No       | `string`          | `theme_mod`, `option`, `user_meta`. This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.
`option_name`       | No       | `string`          | This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.


```php
Kirki::add_field( 'my_config', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'my_setting',
	'label'       => __( 'Radio-Buttonset Control', 'my_textdomain' ),
	'section'     => 'radio',
	'default'     => 'red',
	'priority'    => 10,
	'choices'     => array(
		'red'   => esc_attr__( 'Red', 'my_textdomain' ),
		'green' => esc_attr__( 'Green', 'my_textdomain' ),
		'blue'  => esc_attr__( 'Blue', 'my_textdomain' ),
	),
) );
```
