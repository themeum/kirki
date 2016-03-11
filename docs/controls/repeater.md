# repeater

Repeater controls allow you to build repeatable blocks of fields.
You can create for exmaple a set of fields that will contain a checkbox and a textfield. The user will then be able to add "rows", and each row will contain a checkbox and a textfield.

### Arguments

Argument            | Required | Type              | Description
:------------------ | :------: | :---------------- | :----------
`settings`          | Yes      | `string`          | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`          | Set to `repeater`
`label`             | Yes      | `string`          | The title that will be displayed in the control.
`description`       | No       | `string`          | An optional description.
`section`           | Yes      | `string`          | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`         | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `array`           | See example below.
`choices`           | No       | `array`           | If you're using switches, you can use this to change the ON/OFF labels.
`variables`         | No       | `array`           | If you're using a compiler you can use this to define the corresponding variable names. See `variables` documentation for more details.
`tooltip`           | No       | `string`          | Add a localized string to show an informative tooltip.
`active_callback`   | No       | `string`, `array` | A callable function or method returning boolean (`true`/`false`) to define if the current field will be displayed or not. Overrides the `required` argument if one is defined.
`sanitize_callback` | No       | `string`, `array` | Not necessary since we already have a default sanitization callback in pace. If you want to override the default sanitization you can enter a callable function or method.
`transport`         | No       | `string`          | `refresh` or `postMessage`. defaults to `refresh`.
`required`          | No       | `array`           | Define field dependencies if you want to show or hide this field conditionally based on the values of other controls.
`capability`        | No       | `string`          | The capability required so that users can access this setting. This is automatically set by your configuration, and if none is defined in your config then falls-back to `edit_theme_options`. You can use this to override your config defaults on a per-field basis.
`option_type`       | No       | `string`          | `theme_mod`, `option`, `user_meta`. This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.
`option_name`       | No       | `string`          | This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.


Example: Creating a repeater control where each row contains 2 textfields.
```php
Kirki::add_field( 'my_config', array(
	'type'        => 'repeater',
	'label'       => esc_attr__( 'Repeater Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'priority'    => 10,
	'settings'    => 'my_setting',
	'default'     => array(
		array(
			'link_text' => esc_attr__( 'Kirki Site', 'my_textdomain' ),
			'link_url'  => 'https://kirki.org',
		),
		array(
			'link_text' => esc_attr__( 'Kirki Repository', 'my_textdomain' ),
			'link_url'  => 'https://github.com/aristath/kirki',
		),
	),
	'fields' => array(
		'link_text' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link Text', 'my_textdomain' ),
			'description' => esc_attr__( 'This will be the label for your link', 'my_textdomain' ),
			'default'     => '',
		),
		'link_url' => array(
			'type'        => 'text',
			'label'       => esc_attr__( 'Link URL', 'my_textdomain' ),
			'description' => esc_attr__( 'This will be the link URL', 'my_textdomain' ),
			'default'     => '',
		),
	)
) );
```
