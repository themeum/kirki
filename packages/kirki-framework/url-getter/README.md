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
$url = \Kirki\URL::get_from_path( '/absolute/path/to/file' );
```
