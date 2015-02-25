=== Kirki ===
Contributors: aristath, fovoc
Donate link: http://kirki.org
Tags: customizer
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 0.6.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tired of all the bloated options frameworks? You can use the WordPress Customizer instead, and extend it using Kirki!

== Description ==

Kirki allows developers to add advanced controls to their customizer as well as customize the way the customizer looks and feels.

The following controls are included:

* Buttonset
* Checkbox
* Color
* Image
* Background
* Image Radio
* Multicheck
* Radio
* Select
* Slider
* Text
* Textarea
* Upload
* Switch
* Toggle
* Sortable

For documentation and examples on how to use these controls, please visit [kirki.org](http://kirki.org/#fields).

In addition you can also automatically generate the CSS for a lot of controls and have it added to the head of your document without writing any custom functions and code for that. [Learn more about automatic output of CSS here](http://kirki.org/#output)

== Installation ==

Just install this plugin and activate it.
For configuration instructions please visit http://kirki.org/#configuration

== 0.6.1 - 2012-02-25, dev time: 1 hours==
* Fix: Sortables controls had a JS conflict
* Fix: Switches & Toggles were not properly working

== 0.6.0 - 2012-02-25, dev time: 9 hours==
* Fix: Tooltips now properly working
* New: Added checkbox switches
* New: Added checkbox toggles
* Fix: Generated CSS is not properly combined & minified
* Fix: Re-structuring files hierarchy
* Fix: Simplify the way controls are loaded
* New: Only load control classes when they are needed
* New: Introducing Kirki_Customize_Control class
* Fix: CSS tweaks
* New: Sortable control (creating one is identical to a select control, but with `'type' => 'sortable'`)
* Fix: Double output CSS (props @agusmu)
* New: Google fonts now parsed from a json file.

== 0.5.1 ==
* Fix: Transport defaults to refresh instead of postMessage
* Fix: undefined index notice.

== 0.5 ==
* New: Automatic output of styles for generic controls.
* New: Automatic output of styles + scripts for fonts (including googlefonts )
* New: The 'output' argument on background controls is now an array for consistency with other controls. Older syntax is still compatible though. :)
* New: Add the ability to auto-generate styles for colors.
* Fix: Add a blank stylesheet if we need one and no stylesheet_id has been defined in the config options.
* Fix: CSS-only tooltips. Fixes issue with tooltips now showing up on WP >= 4.1
* Fix: Code cleanups
* New: Added support for WordPress's transport arguments
* Fix: All controls now have a sanitization callback. Users can override the default sanitizations by adding their own 'sanitize_callback' argument.
* Fix: OOP rewrite
* Fix: Strip protocol from Google API link
* Fix: Loading order for some files
* Fix: Removed deprecated less_var argument

= 0.4 =
* Fix: bugfix for selector
* New: Change the Kirki theme based on which admin theme is selected.
* Fix: Tranlsation domain issue
* New: Added a "group_title" control
* Fix: Updated the required script
* Fix: Updating CSS
* Other minor improvements and bugfixes

= 0.3 =
* new: added background field
* new: added 'output' argument to directly output the CSS

= 0.2 =
* Initial version
