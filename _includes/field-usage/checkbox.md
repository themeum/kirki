
```php
<?php if ( true == get_theme_mod( 'my_setting', true ) ) : ?>
	<p>Checkbox is checked</p>
<?php else : ?>
	<p>Checkbox is unchecked</p>
<?php endif; ?>
```

Adding a class to a `<div>` if the checkbox is checked:

```php
<?php $value = get_theme_mod( 'my_setting', true ); ?>
<div class="<?php echo ( $value ) ? 'checkbox-on' : 'checkbox-off'; ?>">
	If the checkbox is checked, the class will have a class "checkbox-on".
	If the checkbox is unchecked, the class will have a class "checkbox-off".
</div>
```
