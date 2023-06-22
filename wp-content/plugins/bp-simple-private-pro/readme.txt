=== BP Simple Private Pro ===
Contributors: shanebp
Donate link: https://www.philopress.com/donate/
Tags: buddypress, private, privacy
Author: PhiloPress
Author URI: https://philopress.com/
Plugin URI: https://philopress.com/
Requires at least: 4.0
Tested up to: 5.4
Stable tag: 3.1
Copyright (C) 2016-2021 shanebp, PhiloPress

A simple Private Content settings plugin for BuddyPress or the BuddyBoss Platform. This is the Pro version.

== Description ==

This plugin allows administrators to select whether posts, pages and BuddyPress sections and bbPress can be viewed by non-logged-in users.

Your front page or home page will always be Public.

If a user is logged in - this plugin will have no effect on them.

It:
* provides a Settings screen in wp-admin: Settings > BP Simple Private
* will redirect non-logged-in users trying to access private content to the URL entered in Settings or to home page
* provides a Private checkbox in the upper right corner of every page, post, and custom post type selected in Settings
* allows an admin to select which post types and BuddyPress Components are Private
* provides an option to disable BuddyPress RSS Feeds if the visitor is not logged in


It does have multi-site support - if both this plugin and BuddyPress are network-activated.

For more  plugins, please visit https://www.philopress.com/

== Installation ==

1. Unzip and then upload the 'bp-simple-private-pro' folder to the '/wp-content/plugins/' directory

2. Activate the plugin through the 'Plugins' menu in WordPress
If you have the BP Simple Private plugin installed, make sure you deactivate it first! Your current settings will not change.

3. Go to Settings -> BP Simple Private. Enter your License Key and select your options.
Individual pages and posts can be set to Private via a Private checkbox in the upper right corner of every page, post, and custom post type.
In Gutenberg, the checkbox will appear at the bottom of the right column.


== Frequently Asked Questions ==

= MultiSite support? =

Yes - if both this plugin and BuddyPress are network-activated.


== Changelog ==

= 3.1 =
* Tested in WP 5.4
* bp_current_component() can return empty for some custom components, so this release also check the bp-uri

= 3.0 =
* Tested in 5.0 and Gutenberg

= 2.1 =
* bug - Site-Wide options for Post Types were not saving - Fixed

= 2.0 =
* add License Key and automatic Update Notices

= 1.2 =
* add disable RSS option

= 1.1 =
* add multisite support

= 1.0 =
* Initial release.


== Upgrade Notice ==

= 3.1 =
* Tested in WP 5.4
* bp_current_component() can return empty for some custom components, so this release also check the bp-uri

= 3.0 =
* Tested in 5.0 and Gutenberg

= 2.1 =
* bug - Site-Wide options for Post Types were not saving - Fixed

= 2.0 =
* add License Key and automatic Update Notices

= 1.2 =
* add disable RSS option

= 1.1 =
* add multisite support

= 1.0 =

