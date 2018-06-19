=== 410 for WordPress ===
Contributors: solarissmoke
Tags: error, gone, robots
Requires at least: 3.7
Tested up to: 4.9
Stable tag: trunk

A plugin that sends HTTP 410 (Gone) responses to requests for articles that no longer exist on your blog.

== Description ==

This plugin will issue a HTTP `410` response to requests for articles that no longer exist on your blog. When you delete a post or page, it records the URL for that page and issues a `410` response when that URL is requested. You can also manually manage the list of obsolete URLs.

The [HTTP Specification](http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html#sec10.4.11) defines the `410` response header for use when a resource has been permanently removed. It informs robots visiting your site that the requested content has gone, and that they should stop trying to access it.

If you come across any bugs or have suggestions, please use the plugin support forum. I can't fix it if I don't know it's broken! Please check the [FAQ](http://wordpress.org/extend/plugins/wp-410/faq/) for common issues.

== Frequently Asked Questions ==

= Can I customise the 410 response message? =

The default message is a simple plain text message that reads "Sorry, the page you requested has been permanently removed." This is because many people want to minimise the bandwidth that is used by error responses.

If you want to customise the message, just place a template file called `410.php` in your theme folder, and the plugin will automatically use that instead. Take a look at your theme's `404.php` file to see how the template needs to be structured. You can also hook into the `wp_410_response` action to trigger any specific events for queries resulting in a 410 response.

= Will this plugin work if a caching/performance plugin is active ? =

The plugin has been tested with the following caching plugins, and should work even if they are active:

- W3 Total Cache
- WP Super Cache

I have not tested it with other caching plugins, and there is a high chance that it **will not work** with many of them. Most of them will cache the response as if it is a 404 (page not found) response, and issue a 404 response header instead of a 410 response header.

== Changelog ==

= 0.8.6 =
* Don't rely on WordPress to correctly report whether the site is using SSL.

= 0.8.5 =
* Fix admin form CSRF checking.

= 0.8.4 =
* Add CSRF validation to settings page.

= 0.8.3 =
* Fix magic quotes handling on settings page.

= 0.8.2 =
* Overhaul settings page UI.
* Add option to specify how many 404 errors to keep.

= 0.8.1 =
* Add select all helpers to 410/404 lists.

= 0.8 =
* Don't automatically add links to the list when posts are deleted (most deletions are drafts).

= 0.7.2 =
* Add support for popular caching plugins (W3 Total Cache and WP Super Cache).

= 0.7.1 =
* Database tweaks (change ID to unsigned MEDIUMINT)

= 0.7 =
* Added logging of 404 errors so they can be easily added to the list of obsolete URLs.

= 0.6.1 =
* Bugfix: don't accept URLs that don't resolve to WordPress
* Warn about invalid URLs when permalink settings change

= 0.6 =
* Moved storage of old URLs from the Options API to the database, to avoid issues with long lists.

= 0.5 =
* Added the option to use your own template to display the 410 response. Just add a file called `410.php` to your theme folder.

= 0.4 =
* Bugfix: With batch deletes, only the first item being deleted was noted by the plugin

= 0.3 =
* Bugfix: URLs containing non-ascii characters were not always recognised
* Bugfix: URLs were displayed in encoded form on the settings page
* Added a `wp_410_response` action to allow users to customise the response message when a deleted article is requested

= 0.2 =
* Added wildcard support to URLs
* Bugfix: don't check URLs of deleted revisions and new draft posts

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The plugin settings can be accessed via the 'Plugins' menu in the administration area
