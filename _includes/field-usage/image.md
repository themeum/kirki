
```php
<?php $image = get_theme_mo( 'my_setting', '' ); ?>
<div style="background-image: url('<?php echo esc_url_raw( $image ); ?>')">
	Set the background-image of this div from "my_setting".
</div>
```
