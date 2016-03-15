
Most times you won't have to manually retrieve the value of `color` controls since the `output` argument can cover most use-cases.

{% highlight php %}
<div style="color:<?php echo get_theme_mod( 'my_setting', '#FFFFFF' ); ?>">
	<p>The text-color of this div is controlled by "my_setting".
</div>
{% endhighlight %}
