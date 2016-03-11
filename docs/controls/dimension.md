# dimension

`dimension` controls allow you to add a simple, single-line text input. The difference with normal text inputs is that entered values can only be valid CSS units (example: `10px`, `3em`, `48%`, `90vh` etc.).

Values are sanitized both on input and on save. If the user enters an invalid value, a warning message appears below the input field informing them that the entered value is invalid.

Invalid values are not saved, and the preview refresh is only triggered once a valid value has been entered.

### Arguments

Argument            | Required | Type              | Description
:------------------ | :------: | :---------------- | :----------
`settings`          | Yes      | `string`          | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`          | Set to `dimension`.
`label`             | Yes      | `string`          | The title that will be displayed in the control.
`description`       | No       | `string`          | An optional description.
`tooltip`           | No       | `string`          | Add a localized string to show an informative tooltip.
`section`           | Yes      | `string`          | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`         | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `string`          | Define a valid CSS value. Example: `10px`, `1em`, `90vh` etc.
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
	'type'        => 'dimension',
	'settings'    => 'my_setting',
	'label'       => __( 'Dimension Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => '1.5em',
	'priority'    => 10,
) );
```

## Usage

```html
<div style="font-size: <?php echo get_theme_mod( 'my_setting', '1em' ); ?>">
	<p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
```
