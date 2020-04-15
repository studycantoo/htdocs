=== Zoom Video Conferencing on WordPress ===
Contributors: j__3rk, digamberpradhan, adeelraza_786hotmailcom
Tags: zoom video conference, video conference, zoom, zoom video conferencing, web conferencing, online meetings
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=HUVV5Y7MU8E9Y&source=url
Requires at least: 4.9
Tested up to: 5.2.4
Stable tag: 3.0.0
Requires PHP: 5.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives you the power to conduct Zoom Meetings directly on WordPress, check reports and create users from your WordPress dashboard.

== Description ==

This is an extended version of Video Conferencing with Zoom API, a simple plugin which gives you the extensive functionality to manage zoom meetings, users, reports from WordPress. Zoom meetings can be directly conducted on your WordPress site using a simple shortocde. Users can now paginate through meetings and select users to view each users meetings. However, still webinar module is not integrated.

**Few Features:**

1. Manage Meetings
2. List/Add Users
3. Clean and Friendly UI
4. Shortcodes
5. Daily and Account Reports
6. Directly conduct zoom meeting on your site using a simple shortcode

**Limitations**

* Webinar module not integrated

**Use shortcode**

* [zoom_api_link meeting_id="zoom_meeting_id" class="your_class" id="your_id" title="Text with Zoom Window"] -> You can show the link of your meeting in your site anywhere using the shortcode. Replace your zoom meeting id in place of "zoom_meeting_id".

* Or add from icon in classic editor. Not integrated for gutenberg !

**Find a Short Documentation or Guide on how to setup: [Here](elearningevolve.com/products/wordpress-zoom-addon "Documentation")**

**Using Action Hooks**

* 1. zvc_after_create_meeting( $meeting_id, $host_id, $meeting_time ) *
Hook this method in your functions.php file in order to run a custom script after a meeting has been created.

* 2. zvc_after_update_meeting( $meeting_id, $host_id, $meeting_time ) *
Hook this method in your functions.php file in order to run a custom script after a meeting has been updated.

* 3. zvc_after_create_user( $created_id, $created_email ) *
Hook this method in your functions.php file in order to run a custom script after a user is created.

**Please consider giving a [5 star thumbs up](elearningevolve.com/products/wordpress-zoom-addon "5 star thumbs up") if you found this useful.**

Any additional features, suggestions related to translations you can contact me via [email](elearningevolve.com/products/contact "Adeel Raza").

== Installation ==
Search for the plugin -> add new dialog and click install, or download and extract the plugin, and copy the the Zoom plugin folder into your wp-content/plugins directory and activate.

== Frequently Asked Questions ==
= How to show Zoom Meetings on Front =

* By using shortcode like [zoom_api_link meeting_id="zoom_meeting_id" class="your_class" id="your_id" title="Text with Zoom Window"] you can show the link of your meeting in front.

== Screenshots ==
1. Meetings Listings. Select a User in order to list meetings for that user.
2. Add a Meeting.
3. Add Meeting into a post using tinymce shortcode button.
4. Users List Screen. Flush cache to clear the cache of users.
5. Reports Section.

== Changelog ==

= 3.0.0 =
Added: Support for conducting zoom meetings on your WordPress site using shortcode
Added: Countdown if the meeting has not started yet.
Added: Option to End the meeting from WP backend so that users visiting after the meeting end are shown appropriate message.
Fixed: Empty field values after adding meeting.
Fixed: Incorrect GMT timezone values field on meeting page
Fixed: Warning on add meeting page for incorrect default form values

= 2.2.3 =
Fixed: API access token time increased by 1 hour

= 2.2.3 =
Added: Validation issue fixed
Fixed: Added vanity URL functionality in settings
Fixed: Minor users API bug fixes

= 2.2.2 =
Added: UI changes
Fixed: Validation Issues fixed
Fixed: Minor bug fixes

= 2.2.1 =
Fixed: CURL Request fail fixed

= 2.2.0 =
* Removed: API version 1 support. Added to deprecated library.
* Added: New options when adding meetings
* Added: Classic editor meeting link add icon
* Fix: Changed API call implementation to fit WordPress standards
* Fix: Major bug fixes

= 2.1.3 =
* Minor Changes

= 2.1.2 =
* Minor Changes
* Timezone Settings Changes

= 2.1.1 =
* Minor Changes

= 2.1.0 =
* API version 2 added.
* Major fixes
* Major breaking changes in this version.
* Added: Assign Host ID manually section for Developers

= 2.0.5 =
* Minor Changes

= 2.0.4 =
* Minor Change

= 2.0.3 =
* WordPress 4.8 Compatible

= 2.0.1 =
* Added: Translation Error Fixed
* Added: French Translation
* Added: 3 new hooks see under "Using Action Hook" in description page.

= 2.0.0 =
* Added: Datatables in order to view all listings
* Added: New shortcode button in tinymce section
* Added: Bulk delete
* Added: Redesigned Zoom Meetings section where meetings can be viewed based on users.
* Added: Redesigned add meetings section with alot of bug fixes and attractive UI.
* Changed: Easy datepicker
* Changed: Removed editing of users capability. Maybe in future again ?
* Removed: Single link shortcode ( [zoom_api_video_uri] )
* Bug Fix: Reports section causing to define error when viewing available reports
* Bug Fix: Error on reload after creating a meeting
* Bug Fix: Unknown error when trying to connect with api keys ( Rare Case )
* Changed: Total codebase of the plugin.
* Fixed: Few security issues such as no nonce validations.
* Alot of Major Bug Fixes but no breaking change except for a removed shortcode

= 1.3.1 =
* Minor Bug Fixes

= 1.3.0 =
* Added Pagination to meetings list
* Hidden API token fields
* Fixed various bugs and flaws

= 1.2.4 =
* WordPress 4.6 Compatible

= 1.2.3 =
* Validation Errors Added
* Minor Bug Fixes

= 1.2.2 =
* Minor Functions Change

= 1.2.1 =
* Bug Fixes
* Major Bug fix on problem when adding users
* Removed only system users on users adding section
* Added a shortcode which will print out zoom video link. [zoom_api_video_uri]

= 1.2.0 =
* Various Bug Fixes
* Validation Errors Fixed
* Translation Ready

= 1.1.1 =
* Increased Add Meeting Refresh time interval to 5 seconds.

= 1.1 =
* Added Reports
* Minor Bug fixes and Changes

= 1.0.2 =
* Minor Changes

= 1.0.1 =
* Minor UI Changes
* Removed the unecessary dropdown in Meeting Type since only Scheduled Meetings are allowed to be created.
* Added CSS Editor in Settings Page
* Alot of Minor Bug Fixes

= 1.0.0 =
* Initial Release

== Upgrade Notice ==

= 2.2.0 =
This is a major release. Please check you if you have any customization related to this plugin before upgrading.

= 2.1.0 =
This is a major release. Please check you if you have any customization related to this plugin before upgrading.

= 2.0.0 =
This is a major release. Kindly request to upgrade for better performance and lots of bug fixes.

= 1.2.3 =
Validation Errors Added

= 1.2.0 =
Crucial Security Patches