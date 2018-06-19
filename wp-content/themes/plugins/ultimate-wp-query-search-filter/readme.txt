=== Ultimate WP Query Search Filter ===
Contributors: TC.K
Donate link: http://9-sec.com/donation/
Tags: Search Filter, taxonoy, custom post type, custom meta field, taxonomy & meta field filter, advanced search, Ajax, search engine
Requires at least: 3.5
Tested up to: 4.2.2
Stable tag: 1.0.10
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Ultimate WP Query Search Filter lets you filter searches through post types, taxonomies and meta fields. Results displayed via search template or Ajax.

== Description ==

Ultimate WP Query Search Filter is a powerful search engine that lets your users perform more precise searches by filtering the search through post types, taxonomies and meta fields. The search result can be displayed either through the theme search template or an Ajax call.

**Plugin Features:**

* Admins are free to choose whether the search filters post type, taxonomy, meta field or even all three.
* Multiple search forms supported.
* Free to choose either theme search template or Ajax call to display the result for each of the search forms.
* Search forms support checkbox, radio and select fields.
* Plugin extendable with hooks.
* The search form can be displayed via shortcode.


If you have any problems with the current plugin, please leave a message via support forum post or go [Here](http://9-sec.com/support-forum/) to visit the 9-SEC forum.


== Installation ==

1. Upload `ultimate-wp-query-search-filter` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Create your search form in the Ultimate WPQSF menu.
4. Using `[ULWPQSF id={form id}]` to display the form. 

== Frequently Asked Questions ==

= How can I styling the search form? =

You can simply refer the themes/default.css within the plugin folder and alter it or override it at your theme's CSS file.

= What if I want to display the search form in my template? =

Put this into your template:
<?php echo do_shortcode("[ULWPQSF id={form id}"); ?>

= What if I want to display the search form in a sidebar widget? =

Just insert the shortcodes like you would in the post content. eg. `[ULWPQSF id=3299]`

= What if I want to display the search form in a tempate? =
From version 1.0.4 you can use `get_uwpqdf_form()` to display the form in template. You have to insert aleast the form id attribute to the function. Eg. `$arg=array('id'=>102); echo get_uwpqsf_form($arg);`. Other attributes supported includes 'button','formtitle' and 'divclass', just like the shortcodes does.

= What is the 'button' parameter? How is it used? =
The 'button' parameter is used to display/hide the search button. NOTE that this parameter is applied to AJAX SEARCH only and once you hide the button, it will automatically update the result when a change is made in the search form. To hide the button, simply add 'button=0' to the shortcode. eg. `[ULWPQSF id=3299 button=0]`

= What is the 'divclass' parameter? How is it used? =
The 'divclass' is used to add your own class to the front-end search form. This class will be applied to each filter (taxonomy or meta field) and then you can use it for customize the design etc. To use the parameter, just simply add 'divclass' to the shortcode. eg. `[ULWPQSF id=3299 divclass=my_own_class]`

= What if I don't want to display the title of the search form? =
Just set the `formtitle` attribute to 0 in the shortcode eg. `[ULWPQSF id=3299 formtitle="0"]`

= I want to put the string search input box on the top of the search form =
Frist, you need to enable the string search at the form setting page, then on the shortcode add `text_position="top"`. Eg. `[ULWPQSF id=3299 text_position="top"]`.

= How can I customize the plugin? =

Visit this [website](http://9-sec.com/) to get the details.

For more Info or Documentation please visit [here](http://9-sec.com/2014/01/ultimate-wp-query-search-filter/).

== Screenshots ==
1. Ultimate WP Query Search Filter setting page 1
2. Ultimate WP Query Search Filter setting page 2
2. Ultimate WP Query Search Filter setting page 3
4. Ultimate WP Query Search Filter setting page 4
5. Ultimate WP Query Search Filter search form in the content and sidebar


== Changelog ==


= 1.0.0 =
* First version released.

= 1.0.2 =
* Fixed header message sent error.

= 1.0.3 =
* Fixed undefined warning on ajax call resutl.
* Refined some hooks.
* Thanks Christopher for helping me refined the description.

= 1.0.4 =
* Fixed some bugs and add new functions to call the search form and pagination

= 1.0.5 =
* Fixed orderby bug

= 1.0.6 =
* Add exclude terms panel
* Add parameter to taxonomy arguments. 

= 1.0.7 =
* Fixed minor issue
* Defualt template form input memory

= 1.0.8 =
* Fixed search form html issue
* Add new parameter to shortcode to show text input box on top or bottom
* Disabled input when submit on Ajax search

= 1.0.9 =
* Add WPML compatibility

= 1.0.10 =
* Fix frontend js error for multiple form with same ID
