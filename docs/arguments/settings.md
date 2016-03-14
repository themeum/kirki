---
layout: docs
---

# settings

`settings` is a mandatory argument for any field. The value entered here will be used to store the settings in the database.

If for example you create a field using something like this:

{% highlight php %}
<?php
Kirki::add_field( 'my_config', array(
    'type'        => 'color',
    'settings'    => 'body_background_color',
    'label'       => __( 'This is the label', 'my_textdomain' ),
    'section'     => 'my_section',
    'default'     => '#0088CC',
    'priority'    => 10,
    'alpha'       => true,
) );
?>
{% endhighlight %}

then in your theme you can access that value using:

{% highlight php %}
<?php $color = get_theme_mod( 'body_background_color', '#0088CC' ); ?>
{% endhighlight %}
