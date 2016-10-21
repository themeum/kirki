=== Kirki ===
Contributors: aristath, fovoc, igmoweb
Tags: customizer,options framework, theme, mods, toolkit
Donate link: http://kirki.org/
Requires at least: 4.4
Tested up to: 4.6.1
Stable tag: 2.3.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The ultimate toolkit for theme developers using the WordPress Customizer


== Description ==

[![Build Status](https://travis-ci.org/aristath/kirki.svg?branch=master)](https://travis-ci.org/aristath/kirki) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aristath/kirki/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aristath/kirki/?branch=master) [![Code Climate](https://codeclimate.com/github/aristath/kirki/badges/gpa.svg)](https://codeclimate.com/github/aristath/kirki) [![License](https://img.shields.io/badge/license-GPL--2.0%2B-red.svg)](https://raw.githubusercontent.com/aristath/kirki/master/LICENSE) [![Join the chat at https://gitter.im/aristath/kirki](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/aristath/kirki?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Kirki is a Toolkit allowing WordPress developers to use the Customizer and take advantage of its advanced features and flexibility by abstracting the code and making it easier for everyone to create beautiful and meaningful user experiences.

Kirki does not replace the WordPress Customizer API, you can still use the default WordPress methods and we advise you to familiarize yourselves with it. An excellent handbook for the WordPress Customizer can be found on the developer.wordpress.org website.

What Kirki does is save you time… LOTS of time!

Easily add configurations for your project, create panels, sections and add fields with ease.

Automatically create CSS from your fields, and make the customizer’s preview instant with our automatic postMessage scripts creation!

Add Google Fonts with our typography field, add tooltips to help your users and build awesome products!

You can find detailed documentation on how to use Kirki on [https://kirki.org](https://kirki.org)

== Installation ==

Simply install as a normal WordPress plugin and activate.

If you want to integrate Kirki in your theme or plugin, please read the instructions on [our ducumentation site](https://kirki.org/docs/advanced/integration.html).

== Changelog ==

= 2.3.7 =

October 22, 2016, dev time: 12 hours.

* Fix: `spacing` controls were not updating after save
* New: Now using the WP Notifications API in the customizer for spacing & dimension controls (requires WP 4.6).
* Fix: Allow overriding `option_type` with `theme_mod` when global config uses `option` by using the `option_type` argument in the fields.
* Fix: Disabled the custom kirki-preview loader. This will have to be built more modular in future versions.
* Fix: Refactored panel & section icons.
* Fix: postMessage now works better with slider controls.
* Fix: Reset button not working unless tooltips are loaded.
* Fix: Properly sanitize `link` and `url` fields.
* Fix: Automate sanitization for `repeater` fields.

= 2.3.6 =

August 28, 2016, dev time: 3 hours.

* Fix: CSS prefixes order fixes ([#1042](https://github.com/aristath/kirki/pull/1042)).
* Fix: `suffix` output argument support in Multicolor control ([#1042](https://github.com/aristath/kirki/pull/1042)).
* Fix: `Kirki::get_variables()` method should be static ([#1050](https://github.com/aristath/kirki/pull/1050)).
* Fix: Add line wrapping to CodeMirror ([#1079](https://github.com/aristath/kirki/pull/1079)).
* Fix: `container_inclusive` is disregarded on the selective refresh class ([#1089](https://github.com/aristath/kirki/issues/1089)).
* Fix: Support `input_attrs` parameter for controls ([#1074](https://github.com/aristath/kirki/issues/1074)).
* Fix: Outdated Google-Fonts list ([#1091](https://github.com/aristath/kirki/issues/1091)).

= 2.3.5 =

July 2, 2016. dev time: 6 hours.

* FIX: Missing button labels in `repeater` fields.
* FIX: Missing button label in `code` fields ([#1017](https://github.com/aristath/kirki/issues/1017)).
* FIX: Better implementation when embedding Kirki in a theme ([#1025](https://github.com/aristath/kirki/issues/1025)).
* FIX: Updated google-fonts ([#1041](https://github.com/aristath/kirki/issues/1041)).
* NEW: Allow simpler format for `variables` argument ([#1020](https://github.com/aristath/kirki/issues/1020)).

= 2.3.4 =

June 1, 2016, dev time: 30 minutes.

* FIX: Repeater JS issues due to error in translation strings.

= 2.3.3 =

May 31, 2016, dev time: 17 hours.

* FIX: Editor field covering the content ([#955](https://github.com/aristath/kirki/issues/955)).
* FIX: Smoother transition for editor switching.
* FIX: Code field JS error when using "php" mode ([#958](https://github.com/aristath/kirki/issues/958)).
* FIX: `postMessage` for typography fields ([#528](https://github.com/aristath/kirki/issues/528)).
* FIX: translation strings ([#960](https://github.com/aristath/kirki/issues/960)).
* FIX: `postMessage` for `background-image` properties ([#963](https://github.com/aristath/kirki/issues/963)).
* FIX: Reset Typography Control without font-family default value ([#951](https://github.com/aristath/kirki/issues/951)).
* FIX: Typography field: font-style missing in CSS output if variant is regular/400 ([#977](https://github.com/aristath/kirki/issues/977)).
* FIX: Placing two editor controls in the customizer leads to odd behavior ([#140](https://github.com/aristath/kirki/issues/140)).
* FIX: Typography field: letter-spacing missing in CSS output if its value is 0 ([#978](https://github.com/aristath/kirki/issues/978)).
* FIX: Allow using HTML in section descriptions ([#976](https://github.com/aristath/kirki/issues/976)).
* FIX: Bug preventing partial refreshes from working properly ([#991](https://github.com/aristath/kirki/issues/991)).
* FIX: Better internationalization handling.
* FIX: Output errors on typography settings ([#975](https://github.com/aristath/kirki/issues/975)).
* NEW: Added a new `attr` argument to `js_vars` ([#957](https://github.com/aristath/kirki/issues/957)).
* NEW: Implemented both `AND` and `OR` conditionals in `active_callback` arrays ([#839](https://github.com/aristath/kirki/issues/839)).
* NEW: Allow defining an array of dashicons to use.
* NEW: Added a `link` control type.

= 2.3.2 =

May 2, 2016, dev time: 52 hours.

* NEW: Completely refactored `editor` controls.
* NEW: Completely re-styled `code` controls.
* NEW: Added a new `kirki/{$config_id}/styles` filter ([#908](https://github.com/aristath/kirki/issues/908)).
* NEW: Added a `customize-control-kirki` class to all Kirki controls.
* FIX: Field type number : Cannot read property 'min' of undefined ([#911](https://github.com/aristath/kirki/issues/911)).
* FIX: All controls are now prefixed ([#918](https://github.com/aristath/kirki/issues/918))
* FIX: `alpha` argument in color-alpha controls ([#932](https://github.com/aristath/kirki/issues/932)).
* FIX: Name attribute in repeaters (props @guillaumemolter).
* FIX: Missing label for checkbox controls inside repeaters (props @guillaumemolter).
* FIX: Placing 2 editor controls in the customizer leads to odd behaviour ([#140](https://github.com/aristath/kirki/issues/140)).
* FIX: `active_callback` conbined with the old `required` argument. ([#906](https://github.com/aristath/kirki/issues/906)).
* FIX: Double prefix and suffix in `js_vars` ([#943](https://github.com/aristath/kirki/issues/943)).
* FIX: Typography control returns both 'subset' and 'subsets' indexes with the same value ([#948](https://github.com/aristath/kirki/issues/948)).
* FIX: Use `strict` JS mode in all controls.

= 2.3.1 =

April 19, 2016, dev time: 30 hours.

* FIX: Spacing control JS dependencies.
* FIX: Output property ignored in multicolor field.
* FIX: Image sub-controls in repeaters were causing a JS error.
* FIX: Text Domain Compliance with Themecheck.
* FIX: PostMessage scripts when using more than 1 elements for the output.
* FIX: Default values for swithes, toggles & checkboxes.
* FIX: Conflict with WP Core's `dropdown-pages` control.
* FIX: Auto-transport not working when using serialized options instead of theme_mods.
* FIX: `value_pattern` was not working properly when used in `js_vars`.
* FIX: Repeater control bugfixes (props @guillaumemolter).
* FIX: multi-selects saving single value.
* NEW: Added support for `upload` controls in repeaters (props @guillaumemolter).
* NEW: Adding mime_type parameter for image, cropped_image, upload controls in repeaters (props @guillaumemolter).
* NEW: Added color-picker support in repeater fields (props @guillaumemolter).

= 2.3.0 =

April 10, 2016, dev time: 21 hours.

Kirki is now 100% WordPress Coding Standards compliant.

* FIX: Escaping google-font URLs when possible.
* FIX: Only enqueue the tooltips script if needed.
* FIX: WordPress Coding Standards.
* FIX: undefined sub-controls were still being saved in typography fields
* FIX: Javascript Console Errors: "wp.customize" object undefined when Kirki fields were added in `customize_register`
* FIX: markup in editor fields - props @manuelmoreale.
* FIX: multiple styles in head when using js_vars
* FIX: Sanitization for rem units
* FIX: CSS output for multicolor controls
* NEW: Repeater labels are now dynamic - props @guillaumemolter.
* NEW: The entire header on repeaters is now draggable - props @guillaumemolter.
* TWEAK: More efficient JS code for the typography control

= 2.2.10 =

* FIX: Issue with URLs when using Kirki embedded in a theme and not installed as a plugin.

= 2.2.9 =

* FIX: Repeater controls were not working on 2.2.8 due to a typo - props @guillaumemolter
* NEW: Repeater fields now allow more control types (email/tel/url/hidden) - props @guillaumemolter

= 2.2.8 =

April 6, 2016, dev time: 5 hours.

* FIX: Enqueued assets missing when useg WP_DEBUG & WP_DEBUG_SCRIPT
* FIX: Checkboxes were not properly displaying their values
* FIX: Javascript errors when `number` controls were used without `min`, `max` or `step`.
* FIX: Multiselect controls issue with the `sanitize_callback` used.
* NEW: Make attributes in `cropped_image` sub-controls inside repeaters dynamic (props @guillaumemolter).

= 2.2.7 =

April 5, 2016, dev time: 23 hours.

* FIX: Properly parsing `postMessage` scripts when `transport` is set to `auto`.
* FIX: Background image was outputing CSS even if it was empty.
* FIX: Default value for checkboxes.
* FIX: Issue with plugin URLs in the customizer, when the plugin was embedded in a theme.
* FIX: Descriptions were now shown in `sortable` fields.
* FIX: Reset not working for textarea fields.
* FIX: In some cases only the first element in `output` arguments was being processed.
* FIX: edge-case bugfix for select controls when data saved if the db was somehow mis-formatted.
* FIX: Repeater controls now use image IDs instead of image URLs. Props @guillaumemolter
* NEW: Added `text-align` ability in `typography` fields.
* NEW: Added `text-transform` ability in `typography` fields.
* NEW: Introduce `value_pattern` argument for `output` & `js_vars`.
* NEW: Started refactoring the `Kirki_Field` class. Now each field can have its own sub-class extending the main Kirki_Field object.
* NEW: `multicolor` control.
* NEW: Added `cropped_image` support in `repeater`. Props @guillaumemolter
* TWEAK: Renamed `Kirki_Customizer_Scripts_Loading` to `Kirki_Scripts_Loading`.
* TWEAK: Renamed `Kirki_Customizer_Scripts_Tooltips` to `Kirki_Scripts_Tooltips`.
* TWEAK: Renamed `Kirki_Customizer_Scripts_Icons` to `Kirki_Scripts_Icons`.
* TWEAK: More inline comments, docs & coding-standards improvements.
* DEPRECATED: Removed the `Kirki_Colourlovers` class.

= 2.2.6 =

March 26, 2016, dev time: 10 hours

* FIX: Invalid variants for google fonts were getting enqueued due to a mischeck.
* FIX: Repeater rows are now minimized by default.
* FIX: Styling for the `dropdown-pages` control.
* FIX: `switch` controls now properly resize based on the label used in the `choices` argument.
* FIX: It is now possible to use `calc()` in CSS value controls.
* FIX: Styles were being applied to the customizer even if they were not defined in the `kirki/config` filter.
* FIX: Removed unnecessary class inheritances & other code cleanups.
* NEW: Allow resetting options per-section.
* NEW: Added new `color-palette` control.
* NEW: Added `'transport' => 'auto'` to auto-calculate postMessage scripts from the `output` argument when possible.
* NEW: Added Material design palettes in the `Kirki_Helper` class.
* NEW: Allow changing the "Add Row" text on repeater fields.
* NEW: Allow setting a limit for repeater rows.

= 2.2.5 =

March 23, 2016, dev time: 7 hours

* FIX: Google fonts now loaded via a PHP array instead of a JSON file.
* FIX: CSS issue due to escaped quotes on standard fonts.
* FIX: Issue when using `units` on `js_vars` combined with the `style` method.
* FIX: Missing textdomain on a string.
* NEW: Refactored postMessage scripts.
* NEW: Allow passing options to iris using the `choices` argument on color controls.
* NEW: Allow disabling the custom loader using the `disable_loader` argument in the `kirki/config` filter.

= 2.2.4 =

March 20, 2016, dev time: 6 hours

* FIX: Removed unnecessary CSS echoed by the `typography` control
* FIX: Color Calculation class improvements
* FIX: CSS improvement for `toggle` controls
* NEW: Added `dashicons` field
* NEW: Added the ability to limit the number of rows in `repeater` controls (props @fovoc)

= 2.2.3 =

March 19, 2016

* FIX: Selecting a color inside typography controls was throwing a JS error (typo)
* FIX: CSS alignment for descriptions in toggle controls
* FIX: Default value for letter-spacing setting in typography controls (props @andreg)

= 2.2.2.1 =

March 18, 2016, dev time: 5 minutes

* FIX: Backwards-compatibility bugfix

= 2.2.2 =

March 17, 2016, dev time: 10 minutes

* FIX: PHP notice for non-standard controls when the `element` defined in an `output` argument is of type `array`.

= 2.2.1 =

March 17, 2016, dev time: 3 hours

* FIX: Alpha channel was always enabled for color controls
* FIX: PHP Notices in the class-kirki-output-control-typography.php file
* FIX: PHP Fatal error on PHP 5.2
* FIX: PHP Notice in the class-kirki-field.php file
* FIX: PHP Fatal error when using background-position in the output argument
* TWEAK: Removed unused languages from CodeMirror to reduce the plugin's size

= 2.2.0 =

March 16, 2016, dev time: 120 hours

* FIX: Improved & simplified the `number` control.
* FIX: Improved & simplified the `spacing` control.
* FIX: Minor bugfix on the `select` control.
* FIX: WP Coding standards improvements.
* FIX: Bugfix for radio controls.
* FIX: Fixed repeater remove image not triggering save button to activate, and added a placeholder when the image is removed. (props @sayedwp)
* FIX: Fixed bug when using negative numbers as min value in the `number` field
* FIX: Typo in the textdomain for some strings (some strings were using "Kirki" instead of "kirki").
* FIX: Complete refactor & rewrite of the google-fonts implementation.
* FIX: IE11 bug on radio-image controls.
* FIX: Radio-image bug when used with serialized options.
* NEW: Complete refactor & rewrite of typography control.
* NEW: Refactored the CSS output methods.
* NEW: Added new mothods for detecting dependencies.
* NEW: Added font-subsets in typography controls.
* NEW: Google fonts now only show valid variants & subsets in typography controls.
* NEW: Implemented partial refreshes for WP 4.5 using a "partial_refresh" argument (formatted as an array).
* NEW: Better autoloader & improved file structure.
* NEW: Deprecated the `Kirki_Field_Sanitize` class in favor of a more simplified & robust implementation.
* NEW: Completely refactored the `Kirki_Field` class, we're migrating to a more OOP model.
* NEW: Added a new `kirki-generic` control.
* NEW: Deprecated the custom text control and used the new `kirki-generic` control instead.
* NEW: Deprecated the custom textarea control and used the new `kirki-generic` control instead.
* NEW: Renamed the `help` argument to `tooltip`. `help` will continue to work as an alias.
* NEW: Merged the `color` & color-alpha` controls. We now use the `color-alpha` control for all colors, and just modify the `data-alpha` property it has.
* NEW: Started an OOP rewrite of many classes
* NEW: Started rewriting the PHPUNIT tests & tweaked them so they can now run on localhosts (like VVV) and not just on travis-ci.
* NEW: Included the ariColor library for color calculations (https://aristath.github.io/ariColor/)
* TWEAK: Other code refactoring for improved performance
* TWEAK: Updated `grunt` packages.

= 2.1.0.1 =

February 17, 2016, dev time: 5 minutes

* FIX: PHP Notices (undefined index)

= 2.1.0 =

February 17, 2016, dev time: 4 hours

* FIX: Image field issues inside the Repeater field (props @sayedwp)
* NEW: Allow disabling output per-config
* NEW: Introduce 'postMessage' => 'auto' option in config (will auto-create `js_vars` using the `output` argument)
* NEW: New color control using a js-based template
* TWEAK: Branding script rewrite
* TWEAK: Color controls styling
* TWEAK: Coding improvements & cleanups

= 2.0.9 =

February 13, 2016, dev time: 1 hour.

* FIX: Google fonts bug (use double quotes when font name contains a space character)
* FIX: Checkbox control bug (checkboxes were always displayed as checked, regardless of their actual value)
* NEW: Intruducing KIRKI_NO_OUTPUT constant that disables CSS output completely when set to true.

= 2.0.8 =

February 10, 2016, dev time: 2 hours

* FIX: Only load Kirki styles when in the customizer
* FIX: Performance issue with Google Fonts
* NEW: Added radio-image controls to repeaters
* TWEAK: Better color handling in the Kirki_Color class

= 2.0.7 =

January 19, 2016, dev time: 1 hour

* FIX: Narrow the scope of "multicheck" modification checker (props @chetzof)
* FIX: PHP warnings due to invalid callback method
* FIX: postMessage bug introduced in 2.0.6 (2 lines commented-out)

= 2.0.6 =

January 18, 2016, dev time: 7 hours

* FIX: Fix active callback for multidimensional arrays. (props @andrezrv)
* FIX: Correctly check current value of checkbox control. (props @andrezrv)
* FIX: Bug in the sortable field (props @daviedR)
* FIX: Fixed some bugs that occured when using serialized options instead of theme_mods
* NEW: Added an image sub-field to repeater fields (props @sayedwp)
* NEW: Added a JS callback to js_vars (props @pingram3541)
* TWEAK: Settings sanitization
* TWEAK: Removed demo theme from the plugin. This is now provided separately on https://github.com/aristath/kirki-demo

= 2.0.5 =

December 23, 2015, dev time: 2.5 hours

* FIX: Disabled the ajax-loading method for stylesheets. All styles are now added inline. Will be re-examined for a future release.
* FIX: Number controls were not properly triggering changes
* FIX: Styling for number controls
* FIX: In some cases the dynamic CSS was added before the main stylesheet. We now add them using a priority of 999 to ensure they are enqueued afterwards.

= 2.0.4 =

December 19, 2015, dev time: 3 hours

* NEW: Added units support to the Typography field
* NEW: Default methods of enqueuing styles in now inline.
* NEW: Added 'inline_css' argument to config. set to false to add styles using AJAX.
* FIX: HTML mode for CodeMirror now functional
* FIX: PHP Notices when the config filter is used wrong
* FIX: Monor bugfix for text inputs
* FIX: Indentation & coding standards
* FIX: failing PHPUNIT test.
* TWEAK: Remove passing click event object

= 2.0.3 =

December 6, 2015, dev time: 45 minutes

* Bugfix for updates

= 2.0.2 =

December 6, 2015, dev time: 30 minutes

* FIX: Fatal error on update (not on new installations)
* FIX: Typo

= 2.0.1 =

December 6, 2015, dev time: 10 minutes

* FIX: Some configurations were failing with the new autoloader. Reverted to a simpler file structure.

= 2.0 =

December 6, 2015, dev time > 140 hours

* NEW: Added support for `sanitize_callback` arguments on each item in the CSS `output`.
* NEW: Added the ability to define an array as element in the `output`.
* NEW: Auto-prefixing CSS output for cross-browser compatibilities.
* NEW: Allow using arrays in settings.
* NEW: Dimension Field.
* NEW: Repeater Field.
* NEW: Code Field using the ACE editor.
* NEW: Typography Control.
* NEW: Preset Field.
* NEW: Demo theme.
* NEW: Spacing Control.
* REMOVED: Redux Framework compatibility.
* FIX: Minor bugfixes to the Kirki_Color class.
* FIX: kirki_get_option now uses Kirki::get_option().
* FIX: Various bugfixes.
* TWEAK: Converted the `checkbox` control to use the JS templating system.
* TWEAK: Converted the `custom` control to use the JS templating system.
* TWEAK: Converted the `multicheck` control to use the JS templating system.
* TWEAK: Converted the `number` control to use the JS templating system.
* TWEAK: Converted the `palette` control to use the JS templating system.
* TWEAK: Converted the `radio-buttonset` control to use the JS templating system.
* TWEAK: Converted the `radio-image` control to use the JS templating system.
* TWEAK: Converted the `radio` control to use the JS templating system.
* TWEAK: Converted the `select` control to use the JS templating system.
* TWEAK: Converted the `slider` control to use the JS templating system.
* TWEAK: Converted the `switch` control to use the JS templating system.
* TWEAK: Converted the `textarea` control to use the JS templating system.
* TWEAK: Converted the `toggle` control to use the JS templating system.
* TWEAK: `radio-buttonset` controls are now CSS-only.
* TWEAK: `radio-image` controls are now CSS-only.
* TWEAK: `select` controls nopw use [selectize](http://brianreavis.github.io/selectize.js/) instead of [Select2](https://select2.github.io/).
* TWEAK: Deprecated `select2` and `select2-multiple` controls. We now have a global `select` control. Previous implementations gracefully fallback to the current one.
* TWEAK: `switch` controls are now CSS-only.
* TWEAK: `toggle` controls are now CSS-only.
* TWEAK: Sliders now use an HTML5 "range" input instead of jQuery-UI.
* TWEAK: Better coding standards.
* TWEAK: Descriptions styling.
* TWEAK: Improved controls styling.
* TWEAK: Compiled CSS & JS for improved performance.
* TWEAK: Added prefix to the sanitized output array.
* TWEAK: Updated google-fonts.
* TWEAK: Grunt integration.
* TWEAK: Some Code refactoring.

= 1.0.2 =

July 17, 2014, dev time: 5 minutes

* NEW: Added 'disable_output' and 'disable_google_fonts' arguments to the configuration.

= 1.0.1 =

July 17, 2014, dev time: 1 hour

* FIX: Issues when using serialized options instead of theme_mods or individual options.
* FIX: Issues with the `output` argument on fields.
* FIX: Other minor bugfixes

= 1.0.0 =

July 11, 2014, dev time: 177 hours

* NEW: Added PHPUnit tests
* NEW: Use wp_add_inline_style to add customizer styles
* NEW: Rebuilt the background fields calculation
* NEW: Now using Formstone for switches & toggles
* NEW: Added a new API. See https://github.com/aristath/kirki/wiki for documentation.
* NEW: Minimum PHP requirement is now PHP 5.2
* NEW: Added a Select2 field type.
* NEW: Introducing the Kirki::get_option() method to get values.
* NEW: added 'media_query' argument to output.
* NEW: Added ability to get variables for CSS preprocessors from the customizer values. See https://github.com/aristath/kirki/wiki/variables for documentation
* NEW: now supporting 'units' to all outputs to support '!important'
* NEW: Ability to create panels & sections using the new API.
* NEW: added a get_posts method to the Kirki class.
* NEW: Implement width argument in the styling options. See https://github.com/aristath/kirki/wiki/Styling-the-Customizer
* NEW: add 'kirki/control_types' filter
* FIX: Properly saving values in the db when using serialized options
* FIX: Check if classes & functions exist before adding them (allows for better compatibility when embedded in a theme)
* FIX: PHP Warnings & Notices
* FIX: Other minor bugfixes
* FIX: Now using consistently `option_type` instead of `options_type` everywhere
* FIX: `Kirki::get_option()` method now works for all fields, including background fields.
* FIX: avoid errors when Color is undefined in background fields
* FIX: Use WP_Filesystem to get the google fonts array from a json file
* FIX: Radio-Button styling
* FIX: PHP Notices
* FIX: Typos
* FIX: Properly sanitizing rgba colors
* FIX: Properly sanitize numbers
* FIX: Make sure all variables are escaped on output
* TWEAK: Simplify the Colourlovers integration.
* TWEAK: Improve sanitization
* TWEAK: Improve the Kirki_Styles_Customizer class
* TWEAK: Code cleanups
* TWEAK: Added more inline docs (lots of them)
* TWEAK: Use active_callback for required arguments instead of custom JS
* TWEAK: Updated translation files
* TWEAK: Better color manipulation in the Kirki_Color class
* TWEAK: Move secondary classes instantiation to the Kirki() function.
* TWEAK: set a $kirki global
* TWEAK: deprecate getOrThrow method in the Kirki_Config class.
* TWEAK: Move sanitisation functions to a Kirki_Sanitize class.
* TWEAK: Rename Kirki_Framework to Kirki_Toolkit.
* TWEAK: Move variables to the new API
* TWEAK: simplify Kirki_Controls class
* TWEAK: move the kirki/fields & kirki/controls filters to the new API
* REMOVED: remove the 'stylesheet_id' from the configuration.

= 0.8.4 =

April 6, 2014, dev time: 0.5 hours

* FIX: Color sanitization was distorting 0 characters in the color hex.
* FIX: Properly sanitizing ColorAlpha controls
* FIX: Sanitizing more properties in the Fields class
* FIX: removing remnant double-sanitization calls from the controls classes

= 0.8.3 =

April 5, 2014, dev time: 28 hours

* NEW: Introduce a Field class
* NEW: Introduce a Builder class
* TWEAK: Code Cleanups
* NEW: Added ability to use 'option' as the setting type
* Fix : Bugs in the color calculation class
* TWEAK: Everything gets sanitized in the "Field" class
* FIX: Bugs in sortable field
* FIX: Editor control had no description
* NEW: Added a color-alpha control. To use it just set an rgba color as the default value.
* TWEAK: SCSS & CSS improvements
* FIX: Various PHP notices and warnings when no fields are defined
* TWEAK: More efficient color sanitization method
* TWEAK: Improved number control presentation
* TWEAK: Improved the way background fields are handled
* TWEAK: Checkboxes styling
* NEW: Allow using rgba values for background colors
* FIX: CSS fix - :focus color for active section
* NEW: Add a static 'prepare' method to the ScriptRegistry class
* FIX: Issues with the URL when Kirki is embedded in a theme

= 0.8.2 =

March 30, 2015, dev time: 5 minutes

* FIX: Autoloader could not properly include files due to strtolower()

= 0.8.1 =

March 30, 2015, dev time: 30 minutes

* FIX: Translation strings now overridable using the config filter.

= 0.8.0 =

March 30, 2015, dev time: 32 hours

* Improvement: OOP redesign (props @vpratfr)
* NEW: Added Palette control
* NEW: Added Editor control (WYSIWYG - uses TinyMCE)
* NEW: Added Custom control (free html)
* NEW: Added a Kirki_Colourlovers class to use palettes from the colourlovers API
* NEW: Added a composer file (props @vpratfr)
* FIX: Wrong settings IDs
* FIX: Color calculation on RGBA functions were off
* TWEAK: Restructuring the plugin (props @vpratfr)
* NEW: added a functional kirki_get_option() function
* TWEAK: Simplified configuration options.
* NEW: Turn Kirki into a singleton and a facade (props @vpratfr)
* TWEAK: Completely re-written the customizer styles
* NEW: Using SASS for customizer styles
* TWEAK: Deprecating the group_title control in favor of the new custom control
* TWEAK: Changed the CSS for checkboxes

= 0.7.1 =

March 15, 2015, dev time: 2 hours

* REMOVED: Remove the `kirki_get_option` function that was introduced in 0.7 as it's not working properly yet.
* FIX: Undefined index notice when a default value for the control was not defined
* TWEAK: `logo_image` now injects an `img` element instead of a `div` with custom background
* NEW: Added `description` argument in the kirki configuration (replaces the theme description)

= 0.7 =

March 14, 2015, dev time: 10 hours

* FIX: Array to string conversion that happened conditionally when used with googlefonts. (props @groucho75)
* FIX: Background opacity affects background-position of bg image
* FIX: font-weight not being applied on google fonts
* NEW: Added `kirki_get_option( $setting );` function that also gets default values
* TWEAK: Singleton for main plugin class
* FIX: Prevent empty help tooltips
* NEW: Added `toggle` control
* NEW: Added `switch` control
* FIX: Color controls were not being reset to default:
* TWEAK: Tooltips now loaded via jQuery
* TWEAK: Renamed `setting` to settings for consistency with WordPress core
* TWEAK: Renamed `description` to `help` and `subtitle` to `description for consistency with WordPress core
* TWEAK: Backwards-compatibility improvements
* NEW: Allow hiding background control elements by not including default values for them
* TWEAK: Performance improvements
* TWEAK: Using WordPress core controls instead of custom ones when those are available
* TWEAK: Separate logic for multiple-type controls that were using the "mode" argument. This has been deprecated in favor of completely separate control types.

= 0.6.2 =

March 2, 2015, dev time: 3 hours

* FIX: Frontend styles were not properly enqueued (props @dmgawel)
* NEW: Allow multiple output styles per control defined as an array of arrays.
* FIX: Background control styles
* FIX: Serialise default values for the sortable control. Now you can define default values as an array.
* FIX: Required script
* FIX: \'_opacity\' was added to a lot of controls by mistake. Removed it and wrote a migration script.

= 0.6.1 =

February 25, 2015, dev time: 1 hours

* FIX: Sortables controls had a JS conflict
* FIX: Switches & Toggles were not properly working

= 0.6.0 =

February 25, 2015, dev time: 9 hours

* FIX: Tooltips now properly working
* NEW: Added checkbox switches
* NEW: Added checkbox toggles
* FIX: Generated CSS is not properly combined & minified
* FIX: Re-structuring files hierarchy
* FIX: Simplify the way controls are loaded
* NEW: Only load control classes when they are needed
* NEW: Introducing Kirki_Customize_Control class
* FIX: CSS tweaks
* NEW: Sortable control (creating one is identical to a select control, but with `\'type\' => \'sortable\'`)
* FIX: Double output CSS (props @agusmu)
* NEW: Google fonts now parsed from a json file.

= 0.5.1 =

January 22, 2015

* FIX: Transport defaults to refresh instead of postMessage
* FIX: undefined index notice.

= 0.5 =

January 21, 2015

* NEW: Automatic output of styles for generic controls.
* NEW: Automatic output of styles + scripts for fonts (including googlefonts )
* NEW: The \'output\' argument on background controls is now an array for consistency with other controls. Older syntax is still compatible though. :)
* NEW: Add the ability to auto-generate styles for colors.
* FIX: Add a blank stylesheet if we need one and no stylesheet_id has been defined in the config options.
* FIX: CSS-only tooltips. Fixes issue with tooltips now showing up on WP >= 4.1
* FIX: Code cleanups
* NEW: Added support for WordPress\'s transport arguments
* FIX: All controls now have a sanitization callback. Users can override the default sanitizations by adding their own \'sanitize_callback\' argument.
* FIX: OOP rewrite
* FIX: Strip protocol from Google API link
* FIX: Loading order for some files
* FIX: Removed deprecated less_var argument

= 0.4 =

October 25, 2014

* FIX: bugfix for selector
* NEW: Change the Kirki theme based on which admin theme is selected.
* FIX: Tranlsation domain issue
* NEW: Added a \"group_title\" control
* FIX: Updated the required script
* FIX: Updating CSS
* Other minor improvements and bugfixes

= 0.3 =

May 26, 2014

* NEW: added background field
* NEW: added \'output\' argument to directly output the CSS

= 0.2 =

May 9, 2014

* Initial version
