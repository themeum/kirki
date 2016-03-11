# number

`number` controls are simple numeric fields that only accept numbers as input and not free text.

### Arguments

Argument            | Required | Type                     | Description
:------------------ | :------: | :----------------------- | :----------
`settings`          | Yes      | `string`                 | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`                 | Set to `number`.
`label`             | Yes      | `string`                 | The title that will be displayed in the control.
`description`       | No       | `string`                 | An optional description.
`tooltip`           | No       | `string`                 | Add a localized string to show an informative tooltip.
`section`           | Yes      | `string`                 | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`                | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `string`, `int`, `float` | Define a numeric value. Example: `'8'`
`transport`         | No       | `string`                 | `refresh` or `postMessage`. defaults to `refresh`.
`output`            | No       | `array`                  | Define an array of elements & properties to auto-generate and apply the CSS to your frontend. See `output` documentation for more details.
`js_vars`           | No       | `array`                  | Define an array of elements & properties to auto-generate and apply the necessary JS in order for postMessage to work. Requires that `transport` is set to `postMessage`.
`variables`         | No       | `array`                  | If you're using a compiler you can use this to define the corresponding variable names. See `variables` documentation for more details.
`active_callback`   | No       | `string`, `array`        | A callable function or method returning boolean (`true`/`false`) to define if the current field will be displayed or not. Overrides the `required` argument if one is defined.
`sanitize_callback` | No       | `string`, `array`        | Not necessary since we already have a default sanitization callback in pace. If you want to override the default sanitization you can enter a callable function or method.
`required`          | No       | `array`                  | Define field dependencies if you want to show or hide this field conditionally based on the values of other controls.
`capability`        | No       | `string`                 | The capability required so that users can access this setting. This is automatically set by your configuration, and if none is defined in your config then falls-back to `edit_theme_options`. You can use this to override your config defaults on a per-field basis.
`option_type`       | No       | `string`                 | `theme_mod`, `option`, `user_meta`. This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.
`option_name`       | No       | `string`                 | This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.


```php
Kirki::add_field( 'my_config', array(
	'type'        => 'number',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 42,
) );
```

## Usage

```html
<div style="font-size: <?php echo get_theme_mod( 'my_setting', '14' ); ?>px">
	<p>The font-size of this paragraph is controlled by "my_setting".</p>
</div>
```
