---
layout: default
title: Adding Controls to your project
subtitle: How to add kirki to your project.
mainMaxWidth: 50rem;
bodyClasses: page
heroButtons:
  - url: ../config
    class: white button round border-only
    icon: fa fa-cogs
    label: Configuring Project
  - url: ../adding-panels-and-sections
    class: white button round border-only
    icon: fa fa-th-list
    label: Add Panels and Sections
  - url: ../controls
    class: white button round
    icon: fa fa-diamond
    label: Controls
---
<ul>
{% for node in site.pages %}{% if node.url contains "docs/controls" %}{% if node.slug %}<li><a href="{{ site.baseurl }}{{ node.url }}">{{ node.slug }}</a></li> {% endif %}{% endif %}{% endfor %}
</ul>
