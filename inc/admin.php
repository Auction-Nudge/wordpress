<?php

/**
 * ======================================================== 
 * ====================== ADMIN  ==========================
 * ========================================================
 */

/**
 * Setup admin
 */
function an_admin_init() {
	//Permissions
	if(current_user_can('manage_options')) {
		//Add custom fields
		add_action('admin_head-post.php', 'an_update_parameter_defaults');
		add_action('admin_head-post.php', 'an_create_custom_fields_box');
		add_action('admin_head-post-new.php', 'an_update_parameter_defaults');
		add_action('admin_head-post-new.php', 'an_create_custom_fields_box');

		//Save custom fields
		add_action('save_post', 'an_save_custom_fields', 10, 2);

		//Add CSS
		wp_register_style('an_admin_css', plugins_url('assets/css/admin.css', dirname(__FILE__)), array(), an_get_config('plugin_version'));
		wp_enqueue_style('an_admin_css');	

		//Add JS
		wp_register_script('an_admin_js', plugins_url('assets/js/admin.js', dirname(__FILE__)), array('jquery'), an_get_config('plugin_version'));
		wp_enqueue_script('an_admin_js');
	}
}
add_action('admin_init', 'an_admin_init');

/**
 * Validate our options
 */
function an_options_validate($input) {
	$output = array();
	foreach($input as $o_key => $o_value) {
		$output[$o_key] = trim($o_value);
	}
	return $output;
}

/**
 * Get plugin options
 */
function an_get_option($option_key) {
	$options = get_option('an_options');
	
	if(is_array($options) && array_key_exists($option_key, $options)) {
		return $options[$option_key];		
	} else {
		return false;		
	}
}

/**
 * Ads...
 */
function an_ads_disable() {
	$an_options = get_option('an_options');
	
	//No settings present, or not the one we are looking for
	if(! is_array($an_options) || ! array_key_exists('an_ads_disable', $an_options)) {
		global $wpdb;
		
		//Check post meta
		$results = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_key` LIKE '%ad_SellerID%'", ARRAY_A);			

		//If post meta
		if(sizeof($results) > 0) {
			//Don't disable
			$an_options['an_ads_disable'] = false;				
		//If no page meta
		} else {
			//Then check for widget meta WITH DATA
			$results = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "options` WHERE option_name LIKE 'widget_an_%_widget' AND option_value LIKE '%siteid%'", ARRAY_A);
			
			//If widget meta		
			if(sizeof($results) > 0) {
				//Don't disable
				$an_options['an_ads_disable'] = false;				
			//No widget meta either
			} else {
				//Disable
				$an_options['an_ads_disable'] = true;								
			}
		}
		
		update_option('an_options', $an_options);
	}
}
add_action('admin_init', 'an_ads_disable');

/**
 * Username change
 */
function an_propagate_username_change($an_new_username) {
	global $wpdb;
	
	//Update posts...
	
	$wpdb->query( 
		$wpdb->prepare("
			UPDATE $wpdb->postmeta
			SET meta_value = '%s'
			WHERE meta_key IN('item_SellerID', 'ad_SellerID', 'profile_UserID', 'feedback_UserID')
		", $an_new_username)
	);
	
	//Update widgets...
	
	//Ad widgets
	$an_widgets_options = get_option('widget_an_ads_widget');
	foreach($an_widgets_options as &$an_widget_options) {
		if(is_array($an_widget_options) && array_key_exists('ad_SellerID', $an_widget_options)) {
			$an_widget_options['ad_SellerID'] = $an_new_username;				
		}
	}		
	update_option('widget_an_ads_widget', $an_widgets_options);

	//Feedback widgets
	$an_widgets_options = get_option('widget_an_feedback_widget');
	foreach($an_widgets_options as &$an_widget_options) {
		if(is_array($an_widget_options) && array_key_exists('feedback_UserID', $an_widget_options)) {
			$an_widget_options['feedback_UserID'] = $an_new_username;				
		}
	}		
	update_option('widget_an_feedback_widget', $an_widgets_options);

	//Profile widgets
	$an_widgets_options = get_option('widget_an_profile_widget');
	foreach($an_widgets_options as &$an_widget_options) {
		if(is_array($an_widget_options) && array_key_exists('profile_UserID', $an_widget_options)) {
			$an_widget_options['profile_UserID'] = $an_new_username;				
		}
	}		
	update_option('widget_an_profile_widget', $an_widgets_options);
	
	//Listings widget
	$an_widgets_options = get_option('widget_an_listings_widget');
	foreach($an_widgets_options as &$an_widget_options) {
		if(is_array($an_widget_options) && array_key_exists('item_SellerID', $an_widget_options)) {
			$an_widget_options['item_SellerID'] = $an_new_username;				
		}
	}		
	update_option('widget_an_listings_widget', $an_widgets_options);	
}

/**
 * Helpful upgrade notification
 */
function an_show_upgrade_notification($current_plugin_metadata, $new_plugin_metadata){
   //Check Upgrade Notice
   if(isset($new_plugin_metadata->upgrade_notice) && strlen(trim($new_plugin_metadata->upgrade_notice)) > 0) {
	    echo '<br /><br /><strong style="color:#f56e28">Important Update!</strong><br />' . strip_tags($new_plugin_metadata->upgrade_notice);
   }
}
add_action('in_plugin_update_message-auction-nudge/auctionnudge.php', 'an_show_upgrade_notification', 10, 2);

/**
 * Modify plugin action links
 */
function an_add_action_links($links) {
 $links_before = array();
 $links_after = array(
 	'<a href="' . admin_url('options-general.php?page=an_options_page') . '">Settings</a>',	 
 );
 
 return array_merge($links_before, $links, $links_after);
}
add_filter('plugin_action_links_auction-nudge/auctionnudge.php', 'an_add_action_links');


/**
 * ================= CUSTOM FIELDS ========================
 */
 
/**
 * Create the custom fields box
 */
function an_create_custom_fields_box() {
	foreach(array('post', 'page') as $post_type) {
		add_meta_box('an-custom-fields', an_get_config('plugin_name'), 'an_create_custom_field_form', $post_type, 'normal', 'high');
	}
}

/**
 * Create the custom field form
 */
function an_create_custom_field_form() {	
	global $post;
	
	//Get post meta	
	$post_meta = get_post_meta($post->ID);
	
	$out = '<div id="an-custom-field-container">' . "\n";
	
	//Tabs
	$out .= '<ul id="an-tab-links">' . "\n";
	$out .= '	<li><a class="an-tab-link active" data-tab="listings-tab" href="#">Your eBay Listings</a></li>' . "\n";
	//Show Ad tool?
	if(an_get_option('an_ads_disable') == false) {
		$out .= '	<li><a class="an-tab-link" data-tab="ads-tab" href="#">Your eBay Ads</a></li>' . "\n";
	}
	$out .= '	<li><a class="an-tab-link" data-tab="profile-tab" href="#">Your eBay Profile</a></li>' . "\n";
	$out .= '	<li><a class="an-tab-link" data-tab="feedback-tab" href="#">Your eBay Feedback</a></li>' . "\n";	
	$out .= '</ul>' . "\n";
	
	//Item tool
	$out .= '<div id="listings-tab" class="an-custom-field-tab">' . "\n";			
	$out .= '	<div class="an-custom-field-help">' . "\n";
	$out .= '		<p>Use these options to specify which of your eBay items to display within your page/post.</p><p>Add the following shortcode within your content editor to specify where the items will appear:</p><p>[' . an_get_config('shortcode') . ' tool="listings"]</p><p><small><b>Note:</b> Only one set of eBay listings can be loaded per page.</small></p>' . "\n";
	$out .= '		<a class="button" target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage">Help</a>' . "\n";
	$out .= '	</div>' . "\n";
	$out .= '	<h2>Your eBay Listings</h2>' . "\n";						
	
	//Get stored post meta values
	$tool_parameters = an_request_parameters_from_assoc_array('item', $post_meta, false);
	$out .= an_create_tool_custom_fields('item', $tool_parameters);
	
	$out .= '</div>' . "\n";			

	//Show Ad tool?
	if(an_get_option('an_ads_disable') == false) {
		//Ad tool
		$out .= '<div id="ads-tab" class="an-custom-field-tab" style="display:none">' . "\n";			
		$out .= '	<div class="an-custom-field-help">' . "\n";
		$out .= '		<p><b>The Your eBay Ads tool is no longer recommended due to very poor conversion rates.</b> You should try the the <b>Your eBay Listings</b> tool instead. More information <a target="_blank" href="https://www.auctionnudge.com/changes#v3.8">here</a>.</p>' . "\n";
		$out .= '		<p>Use these options to specify the type of ad to display within your page/post.</p><p>Add the following shortcode within your content editor to specify where the ad will appear:</p><p>[' . an_get_config('shortcode') . ' tool="ads"]</p><p><small><b>Note:</b> Only one type of eBay ad can be loaded within each content area.</small></p>' . "\n";
		$out .= '	</div>' . "\n";
		$out .= '	<h2>Your eBay Ads</h2>' . "\n";						

		//Get stored post meta values
		$tool_parameters = an_request_parameters_from_assoc_array('ad', $post_meta, false);
		$out .= an_create_tool_custom_fields('ad', $tool_parameters);

		$out .= '</div>' . "\n";		
	}
			
	//Profile tool
	$out .= '<div id="profile-tab" class="an-custom-field-tab" style="display:none">' . "\n";				
	$out .= '	<div class="an-custom-field-help">' . "\n";
	$out .= '		<p>Use these options to specify how your eBay profile will appear within your page/post.</p><p>Add the following shortcode within your content editor to specify where the items will appear:</p><p>[' . an_get_config('shortcode') . ' tool="profile"]</p><p><small><b>Note:</b> Only one profile can be loaded per page.</small></p>' . "\n";
	$out .= '		<a class="button" target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage">Help</a>' . "\n";
	$out .= '	</div>' . "\n";
	$out .= '	<h2>Your eBay Profile</h2>' . "\n";						

	//Get stored post meta values
	$tool_parameters = an_request_parameters_from_assoc_array('profile', $post_meta, false);
	$out .= an_create_tool_custom_fields('profile', $tool_parameters);

	$out .= '</div>' . "\n";			

	//Feedback tool
	$out .= '<div id="feedback-tab" class="an-custom-field-tab" style="display:none">' . "\n";			
	$out .= '	<div class="an-custom-field-help">' . "\n";
	$out .= '		<p>Use these options to specify how your eBay feedback will appear within your page/post.</p><p>Add the following shortcode within your content editor to specify where the items will appear:</p><p>[' . an_get_config('shortcode') . ' tool="feedback"]</p><p><small><b>Note:</b> Only one set of feedback can be loaded per page.</small></p>' . "\n";
	$out .= '		<a class="button" target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage">Help</a>' . "\n";
	$out .= '	</div>' . "\n";
	$out .= '	<h2>Your eBay Feedback</h2>' . "\n";						

	//Get stored post meta values
	$tool_parameters = an_request_parameters_from_assoc_array('feedback', $post_meta, false);
	$out .= an_create_tool_custom_fields('feedback', $tool_parameters);

	$out .= '</div>' . "\n";			
						
	$out .= '</div> <!-- END #an-custom-field-container -->' . "\n";
	$out .= '<div id="adblock-test" class="auction-nudge"></div>' . "\n";	

	echo $out;
}

/**
 * Create fields for tool
 */
function an_create_tool_custom_fields($tool_key, $tool_params, $field_name_format = '%s') {
	$out = '';

	$current_group = false;
	//Iterate over each field
	foreach(an_get_config($tool_key . '_parameters') as $field) {
		//Does this tool have groups?
		if($tool_has_groups = (an_get_config($tool_key . '_parameter_groups') !== false)) {
			$parameter_groups = an_get_config($tool_key . '_parameter_groups');
			$group = $parameter_groups[$field['group']];
					
			//Output group?
			if($current_group != $group) {
				//Close previous fieldset?
				if($current_group !== false) {			
					$out .= '	</div>' . "\n";
					$out .= '</fieldset>' . "\n";					
				}
				$out .= '	<fieldset class="an-parameter-group an-parameter-group-' . $field['group'] . '">' . "\n";					
				$out .= '		<legend title="Click to expand">' . $group['name'] . '</legend>' . "\n";
				$out .= '		<div class="an-parameter-group-content">' . "\n";
				$out .= '			<p>' . $group['description'] . '</p>' . "\n";
				$current_group = $group;
			}
			
		}

		//Get saved custom field value
		if(array_key_exists($field['name'], $tool_params)) {
			//Is array?
			if(is_array($tool_params[$field['name']])) {
				$set_value = $tool_params[$field['name']][0];
			} else {
				$set_value = $tool_params[$field['name']];				
			}
		} else {
			$set_value = false;
		}

		//Update field names
		$field['name'] = sprintf($field_name_format, $field['name']);
		
		//Defaults...

		//Do we have a default?
		if(array_key_exists('default', $field)) {
			//Do we need to maintain old defaults?
			//This is used when a parameter is added/updated and the default is changed,
			//but we don't want to force existing users to use it
			//...
			//If tool has existing data and there is an old default value
			if((sizeof($tool_params) && array_key_exists($tool_key . '_siteid', $tool_params)) && array_key_exists('default_old', $field)) {
				//Set the old default
				$field['default'] = $field['default_old'];
			}			
		//No default
		} else {
			$field['default'] = false;		
		}		
		
		//Get the input
		$out .= an_create_custom_field_input($field, $set_value);	
	}
	
	if($tool_has_groups) {
		$out .= '		</div>' . "\n";
		$out .= '	</fieldset>' . "\n";			
	}
	
	return $out;
}

/**
 * Create the custom fields inputs
 */
function an_create_custom_field_input($field, $set_value = false) {
	$out = '';
	
	//ID
	$field['id'] = an_unprefix($field['id']);

	//Container
	$out .= '<div class="control-group" id="' . $field['id'] . '-container">' . "\n";

	//Label
	$out .= '	<label class="control-label" for="' . $field['name'] . '">' . $field['title'] .  '</label>' . "\n";
	$out .= '	<div class="controls">' . "\n";				

	//Default type
	if(! array_key_exists('type', $field)) {
		$field['type'] = 'text';
	}
	
	//Create input
	$out .= an_create_input($field, $set_value);

	//Tip
	if($field['tip']) {
		$out .= ' <a class="an-tooltip" data-title="' . $field['tip'] . '';
		if(array_key_exists('tip_link', $field)) {
			$out .= ' Click for more details." href="' . $field['tip_link'] . '" target="_blank"';					
		} else {
			$out .= '" href="#" onclick="return false;"';
		}
		$out .= '>?</a>';
	}
	
	$out .= '	</div>' . "\n";								
	$out .= '</div>' . "\n";
	
	return $out;
}

/**
 * Save the custom field data
 */
function an_save_custom_fields($post_id, $post) {
	//Ensure the user clicked the Save/Publish button
	//Credit: https://tommcfarlin.com/wordpress-save_post-called-twice/
	if(! (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id))) {
		//Save parameters as post meta
		an_save_post_meta_from_form_post($post_id, $_POST);
	}
}

/**
 * ================== SETTINGS PAGE =======================
 */

/**
 * Create settings page
 */
function an_admin_page() {
	//Permissions
	if(current_user_can('manage_options')) {
		add_options_page(an_get_config('plugin_name') . ' Options', an_get_config('plugin_name'), 'manage_options', 'an_options_page', 'an_options_page');
	}
}
add_action('admin_menu', 'an_admin_page');

/**
 * Display the settings page
 */
function an_options_page() {
	echo '<div id="an-options-container">' . "\n";

	echo '	<a class="button right" target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage">Help</a>' . "\n";

	echo '	<div id="an-about">' . "\n";	
	echo '		<img width="60" height="60" alt="Joe\'s mug" src="http://www.josephhawes.co.uk/assets/images/Joe1BW.jpg" />' . "\n";		
	echo '		<p><b>Hi, I\'m Joe and I created this plugin.</b></p>' . "\n";		
	echo '		<p>I highly recommend watching the <a target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage#video">Walk-through Video</a> on how to use the plugin.</p>' . "\n";	
	echo '		<p>Most common issues are solved by reading the <a target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/help">Help</a> section. Bugs and errors can be reported <a target="_blank" href="https://www.auctionnudge.com/issues">here</a>. Please do this before leaving a poor review.</p>' . "\n";	
	echo '		<p>If you like the plugin, please show your appreciation by <a target="_blank" href="https://wordpress.org/support/plugin/auction-nudge/reviews/">leaving a rating</a>. It really does help.</p>' . "\n";		
	echo '		<p><b>Thanks!</b></p>' . "\n";		
	echo '		<a class="button" target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage#video">Walk-through Video</a>' . "\n";
	echo '		<a class="button" target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/help">Plugin Help</a>' . "\n";
	echo '		<a class="button button-primary" target="_blank" href="https://wordpress.org/support/plugin/auction-nudge/reviews/">Rate the plugin <span class="dashicons dashicons-smiley" style="font-size:20px;padding-top:1px"></span></a>' . "\n";
	echo '	</div>' . "\n";

	echo '	<h1>' . an_get_config('plugin_name') . '</h1>' . "\n";
	
	echo '<p>To add Auction Nudge to your pages or posts, use the Auction Nudge box on the edit page. You can also add Auction Nudge to your theme as <a href="' . admin_url('widgets.php') . '">Widgets</a>. The Settings below can be used to specify some defaults and style rules, but are not required.</p>' . "\n";
	
	echo '<p>For more details on how to use the plugin, you can watch the <a target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage#video">Walk-through Video</a>.</p>' . "\n";
	
	//Tabs
	$active_tab = (isset($_GET['tab'])) ? $_GET['tab'] : 'general';
	an_admin_tabs($active_tab);
	
	//Open form
	echo '	<form action="' . admin_url('options.php') . '" method="post">' . "\n";
	settings_fields('an_options');
	
	//Preserve value
	$an_options = get_option('an_options');	
	$an_ads_disable = ($an_options['an_ads_disable']) ? 1 : 0;
	echo '<input type="hidden" id="an_ads_disable" name="an_options[an_ads_disable]" value="' . $an_ads_disable . '" />';

	//Propagate username change?
	if(isset($an_options['an_username_propagate']) && $an_options['an_username_propagate'] == 'true') {
		an_propagate_username_change($an_options['an_ebay_user']);
	}
	
	//Which group of options are we showing?
	switch($active_tab) {
		case 'theme' :
			echo '<div style="display:none">';
			do_settings_sections('an_general');
			echo '</div>';
			echo '<p><strong>To add Auction Nudge to your pages / posts use the Auction Nudge box on the edit page. The options on this page allow you to specify code snippets from within your theme if you are modifying your theme\'s PHP scripts.</strong></p>' . "\n";
			echo '<p>In <em>most</em> cases you will not need to use these options. If you are unsure how to use the plugin, I recommend checking out this quick <a target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage#video">Walk-through Video</a>.</p>' . "\n";
			echo '<p>To modify these options, click <a href="#" id="an-theme-show">here</a>.</p>' . "\n";
			echo '<div id="an-theme-options" style="display:none">' . "\n";
			do_settings_sections('an_theme');
			echo '</div>' . "\n";
			break;
		case 'general' :
		default :
			do_settings_sections('an_general');
			echo '<div style="display:none">';
			do_settings_sections('an_theme');
			echo '</div>';
			break;
	}
	
	//Submit
	echo '		<input class="button button-primary" name="Submit" type="submit" value="Save Settings" />' . "\n";
	echo '	</form>' . "\n";
	
	echo '</div>' . "\n";
	echo '<div id="adblock-test" class="auction-nudge"></div>';
}

/**
 * Settings page tabs
 */
function an_admin_tabs($current = 'general') {
  $tabs = array(
  	'general' => 'General',
  	'theme' => 'Within Your Theme'
  );
  $links = array();
  foreach($tabs as $slug => $name) {
		if($slug == $current) {
			$links[] = '<a class="nav-tab nav-tab-active" href="?page=an_options_page&tab=' . $slug . '">' . $name . '</a>';
		} else {
			$links[] = '<a class="nav-tab" href="?page=an_options_page&tab=' . $slug . '">' . $name . '</a>';
		}
  }
  echo '<h2 class="nav-tab-wrapper">';
  foreach($links as $link) {
		echo $link; 
  }      
  echo '</h2>';
}

/**
 * Define settings
 */
function an_admin_settings(){
	//Permissions
	if(current_user_can('manage_options')) {
		register_setting('an_options', 'an_options', 'an_options_validate');

		//General...
		
		//eBay ID
		add_settings_section('an_ebay_defaults', 'Your eBay Defaults', 'an_ebay_defaults_text', 'an_general');
		add_settings_field('an_ebay_user', 'eBay Username', 'an_ebay_user_setting', 'an_general', 'an_ebay_defaults');
		add_settings_field('an_ebay_site', 'eBay Site', 'an_ebay_site_setting', 'an_general', 'an_ebay_defaults');

		//CSS
		add_settings_section('an_css', 'Your CSS Rules', 'an_css_text', 'an_general');
		add_settings_field('an_css_rules', 'Insert CSS Rules', 'an_css_setting', 'an_general', 'an_css');		

		//Requests
		add_settings_section('an_request', 'Caching', 'an_request_text', 'an_general');
		add_settings_field('an_local_requests', 'Use WordPress Cache?', 'an_local_requests_setting', 'an_general', 'an_request');		

		
		//Within Your Theme...

		//Items
		add_settings_section('an_items', 'Your eBay Listings', 'an_items_text', 'an_theme');
		add_settings_field('an_items_code_snippet', 'Insert code snippet', 'an_items_setting', 'an_theme', 'an_items');

		//Profile
		add_settings_section('an_profile', 'Your eBay Profile', 'an_profile_text', 'an_theme');
		add_settings_field('an_profile_code_snippet', 'Insert code snippet', 'an_profile_setting', 'an_theme', 'an_profile');

		//Feedback
		add_settings_section('an_feedback', 'Your eBay Feedback', 'an_feedback_text', 'an_theme');
		add_settings_field('an_feedback_code_snippet', 'Insert code snippet', 'an_feedback_setting', 'an_theme', 'an_feedback');
	}
}
add_action('admin_init', 'an_admin_settings');

/**
 * eBay defaults
 */
function an_ebay_defaults_text() {
	echo '<p>Entering a default eBay username and site here will save you from re-entering them on each page, post or widget where you want to use Auction Nudge.</p>' . "\n";
}

/**
 * Output eBay ID option
 */
function an_ebay_user_setting() {
	$options = get_option('an_options');
	
	//Option set?
	if(is_array($options) && array_key_exists('an_ebay_user', $options)) {
		$ebay_user_setting = $options['an_ebay_user'];
	} else {
		$ebay_user_setting = '';
	}
		
	echo '<input type="text" id="an_ebay_user" class="regular-text" name="an_options[an_ebay_user]" value="' . $ebay_user_setting . '" />' . "\n";
	echo '<a class="an-tooltip" data-title="This is your eBay ID &ndash; the username you are known by on eBay and appears on your listings. This is not your store name." href="#" onclick="return false;">?</a>' . "\n";
	echo '<div style="margin-top:5px;">' . "\n";
	echo '<input type="checkbox" id="an_username_propagate" name="an_options[an_username_propagate]" value="true" />' . "\n";
	echo '<small>Update every instance</small>	<a class="an-tooltip" data-title="Should you change eBay username, you can also use this option to update every Auction Nudge instance with the new setting." href="#" onclick="return false;">?</a>' . "\n";
	echo '</div>' . "\n";	
}

/**
 * Output eBay site option
 */
function an_ebay_site_setting() {
	$options = get_option('an_options');

	//Option set?
	if(is_array($options) && array_key_exists('an_ebay_site', $options)) {
		$ebay_site_setting = $options['an_ebay_site'];
	} else {
		$ebay_site_setting = '0';
	}

	$siteids = array(
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
	);
	
	echo '<select name="an_options[an_ebay_site]" id="an_ebay_site">' . "\n";
	foreach($siteids as $siteid => $description) {
		$selected = ($ebay_site_setting == $siteid) ? ' selected="selected"' : '';
		echo '	<option value="' . $siteid . '"' . $selected . '>' . $description . '</option>' . "\n";	
	}
	echo '</select>' . "\n";
	echo '<a class="an-tooltip" data-title="This is where your items are usually listed. The site you choose will determine where you link to and what currency is displayed." href="#" onclick="return false;">?</a>' . "\n";
}

/**
 * CSS text
 */
function an_css_text() {
	echo '<p>You can modify the appearance of Auction Nudge by pasting <abbr title="Cascading Style Sheets">CSS</abbr> rules into this box.</p>' . "\n";
	echo '<p>For example <code>div#auction-nudge-items a { color: red }</code> will make all links displayed by the Your eBay Listings tool red. You can find more information and demos on modifying the appearance of Auction Nudge <a target="_blank" href="https://www.auctionnudge.com/customize/appearance">here</a>.</p>' . "\n";
}

/**
 * Output CSS option
 */
function an_css_setting() {
	$options = get_option('an_options');
	
	$an_css_rules = isset($options['an_css_rules']) ? $options['an_css_rules'] : '';
	
	echo '<textarea id="an_css_rules" name="an_options[an_css_rules]" rows="6" style="font-family:courier;width:400px">' . $an_css_rules . '</textarea>' . "\n";		
}

/**
 * Request text
 */
function an_request_text() {
	echo '<p>The plugin utilises the in-built WordPress caching mechanism to deliver Auction Nudge content, increasing performance.</p>' . "\n";

	echo '<p>If you are experiencing issues with Auction Nudge (like if nothing is displayed), try changing this setting to "No". Don\'t worry, other caching mechanisms are still in place.</p>' . "\n";
}

/**
 * Local Requests option
 */
function an_local_requests_setting() {
	$options = get_option('an_options');
	
	$an_local_requests = isset($options['an_local_requests']) ? $options['an_local_requests'] : '1';
	
	echo '<select id="an_local_requests" name="an_options[an_local_requests]">' . "\n";		
	$selected = ($an_local_requests == '1') ? ' selected="selected"' : '';
	echo '	<option value="1"' . $selected . '>Yes</option>' . "\n";		
	$selected = ($an_local_requests == '0') ? ' selected="selected"' : '';
	echo '	<option value="0"' . $selected . '>No</option>' . "\n";		
	echo '</select>' . "\n";			
}


/**
 * ==================== LEGACY ============================
 */

/**
 * Items text
 */
function an_items_text() {
	echo '<p>To begin <strong>you must obtain your code snippet from the Auction Nudge website</strong> <a target="_blank" href="https://www.auctionnudge.com/tools/your-ebay-items">here</a> (shown as "Copy the code snippet onto your site") and paste it into the box below.</p>' . "\n";
	echo '<p>You can then call <code>&lt;?php an_items(); ?&gt;</code> from within your theme files to display Your eBay Listings where desired.</p>' . "\n";
}

/**
 * Output items option
 */
function an_items_setting() {
	$options = get_option('an_options');

	$an_items_code = isset($options['an_items_code']) ? $options['an_items_code'] : '';
	
	echo '<textarea id="an_items_code_snippet" name="an_options[an_items_code]" rows="6" style="font-family:courier;width:400px">' . $an_items_code  . '</textarea>' . "\n";
}

/**
 * Profile text
 */
function an_profile_text() {
	echo '<p>To begin <strong>you must obtain your code snippet from the Auction Nudge website</strong> <a target="_blank" href="https://www.auctionnudge.com/tools/your-ebay-profile">here</a> (shown as "Copy the code snippet onto your site") and paste it into the box below.</p>' . "\n";
	echo '<p>You can then call <code>&lt;?php an_profile(); ?&gt;</code> from within your theme files to display Your eBay Profile where desired.</p>' . "\n";
}

/**
 * Output profile option
 */
function an_profile_setting() {
	$options = get_option('an_options');
	
	$an_profile_code = isset($options['an_profile_code']) ? $options['an_profile_code'] : '';	
	
	echo '<textarea id="an_profile_code_snippet" name="an_options[an_profile_code]" rows="6" style="font-family:courier;width:400px">' . $an_profile_code . '</textarea>' . "\n";
}

/**
 * Feedback text
 */
function an_feedback_text() {
	echo '<p>To begin <strong>you must obtain your code snippet from the Auction Nudge website</strong> <a target="_blank" href="https://www.auctionnudge.com/tools/your-ebay-feedback">here</a> (shown as "Copy the code snippet onto your site") and paste it into the box below.</p>' . "\n";
	echo '<p>You can then call <code>&lt;?php an_feedback(); ?&gt;</code> from within your theme files to display Your eBay Feedback where desired.</p>' . "\n";
}

/**
 * Output feedback option
 */
function an_feedback_setting() {
	$options = get_option('an_options');
	
	$an_feedback_code = isset($options['an_feedback_code']) ? $options['an_feedback_code'] : '';		
	
	echo '<textarea id="an_feedback_code_snippet" name="an_options[an_feedback_code]" rows="6" style="font-family:courier;width:400px">' . $an_feedback_code . '</textarea>' . "\n";
}