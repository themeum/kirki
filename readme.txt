=== Kirki ===
Contributors: aristath, fovoc
Donate link: http://kirki.org
Tags: customizer
Requires at least: 3.8
Tested up to: 4.0
Stable tag: 0.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tired of all the bloated options frameworks? You can use the WordPress Customizer instead, and extend it using Kirki!

== Description ==

For documentation and examples please visit [kirki.org](http://kirki.org).

== Installation ==

Just install this plugin and activate it.
For configuration instructions please visit http://kirki.org/#configuration

== Changelog ==

= HEAD =
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
