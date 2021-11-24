=== Kirki Customizer Framework ===
Contributors: davidvongries, aristath, dannycooper, wplemon, igmoweb
Tags: customizer, options framework, theme, mods, toolkit, gutenberg
Requires at least: 4.9
Tested up to: 5.8
Stable tag: 3.1.9
License: MIT
License URI: https://opensource.org/licenses/MIT

The ultimate customizer framework for WordPress theme developers.

== Description ==

[![Build Status](https://travis-ci.org/aristath/kirki.svg?branch=develop)](https://travis-ci.org/aristath/kirki) [![Code Climate](https://codeclimate.com/github/aristath/kirki/badges/gpa.svg)](https://codeclimate.com/github/aristath/kirki) [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/66d6d8b6a4654cd18686ed1cd9f1bfb3)](https://www.codacy.com/app/aristath/kirki?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=aristath/kirki&amp;utm_campaign=Badge_Grade) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aristath/kirki/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/aristath/kirki/?branch=develop)

[Kirki](https://kirki.org/?utm_source=repo&utm_medium=description&utm_campaign=kirki) allows theme developers to build themes quicker & more easily.

With over **30 custom controls** ranging from simple sliders to complex typography controls with Google-Fonts integration and features like automatic CSS & `postMessage` script generation, Kirki makes theme development a breeze.

### Features ###
* Increased Performance
* Simplified API
* Automatic CSS Generation
* Automatic postMessage Generation
* Partial Refresh
* Conditional Logic
* GDPR Compliance
* Improved Page Speed
* & more!

### Controls ###

* [Background Customizer Control](https://kirki.org/docs/controls/background)
* [Code Customizer Control](https://kirki.org/docs/controls/code)
* [Checkbox Customizer Control](https://kirki.org/docs/controls/checkbox)
* [Color Customizer Control](https://kirki.org/docs/controls/color)
* [Color Palette Customizer Control](https://kirki.org/docs/controls/color-palette)
* [Custom Customizer Control](https://kirki.org/docs/controls/custom)
* [Dashicons Customizer Control](https://kirki.org/docs/controls/dashicons)
* [Date Customizer Control](https://kirki.org/docs/controls/date)
* [Dimension Customizer Control](https://kirki.org/docs/controls/dimension)
* [Dimensions Customizer Control](https://kirki.org/docs/controls/dimensions)
* [Dropdown Pages Customizer Control](https://kirki.org/docs/controls/dropdown-pages)
* [Editor Customizer Control](https://kirki.org/docs/controls/editor)
* [Generic Customizer Control](https://kirki.org/docs/controls/generic)
* [Image Customizer Control](https://kirki.org/docs/controls/image)
* [Link Customizer Control](https://kirki.org/docs/controls/link)
* [Multiple Checkbox Customizer Control](https://kirki.org/docs/controls/multicheck)
* [Multicolor Customizer Control](https://kirki.org/docs/controls/multicolor)
* [Number Customizer Control](https://kirki.org/docs/controls/number)
* [Radio Customizer Control](https://kirki.org/docs/controls/radio)
* [Radio Buttonset Customizer Control](https://kirki.org/docs/controls/radio-buttonset)
* [Radio Image Customizer Control](https://kirki.org/docs/controls/radio-image)
* [Repeater Customizer Control](https://kirki.org/docs/controls/repeater)
* [Select Customizer Control](https://kirki.org/docs/controls/select)
* [Slider Customizer Control](https://kirki.org/docs/controls/slider)
* [Sortable Customizer Control](https://kirki.org/docs/controls/sortable)
* [Switch Customizer Control](https://kirki.org/docs/controls/switch)
* [Text Customizer Control](https://kirki.org/docs/controls/text)
* [Textarea Customizer Control](https://kirki.org/docs/controls/textarea)
* [Toggle Customizer Control](https://kirki.org/docs/controls/toggle)
* [Typography Customizer Control](https://kirki.org/docs/controls/typography)
* [Upload Customizer Control](https://kirki.org/docs/controls/upload)

### Theme Example ###

[Page Builder Framework](https://wp-pagebuilderframework.com?utm_source=kirki&utm_medium=repo&utm_campaign=wpbf)'s customizer settings are a prime example of what can be achieved with Kirki.

Conditional Logic, Partial Refresh, postMessage and a variety of controls - It has all of it.

### Documentation ###

You can find detailed documentation on how to use Kirki on [kirki.org](https://kirki.org/?utm_source=repo&utm_medium=description&utm_campaign=kirki)

### Kirki PRO ###

Kirki PRO is currently in development. You can [sign up for the waiting list](https://kirki.org/pricing/?utm_source=repo&utm_medium=description&utm_campaign=kirki) here to be notified about updates.

### Disclaimer ###

Theme developers should be familiar with the Customizer API before starting to build a theme using Kirki. An excellent handbook for the WordPress Customizer can be found on the [developer.wordpress.org](https://developer.wordpress.org/themes/customize-api/) website.

== Installation ==

Simply install as a normal WordPress plugin and activate.

If you want to integrate Kirki in your theme or plugin, please read the instructions on [our documentation site](https://kirki.org/docs/integration).

== Changelog ==

= 4.0 - November 24, 2021 =
Fix color picker on repeater and 🎉

= 4.0-beta.3 - November 18, 2021 =
Small bugfixes/changes:
* Update `googlefonts` package
* Update `control-react-colorful` package
* Fix notices & warnings in `module-webfonts` package when `get_font_choices` method is called.

= 4.0-beta.2 - November 04, 2021 =
Bugfixes:
* The CSS output of `control-react-colorful` was empty when the value is a string
* On `control-radio`, the control id wasn't outputted causing broken behavior
* The sanitize callback of field-dimensions wasn't implemented
* Output on Gutenberg editing screen was affecting the whole page instead of only the editing content
* The margin-top & margin-bottom of `field-typography` wasn't rendered in frontend styles
* The `kirki/fonts/standard_fonts` wasn't implemented when it's hooked AFTER adding the fields (in user's usage)
* The default browser font-family (from v3) was missing
* The custom font families grouping was missing
* Custom variants set on standard fonts wasn't implemented

Improvement:
* The `control-react-select` choices now accept an array of objects (used by a variant in field-typography)

Refactor:
* Bring back the v3 style/model of font's variant in `field-typography`

= 4.0-beta.1 - October 15, 2021 =

* Now controls are developed (and available) as composer packages
* Some controls are using React for their JS part
* Much improvement over color control (using `react-colorful`) also includes new features
* Improved typography field
* Improved color palette control
* Improved multicolor field
* Improved dimensions field
* Improved select controls (including dropdown pages control)
* Some other improvements
* Bugfixes!
* Use Parcel as the build tool (it's nice!)

= 3.1.9 - July 19, 2021 =

* Fixed: Styling issue in Switch control.

[See the previous changelogs here](https://github.com/kirki-framework/kirki/blob/master/CHANGELOG.md).
