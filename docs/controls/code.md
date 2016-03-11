# code

`code` controls use the [CodeMirror](https://codemirror.net/) script to properly format the code area.

You can define the language you'll be using (`css`, `html`, `javascript` etc) as well as the theme in the `choices` argument as seen in the code example below.

You can see a list of all available languages [here](https://codemirror.net/mode/index.html) and a list of all available themes [here](https://codemirror.net/demo/theme.html).

### Arguments

Argument            | Required | Type              | Description
:------------------ | :------: | :---------------- | :----------
`settings`          | Yes      | `string`          | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`          | Set to `code`.
`label`             | Yes      | `string`          | The title that will be displayed in the control.
`description`       | No       | `string`          | An optional description.
`tooltip`           | No       | `string`          | Add a localized string to show an informative tooltip.
`section`           | Yes      | `string`          | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`         | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `string`          | Define a default string that will be used, or use an empty string ( `'default' => ''`)
`choices`           | No       | `array`           | Use it to define the language to be used, the theme, and the area's height.
`transport`         | No       | `string`          | `refresh` or `postMessage`. defaults to `refresh`.
`active_callback`   | No       | `string`, `array` | A callable function or method returning boolean (`true`/`false`) to define if the current field will be displayed or not. Overrides the `required` argument if one is defined.
`sanitize_callback` | No       | `string`, `array` | Not necessary since we already have a default sanitization callback in pace. If you want to override the default sanitization you can enter a callable function or method.
`required`          | No       | `array`           | Define field dependencies if you want to show or hide this field conditionally based on the values of other controls.
`capability`        | No       | `string`          | The capability required so that users can access this setting. This is automatically set by your configuration, and if none is defined in your config then falls-back to `edit_theme_options`. You can use this to override your config defaults on a per-field basis.
`option_type`       | No       | `string`          | `theme_mod`, `option`, `user_meta`. This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.
`option_name`       | No       | `string`          | This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'code',
	'settings'    => 'code_demo',
	'label'       => __( 'Code Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'body { background: #fff; }',
	'priority'    => 10,
	'choices'     => array(
		'language' => 'css',
		'theme'    => 'monokai',
		'height'   => 250,
	),
) );
```

## Usage

The saved values is a `string`

```php
<?php echo get_theme_mod( 'my_setting', '' ); ?>
```
