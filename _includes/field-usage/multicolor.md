
```
<?php
$defaults = array(
	'link'    => '#0088cc',
	'hover'   => '#00aaff',
	'active'  => '#00ffff',
);
$value = get_theme_mod( 'my_setting', $defaults );
?>
<style>
a {
	color: <?php echo $value['link']; ?>;
}
a:hover {
	color: <?php echo $value['hover']; ?>
}
a:active {
	color: <?php echo $value['active']; ?>
}
</style>
```
