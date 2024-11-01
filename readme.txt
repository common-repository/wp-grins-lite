=== WP Grins Lite ===
Tags: clickable, smilies, comments, admin, wpgrins
Contributors: alexkingorg,ronalfy
Requires at least: 2.85
Tested up to: 3.0
Stable tag: trunk
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=9189995

WP Grins Lite provides smilies for your comment area.

== Description ==

WP Grins Lite will provide clickable smilies for both the post form in the admin interface and the comments form of your blog.  WP Grins Lite uses the lighter footprint of the jQuery library.

== Installation ==

1. Download the plugin archive and expand it (you've likely already done this).
2. Put the 'wp-grins-lite' folder into your wp-content/plugins/ directory.
3. Go to the Plugins page in your WordPress Administration area and click 'Activate' for WP Grins.

== Changelog ==
= 1.1 = 
* Released 04 November 2009 by Ronalfy
* Fixed bug where grins would show up in the comments panel.
* Re-did the JavaScript to it's completely separate and only runs when necessary.
* Added admin panel option to manual insert smilies on a page or a post.
= 1.0 = 
* Released 25 October 2009 by Ronalfy
* First release.  Yay!

== Screenshots ==

1. WP Grins Lite in action.

== Usage ==

Click on the smilies icons to insert their tags into the text field.


== Frequently Asked Questions ==

= Why don't the smilies show up in my comments form? =

Your theme must include the `wp_head` call and the comments field in your theme must have an id of `comment`;
