# Getting your values

To get the value of any of your settings we recommend using the WordPress Core functions [`get_option`](https://codex.wordpress.org/Function_Reference/get_option) and [`get_theme_mod`](https://codex.wordpress.org/Function_Reference/get_theme_mod)

## When using **Theme Mods**

```php
$value = get_theme_mod( 'option_name', 'default_value' );
```

## When using **Options**

```php
$value = get_option( 'option_name', 'default_value' );
```

## When using **Serialized Options**

If you're using serialized options you may want to consider writing a proxy function to make this easier:
```php
function my_theme_get_option( $setting, $default ) {
    $options = get_option( 'option_name', array() );
    $value = $default;
    if ( isset( $options[ $setting ] ) ) {
        $value = $options[ $setting ];
    }
    return $value;
}
```

You can then get your values using the above function:
```php
$value = my_theme_get_option( 'option_name', 'default_value' );
```
