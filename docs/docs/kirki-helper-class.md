---
layout: default
title: The Kirki_Helper class
subtitle: A collection of helper methods
mainMaxWidth: 50rem;
bodyClasses: page
---

Kirki includes some helper methods that allow you to make a few tasks easier.

### Get the ID of an image from its URL

To get the attachment ID of an image from its URL, you can use the following:

```php
$image_id = Kirki_Helper::get_image_id( $url );
```

### Get image details from its URL

```php
$image = Kirki_Helper::get_image_from_url( $url );
```

The above will return an array formatted like this:

```php
array(
	'url'       // string, the URL of the image
	'width'     // integer, the width of the image
	'height'    // integer, the height of the image
	'thumbnail' // string, URL of the image's thumbnail.
);
```

### Get an array of posts

```php
$posts = Kirki_Helper::get_posts( $args );
```

as `$args` you will have to use an array formatted as documented in WordPress's [`get_posts`](https://codex.wordpress.org/Template_Tags/get_posts) function.

The difference between WordPress's `get_posts` function and the `Kirki_Helper::get_posts` method is that the method included in Kirki will return an array of posts formatted in a way that can be easily used in a control in the `choices` argument.

Example:

```php
Kirki::add_field( 'my_config', array(
	'type'     => 'select',
	'settings' => 'my_setting',
	'label'    => esc_attr__( 'This is the label', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => '',
	'priority' => 10,
	'multiple' => 1,
	'choices'  => Kirki_Helper::get_posts(
		array(
			'posts_per_page' => 10,
			'post_type'      => 'page'
		) ,
	),
) );
```

### Get an array of available taxonomies

```php
$taxonomies = Kirki_Helper::get_taxonomies();
```

This will return an array of all the available taxonomies so you can use it directly in a control's `choices` argument.

Example:

```php
Kirki::add_field( 'my_config', array(
	'type'     => 'select',
	'settings' => 'my_setting',
	'label'    => esc_attr__( 'This is the label', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => 'option-1',
	'priority' => 10,
	'multiple' => 1,
	'choices'  => Kirki_Helper::get_taxonomies(),
) );
```

### Get an array of available post-types

```php
$post_types = Kirki_Helper::get_post_types();
```

This will return an array of all the publicly-available post-types so you can use it directly in a control's `choices` argument.

Example:

```php
Kirki::add_field( 'my_config', array(
	'type'     => 'select',
	'settings' => 'my_setting',
	'label'    => esc_attr__( 'This is the label', 'my_textdomain' ),
	'section'  => 'my_section',
	'default'  => 'option-1',
	'priority' => 10,
	'multiple' => 1,
	'choices'  => Kirki_Helper::get_post_types(),
) );
```

### Get an array of terms

```php
$terms = Kirki_Helper::get_terms( $taxonomies );
```

as `$taxonomies` you will have to use an array formatted as documented in WordPress's [`get_terms`](https://developer.wordpress.org/reference/functions/get_terms/) function.

The difference between WordPress's `get_terms` function and the `Kirki_Helper::get_terms` method is that the method included in Kirki will return an array of posts formatted in a way that can be easily used in a control in the `choices` argument.

Example:

```php
Kirki::add_field( 'my_config', array(
	'type'        => 'select',
	'settings'    => 'my_setting',
	'label'       => esc_attr__( 'This is the label', 'my_textdomain' ),
	'section'     => 'my_section',
	'default'     => 'option-1',
	'priority'    => 10,
	'multiple'    => 1,
	'choices'     => Kirki_Helper::get_terms( array('taxonomy' => 'category') )),
) );
```
For full list of choices https://developer.wordpress.org/reference/functions/get_terms/#source
