
```php
<?php
$defaults = array(
	'link'    => '#0088cc',
	'hover'   => '#00aaff',
	'active'  => '#00ffff',
);
$value = get_theme_mod( 'my_setting', $defaults );

echo '<style>';
echo 'a { color: ' . $value['link'] . '; }';
echo 'a:hover { color: ' . $value['hover'] . '; }';
echo 'a:active { color: ' . $value['active'] . '; }';
```
