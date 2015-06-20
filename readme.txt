=== Kirki ===
Contributors: aristath, fovoc
Tags: customizer, options framework, theme, mods, toolkit
Donate link: http://kirki.org/
Requires at least: 4.0
Tested up to: 4.2
Stable tag: 0.8.4
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
* Select2

For documentation and examples on how to use these controls, please visit the [Kirki Wiki on Github](https://github.com/aristath/kirki/wiki).


== Installation ==

**Method 1: Use as a plugin**
From your dashboard go to Plugins => Add New.
Search for "Kirki" and install it.
Once you install it, activate it.
For configuration instructions please visit the [Kirki Wiki on Github](https://github.com/aristath/kirki/wiki).

**Method 2: Embed in your theme**
Please visit https://github.com/aristath/kirki/wiki/Embedding-in-a-theme for documentation and instructions.

== Sample Theme ==

To get an idea on how to include Kirki in your next project, a [sample theme](https://github.com/aristath/kirki/wiki/Sample-Theme-with-Kirki) has been created.

== Changelog ==

= 1.0.0-beta1 =

* NEW: Added a new API. See https://github.com/aristath/kirki/wiki for documentation.
* NEW: Minimum PHP requirement is now PHP 5.2
* NEW: Added a Select2 field type.
* NEW: Introducing the Kirki::get_option() method to get values.
* NEW: added 'prefix' and 'suffix' arguments to output. See https://github.com/aristath/kirki/issues/200#issuecomment-95994419
* NEW: Added ability to get variables for CSS preprocessors from the customizer values
* NEW: $units to all outputs to support '!important'
* NEW: Ability to create panels & sections using the new API.
* NEW: added a get_posts method to the Kirki class.
* NEW: Implement width argument in the styling options. See https://github.com/aristath/kirki/wiki/Styling-the-Customizer
* NEW: add kirki/control_types filter
* FIX: avoid errors when Color is undefined
* FIX: Use WP_Filesystem to get the google fonts array from a json file
* FIX: Radio-Button styling
* FIX: PHP Notices
* FIX: Typos
* FIX: Properly sanitising rgba colors
* FIX: Properly sanitize numbers
* FIX: Make sure all variables are escaped on output
* TWEAK: allow using serialized options.
* TWEAK: Use active_callback for required arguments instead of custom JS
* TWEAK: Adding some more inline docs
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
