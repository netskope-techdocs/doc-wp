=== EazyDocs Pro ===
Contributors: mdjwel, spiderdevs, freemius
Tags: document, docs, documentation, knowledge base, knowledgebase, kb, support, faq, faqs, wiki, helpdesk, table of content, documentation generator, support center
Requires at least: 5.0
Tested up to: 6.1.1
Requires PHP: 7.4
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

EazyDocs assist you in easily creating beautifully designed documentation for your products.

== Description ==

EazyDocs assist you in quickly and easily creating great looking documentation for your products. Site operators can create & manage detailed, hierarchical documentation in the WordPress admin. You get all the power of WordPress to create/add new docs, tags, organize with ordering your documentation. EazyDocs makes browsing and creating advanced documentation easy and user-friendly.

### Author ###
Brought to you by Md Jwel from [spider-themes](https://spider-themes.com)

== Frequently Asked Questions ==

= Does EazyDocs work with any theme? =
Yes, the EazyDocs works with any standard WordPress theme.

= Do I need coding skills to use EazyDocs? =
Absolutely not! EazyDocs is as easy to use, as you can think of.

= Where can I report bugs or contribute to the project? =
To report bugs or to contribute, head-over to the [GitHub repository](https://github.com/spider-themes/eazydocs/issues)

== Installation ==

= Minimum Requirements =

* PHP 7.3 or greater is recommended
* MySQL 5.6 or greater is recommended

You can install the EazyDocs from your WordPress Dashboard or manually upload it through cPanel/FTP.

= OPTION 1: Install the EazyDocs Plugin from WordPress Dashboard =

1. Navigate to Plugins -> Add New.
2. Search for 'EazyDocs' and click on the Install button to install the plugin.
3. Activate the plugin in the Plugins menu.
4. Optional step: configure the plugin in the Admin menu, in EazyDocs -> Settings.

= OPTION 2: Manually Upload Plugin Files =

1. Download the plugin file from the plugin page: eazydocs.zip.
2. Upload the 'eazydocs.zip' file to your '/wp-content/plugins' directory.
2. Unzip the file eazydocs.zip (do not rename the folder).
4. Optional step: configure the plugin in the Admin menu, in EazyDocs -> Settings.

== Screenshots ==

1. Admin UI
2. Documentation on Admin UI builder
3. Docs shortcode UI on frontend
4. Single doc page

== Changelog ==

= v1.4.5 (14 January 2023) =
Tweaked: Doc Assistant design improved (search form, active tab state, etc.)
Tweaked: Improved internal documentation
Updated: Freemius SDK updated to 2.6.2

= v1.4.4 (29 December 2023) =
Fixed: Glossary Tooltip design
Fixed: Analytics views problem 

= v1.4.3 (25 December 2023) =
Fixed: Install and Activate Free version button were not working
Fixed: MultiDocs Elementor widget's design was breaking on the frontend
Fixed: An issue causing restrictions on table functionality from wpDataTables within EazyDocs Pro
Fixed: Doc Assistant Contact Form was not working
Fixed: Undefined function issue which function was called from free plugin
Fixed: Wrong ordering issue solved in the Docs Builder page in the admin dashboard (Was wrong ordering when Add Doc from Frontend)
New: Assistant display location options added in the EazyDocs > Settings > Doc Assistant. Now, you can choose where you want to show the assistant.
Tweaked: Compatibility added with the latest free version of EazyDocs (2.3.7)
Tweaked: The language (.pot) file updated

= v1.4.2 (15 November 2023) =
Tweaked: Code reformatted and file restructured to make it more readable and maintainable
Tweaked: The language (.pot) file updated
Tweaked: Removed some unnecessary or optional codes from the plugin to improve the performance
Tweaked: Made compatible with the latest free version of EazyDocs (2.3.5)
Updated: Freemius SDK updated to 2.6.0

= v1.4.1 (05 November 2023) =
Fixed: A PHP error in the includes/functions.php file
Tweaked: The language (.pot) file updated
Tweaked: The doc assistant in dark mode improved

= v1.4.0 (02 November 2023) =
Tweaked: Styling options for the Glossary Elementor widget
Tweaked: Removed bootstrap dependency from the whole plugin
Fixed: Keywords alignment was not working in the Search Form Elementor widget
Fixed: Contributor list and count was not showing correctly in the Collaborative Docs design of MultiDocs Elementor widget
Fixed: MultiDocs Tab Arrow was showing incorrectly
Fixed: Undefined array key error on the Analytics page in the admin dashboard

= v1.3.9 (21 September 2023) =
New: Tooltip feature added for the Glossary Doc Elementor widget
Updated: Freemius SDK to the latest version 2.5.12
Fixed: feedback_mail function php error
Fixed: Multisite license activation mechanism where it would not include inactive sites in some cases
Fixed: Properly acknowledge the use of the constant WP_SITEURL so that the clone resolution mechanism can work thoroughly in the necessary edge cases

= v1.3.8 (10 September 2023) =
Fixed: Adding contributor function was not working for the Ajax on scroll loaded contributor list
Fixed: Private doc 404 page issue solved
Fixed: Assistance contact form mail issue resolved
Tweaked: Newly added contributors will be added instantly in the contributors list. No need to reload the page to see the newly added contributors.
Tweaked: Glossary Doc Elementor widget design improved
Tweaked: Multi Docs Elementor widget's Flat Tabbed Docs design improved

= v1.3.7 (23 July 2023) =
New: Glossary Doc Elementor widget

= v1.3.6 (17 June 2023) =
New: Embed doc feature added. Now, you can embed any doc in any page/post using the [embed_post] shortcode (https://tinyurl.com/2k3sajt5)
Tweaked: Code optimized to improve the performance
Fixed: Duplicate Docs issue solved

= v1.3.5 (20 April 2023) =
Fixed: PHP Fatal error on Activation the EazyDocs Pro plugin without EazyDocs free plugin
Tweaked: Freemius SDK updated to the latest version 2.5.6

= v1.3.4 (14 April 2023) =
Tweaked: Removed some unnecessary files from the plugin
Tweaked: Compatibility improved with the latest EazyDocs free version

= v1.3.3 (14 March 2023) =
Fixed: PHP error was thrown if Elementor plugin isn't active

= v1.3.2 (14 March 2023) =
Fixed: PHP error on Applying custom content in the Doc sidebar content popup
Fixed: Feedback calculation issue resolved.
Tweaked: Load more contributors asynchronously on scrolling down. Previously, it was loading all the contributors at once.

= v1.3.1 (01 March 2023) =
New: Elementor template library added to import the prebuilt templates (available in the Pro-MAX plan)
Fixed: Freemius license issue
Fixed: PHP error on the Users Feedback page in the admin dashboard
Tweaked: Analytics page design and functionality improved

= v1.3.0 (11 February 2023) =
New: Analytics page added in the admin UI (Unlocked in the Pro-MAX plan)
Fixed: Doc Duplicator issue solved with attachment
Fixed: Editor can access Settings page even if this role not assigned to access the settings page. (Fixed)
Tweaked: Footnotes design improved
Tweaked: Changed the Menu name to EazyDocs Pro
Tweaked: Code structure improved to make it more readable and maintainable
Tweaked: OnePage Doc layouts design improved

= v1.2.2 (29 December 2022) =
New: [reference] shortcode added to show/create Footnotes. Read doc here https://tinyurl.com/2ewlorze (available in Pro-MAX plan)
Fixed: Extended Docs Navigation Layout design issues
Tweaked: Elementor EazyDocs Search widget
Tweaked: OnePage doc design improved
Deleted: Unnecessary files removed

= v1.2.1 (05 December 2022) =
New: Reusable Blocks support added for the OnePage Doc sidebars
Tweaked: Shortcode content type merged with Normal Content in the Doc sidebars. Now, you can put shortcode in the Normal Content box.
Tweaked: Link added for Managing Reusable content from the Doc Sidebar content popup
Tweaked: Adding new Doc by clicking on the Add Doc button is now automatically added to the current Doc's parent category

= v1.2.0 (06 November 2022) =
Notice: Compatibility with EazyDocs 1.3.5 (The EazyDocs Pro 1.2.0 requires EazyDocs 1.3.5 or higher)
New: Bulk Visibility option added for doc Section, Articles (Visibility icon added in the admin UI)
New: Reusable Blocks support added for the Doc sidebars
Deleted: Separate settings file for the EazyDocs Pro (made one single settings file for pro and free)

= v1.1.9 (15 October 2022) =
New: Contributors management system on the Frontend
New: EazyDocs Pro Max plan integrated
Tweaked: Doc Badge styling improved

= v1.1.8 (21 August 2022) =
New: Docs Contribution feature (works on frontend Add Doc, Edit Doc buttons) added to allow other people to contribute the docs.
New: Extended left sidebar layout (choose it from EazyDocs > Settings > Doc Single > Left Sidebar).
New: Full Screen OnePage Doc layout added.
New: Article Badge feature added.
New: User Feedbacks database in list view.
New: Private Doc access with Login
Tweaked: Some settings improved (Title, description, default value).

= v1.1.7 (22 June 2022) =
Fixed: The Auto Update notice was not working for the PRO version (from this version, you will get update notice)

= v1.1.6 (16 June 2022) =
New: OnePage Doc
New: Dark Mode
New: Mark filtering text option added in EazyDocs > Settings

= v1.1.5 (19 May 2022) =
New: Knowledge-base assistant
New: Next/Previous doc links
Fixed: Notifications count
Fixed: Customizer options was missing in PRO

= v1.1.1 (09 May 2022) =
 * Initial release