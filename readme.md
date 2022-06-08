# Auction Nudge - Your eBay on Your Site #
**Contributors:** [morehawes](https://profiles.wordpress.org/morehawes/)  
**Tags:** eBay, widget, embed, feed, integration, display, sidebar, integrate, listings, item, items, search, pagination, profile, feedback, free, products, ad, ads, adverts, banner, banners, shop, store, advertise, advertising, on your own site, automatic, automatically, update, category, keywords, seller, user, username, links, images, pictures, international, US, UK, Canada, Australia, Belgium, Germany, France, Spain, Austria, Italy, Netherlands, Ireland, Switzerland, ebay.com, ebay.co.uk, ebay.ca, ebay.com.au, ebay.be, ebay.de, ebay.fr, ebay.at, ebay.it, ebay.nl, ebay.ie, ebay.pl, ebay.es, ebay.ch, Auction Nudge, auctionnudge.com, plugin, widgets  
**Requires at least:** 3.2  
**Tested up to:** 6.0  
**Requires PHP:** 5.2  
**Stable tag:** 6.2.2  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Embed your live eBay listings, profile and feedback information in no time!

## Description ##

Display your live eBay information on your WordPress site using <a href="https://www.auctionnudge.com/">Auction Nudge</a>. Once installed, all tools will update automatically to display your most recent eBay information.

The following tools are available to integrate eBay into your own website:

* **Your eBay Listings** - displays your active items, with lots of options and filters to choose from. You visitors can:
	* Browse multiple pages of items
	* Filter by eBay category
	* Search of all of your active items by keyword

* **Your eBay Profile** - displays your eBay profile information like feedback rating and date of registration as a badge

* **Your eBay Feedback** - displays your most recent feedback comments

This plugin allows you to add Auction Nudge within your posts and pages using shortcodes, as widgets or directly from within your theme.

**Most common issues are solved by reading the <a href="https://www.auctionnudge.com/wordpress-plugin/help#faq">Help section</a>. Bugs and errors can be reported <a href="https://www.auctionnudge.com/issues">here</a>. Please do this before leaving a poor review.**

### Auction Nudge Options ###

Available for the following international eBay sites:

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

The following shows just some of the options available for the Your eBay Listings tool:

### Feed Options ###

* **eBay Username** - The eBay account name you want to display items for
* **eBay Site** - Which international eBay site your items are listed on

### Display Options ###

* **Theme** - There are a number of themes and options to choose from, including a responsive design theme
* **Category List** - Allow visitors to your site to filter your items by category
* **Items per Page** - How many items you wish to show per page
* **Show Multiple Pages?** - Multiple pages can show all of your items for sale
* **Show Search Box?** - Allow your site visitors to search all of your active eBay items by keyword
* **Open Links in New Tab?** - Decide if your visitors should be taken to eBay in a new tab or the current one
* **Image Size** - Large item images can be displayed (up to 500px by 500px)

### Advanced Options ###

* **Sort Order** - Choose in which order your items are displayed (items ending first, newly-listed first, price + shipping: lowest first, price + shipping: highest first or best match)
* **Listing Type** - Choose to only display items listed as either Auction or Buy It Now.
* **Filter by Keyword** - Specify to only show items which match a certain keyword query
* **Filter by Category ID** - Specify to only show items listed in a certain category/categories

*Auction Nudge is not owned or operated by eBay Inc. eBay and the eBay logo are trademarks of eBay Inc. As a member of the eBay Partner Network, Auction Nudge may receive anonymous referral commissions from eBay if a successful transaction occurs after clicking a link to eBay, at no cost to the user.*

## Installation ##

**Most common issues are solved by reading the <a href="https://www.auctionnudge.com/wordpress-plugin/help#faq">Help section</a>. Bugs and errors can be reported <a href="https://www.auctionnudge.com/issues">here</a>. Please do this before leaving a poor review.**

Once you have installed and activated the plugin you are able to add your eBay information in a number of ways:

### Within Your Pages/ Posts ###

Once the plugin has been enabled, an Auction Nudge box will appear on your edit page/post admin pages under the content editor. This box enables you to specify the desired options for the Your eBay Listings, Your eBay Profile and Your eBay Feedback tools.

Once you have set your options, you can add the relevant Auction Nudge shortcode (e.g. `[auction-nudge tool="listings"]`) to the content editor where you would like the content to display.

Each Auction Nudge tool has it's own shortcode format:

`<!-- To display Your eBay Listings -->
[auction-nudge tool="listings"]

<!-- To display Your eBay Profile -->
[auction-nudge tool="profile"]

<!-- To display Your eBay Feedback -->
[auction-nudge tool="feedback"]`

### As Widgets ###

Once the plugin is activated, Auction Nudge widgets for each tool will appear on the *Appearance > Widgets* page. Here you can create widgets with the full range of options and add them to a widget area.

### From Within Your Theme ###

As well as adding Auction Nudge content to your pages/posts using the shortcode you can also call the plugin directly from your theme files.

To use this feature, generate your code snippets from the <a href="https://www.auctionnudge.com/tools">Auction Nudge website</a> and paste them in to the appropriate boxes in the *Settings &gt; Auction Nudge &gt; Within Your Theme* page. You can then use the following functions to add Auction Nudge within your theme files:

`/* To display Your eBay Listings */
<?php an_items(); ?>

/* To display Your eBay Profile */
<?php an_profile(); ?>

/* To display Your eBay Feedback */
<?php an_feedback(); ?>`

### Nothing Displaying? ###

A common reason for Auction Nudge not loading is the use of **ad blocking browser plugins**. If you are using such a plugin, disable it, or add an exception to see if Auction Nudge loads without it.

## Frequently Asked Questions ##

**Most common issues are solved by reading the <a href="https://www.auctionnudge.com/wordpress-plugin/help#faq">Help section</a>. Bugs and errors can be reported <a href="https://www.auctionnudge.com/issues">here</a>. Please do this before leaving a poor review.**

Please refer to the Auction Nudge website to:

* Read the <a href="https://www.auctionnudge.com/wordpress-plugin/help#faq">plugin FAQ</a> for common issues.
* Watch the <a href="https://www.auctionnudge.com/wordpress-plugin/usage#video">Walk-through video</a> to ensure you have the plugin set up correctly.

### Nothing is Displaying, What's Wrong? ###

A common reason for Auction Nudge not loading is the use of **ad blocking browser plugins**. If you are using such a plugin, disable it, or add an exception to see if Auction Nudge loads without it.

<a href="https://www.auctionnudge.com/wordpress-plugin/help#faq">More help</a>

### How Often Does Auction Nudge Update? ###

To reduce server load, Auction Nudge does not update every time it is loaded on your site. The tools update as follows:

* Your eBay Listings – updates every 15 minutes
* Your eBay Profile – updates every 12 hours
* Your eBay Feedback – updates every 12 hours

These update times aim to optimise server resources by updating the most important feeds (i.e. those displaying active eBay items) more frequently than ones that change only occasionally (i.e. profile/feedback information).

### How Is Such an Awesome Tool Free? ###

Auction Nudge funds itself through referral commissions from eBay. As a member of the eBay Partner Network, Auction Nudge may receive anonymous referral commissions from eBay if a successful transaction occurs after clicking a link to eBay, at no cost to the user.

This means Auction Nudge is free to use and there are no 'pay to unlock' type restrictions and no signups - just obtain your code snippet and install it on your site!

### How Can I Modify the Appearance of Auction Nudge? ###

Please see the <a href="https://www.auctionnudge.com/wordpress-plugin/usage#customize">Customize</a> section of the Auction Nudge website.

### Where Can I Find More Help? ###

The following links should help with most questions and issues:
	
* Watch the <a href="https://www.auctionnudge.com/wordpress-plugin/usage#video">Walk-through video</a>
* Read through the <a href="https://www.auctionnudge.com/wordpress-plugin/help#faq">Help section</a>
* Read through the <a href="https://www.auctionnudge.com/wordpress-plugin/usage#customize">Customize section</a>

## Screenshots ##

### 1. Once installed on your site, Auction Nudge will always display your active eBay listings. ###
![Once installed on your site, Auction Nudge will always display your active eBay listings.](https://ps.w.org/auction-nudge/assets/screenshot-1.png)

### 2. You can also display your eBay profile. ###
![You can also display your eBay profile.](https://ps.w.org/auction-nudge/assets/screenshot-2.png)

### 3. As well as your most recent eBay feedback. ###
![As well as your most recent eBay feedback.](https://ps.w.org/auction-nudge/assets/screenshot-3.png)

### 4. Setup the tools using the Auction Nudge box that appears under the content editor, then add the shortcode to the content editor. ###
![Setup the tools using the Auction Nudge box that appears under the content editor, then add the shortcode to the content editor.](https://ps.w.org/auction-nudge/assets/screenshot-4.png)

### 5. Widgets are available for each tool. ###
![Widgets are available for each tool.](https://ps.w.org/auction-nudge/assets/screenshot-5.png)

### 6. Setting a default eBay username & eBay site will save you from entering them each time you want to add Auction Nudge to your page. ###
![Setting a default eBay username & eBay site will save you from entering them each time you want to add Auction Nudge to your page.](https://ps.w.org/auction-nudge/assets/screenshot-6.png)


## Changelog ##

### 6.2.2 ###

* Release date: May 24th, 2022

Minor bug fixes. Thanks to <a href="https://wordpress.org/support/users/bkjproductions/">bkjproductions</a> for letting me know about <a href="https://wordpress.org/support/topic/undefined-offset-in-parameters-php/">this one</a>.


### 6.2.1 ###

* Release date: February 25th, 2020

Minor text tweaks.

### 6.2 ###

* Release date: November 25th, 2018

New Search Box feature added.

**Added**

* **<a href="https://www.auctionnudge.com/help/options#search-box">Search Box</a>** – If this option is enabled, a search box will appear above the items which will allow users to search all of your active eBay items.

### 6.1 ###

* Release date: May 28th, 2018

Multi-language support for all tools.

**Added**

* All tools now support the following languages: English, French, German, Spanish and Italian. This allows you to specify which language Auction Nudge tools display on your site. To change language, use the <a href="https://www.auctionnudge.com/help/options#language">language option</a> found in the Auction Nudge options box when editing a post/page or widget.

### 6.0.2 ###

* Release date: December 13th, 2017

"Use WordPress Cache?" setting.

**Added**

* Added setting to enable/disable the use of the WordPress cache.

### 6.0.1 ###

* Release date: November 21st, 2017

Bug fixes.

**Fixed**

* Fixed a bug with gzip compression which was causing feeds to not load for some users. Thanks to Michael for bringing this to my attention.
* Minor upgrade notification bug fix.

### 6.0 ###

* Release date: November 10th, 2017

This is a major update to the plugin. While it may not seem like it on the surface, there have been some big changes under the hood:

**Added**

* **WordPress caching** - the plugin now utilises the in-built WordPress caching mechanism to deliver Auction Nudge content, offering a significant performance boost.

**Updated**

* **Code overhaul** - the plugin code has been completely refactored to make maintenance and the development of new features less sucky.
* **<a href="https://www.auctionnudge.com/wordpress-plugin/usage">Documentation</a>** - the plugin documentation has been rewritten and can now be found on the Auction Nudge website.
* Bug fixes and minor improvements.

This is a recommended update, with lots of new features and further improvements in the works.

### 5.0 ###

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

### 4.4.3 ###

<a href="https://wordpress.org/support/topic/page-settings-are-getting-wiped-out/">Bug fix</a>. Thanks to Janak for helping to identifying this issue.

### 4.4.2 ###

<a href="https://wordpress.org/support/topic/undefined-index-error-31/#topic-8557716-replies">More</a> bug fixes

### 4.4.1 ###

Minor <a href="https://wordpress.org/support/topic/undefined-index-error-31/">bug</a> fix. Thanks to kemco1969 for bringing this to my attention

### 4.4 ###

* Should your eBay username change, you can now update every instance of Auction Nudge in one go through the Settings page, instead of having to update each manually
* Resolved a conflict with the WooCommerce plugin, which was causing a "No parameters were provided" error for some users

### 4.3.5 ###

Fixed a bug with the Your eBay Listings tool where usernames containing the star ('*') character were causing an error. Thanks to Daniel for bringing this to my attention

### 4.3.4 ###

Minor bug fix.

### 4.3.3 ###

Minor bug fixes.

### 4.3.2 ###

Another small bug fix.

### 4.3.1 ###

Small bug fix. Thanks to Orlandoo for bringing this to my attention.

### 4.3 ###

* Added new 'Overview' theme to the Your eBay Profile tool
* Retired Your eBay Ads tool, see <a href="https://www.auctionnudge.com/changes#v3.8">here</a> for more information

### 4.2 ###

* Updated Your eBay Feedback tool options, as explained <a href="https://www.auctionnudge.com/changes#v3.7">here</a>
* Updated plugin FAQ section
* Minor updates to admin area pages

### 4.1.3 ###

Small bug fixes. Thanks to moleroda for bringing this to my attention.

### 4.1.2 ###

Minor text updates

### 4.1.1 ###

Minor text updates

### 4.1 ###

Added 'Responsive' theme to the Your eBay Listings tool

### 4.0.3 ###

Fixed minor WordPress admin JavaScript bug which was causing conflicts with some other plugins. Thanks to Tamara for bringing this to my attention.

### 4.0.2 ###

Minor plugin user interface improvements.

### 4.0.1 ###

Fixed bug with setting the eBay site. Thanks to legacy_dzynes for bringing this to my attention on the support forum.

### 4.0 ###
* **Pagination** – there is no longer a limit to the total number of items Auction Nudge can display using the Your eBay Listings tool. Each page can show up to 100 items at once, if you have more listed "Previous" and "Next" buttons will allow users to navigate through multiple pages. Use the "Show multiple pages?" option to enable this feature
* **Larger images** – Your eBay Listings item image sizes can now be increased up to 500px x 500px using the "Image Size" option (the previous maximum was 140px x 140px)
* **Reduced cache time** – the Your eBay Listings and Your eBay Ads tools now automatically update 4 times more frequently. These tools now update every 15 minutes (was previously every 60 minutes)
* New 'Profile Table' theme added to the Your eBay Feedback tool

### 3.2 ###
* Made wording on Settings page a little clearer
* Added 'Open links in new tab?' option to Your eBay Listings, Your eBay Profile and Your eBay Feedback tools

### 3.1 ###
Fixed issue with older versions of PHP which do not support anonymous functions. Thanks Jeff for pointing this out to me.

### 3.0 ###
* Added Your eBay Ads tool to plugin
* All tools now available as widgets
* Added eBay Switzerland support
* Small tweaks and bug fixes

### 2.1 ###
Fixed bug with special characters in seller IDs. Thanks Jon-Paul for pointing this out to me.

### 2.0 ###
* Plugin completely rewritten
* Your eBay Listing, Your eBay Profile and Your eBay Feedback tools can now be added through the page/post edit page
* Allows for feeds to be created on a page-by-page basis, useful if you require multiple item feeds

### 1.0 ###
* Minor updates
* Plugin hosted on WordPress Plugin Directory

### 0.2 ###
Added the ability to specify custom CSS rules within the plugin to modify the appearance of Auction Nudge.

### 0.1 ###
WordPress plugin released.

## Upgrade Notice ##

### 6.0.1 ###
Thanks for using Auction Nudge! Version 6 of the plugin is a major update with some serious performance improvements. Updating to this version is recommended.

### 6.0 ###
Thanks for using Auction Nudge! This is a major update with some serious performance improvements. Updating to this version is recommended.

### 5.0 ###
This is a major update with new **features**, new and updated **filters** and lots of other improvements.

### 4.4.3 ###
This update is highly recommended as it contains a bug fix which caused Auction Nudge options to be wiped for some users. It is also recommended that you check the pages which use Auction Nudge to ensure you were not affected by this issue.

### 4.4 ###
This update is recommended for all users as it contains a fix for a conflict with the WooCommerce plugin, as well as other bug fixes and improvements

### 4.0.1 ###
Fixed bug with setting the eBay site. This bug fix is recommended for all users

### 4.0 ###
A major update with lots of new features: faster feed updates, multiple pages of items, larger item images and more