
```php
<?php $image = get_theme_mod( 'my_setting', '' ); ?>
<div style="background-image: url('<?php echo esc_url( $image ); ?>')">
	Set the background-image of this div from "my_setting".
</div>
```
