---
layout: default
title: Getting Started
subtitle: How to add kirki to your project.
mainMaxWidth: 50rem;
bodyClasses: page
heroButtons:
  - url: config
    class: white button round border-only
    icon: fa fa-cogs
    label: Configuring Project
  - url: adding-panels-and-sections
    class: white button round border-only
    icon: fa fa-th-list
    label: Add Panels and Sections
  - url: controls
    class: white button round
    icon: fa fa-diamond
    label: Controls
---

If you are building a WordPress theme that will be distributed (either free or premium), the first thing you have to decide when using Kirki is how your clients will get the plugin on your site.

Currently there are 2 options:

1. Recommend (or require) the installation of Kirki as a plugin
2. Embed Kirki in your theme.

### Use a 3rd-party script to require/recommend the installation of Kirki

If you are using [TGMPA](http://tgmpluginactivation.com/) or [MerlinWP](https://merlinwp.com/) in your theme, then you can use those to recommend - or require - the installation of the Kirki plugin with your theme.

### Use a custom script to recommend the installation of Kirki

If you don't use one of the above scripts, then you can use [this simple script](https://github.com/aristath/kirki/tree/master/docs/files/recommend-kirki.php) in your theme to recommend the installation of Kirki.

Usage:

Copy the file from [here](https://github.com/aristath/kirki/tree/master/docs/files/recommend-kirki.php) to your theme (for example in `mytheme/inc/class-kirki-installer-section.php`), and then in your `functions.php` file add this:

```php
include_once get_theme_file_path( 'inc/class-kirki-installer-section.php' );
```

<div class="callout warning ribbon-full">
    <h5>A word of caution for themes on wordpress.org:</h5>
    <p>If your theme will be distributed via wordpress.org you cannot require the installation of plugins but you can recommend them. That means that the theme will still have to work when kirki is not installed, for which we have already build a fallback PHP Class you can use in your themes <a href="https://github.com/aristath/kirki/tree/master/docs/files/class-my-theme-kirki.php">here</a>.</p>
</div>

### Embed in your theme

Though we do do not recommend embedding kirki in your theme it is still possible to do. You can simply copy the plugin in your theme and then include the main plugin file in your theme's `functions.php` file.

Keep in mind that if you choose to follow this method Kirki will be "invisible" as a plugin to your clients and they will therefore be unable to update to future versions in case of bugfixes and/or security updates.
