# control-typography

The typography field is an easy way to add multiple customizer controls in order to provide a unified experience and implementation for typography settings.

it is not a customizer control and therefore can't be used via the WordPress Customizer API. It is a shortcut for the Kirki API. If you want to achieve a similar result using the customizer API you can add separate controls for each property. For details on what controls and options are added you can take a look at the `src/Field/Typography.php` file.

## Installation

You can install this package using Composer:

```bash
composer require kirki-framework/field-typography
```

Make sure you include the autoloader:
```php
require_once get_parent_theme_file_path( 'vendor/autoload.php' );
```
