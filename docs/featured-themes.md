---
layout: default
title: Awesome themes built with Kirki
---

<div class="callout success">
	<p>Are you a theme author? Add your <a href="https://github.com/aristath/kirki/edit/master/docs/_data/themes_premium.yml" target="_blank">Premium</a> and <a href="https://github.com/aristath/kirki/edit/master/docs/_data/themes_free.yml" target="_blank">Free</a> themes on this page!</p>
</div>

<hr>
<h2>Premium Themes</h2>
<hr>
<div class="awesome-themes grid-x grid-padding-x">
	<!-- Themes are ordered randomly using Jekyll's "sample" filter. -->
	{% assign premium_themes = site.data.themes_premium | sample:999 %}
    {% for theme in premium_themes %}
		<div class="cell item">
			<div class="inner">
				<a href="{{ theme.url }}{% if 'ThemeForest' == theme.market %}?ref=aristath{% endif %}" target="_blank">
					<h4>{{ theme.name }}</h4>
					<hr>
					<img src="{{ theme.thumb }}">
				</a>
			</div>
		</div>
	{% endfor %}
</div>

<hr>
<h2>Free Themes</h2>
<hr>
<div class="awesome-themes grid-x grid-padding-x">
	<!-- Themes are ordered randomly using Jekyll's "sample" filter. -->
	{% assign free_themes = site.data.themes_free | sample:999 %}
    {% for theme in free_themes %}
		<div class="cell item">
			<div class="inner">
				<a href="{{ theme.url }}" target="_blank">
					<h4>{{ theme.name }}</h4>
					<hr>
					<img src="{{ theme.thumb }}">
				</a>
			</div>
		</div>
	{% endfor %}
</div>
