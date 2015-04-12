# [Kirki](http://kirki.org) #

Contributors: aristath, fovoc<br>
Tags: customizer, options famework, theme mods<br>
Donate link: http://kirki.org/<br>
Requires at least: 4.0<br>
Tested up to: 4.2<br>
Stable tag: 0.8.4<br>
License: GPLv2 or later<br>
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tired of all the bloated options frameworks? You can use the WordPress Customizer instead, and extend it using Kirki!


## Description
Kirki allows developers to add advanced controls to their customizer as well as customize the way the customizer looks and feels.

You can add beautiful options to your theme\'s customizer panel and allow your users to tweak any aspect of their theme. You\'ve got 18 control types that you can use ( 9 default + 9 custom-made ), styling options for the customizer, as well as automatic calculations for your styles using the `output` argument on your controls.

Converting from the default customizer to the syntax used by Kirki will only take a few minutes and will save you a lot of time in the long run. :)

**CAUTION**: This plugin requires PHP 5.3 and is not compatible with PHP 5.2

The following controls are included:

* Radio-Buttonset
* Radio-Image
* Radio
* Checkbox
* Color
* Color-Alpha
* Dropdown Pages
* Image
* Background
* Multicheck
* Select
* Slider
* Text
* Textarea
* Upload
* Switch
* Toggle
* Sortable
* Number
* Palette
* Editor (TinyMCE)

For documentation and examples on how to use these controls, please visit [kirki.org](http://kirki.org/#fields).


## Installation

### Method 1: Use as a plugin
From your dashboard go to Plugins => Add New.
Search for "Kirki" and install it.
Once you install it, activate it.
For configuration instructions please visit [kirki.org](http://kirki.org/#configuration)

### Method 2: Embed in your theme
Please visit [kirki.org](http://kirki.org) for documentation and instructions.


### Sample Theme

To get an idea on how to include Kirki in your next project, a [sample theme](https://github.com/aristath/kirki/wiki/Sample-Theme-with-Kirki) has been created.


## Current Version

**0.8.4**
April 6, 2014, dev time: 0.5 hours

* Fix: Color sanitization was distorting 0 characters in the color hex.
* Fix: Properly sanitizing ColorAlpha controls
* Fix: Sanitizing more properties in the Fields class
* Fix: removing remnant double-sanitization calls from the controls classes

[Full Changelog found here](https://github.com/aristath/kirki/wiki/Changelog)
