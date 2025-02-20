=== Auction Nudge - Your eBay on Your Site ===
Contributors: morehawes
Tags: ebay, item, listing, embed, store
Requires at least: 3.2
Tested up to: 6.7
Requires PHP: 5.2
Stable tag: 7.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display your live eBay Listings with a Shortcode.

== Description ==

Display your active eBay items on your WordPress site using <a href="https://www.auctionnudge.com/">Auction Nudge</a>, an approved eBay Compatible Application.

**The Your eBay Profile and Your eBay Feedback tools are being retired, more information <a href="https://www.auctionnudge.com/changes#v2024.4.0">here</a>. The Your eBay Listings tool will continue to be supported** :)

Add the Auction Nudge Shortcode anywhere that Shortcodes are supported:

`
[auction-nudge tool="listings" sellerid="ebay_username"]
`

* **Your eBay Listings** - displays your active items, with lots of options and filters to choose from. You visitors can:
	* Browse multiple pages of items
	* Filter by eBay category
	* Search of all of your active items by keyword

**In order to remain free, Auction Nudge is supported by referral commissions from eBay and includes an [Advertising Disclosure](https://www.auctionnudge.com/about#disclosure).**

= Feed Options =

* **eBay Username** - You eBay account username (not your Store ID)
* **eBay Site** - Where your items are listed:
	* eBay US
	* eBay UK
	* eBay Canada
	* eBay Australia
	* eBay Belgium
	* eBay Germany
	* eBay France
	* eBay Spain
	* eBay Austria
	* eBay Italy
	* eBay Netherlands
	* eBay Ireland
	* eBay Switzerland

= Display Options =

* **Theme** - There are a number of themes and options to choose from, including a responsive design theme
* **Language** - All tools support the following languages: 
	* English
	* French
	* German
	* Spanish
	* Italian
* **Category List** - Allow visitors to your site to filter your items by category
* **Items per Page** - How many items you wish to show per page
* **Show Multiple Pages?** - Multiple pages can show all of your items for sale
* **Show Search Box?** - Allow your site visitors to search all of your active eBay items by keyword
* **Open Links in New Tab?** - Decide if your visitors should be taken to eBay in a new tab or the current one
* **Image Size** - Large item images can be displayed (up to 500px by 500px)
* **User Profile** - Display your eBay username, positive feedback percentage, feedback score and feedback star (if applicable) at the top of the Your eBay Listings tool

= Advanced Options =

* **Sort Order** - Choose in which order your items are displayed (items ending first, newly-listed first, price + shipping: lowest first, price + shipping: highest first or best match)
* **Listing Type** - Choose to only display items listed as either Auction or Buy It Now.
* **Filter by Keyword** - Specify to only show items which match a certain keyword query
* **Filter by Category ID** - Specify to only show items listed in a certain category/categories

*Auction Nudge is an approved eBay Compatible Application. Auction Nudge is not owned or operated by eBay Inc. eBay and the eBay logo are trademarks of eBay Inc. As a member of the eBay Partner Network, Auction Nudge may receive anonymous referral commissions from eBay if a successful transaction occurs after clicking a link to eBay, at no cost to the user.*

== Installation ==

**Most common issues are solved by reading the <a href="https://www.auctionnudge.com/wordpress-plugin/usage">Help section</a>. Bugs and errors can be reported <a href="https://wordpress.org/support/plugin/auction-nudge/">here</a>. Please do this before leaving a poor review.**

Once the plugin has been activated, go to Settings > Auction Nudge to set your default eBay username and eBay site. These aren't required, but this will save you time.

Now you can add the appropriate Auction Nudge Shortcode to your WordPress site anywhere Shortcodes are supported:

`<!-- To display Your eBay Listings -->
[auction-nudge tool="listings"]

Use the Shortcode Generator (Settings > Auction Nudge) to customise your content, or pass your options to the Shortcode like this:

`<!-- Showing items for the eBay username "ebay_username" -->
[auction-nudge tool="listings" sellerid="ebay_username"]

<!-- Show 100 items, in French and disable search -->
[auction-nudge tool="listings" lang="french" maxentries="100" search_box="0"]`

= Nothing Displaying? =

A common reason for Auction Nudge not loading is the use of **ad blocking browser plugins**. If you are using such a plugin, disable it, or add an exception to see if Auction Nudge loads without it.

== Frequently Asked Questions ==

**Most common issues are solved by reading the <a href="https://www.auctionnudge.com/wordpress-plugin/usage">Help section</a>. Bugs and errors can be reported <a href="https://wordpress.org/support/plugin/auction-nudge/">here</a>. Please do this before leaving a poor review.**

= Nothing is Displaying, What's Wrong? =

A common reason for Auction Nudge not loading is the use of **ad blocking browser plugins**. If you are using such a plugin, disable it, or add an exception to see if Auction Nudge loads without it.

<a href="https://www.auctionnudge.com/wordpress-plugin/usage">More help</a>

= How Often Does Auction Nudge Update? =

To reduce server load, Auction Nudge does not update every time it is loaded on your site. The Your eBay Listings tool updates every 15 minutes.

= How Is Such an Awesome Tool Free? =

Auction Nudge funds itself through referral commissions from eBay. As a member of the eBay Partner Network, Auction Nudge may receive anonymous referral commissions from eBay if a successful transaction occurs after clicking a link to eBay, at no cost to the user.

This means Auction Nudge is free to use and there are no 'pay to unlock' restrictions.

= How Can I Modify the Appearance of Auction Nudge? =

Please see the <a href="https://www.auctionnudge.com/wordpress-plugin/usage">Using the Plugin</a> page of the Auction Nudge website.

= Where Can I Find More Help? =

The following links should help with most questions and issues:
	
* The <a href="https://www.auctionnudge.com/wordpress-plugin/usage">WordPress Help</a> page.
* The <a href="https://www.auctionnudge.com/help">Full Auction Nudge Help</a> section.
* The <a href="https://wordpress.org/support/plugin/auction-nudge/">Plugin Support</a> forum on WordPress.org.

= Can I Remove The Advertising Disclosure? =

No. The [advertising disclosure](https://www.auctionnudge.com/about#disclosure) is a requirement of the [eBay Partner Network](https://partnernetwork.ebay.com/page/network-agreement#guidelines) and is a condition of use for Auction Nudge.

This means that if you are not happy with the Advertising Disclosure, then Auction Nudge is not the **free tool** for you.

Attempting to hide, obscure or modifying the disclosure puts the service at risk for all users. Therefore, Auction Nudge reserves the right to block any user who attempts to do so.

= What happened to the Your eBay Profile and Your eBay Feedback tools? =

These tools are being retired as of October 2024. Unfortunately, eBay has scheduled the data source for these tools to be decommissioned in February 2025. With no alternative available, it will no longer be possible to provide these tools.

The tools will continue to function as normal until the Shopping API is decommissioned, when the tools will cease to function and no content will be displayed on the page.

The Your eBay Listings tool has already been migrated to the new Browse API and will continue to be supported :)

More information can be found <a href="https://www.auctionnudge.com/changes#v2024.4.0">here</a>.

== Screenshots ==

1. Preview and customize your Shortcode.
2. Add Shortcodes anywhere they are supported.
3. Promote your eBay content on your site.
4. A default eBay username saves time!

== Changelog ==

= 7.3.1 =

- Security improvements.
- Retired Carousel theme from the Your eBay Listings tool. Existing usage will continue to work.

= 7.3.0 =

Added the option to display a user's eBay profile information at the top of the Your eBay Listings tool. This includes:

* eBay Username
* Positive feedback percentage
* Feedback score
* Feedback star (if applicable)

This option is available in the Display Options section when creating your snippet, or through the `user_profile="1"` Shortcode parameter. 

= 7.2.1 =

Admin form Cross Site Scripting (XSS) vulnerability fix. Thanks to <a href="https://patchstack.com/database/researcher/e8b26d85-211b-4078-9d62-d56faa6d7f8a">b4orvn</a> for reporting this via <a href="https://patchstack.com">Patchstack</a>.

= 7.2.0 =

- The Your eBay Profile and Your eBay Feedback tools are being retired. The ability to create new snippets for these tools has been removed and existing snippets will soon cease to function. More information can be found <a href="https://www.auctionnudge.com/changes#v2024.4.0">here</a>.
- Removed Legacy Meta Box and Widget support, please use Shortcodes instead.

= 7.1.5 =

Request endpoint fix. Thanks	to <a href="https://wordpress.org/support/users/hypergalaxy/">hypergalaxy</a> for bringing this to my <a href="https://wordpress.org/support/topic/listings-have-just-stopped-appearing/">attention</a>.

= 7.1.4 =

Added extra information about the [Advertising Disclosure](https://www.auctionnudge.com/about#disclosure).

= 7.1.3 =

Another fix the Your eBay Listings Keyword Filter bug which was still breaking some feeds. Thanks to <a href="https://wordpress.org/support/users/smile2day/">smile2day</a> for <a href="https://wordpress.org/support/topic/nothing-displays-10/">reaching out</a>.

= 7.1.2 =

Fix for a Your eBay Listings bug which broke some feeds when filtering by keyword. Thanks to <a href="https://wordpress.org/support/users/andycrossley/">andycrossley</a> for <a href="https://wordpress.org/support/topic/using-filter-by-keyword-advanced-option-disables-the-plug-in/">reaching out</a>.

= 7.1.1 =

Minor bug fix.

= 7.1 =

* Removed Legacy features.
* Text updates, including advertising disclosure notice.

= 7.0.3 =

Minor bug fix.

= 7.0.2 =

Shortcode attributes now override Meta Box values even when Meta Boxes are enabled. Thanks to <a href="https://wordpress.org/support/users/as4kb5/">as4kb5</a> for bringing this to my <a href="https://wordpress.org/support/topic/cannot-change-style-of-listings-wp-plugin/">attention</a>.

= 7.0.1 =

Profile / Feedback Shortcode bug fix

= 7.0 =

* Release date: June 2020

**This is a major re-working of the plugin. The Meta Box is being retired in favour of full Shortcode support.**

I have attempted to make every change backwards compatible to cater for all users. Please do <a href="https://wordpress.org/support/plugin/auction-nudge/#new-post">reach out</a> if you have any issues after updating. Cheers, Joe.

**Added**

* **Multiple Shortcodes** - Add Shortcodes anywhere they are supported. Customize your content using Shortcode parameters (e.g. `[auction-nudge tool="listings" lang="french" maxentries="100" search_box="0"]`).
* **Shortcode Generator** - This tool allows you to preview and customize your eBay content, providing you with the appropriate Shortcode.

**Removed**

* **Legacy Widget Support** - This feature is no longer supported. Check out the Shortcode Generator (Settings > Auction Nudge), or refer to the <a href="https://www.auctionnudge.com/wordpress-plugin/usage">Using the Plugin</a> page.

**Changed**

* **Meta Box** - This is now a legacy feature and is not recommended! Instead, try generating Shortcodes (Settings > Auction Nudge) and adding them anywhere Shortcodes are supported, or refer to the <a href="https://www.auctionnudge.com/wordpress-plugin/usage">Using the Plugin</a> page. For backwards compatibility, even with the Meta Box disabled (Settings > Auction Nudge), each post retains it\'s Meta Box options.
* Major design and code overhaul.
* Many many other bug fixes and improvements.

= 6.2.3 =

* Release date: June 9th, 2022

Meta Box layout updates.

= 6.2.2 =

* Release date: May 24th, 2022

Minor bug fixes. Thanks to <a href="https://wordpress.org/support/users/bkjproductions/">bkjproductions</a> for letting me know about <a href="https://wordpress.org/support/topic/undefined-offset-in-parameters-php/">this one</a>.

= 6.2.1 =

* Release date: February 25th, 2020

Minor text tweaks.

= 6.2 =

* Release date: November 25th, 2018

New Search Box feature added.

**Added**

* **<a href="https://www.auctionnudge.com/help/options#search-box">Search Box</a>** – If this option is enabled, a search box will appear above the items which will allow users to search all of your active eBay items.

= 6.1 =

* Release date: May 28th, 2018

Multi-language support for all tools.

**Added**

* All tools now support the following languages: English, French, German, Spanish and Italian. This allows you to specify which language Auction Nudge tools display on your site. To change language, use the <a href="https://www.auctionnudge.com/help/options#language">language option</a> found in the Auction Nudge options box when editing a post/page or widget.

= 6.0.2 =

* Release date: December 13th, 2017

"Use WordPress Cache?" setting.

**Added**

* Added setting to enable/disable the use of the WordPress cache.

= 6.0.1 =

* Release date: November 21st, 2017

Bug fixes.

**Fixed**

* Fixed a bug with gzip compression which was causing feeds to not load for some users. Thanks to Michael for bringing this to my attention.
* Minor upgrade notification bug fix.

= 6.0 =

* Release date: November 10th, 2017

This is a major update to the plugin. While it may not seem like it on the surface, there have been some big changes under the hood:

**Added**

* **WordPress caching** - the plugin now utilises the in-built WordPress caching mechanism to deliver Auction Nudge content, offering a significant performance boost.

**Updated**

* **Code overhaul** - the plugin code has been completely refactored to make maintenance and the development of new features less sucky.
* **<a href="https://www.auctionnudge.com/wordpress-plugin/usage">Documentation</a>** - the plugin documentation has been rewritten and can now be found on the Auction Nudge website.
* Bug fixes and minor improvements.

This is a recommended update, with lots of new features and further improvements in the works.

= 5.0 =

* Release date: April 11th, 2017

This is a major update to the plugin.

**Added**

* **<a href="https://www.auctionnudge.com/help/options#category-list">Category List</a>** – Allows visitors to your site to filter your items by category. When this option is enabled, a list of categories is displayed above your items (if you have items in more than one category). This allows users to filter your items by simply selecting a category from the list.
* **Listing Type Filter** – Filter items by listing type filter, making it possible to just display Auction or Buy It Now items.
* **Default eBay Site** - You can now specify a default eBay site on the Settings page, to save you from re-entering them on each page, post or widget where you want to use Auction Nudge.
* **AdBlock Warning** - If an ad blocker is detected (which may prevent Auction Nudge from loading) a warning is displayed on relevant admin pages.

**Updated**

* **<a href="https://www.auctionnudge.com/help/options#keyword-filter">Keyword Filter</a>** – The "keyword" filter for the Your eBay Listings tool has been rewritten to allow for additional search operators, making this feature much more powerful.
* **Tooltips** – The tooltips next to each option have been updated, are clearer and easier to use
* **Help** – The help popup has been updated to be more... helpful

Plus lots of minor improvements and bug fixes :-)

= 4.4.3 =

<a href="https://wordpress.org/support/topic/page-settings-are-getting-wiped-out/">Bug fix</a>. Thanks to Janak for helping to identifying this issue.

= 4.4.2 =

<a href="https://wordpress.org/support/topic/undefined-index-error-31/#topic-8557716-replies">More</a> bug fixes

= 4.4.1 =

Minor <a href="https://wordpress.org/support/topic/undefined-index-error-31/">bug</a> fix. Thanks to kemco1969 for bringing this to my attention

= 4.4 =

* Should your eBay username change, you can now update every instance of Auction Nudge in one go through the Settings page, instead of having to update each manually
* Resolved a conflict with the WooCommerce plugin, which was causing a "No parameters were provided" error for some users

= 4.3.5 =

Fixed a bug with the Your eBay Listings tool where usernames containing the star ('*') character were causing an error. Thanks to Daniel for bringing this to my attention

= 4.3.4 =

Minor bug fix.

= 4.3.3 =

Minor bug fixes.

= 4.3.2 =

Another small bug fix.

= 4.3.1 =

Small bug fix. Thanks to Orlandoo for bringing this to my attention.

= 4.3 =

* Added new 'Overview' theme to the Your eBay Profile tool
* Retired Your eBay Ads tool, see <a href="https://www.auctionnudge.com/changes#v3.8">here</a> for more information

= 4.2 =

* Updated Your eBay Feedback tool options, as explained <a href="https://www.auctionnudge.com/changes#v3.7">here</a>
* Updated plugin FAQ section
* Minor updates to admin area pages

= 4.1.3 =

Small bug fixes. Thanks to moleroda for bringing this to my attention.

= 4.1.2 =

Minor text updates

= 4.1.1 =

Minor text updates

= 4.1 =

Added 'Responsive' theme to the Your eBay Listings tool

= 4.0.3 = 

Fixed minor WordPress admin JavaScript bug which was causing conflicts with some other plugins. Thanks to Tamara for bringing this to my attention.

= 4.0.2 = 

Minor plugin user interface improvements.

= 4.0.1 = 

Fixed bug with setting the eBay site. Thanks to legacy_dzynes for bringing this to my attention on the support forum.

= 4.0 =

* **Pagination** – there is no longer a limit to the total number of items Auction Nudge can display using the Your eBay Listings tool. Each page can show up to 100 items at once, if you have more listed "Previous" and "Next" buttons will allow users to navigate through multiple pages. Use the "Show multiple pages?" option to enable this feature
* **Larger images** – Your eBay Listings item image sizes can now be increased up to 500px x 500px using the "Image Size" option (the previous maximum was 140px x 140px)
* **Reduced cache time** – the Your eBay Listings and Your eBay Ads tools now automatically update 4 times more frequently. These tools now update every 15 minutes (was previously every 60 minutes)
* New 'Profile Table' theme added to the Your eBay Feedback tool

= 3.2 =

* Made wording on Settings page a little clearer
* Added 'Open links in new tab?' option to Your eBay Listings, Your eBay Profile and Your eBay Feedback tools

= 3.1 =

Fixed issue with older versions of PHP which do not support anonymous functions. Thanks Jeff for pointing this out to me.

= 3.0 =

* Added Your eBay Ads tool to plugin
* All tools now available as widgets
* Added eBay Switzerland support
* Small tweaks and bug fixes

= 2.1 =

Fixed bug with special characters in seller IDs. Thanks Jon-Paul for pointing this out to me.

= 2.0 =

* Plugin completely rewritten
* Your eBay Listing, Your eBay Profile and Your eBay Feedback tools can now be added through the page/post edit page
* Allows for feeds to be created on a page-by-page basis, useful if you require multiple item feeds

= 1.0 =

* Minor updates
* Plugin hosted on WordPress Plugin Directory

= 0.2 =

Added the ability to specify custom CSS rules within the plugin to modify the appearance of Auction Nudge.

= 0.1 =

WordPress plugin released.

== Upgrade Notice ==

= 7.0 =

This is a major re-working of the plugin. Please do reach out if you have any issues after updating. Cheers, Joe.