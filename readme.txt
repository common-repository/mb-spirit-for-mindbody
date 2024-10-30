=== MB Spirit for MINDBODY ===
Contributors: yogaboy
Tags: MINDBODY, API, schedule, classes, staff, events, appointments, calendar, courses
Requires at least: 6.0.0
Tested up to: 6.3.2
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Connect your MB Spirit account with WordPress for easy integration of your MINDBODY account information and enhance SEO support.

== Description ==
MB Spirit allows you to easily integrate your MINDBODY information into your web site. Using the MB Spirit Dashboard, you
can create any number of custom widgets to display MINDBODY elements including:

*   Class Schedules
*   Events, Workshops and Retreats
*   Events, Workshops and Retreats - Calendar View
*   Staff/Instructor Details
*   Class Descriptions
*   Session Types
*   Products and Service
*   Appointments
*   Appointments (Advanced)

You use the MB Spirit WordPress plugin to select your MB Spirit widgets and insert them into pages and posts. 

You can also customize your MB Spirit shortcodes to apply data filters, and adjust the layout for individual pages.

Enable MB Spirit SEO Optimization and allow search engines to index your MINDBODY content, increasing organic traffic to your site.
Our powerful caching technology ensures your MINDBODY content will load just as fast as the rest of your web content. Eliminating
slow page loads enhances your SEO activities (Google loves fast loading content).

Along with your MB Spirit account, this plugin allows you to quickly and flexibly integrate and enhance the
content from your MINDBODY account. Our layouts look awesome out of the box, but if you are a designer, you can apply your own styling to 
MB Spirit widgets.

Easy to get started, powerful features.

Features:

*   Test mode allows you to try MB Spirit integration without impacting your web site's content
*   Works with all WordPress themes
*   Quick setup -- specify your schedule, event list, staff list, and class description pages and identify a pre-set widget to use for each.
*   Create your MINDBODY widgets using the MB Spirit dashboard widget builder and easily add shortcodes to your WordPress pages and posts 
	(you can even override your widgets with new parameters within WordPress)
*   Inject shortcodes into any page of your web site and add filters to give finer control of contents
*   Schedule widgets let you do custom and dynamic filtering of classes
*   Add MB Spirit widgets into your site through the WordPress widgets dashboard under the appearance settings
*   WPML ready content lets you present your information in as many languages as you like
*   MB Spirit allows you to extend your MINDBODY content to add more images and details, with slicker layouts than are capable with MINDBODY
*   Refresh your content from inside WordPress
*   Connect to MB Spirit for registration by allowing users to sign in to their MINDBODY studio client account
*   Dashboard widget shows you information and tips for getting the most out of your MB Spirit service

== Installation ==
1. Download and unzip this plugin
2. Upload the "mb-spirit" folder to your site's /wp-content/plugins/ directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Under WP Admin MB Spirit menu, select Settings and begin the process to register or authorize your site
5. Test that the connection is correct and review a summary schedule to see that the information is correct

== Frequently Asked Questions ==
= How to I connect my MINDBODY account? =

MB Spirit uses a performance-enhancing service to gather your MINDBODY information and prepare it for this plugin. You must 
have an account with BOTH MINDBODY and MB Spirit to use this plugin. If you already have a MB Spirit
account, simply enter your account information under MB Spirit Settings.

If you do not have an MB Spirit account, you need to register at https://mb-spirit.com. Start with a
free trial with access to a demo account. This account will allow you to test MB Spirit and
confirm the integration before signing up.

When you are ready to integrate your data, you  authorize your MINDBODY account with MB Spirit. Once this is
done you will have access to your MINDBODY content. WordPress will pre-fetch its content from MB Spirit ensuring fast
reliable data. MB Spirit users a powerful caching technology to render MINDBODY content instantly on your site.

= Is there a cost to use MB Spirit? =

In addition to your MINDBODY account, you are registering your site with our API service (MB Spirit). 
MINDBODY charges us on a monthly basis to provide this service to you. When you are using MB Spirit in the
demo mode during the trial, there are no charges. Once you have authorized your MINDBODY account to get your
own data, these charges begin. We pay these charges on your behalf and charge you for use of the MB Spirit
service. MB Spirit currently charges $20USD per location per month to provide the full service.

= I don't like the options for presenting my content. Is there a way to improve it? =

You can create your own custom widget presentations and choose options to control filtering and grouping of results.
If you don't see the options you need, let us know! We'll likely build it for you.

If you are savvy with programming in WordPress there are a number of filter hooks within the plugin that you can
use to manipulate the content or to completely build the content from raw data received from the API service.
Documentation of these filters is available at the MB Spirit web site (https://mb-spirit.com/filters-wordpress-plugin)
Please contact us for questions or support with this feature.

= I have a multilingual site. How do I translate my content? =

We are WPML friendly and have routines to manage addition of new languages. We are always happy to integrate 
new languages to our core, so feel free to obtain templates for translation and  contribute your translation 
files to us at:
https://mb-spirit.com/dashboard/translate

While much of the interface can be internationalized, we do not have the facility yet to provide multilingual
support for translations of your descriptions. Please indicate your enthusiasm for this enhancement by
contacting us directly.

== Screenshots ==

1. Settings Manager
2. Media Icon to add shortcodes to any page or post
3. Widget Selector view
4. Widget customization options with preview of widget presentation
5. Shortcode format - additional settings can be added here and you can also adjust the layout if you used an open shortcode tag
6. Rendered class schedule from injected shortcode
7. Example of schedule presentation within a different web site design
8. Rendered event listing from injected shortcode
9. Example of event listing within a different web site design
10. MB Spirit dashboard with quick access to widget code and analytics
11. MB Spirit dashboard widget builder with additional options for content elements and layout
12. MB Spirit dashboard widget preview


== Changelog ==

= 1.1.0 =
* Add Gutenberg block support
* Add Elementor editor support (classic WYSIWYG editor)
* Add hooks for overriding shortcode attributes and request parameters
* Support ACF customization of shortcodes using the separate MB Spirit for ACF plugin
* Stability improvements and better presentation in dashboard
* Fix/improve the shortcode builder interface to work with most WP installations

= 1.0.22 =
* identify and resolve issues with offsets and filter actions

= 1.0.21 =
* remove deprecated create_function in widget load

= 1.0.20 =
* Correction to version number

= 1.0.19 =
* Invalidated

= 1.0.18 =
* Add ability to revert to Classic Editor until support for the Gutenberg editor is completed (expected October 2022)

= 1.0.17 =
* Update compatibility with WordPress 5.8.1

= 1.0.16 =
* Update compatibility with WordPress 5.6.1

= 1.0.15 =
* Update compatibility with WordPress 4.9.8

= 1.0.14 =
* Patch for undefined key warning in PHP variables

= 1.0.13 =
* Revised patch for cURL issue with cache headers

= 1.0.12 =
* Patch for cURL issue with cache headers

= 1.0.11 =
* Add register and buy now links (direct to MINDBODY) within page/post editor links search
* Extend ability to insert page lists from externally loaded content
* Add future ability to inject widget content into pages or create and populate new pages
* Add filter for shortcode attributes to allow global override of shortcode settings
* Add cache control directive to prevent data refresh being triggered on API calls

= 1.0.10 =
* Fix bug with AJAX hooks for shortcode callbacks and registration process
* Correction to notification messages

= 1.0.9 =
* Enhanced registration system for new and existing MB Spirit clients
* Handle errors thrown from API calls within system checks
* Improve dismissal of notices and add notice option for various critical states
* Correction to uninstall methods to ensure proper cleanup of plugin options

= 1.0.8 =
* Added persistence to dismissing non-critical WordPress notices

= 1.0.7 =
* Added check on widget shortcode to provide debugging information visually if the widget for the shortcode isn't found
* Added WordPress notifications as push from MB Spirit for critical warnings and messages

= 1.0.6 =
* Resolve issues with embed options for shortcodes (some content not being parsed correctly)
* Allow embed option to prevent callback to MB Spirit (prevents JavaScript load refresh of content)

= 1.0.5 =
* Test against WordPress 4.5.2
* Add redirect to settings on activation and add settings link to plugins page
* Change removal of settings to the uninstall hook instead of the deactivation hook to preserve settings if just disabled  

= 1.0.4 =
* Allow Emoji scripts added in WordPress 4.2 to be disabled for better rendering of arrows in date navigators

= 1.0.3 =
* Enable MB Spirit registration from inside WordPress
* Enhancements to shortcode builder to apply date ranges

= 1.0.2 =
* Updated version to match new release version

= 1.0.1 =
* Fixed bug with WPLANG (deprecated), using get_locale() instead to check language
