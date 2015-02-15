=== WP Error Fix ===
Contributors: vasyl_m
Tags: wordpress error, error track, development tool, fix, hotfix, plugin, error fix, common errors
Requires at least: 3.0.1
Tested up to: 3.8.1
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Tracks WordPress errors related to Plugins, Themes and Core and provide Fixes.

== Description ==

WP Error Fix tracks all types of errors on your WordPress website by giving the
complete report in easy-to-read format.

WP Error Fix records all Errors, Warnings and Notices and prepares next
possible visual reports:

* Linear Graph of total number of Errors, Warnings and Notices grouped by Date;
* Pie Graph of negative impact that each plugin or theme has on your blog;
* Interactive list of errors for debugging purposes.

WP Error Fix is a good tool to use during development or daily maintenance purposes.

== Installation ==

1. Upload `wp-error-fix` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. And you are ready to go.

== Frequently Asked Questions ==

= Registration Failed =

Please make sure that you have Internet Access and the website <a href="http://phpsnapshot.com">PHP Snapshot</a> is accessible.
Ok. Now please verify that your website has not trouble to send <a href="http://codex.wordpress.org/Function_API/wp_remote_request">remote request</a>.

= How can I suppress errors on my website? =

Please go to Admin Dashboard and navigate to the Error Fix menu and see the answer 
in Info section.

== Screenshots ==

1. Linear Graph of errors
2. Pie Graph of plugin's system impact
3. List of errors in table format

== Changelog ==

= 2.0 =
* Moved plugin to technical support concept

= 1.7 = 
* Fixed issue with dashboard over SSL
* Fixed PHPSnapshot bug with failed storage retrieve
* Updated Rate Us URL
* Added Preferences page
* Added Email notification functionality
* Fixed issue with PHP Core bug related to _destruct call on fatal error

= 1.6 =
* Moved logs to wp_errorlog dir. Based on Anderton feedback
* Renamed the main class
* Fixed the issue with SSL Dashboard (thank you moxojo)
* Added payment functionality
* Improved Patching mechanism
* Added custom dialog feature

= 1.5 =
* Fixed issue with Ajax failed calls. Show an error message
* Fixed CSS issue with minor actions for Chrome
* Fixed issue with not writable log and cache directories
* Added Error Status tooltip with explanation

= 1.4 =
* Removed deprecated functionality
* Fixed issue with hardcoded bootstrap path
* Added Rate Me button
* Fixed patching mechanism
* Improved (optimized) reporting mechanism
* Added internal caching mechanism for storage & queue objects
* Added additional check if content folder is writable

= 1.3 =
* Fixed Bug Report #81447
* Removed the Send Message screen
* Changed Control Panel UI
* Simplified the About section

= 1.0 =
* Initial version