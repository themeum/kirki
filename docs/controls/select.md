# select

We extend WordPress Core's `select` controls and all `select` controls created using Kirki will use the [selectize.js](http://brianreavis.github.io/selectize.js/) script.

## Creating a select control

### Arguments

Argument            | Required | Type              | Description
:------------------ | :------: | :---------------- | :----------
`settings`          | Yes      | `string`          | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`          | Set to `repeater`
`label`             | Yes      | `string`          | The title that will be displayed in the control.
`description`       | No       | `string`          | An optional description.
`section`           | Yes      | `string`          | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`         | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `string`, `array` | If `multiple` is > 1 then use an `array`. If not, then a `string`.
`choices`           | No       | `array`           | If you're using switches, you can use this to change the ON/OFF labels.
`multiple`          | No       | `int`             | The number of options users will be able to select simultaneously. Use `1` for single-select controls (defaults to `1`).
`variables`         | No       | `array`           | If you're using a compiler you can use this to define the corresponding variable names. See `variables` documentation for more details.
`tooltip`           | No       | `string`          | Add a localized string to show an informative tooltip.
`active_callback`   | No       | `string`, `array` | A callable function or method returning boolean (`true`/`false`) to define if the current field will be displayed or not. Overrides the `required` argument if one is defined.
`sanitize_callback` | No       | `string`, `array` | Not necessary since we already have a default sanitization callback in pace. If you want to override the default sanitization you can enter a callable function or method.
`transport`         | No       | `string`          | `refresh` or `postMessage`. defaults to `refresh`.
`required`          | No       | `array`           | Define field dependencies if you want to show or hide this field conditionally based on the values of other controls.
`capability`        | No       | `string`          | The capability required so that users can access this setting. This is automatically set by your configuration, and if none is defined in your config then falls-back to `edit_theme_options`. You can use this to override your config defaults on a per-field basis.
`option_type`       | No       | `string`          | `theme_mod`, `option`, `user_meta`. This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.
`option_name`       | No       | `string`          | This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'select',
	'settings'    => 'my_setting',
	'label'       => __( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'option-1',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => array(
		'option-1' => esc_attr__( 'Option 1', 'my_textdomain' ),
		'option-2' => esc_attr__( 'Option 2', 'my_textdomain' ),
		'option-3' => esc_attr__( 'Option 3', 'my_textdomain' ),
		'option-4' => esc_attr__( 'Option 4', 'my_textdomain' ),
	),
) );
```

The `multiple` argument allows you to define the maximum number of simultaneous selections a user can make.
If `multiple` is set to `1` then users will be able to select a single option like on a normal dropdown.
If `multiple` is set to `2` for example, the user will be able to select 2 items from the dropdown, as well as re-order their selections using drag-n-drop.
To allow unlimited options simply set a high number like `999`.

If `multiple` is set to `1` then the saved value will be a string.
If `multiple` is set to a value greater than 1 and the user selects multiple elements then the saved value will be an array of all the selected values.
