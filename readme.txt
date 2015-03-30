=== Kirki ===
Contributors: aristath, fovoc
Tags: customizer, options famework, theme mods
Donate link: http://kirki.org/
Requires at least: 4.0
Tested up to: 4.1.1
Stable tag: 0.8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tired of all the bloated options frameworks? You can use the WordPress Customizer instead, and extend it using Kirki!


== Description ==
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


== Installation ==
From your dashboarad go to Plugins => Add New.
Search for \"Kirki\" and install it.
Once you isntall it, activate it.
For configuration instructions please visit http://kirki.org/#configuration


== Changelog ==

== 0.8.1 ==

March 30, 2014, dev time: 30 minutes

* Fix: Translation strings now overridable using the config filter.

== 0.8.0 ==

March 30, 2014, dev time: 32 hours

* Improvement: OOP redesign (props @vpratfr)
* New: Added Palette control
* New: Added Editor control (WYSIWYG - uses TinyMCE)
* New: Added Custom control (free html)
* New: Added a Kirki_Colourlovers class to use palettes from the colourlovers API
* New: Added a composer file (props @vpratfr)
* Fix: Wrong settings IDs
* Fix: Color calculation on RGBA functions were off
* Tweak: Restructuring the plugin (props @vpratfr)
* New: added a functional kirki_get_option() function
* Tweak: Simplified configuration options.
* New: Turn Kirki into a singleton and a facade (props @vpratfr)
* Tweak: Completely re-written the customizer styles
* New: Using SASS for customizer styles
* Tweak: Deprecating the group_title control in favor of the new custom control
* Tweak: Changed the CSS for checkboxes

== 0.7.1 ==

March 15, 2014, dev time: 2 hours

* Removed: Remove the `kirki_get_option` function that was introduced in 0.7 as it's not working properly yet.
* Fix: Undefined index notice when a default value for the control was not defined
* Tweak: `logo_image` now injects an `img` element instead of a `div` with custom background
* New: Added `description` argument in the kirki configuration (replaces the theme description)

== 0.7 ==

March 14, 2014, dev time: 10 hours

* Fix: Array to string conversion that happened conditionally when used with googlefonts. (props @groucho75)
* Fix: Background opacity affects background-position of bg image
* Fix: font-weight not being applied on google fonts
* New: Added `kirki_get_option( $setting );` function that also gets default values
* Tweak: Singleton for main plugin class
* Fix: Prevent empty help tooltips
* New: Added `toggle` control
* New: Added `switch` control
* Fix: Color controls were not being reset to default:
* Tweak: Tooltips now loaded via jQuery
* Tweak: Renamed `setting` to settings for consistency with WordPress core
* Tweak: Renamed `description` to `help` and `subtitle` to `description for consistency with WordPress core
* Tweak: Backwards-compatibility improvements
* New: Allow hiding background control elements by not including default values for them
* Tweak: Performance improvements
* Tweak: Using WordPress core controls instead of custom ones when those are available
* Tweak: Separate logic for multiple-type controls that were using the "mode" argument. This has been deprecated in favor of completely separate control types.

== 0.6.2 ==

March 2, 2014, dev time: 3 hours

* Fix: Frontend styles were not properly enqueued (props @dmgawel)
* New: Allow multiple output styles per control defined as an array of arrays.
* Fix: Background control styles
* Fix: Serialise default values for the sortable control. Now you can define default values as an array.
* Fix: Required script
* Fix: \'_opacity\' was added to a lot of controls by mistake. Removed it and wrote a migration script.

== 0.6.1 ==

2014-02-25, dev time: 1 hours

* Fix: Sortables controls had a JS conflict
* Fix: Switches & Toggles were not properly working

== 0.6.0 ==

2014-02-25, dev time: 9 hours

* Fix: Tooltips now properly working
* New: Added checkbox switches
* New: Added checkbox toggles
* Fix: Generated CSS is not properly combined & minified
* Fix: Re-structuring files hierarchy
* Fix: Simplify the way controls are loaded
* New: Only load control classes when they are needed
* New: Introducing Kirki_Customize_Control class
* Fix: CSS tweaks
* New: Sortable control (creating one is identical to a select control, but with `\'type\' => \'sortable\'`)
* Fix: Double output CSS (props @agusmu)
* New: Google fonts now parsed from a json file.

== 0.5.1 ==

* Fix: Transport defaults to refresh instead of postMessage
* Fix: undefined index notice.

== 0.5 ==

* New: Automatic output of styles for generic controls.
* New: Automatic output of styles + scripts for fonts (including googlefonts )
* New: The \'output\' argument on background controls is now an array for consistency with other controls. Older syntax is still compatible though. :)
* New: Add the ability to auto-generate styles for colors.
* Fix: Add a blank stylesheet if we need one and no stylesheet_id has been defined in the config options.
* Fix: CSS-only tooltips. Fixes issue with tooltips now showing up on WP >= 4.1
* Fix: Code cleanups
* New: Added support for WordPress\'s transport arguments
* Fix: All controls now have a sanitization callback. Users can override the default sanitizations by adding their own \'sanitize_callback\' argument.
* Fix: OOP rewrite
* Fix: Strip protocol from Google API link
* Fix: Loading order for some files
* Fix: Removed deprecated less_var argument

= 0.4 =

* Fix: bugfix for selector
* New: Change the Kirki theme based on which admin theme is selected.
* Fix: Tranlsation domain issue
* New: Added a \"group_title\" control
* Fix: Updated the required script
* Fix: Updating CSS
* Other minor improvements and bugfixes

= 0.3 =

* new: added background field
* new: added \'output\' argument to directly output the CSS

= 0.2 =

* Initial version
