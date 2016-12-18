
```php
<?php
// Default values for 'my_setting' theme mod.
$defaults = array(
    array(
        'link_text' => esc_attr__( 'Kirki Site', 'my_textdomain' ),
		'link_url'  => 'https://aristath.github.io/kirki/',
	),
	array(
		'link_text' => esc_attr__( 'Kirki Repository', 'my_textdomain' ),
		'link_url'  => 'https://github.com/aristath/kirki',
	),
);

// Theme_mod settings to check.
$settings = get_theme_mod( 'my_setting', $defaults ); ?>

<div class="kirki-links">
    <?php foreach( $settings as $setting ) : ?>
        <a href="<?php $setting['link_url']; ?>">
            <?php $setting['link_text']; ?>
        </a>
    <?php endforeach; ?>
</div>
```
