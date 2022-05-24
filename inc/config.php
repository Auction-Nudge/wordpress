<?php
	
/**
 * ======================================================== 
 * ==================== CONFIG ============================
 * ========================================================
 */
 
$an_plugin_config = array(
	'plugin_name' => 'Auction Nudge',
	'plugin_version' => '6.2.1',
	'custom_field_prefix' => 'an',
	'shortcode' => 'auction-nudge',
	'username_bad' => array('.', "\$", '!', '*'),
	'username_good' => array('__dot__', '__dollar__', '__bang__', '__star__'),					
	//Requests
	'item_request' => array(
		'endpoint' => '//www.auctionnudge.com/feed/item/js',
		'content_type' => 'text/javascript',
		'cache_minutes' => 15
	),
	'ad_request' => array(
		'endpoint' => '//www.auctionnudge.com/feed/ad/iframe',
		'content_type' => 'text/html',
		'cache_minutes' => 15
	),
	'profile_request' => array(
		'endpoint' => '//www.auctionnudge.com/feed/profile/js',
		'content_type' => 'text/javascript',
		'cache_minutes' => 720
	),
	'feedback_request' => array(
		'endpoint' => '//www.auctionnudge.com/feed/feedback/js',
		'content_type' => 'text/javascript',
		'cache_minutes' => 720
	),			
	//Item tool parameters
	'item_parameter_groups' => array(
		'feed'  => array(
			'name' => 'Feed options',
			'description' => 'Enter your eBay username'
		),
		'display'  => array(
			'name' => 'Display options',
			'description' => 'Customise your feed'
		),
		'advanced'  => array(
			'name' => 'Advanced options',
			'description' => ''
		)				
	),
	'item_parameters' => array(
		//Step one
		'item_SellerID'  => array(
			'name' => 'item_SellerID',
			'id' => 'item_SellerID',
			'tip' => 'This is your eBay ID &ndash; the username you are known by on eBay and appears on your listings. This is not your store name.',
			'group' => 'feed',
			'title' => 'eBay Username',
			'output_processing' => array(
				'an_username_encode($param_value)'
			)
		),	
		'item_siteid'  => array(
			'name' => 'item_siteid',
			'id' => 'item_siteid',
			'tip' => 'This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed.',
			'type' => 'select',
			'options' => array(
				'0' => 'eBay US',
				'3' => 'eBay UK',
				'2' => 'eBay Canada',
				'15' => 'eBay Australia',
				'23' => 'eBay Belgium',
				'77' => 'eBay Germany',
				'71' => 'eBay France',
				'186' => 'eBay Spain',
				'16' => 'eBay Austria',
				'101' => 'eBay Italy',
				'146' => 'eBay Netherlands',
				'205' => 'eBay Ireland',
				'193' => 'eBay Switzerland'				
			),
			'default' => '0',
			'group' => 'feed',
			'title' => 'eBay Site'
		),
		//Step two
		'item_theme'  => array(
			'name' => 'item_theme',
			'id' => 'item_theme',
			'tip' => 'Your items will display differently on your site depending on which theme you choose. You can change how these themes displaying your listings using CSS rules.',
			'tip_link' => 'https://www.auctionnudge.com/customize/appearance',
			'type' => 'select',
			'options' => array(
				'responsive' => 'Responsive',
				'columns' => 'Column View',
				'carousel' => 'Carousel',
				'simple_list' => 'Simple List',
				'details' => 'Image and Details',
				'images_only' => 'Images Only',
				'grid' => 'Grid View',
				'unstyled' => 'Unstyled (advanced)'
			),
			'default' => 'responsive',
			'group' => 'display',
			'title' => 'Theme'
		),
		'item_lang' => array(
			'name' => 'item_lang',			
			'id' => 'item_lang',			
			'tip' => 'The language option allows you to specify which language Auction Nudge tools display on your site. This option will not modify eBay item titles, which will remain unchanged.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#language',
			'type' => 'select',
			'options' => array(
				'english' => 'English',
				'french' => 'French',
				'german' => 'German',
				'italian' => 'Italian',
				'spanish' => 'Spanish'
			),						
			'default' => 'english',
			'group' => 'display',
			'title' => 'Language'
		),		
		'item_cats_output'  => array(
			'name' => 'cats_output',
			'id' => 'cats_output',
			'tip' => 'Once enabled, a list of categories for your items (if you have items for sale in more than one category) will be displayed above your items. This allows users to filter your items by category. The categories shown are eBay categories and not custom/store categories which can not be displayed. Use the Category ID option (Advanced Options) to specify a starting category.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#category-list',
			'type' => 'select',
			'options' => array(
				'dropdown' => 'Dropdown',
				'unstyled' => 'Unstyled (advanced)',
				'' => 'None'
			),
			'default' => 'dropdown',
			'default_old' => '',
			'group' => 'display',
			'title' => 'Category List'
		),
		'item_MaxEntries'  => array(
			'name' => 'item_MaxEntries',
			'id' => 'item_MaxEntries',
			'tip' => 'This is the number of items you want display per page, the maximum value is 100. You can display multiple pages of items using the \'show multiple pages\' option below. Note: The \'Carousel\' theme can load a maximum of 100 items in total, as it does not support the \'show multiple pages\' option.',
			'group' => 'display',
			'title' => 'Items per Page',
			'default' => '6',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)			
		),
		'item_page'  => array(
			'name' => 'item_page',
			'id' => 'item_page',
			'tip' => 'If you enable this option and have more items listed than the value for the \'Items per Page\' option above, users can paginate between multiple pages of items.',
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Show Multiple Pages?',
			'default' => 'init',
			'default_old' => '',			
			'options' => array(
				'init' => 'Yes',
				'' => 'No'
			)
		),	
		'search_box'  => array(
			'name' => 'search_box',
			'id' => 'search_box',
			'tip' => 'If enabled, a search box will appear above the items which will allow users to search all of your active eBay items. Note: Only item titles are searched, not descriptions.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#search-box',			
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Show Search Box?',
			'default' => '1',
			'default_old' => '0',			
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)
		),				
		'item_carousel_scroll'  => array(
			'name' => 'item_carousel_scroll',
			'id' => 'item_carousel_scroll',
			'tip' => 'This option specifies how may items will be visible in the carousel at one time. Use in conjunction with \'Item width\' to set the overall carousel width, i.e. 140px * 4 = 560px.',
			'group' => 'display',
			'title' => 'Number of Items to Scroll',
			'default' => '4',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)			
		),					
		'item_carousel_width'  => array(
			'name' => 'item_carousel_width',
			'id' => 'item_carousel_width',
			'tip' => 'Specify in pixels how wide each item in the carousel will be. Use in conjunction with \'Number of items to scroll\' to set the overall carousel width, i.e. 140 * 4 = 560px.',
			'group' => 'display',
			'title' => 'Item Width',
			'default' => '140',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)		
		),
		'item_carousel_auto'  => array(
			'name' => 'item_carousel_auto',
			'id' => 'item_carousel_auto',
			'tip' => 'This option specifies how often, in seconds the carousel should auto scroll. If set to 0 auto scroll is disabled.',
			'group' => 'display',
			'title' => 'Auto Scroll',
			'default' => '0',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)			
		),
		'item_grid_cols'  => array(
			'name' => 'item_grid_cols',
			'id' => 'item_grid_cols',
			'tip' => 'Use this option to specify how many columns to display in grid view.',
			'group' => 'display',
			'title' => 'Grid Columns',
			'default' => '2',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)	
		),				
		'item_grid_width'  => array(
			'name' => 'item_grid_width',
			'id' => 'item_grid_width',
			'tip' => 'Use this option to specify how wide the grid should be. This can be specified in either pixels (px) or as a percentage (%)',
			'group' => 'display',
			'title' => 'Grid Width',
			'default' => '100%',
			'output_processing' => array(
				'str_replace("%", "%25", $param_value)'
			)			
		),
		'item_show_logo'  => array(
			'name' => 'item_show_logo',
			'id' => 'item_show_logo',
			'tip' => 'This option specifies if you want to display the eBay logo alongside your listings.',
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Show eBay Logo?',
			'default' => '1',
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)
		),
		'item_blank'  => array(
			'name' => 'item_blank',
			'id' => 'item_blank',
			'tip' => 'Enabling this option will open item links in a new browser tab.',
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Open Links in New Tab?',
			'default' => '0',
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)
		),
		'item_img_size'  => array(
			'name' => 'item_img_size',
			'id' => 'item_img_size',
			'tip' => 'Specify in pixels the maximum image size. Depending on the image ratio, the image width or height will not exceed this size. At larger sizes, higher quality images (and therefore a larger file size) are used.',
			'tip_link' => 'https://www.auctionnudge.com/customize/appearance#image-size',
			'group' => 'display',
			'title' => 'Image Size',
			'default' => '120',
			'default_old' => '',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)			
		),		
		//Advanced
		'item_sortOrder'  => array(
			'name' => 'item_sortOrder',
			'id' => 'item_sortOrder',
			'tip' => 'This option adjusts the order in which items are shown.',
			'type' => 'select',
			'options' => array(
				'' => 'Items Ending First',
				'StartTimeNewest' => 'Newly-Listed First',
				'PricePlusShippingLowest' => 'Price + Shipping: Lowest First',
				'PricePlusShippingHighest' => 'Price + Shipping: Highest First',
				'BestMatch' => 'Best Match'
			),
			'group' => 'advanced',
			'title' => 'Sort Order'
		),
		'item_listing_type'  => array(
			'name' => 'item_listing_type',
			'id' => 'item_listing_type',
			'tip' => 'Filtering by listing type allows you to choose to only display items listed as either Auction or Buy It Now. Auction listings that have the Buy It Now option available will be displayed both when filtering by Auction and Buy It Now.',
			'group' => 'advanced',
			'title' => 'Listing Type',
			'type' => 'select',			
			'options' => array(
				'' => 'All Listings',
				'bin_only' => 'Buy It Now Only',
				'auction_only' => 'Auction Only'
			),			
		),		
		'item_keyword'  => array(
			'name' => 'item_keyword',
			'id' => 'item_keyword',
			'tip' => 'By specifying a keyword, only items which contain that keyword in their title will be displayed. The keyword query can contain search operators, allowing for powerful searches to include/exclude certain keywords. Note: it is not possible to just use the minus sign (NOT) operator alone, another operator must be used to include items.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#keyword-filter',
			'group' => 'advanced',
			'title' => 'Filter by Keyword',
			'output_processing' => array(
				'an_keyword_encode($param_value)'
			)
		),		
		'item_categoryId'  => array(
			'name' => 'item_categoryId',
			'id' => 'item_categoryId',
			'tip' => 'By specifying an eBay category ID, only items which are listed in this category will be displayed. You can specify up to 3 different category IDs by separating with a colon (:) for example 123:456:789.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#category-filter',
			'group' => 'advanced',
			'title' => 'Filter by Category ID'
		)
	),
	//Ad tool parameters
	'ad_parameter_groups' => array(
		'feed'  => array(
			'name' => 'Feed options',
			'description' => 'Enter your eBay username'
		),
		'display'  => array(
			'name' => 'Display options',
			'description' => 'Customise your feed'
		),
		'advanced'  => array(
			'name' => 'Advanced options',
			'description' => ''
		)				
	),	
	'ad_parameters' => array(
		//Step one
		'ad_SellerID'  => array(
			'name' => 'ad_SellerID',
			'id' => 'ad_SellerID',
			'tip' => 'This is your eBay ID &ndash; the username you are known by on eBay and appears on your listings. This is not your store name.',
			'group' => 'feed',
			'title' => 'eBay Username',
			'output_processing' => array(
				'an_username_encode($param_value)'
			)
		),
		'ad_siteid'  => array(
			'name' => 'ad_siteid',
			'id' => 'ad_siteid',
			'tip' => 'This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed.',
			'type' => 'select',
			'options' => array(
				'0' => 'eBay US',
				'3' => 'eBay UK',
				'2' => 'eBay Canada',
				'15' => 'eBay Australia',
				'23' => 'eBay Belgium',
				'77' => 'eBay Germany',
				'71' => 'eBay France',
				'186' => 'eBay Spain',
				'16' => 'eBay Austria',
				'101' => 'eBay Italy',
				'146' => 'eBay Netherlands',
				'205' => 'eBay Ireland',
				'193' => 'eBay Switzerland'
			),
			'default' => '0',
			'group' => 'feed',
			'title' => 'eBay Site'
		),
		//Step two
		'ad_format'  => array(
			'name' => 'ad_format',
			'id' => 'ad_format',
			'tip' => 'Choose from the following list of standard ad sizes.',
			'type' => 'select',
			'options' => array(
				'300x250' => 'Medium rectangle (300px x 250px)',
				'336x280' => 'Large rectangle (336px x 280px)',
				'250x250' => 'Square (250px x 250px)',
				'120x600' => 'Skyscraper (120px x 600px)',
				'728x90' => 'Leaderboard (728px x 90px)',
				'160x600' => 'Wide skyscraper (160px x 600px)'
			),
			'default' => '300x250',
			'group' => 'display',
			'title' => 'Ad Size'
		),
		'ad_theme'  => array(
			'name' => 'ad_theme',
			'id' => 'ad_theme',
			'tip' => 'Specifying a colour will change how the ad appears in order to better integrate with your site.',
			'type' => 'select',
			'options' => array(
				'green'  => 'Green',
				'red'  => 'Red',
				'blue'  => 'Blue',
				'orange'  => 'Orange',
				'grey' => 'Grey',
				'pink' => 'Pink'
			),
			'default' => 'green',
			'group' => 'display',
			'title' => 'Ad Colour'		
		),
		'ad_carousel_auto'  => array(
			'name' => 'ad_carousel_auto',
			'id' => 'ad_carousel_auto',
			'tip' => 'This option specifies how often, in seconds the ad should auto scroll. If set to 0 auto scroll is disabled.',
			'group' => 'display',
			'title' => 'Auto Scroll?',
			'default' => '0',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)
		),
		'ad_blank_noitems'  => array(
			'name' => 'ad_blank_noitems',
			'id' => 'ad_blank_noitems',
			'tip' => 'This option enables you to show nothing in the ad space if you do not have any active listings.',
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Blank Ad if no Listings?',
			'default' => '0',
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)				
		),
		'ad_hide_username'  => array(
			'name' => 'ad_hide_username',
			'id' => 'ad_hide_username',
			'tip' => 'This option hides your eBay username and instead displays \'Our items on eBay\' next to your feedback score.',
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Hide eBay Username?',
			'default' => '0',
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)			
		),				
		//Advanced
		'ad_sortOrder'  => array(
			'name' => 'ad_sortOrder',
			'id' => 'ad_sortOrder',
			'tip' => 'This option adjusts the order of the items shown.',
			'type' => 'select',
			'options' => array(
				'' => 'Items Ending First',
				'StartTimeNewest' => 'Newly-Listed First',
				'PricePlusShippingLowest' => 'Price + Shipping: Lowest First',
				'PricePlusShippingHighest' => 'Price + Shipping: Highest First',
				'BestMatch' => 'Best Match'
			),
			'group' => 'advanced',
			'title' => 'Sort Order'
		),
		'ad_keyword'  => array(
			'name' => 'ad_keyword',
			'id' => 'ad_keyword',
			'tip' => 'By specifying a keyword, only items which contain that keyword in their title will be displayed. Keywords can contain multiple words and up to 5 keywords may be specified. Keywords are separated with a colon (:) and this acts as an OR operator. For example the keywords &ldquo;red:dark blue:black&rdquo; will display all items with either &ldquo;red&rdquo; or &ldquo;dark blue&rdquo; or &ldquo;black&rdquo; in their title.',
			'group' => 'advanced',
			'title' => 'Filter by Keyword',
			'output_processing' => array(
				'str_replace("+", "%20", urlencode($param_value))'
			)
		),		
		'ad_categoryId'  => array(
			'name' => 'ad_categoryId',
			'id' => 'ad_categoryId',
			'tip' => 'By specifying an eBay category ID only items which are listed in this category will be displayed. You can specify up to 3 different category IDs by separating with a colon (:) for example 123:456:789.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#category-filter',			
			'group' => 'advanced',
			'title' => 'Filter by Category ID'
		)
	),	
	//Profile tool parameters	
	'profile_parameters' => array(
		'profile_UserID'  => array(
			'name' => 'profile_UserID',
			'id' => 'profile_UserID',
			'tip' => 'This is your eBay ID &ndash; the username you are known by on eBay and appears on your listings. This is not your store name.',
			'title' => 'eBay Username',
			'output_processing' => array(
				'an_username_encode($param_value)'
			)
		),
		'profile_siteid'  => array(
			'name' => 'profile_siteid',
			'id' => 'profile_siteid',
			'tip' => 'This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed.',
			'type' => 'select',
			'options' => array(
				'0' => 'eBay US',
				'3' => 'eBay UK',
				'2' => 'eBay Canada',
				'15' => 'eBay Australia',
				'23' => 'eBay Belgium',
				'77' => 'eBay Germany',
				'71' => 'eBay France',
				'186' => 'eBay Spain',
				'16' => 'eBay Austria',
				'101' => 'eBay Italy',
				'146' => 'eBay Netherlands',
				'205' => 'eBay Ireland',
				'193' => 'eBay Switzerland'
			),
			'default' => '0',
			'title' => 'eBay Site'
		),
		'profile_theme'  => array(
			'name' => 'profile_theme',
			'id' => 'profile_theme',
			'tip' => 'Your profile will display differently on your site depending on which theme you choose.',
			'type' => 'select',
			'options' => array(
				'overview' => 'Overview',
				'star_grey' => 'Grey Star',
				'badge' => 'Rectangular Badge',
				'simple_details' => 'Simple Details'
			),
			'default' => 'overview',
			'title' => 'Theme'
		),
		'profile_lang' => array(
			'name' => 'profile_lang',			
			'id' => 'profile_lang',			
			'tip' => 'The language option allows you to specify which language Auction Nudge tools display on your site.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#language',
			'type' => 'select',
			'options' => array(
				'english' => 'English',
				'french' => 'French',
				'german' => 'German',
				'italian' => 'Italian',
				'spanish' => 'Spanish'
			),						
			'default' => 'english',
			'group' => 'display',
			'title' => 'Language'
		),			
		'profile_blank'  => array(
			'name' => 'profile_blank',
			'id' => 'profile_blank',
			'tip' => 'Enabling this option will open item links in a new browser tab.',
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Open Links in New Tab?',
			'default' => '0',
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)
		)		
	),
	//Feedback tool parameters	
	'feedback_parameters' => array(
		'feedback_UserID'  => array(
			'name' => 'feedback_UserID',
			'id' => 'feedback_UserID',
			'tip' => 'This is your eBay ID &ndash; the username you are known by on eBay and appears on your listings. This is not your store name.',
			'title' => 'eBay Username',
			'output_processing' => array(
				'an_username_encode($param_value)'
			)
		),
		'feedback_siteid'  => array(
			'name' => 'feedback_siteid',
			'id' => 'feedback_siteid',
			'tip' => 'This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed.',
			'type' => 'select',
			'options' => array(
				'0' => 'eBay US',
				'3' => 'eBay UK',
				'2' => 'eBay Canada',
				'15' => 'eBay Australia',
				'23' => 'eBay Belgium',
				'77' => 'eBay Germany',
				'71' => 'eBay France',
				'186' => 'eBay Spain',
				'16' => 'eBay Austria',
				'101' => 'eBay Italy',
				'146' => 'eBay Netherlands',
				'205' => 'eBay Ireland',
				'193' => 'eBay Switzerland'
			),
			'default' => '0',
			'title' => 'eBay Site'
		),
		'feedback_theme'  => array(
			'name' => 'feedback_theme',
			'id' => 'feedback_theme',
			'tip' => 'Your feedback will display differently on your site depending on which theme you choose.',
			'type' => 'select',
			'options' => array(
				'profile_table' => 'Profile table',
				'table' => 'Basic table'
			),
			'default' => 'profile_table',
			'default_old' => 'table',
			'title' => 'Theme'
		),		
		'feedback_lang' => array(
			'name' => 'feedback_lang',			
			'id' => 'feedback_lang',			
			'tip' => 'The language option allows you to specify which language Auction Nudge tools display on your site.',
			'tip_link' => 'https://www.auctionnudge.com/help/options#language',
			'type' => 'select',
			'options' => array(
				'english' => 'English',
				'french' => 'French',
				'german' => 'German',
				'italian' => 'Italian',
				'spanish' => 'Spanish'
			),						
			'default' => 'english',
			'group' => 'display',
			'title' => 'Language'
		),			
		'feedback_limit'  => array(
			'name' => 'feedback_limit',
			'id' => 'feedback_limit',
			'tip' => 'This number determines how many feedback entries will be displayed.',
			'title' => 'Entries to Show (1-5)',
			'default' => '5',
			'input_processing' => array(
				'preg_replace("/[^0-9]/", "", $param_value);'
			)			
		),		
/*
		'feedback_type'  => array(
			'name' => 'feedback_type',
			'id' => 'feedback_type',
			'tip' => 'Determines the type of feedback entries displayed.',
			'type' => 'select',
			'options' => array(
				'FeedbackReceived' => 'All feedback received',
				'FeedbackLeft' => 'All feedback left for others',
				'FeedbackReceivedAsBuyer' => 'Feedback received as a buyer',
				'FeedbackReceivedAsSeller' => 'Feedback received as a seller'
			),
			'default' => 'FeedbackReceived',
			'title' => 'Feedback type'
		),
*/
		'feedback_blank'  => array(
			'name' => 'feedback_blank',
			'id' => 'feedback_blank',
			'tip' => 'Enabling this option will open item links in a new browser tab.',
			'type' => 'radio',
			'group' => 'display',
			'title' => 'Open Links in New Tab?',
			'default' => '0',
			'options' => array(
				'1' => 'Yes',
				'0' => 'No'
			)
		)
	)	
);
