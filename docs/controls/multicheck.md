# multicheck

### Arguments

Argument            | Required | Type              | Description
:------------------ | :------: | :---------------- | :----------
`settings`          | Yes      | `string`          | The setting-name that will be used to identify this field.
`type`              | Yes      | `string`          | Set to `multicheck`.
`label`             | Yes      | `string`          | The title that will be displayed in the control.
`description`       | No       | `string`          | An optional description.
`tooltip`           | No       | `string`          | Add a localized string to show an informative tooltip.
`section`           | Yes      | `string`          | Defines the section in which this field's control will be added.
`priority`          | No       | `integer`         | You can use `priority` to change the order in which your controls are added inside a section. Defaults to `10`.
`default`           | Yes      | `array`           | Define an array of the elements you want activated by default.
`choices`           | No       | `array`           | The array of available checkboxes formatted as `$key => $label`.
`transport`         | No       | `string`          | `refresh` or `postMessage`. defaults to `refresh`.
`variables`         | No       | `array`           | If you're using a compiler you can use this to define the corresponding variable names. See `variables` documentation for more details.
`active_callback`   | No       | `string`, `array` | A callable function or method returning boolean (`true`/`false`) to define if the current field will be displayed or not. Overrides the `required` argument if one is defined.
`sanitize_callback` | No       | `string`, `array` | Not necessary since we already have a default sanitization callback in pace. If you want to override the default sanitization you can enter a callable function or method.
`required`          | No       | `array`           | Define field dependencies if you want to show or hide this field conditionally based on the values of other controls.
`capability`        | No       | `string`          | The capability required so that users can access this setting. This is automatically set by your configuration, and if none is defined in your config then falls-back to `edit_theme_options`. You can use this to override your config defaults on a per-field basis.
`option_type`       | No       | `string`          | `theme_mod`, `option`, `user_meta`. This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.
`option_name`       | No       | `string`          | This option is set in your configuration but can be overriden on a per-field basis. See configuration documentation for more details.


```php
Kirki::add_field( 'my_config', array(
	'type'        => 'multicheck',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'My Control', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'option-1',
	'priority'    => 10,
	'choices'     => array(
		'option-1' => esc_attr__( 'Option 1', 'my_textdomain' ),
		'option-2' => esc_attr__( 'Option 2', 'my_textdomain' ),
		'option-3' => esc_attr__( 'Option 3', 'my_textdomain' ),
		'option-4' => esc_attr__( 'Option 4', 'my_textdomain' ),
		'option-5' => esc_attr__( 'Option 5', 'my_textdomain' ),
	),
) );
```

On Multicheck fields, you can specify the options that will be available to your users by editing the `choices` argument and specifying an array of options in the form of `key => label`.

> Please keep in mind that you should always use WordPress's i18n functions for your labels and descriptions so they are translatable. More information on WordPress's i18n functions can be found on the [WordPress Codex](https://codex.wordpress.org/I18n_for_WordPress_Developers).

## Usage

```php
<?php $multicheck_value = get_theme_mod( 'my_setting', array( 'option-1', 'option-3' ) ); ?>
<?php if ( ! empty( $multicheck_value ) ) : ?>
  <ul>
	<?php foreach ( $multicheck_value as $checked_value ) : ?>
		<li><?php echo $checked_value; ?></li>
	<?php endforeach; ?>
  </ul>
<?php endif; ?>
```

Please keep in mind that the returned values are the keys of the settings you have defined, not their labels. If you want to display the labels then you will have to implement this on your code.
