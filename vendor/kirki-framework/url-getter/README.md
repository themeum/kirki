# URL Getter.

This is a simple component to get the URL of files in WordPress.

It was originally built for the [Kirki Framework](https://github.com/aristath/kirki) but can be used in any WordPress plugin or theme. 

Since the Kirki Framework can be installed as a plugin, included in themes, or even included in other plugins, I needed a simple and effective way to get the URL of any file using its path as a reference. This way the scripts and styles for the customizer controls that Kirki contains can be loaded without issues in most cases.

To install using Composer:
```bash
composer install kirki-framework/url-getter
```

Then when you need to get the URL of a file you can do this:
```php
$obj = new \Kirki\URL( '/absolute/path/to/file' );
$url = $obj->get_url();
```
It may be convenient to just write a wrapper function in your theme or plugin like this:
```php
/**
 * Get the URL of a file path.
 *
 * @since 1.0
 * @param string $path The absolute path to a file.
 * @return string      Returns the file URL.
 */
function my_prefix_get_file_url( $path ) {
    $url = new \Kirki\URL( $path );
    return $obj->get_url();
}
```
and you can then call it simply by running
```php
$url = my_prefix_get_file_url( '/absolute/path/to/file' );
```
