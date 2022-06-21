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
	$an_settings = an_get_settings();
	
	if(is_array($an_settings) && array_key_exists($option_key, $an_settings)) {
		return $an_settings[$option_key];		
	} else {
		return false;		
	}
}

/**
 * Ads...
 */
function an_legacy_features() {
	global $wpdb;
		
	$an_settings = an_get_settings();
	
	//Meta disable
	if(! array_key_exists('an_meta_disable', $an_settings)) {
		//Check post meta
		$results = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_key` REGEXP '^(item_|profile_|feedback|ad_)(.*)'", ARRAY_A);			

		//If post meta
		if(sizeof($results) > 0) {
			//Don't disable
			$an_settings['an_meta_disable'] = false;				
		} else {
			//Disable
			$an_settings['an_meta_disable'] = true;								
		}
		
		update_option('an_options', $an_settings);
	}

	//Widgets disable
	if(! array_key_exists('an_widget_disable', $an_settings)) {
		//Check post meta
		$results = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "options` WHERE option_name LIKE 'widget_an_%_widget' AND option_value LIKE '%_siteid%'", ARRAY_A);

		//If post meta
		if(sizeof($results) > 0) {
			//Don't disable
			$an_settings['an_widget_disable'] = false;				
		} else {
			//Disable
			$an_settings['an_widget_disable'] = true;								
		}
		
		update_option('an_options', $an_settings);
	}

	//ADs disable?
	if(! array_key_exists('an_ads_disable', $an_settings)) {
		//Check post meta
		$results = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "postmeta` WHERE `meta_key` LIKE '%ad_SellerID%'", ARRAY_A);			

		//If post meta
		if(sizeof($results) > 0) {
			//Don't disable
			$an_settings['an_ads_disable'] = false;				
		//If no page meta
		} else {
			//Then check for an Ad widget meta WITH DATA
			$results = $wpdb->get_results("SELECT * FROM `" . $wpdb->prefix . "options` WHERE option_name LIKE 'widget_an_ads_widget' AND option_value LIKE '%ad_SellerID%'", ARRAY_A);
			
			//If widget meta		
			if(sizeof($results) > 0) {
				//Don't disable
				$an_settings['an_ads_disable'] = false;				
			//No widget meta either
			} else {
				//Disable
				$an_settings['an_ads_disable'] = true;								
			}
		}
		
		update_option('an_options', $an_settings);
	}
}
add_action('admin_init', 'an_legacy_features');

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
	$an_settings = an_get_settings();
	
	//Not if disabled
	if(isset($an_settings['an_meta_disable']) && $an_settings['an_meta_disable']) {
		return false;	
	}

	foreach(array('post', 'page') as $post_type) {
		add_meta_box('an-custom-fields', an_get_config('plugin_name'), 'an_create_custom_field_callback', $post_type, 'normal', 'high');
	}
}

function an_create_custom_field_callback($tools_meta) {
	echo an_create_custom_field_form($tools_meta, 'item', true);	//Show Help
}

/**
 * Create the custom field form
 */
function an_create_custom_field_form($tools_meta = [], $inital_tool = 'item', $show_shortcode = false) {	
	global $post;

	//Do we have?
	if(isset($post->ID)) {
		//Get meta for tools
		$tools_meta = an_get_post_meta($post->ID);
	}
	
	$out = '<div id="an-custom-field-container">' . "\n";
	
	// == Tabs ==
	$out .= '<select name="tool_key" id="an-tab-links">' . "\n";
	
	$selected = ($inital_tool == 'item') ? ' selected="selected"' : '';
	$out .= '	<option' . $selected . ' value="item" class="an-tab-link active" data-tab="listings-tab">Your eBay Listings</option>' . "\n";

	$selected = ($inital_tool == 'profile') ? ' selected="selected"' : '';
	$out .= '	<option' . $selected . ' value="profile" class="an-tab-link" data-tab="profile-tab">Your eBay Profile</option>' . "\n";
	
	$selected = ($inital_tool == 'feedback') ? ' selected="selected"' : '';
	$out .= '	<option' . $selected . ' value="feedback" class="an-tab-link" data-tab="feedback-tab">Your eBay Feedback</option>' . "\n";	
	$out .= '</select>' . "\n";
	
	// == Item tool ==

	$style = ($inital_tool == 'item') ? '' : ' style="display:none"';
	$out .= '<div' . $style . ' id="listings-tab" class="an-custom-field-tab">' . "\n";			
	
	//Get stored post meta values
	$tool_parameters = an_request_parameters_from_assoc_array('item', $tools_meta, false);
	$out .= an_create_tool_custom_fields('item', $tool_parameters);

	//Output Shortcode
	if($show_shortcode) {
		$out .= an_build_shortcode('item');
	}

	$out .= '</div>' . "\n";			

	// == Ad tool (Legacy) ==

	if(isset($post->ID) && an_get_option('an_ads_disable') == false) {
		$out .= '<div id="ads-tab" class="an-custom-field-tab" style="display:none">' . "\n";			

		//Get stored post meta values
		$tool_parameters = an_request_parameters_from_assoc_array('ad', $tools_meta, false);
		$out .= an_create_tool_custom_fields('ad', $tool_parameters);

		$out .= '</div>' . "\n";		
	}
			
	// == Profile tool ==

	$style = ($inital_tool == 'profile') ? '' : ' style="display:none"';
	$out .= '<div' . $style . ' id="profile-tab" class="an-custom-field-tab">' . "\n";				

	//Get stored post meta values
	$tool_parameters = an_request_parameters_from_assoc_array('profile', $tools_meta, false);
	$out .= an_create_tool_custom_fields('profile', $tool_parameters);

	//Output Shortcode
	if($show_shortcode) {
		$out .= an_build_shortcode('profile');
	}

	$out .= '</div>' . "\n";			

	// == Feedback tool ==
	
	$style = ($inital_tool == 'feedback') ? '' : ' style="display:none"';
	$out .= '<div' . $style . ' id="feedback-tab" class="an-custom-field-tab">' . "\n";			

	//Get stored post meta values
	$tool_parameters = an_request_parameters_from_assoc_array('feedback', $tools_meta, false);
	$out .= an_create_tool_custom_fields('feedback', $tool_parameters);

	//Output Shortcode
	if($show_shortcode) {
		$out .= an_build_shortcode('feedback');
	}

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
	$count = 0;
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
		
		//Do we have a default?
		if(array_key_exists('default', $field)) {	
		//No default
		} else {
			$field['default'] = false;		
		}		
		
		//Get the input
		$add_class = ($count % 2) ? 'alt' : '';
		$out .= an_create_custom_field_input($field, $set_value, $add_class);	
		
		$count++;
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
function an_create_custom_field_input($field, $set_value = false, $add_class = '') {
	$out = '';
	
	//ID
	$field['id'] = an_unprefix($field['id']);

	//Container
	$out .= '<div class="control-group ' . $add_class . '" id="' . $field['id'] . '-container">' . "\n";

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
	$an_settings = an_get_settings();

	echo '<div id="an-options-container">' . "\n";

	echo '	<h1>' . an_get_config('plugin_name') . '</h1>' . "\n";

	//Tabs
	$active_tab = (isset($_GET['tab'])) ? $_GET['tab'] : 'shortcodes';
	an_admin_tabs($active_tab);

 	echo '	<div id="an-settings-tabs">' . "\n";
	
	//Settings
	if(in_array($active_tab, ['legacy', 'general'])) {
		//Open form
		echo '		<form class="an-tab-left" action="' . admin_url('options.php') . '" method="post">' . "\n";
		settings_fields('an_options');
	
		//Propagate username change?
		if(isset($an_settings['an_username_propagate']) && $an_settings['an_username_propagate'] == 'true') {
			an_propagate_username_change($an_settings['an_ebay_user']);
		}

		$style = ($active_tab != 'general') ? ' style="display:none"' : '';
		echo '		<div id="an-settings-general"' . $style . '>' . "\n";
		do_settings_sections('an_general');
		echo '		</div>';


		//Removed from UI, but kept for backwards compatibility
		$style = ($active_tab != 'legacy') ? ' style="display:none"' : '';
		echo '		<div id="an-settings-legacy"' . $style . '>' . "\n";
		echo '			<p>[HTML ;)]</p>' . "\n";
		
		//CSS
		echo '			<div id="an-legacy-css">' . "\n";
		do_settings_sections('an_legacy');
		echo '			</div>' . "\n";

		echo '		</div>' . "\n";

		//Submit
		echo '		<input class="button button-primary" name="Submit" type="submit" value="Save Settings" />' . "\n";
		echo '	</form>' . "\n";	

		echo '	<div class="an-tab-right" id="an-about">' . "\n";	
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

	//Not Settings
	} else {
		$tab_url = 'options-general.php?page=an_options_page&tab=shortcodes';

		//Start Preview Form
		echo '		<form id="an-shortcode-form" class="an-tab-left" action="' . admin_url($tab_url) . '" method="post">' . "\n";
		
		//Get tool key
		$tool_key = (isset($_POST['tool_key'])) ? $_POST['tool_key'] : 'item';

		//Display form, propogated with any user submitted values
		echo an_create_custom_field_form($_POST, $tool_key);
		echo '		<input class="button button-primary" name="preview_tools" type="submit" value="Preview" />' . "\n";

		echo '	</form>' . "\n";	

		//Preview submitted?
		$request_params = an_request_parameters_from_assoc_array($tool_key, $_POST);
		if(sizeof($request_params)) {
			echo '		<div id="an-shortcode-preview" class="an-tab-right">' . "\n";

			echo '			<div class="an-shortcode-container" id="an-shortcode-' . $tool_key . '">' . "\n";
			echo an_build_shortcode($tool_key, $request_params);
			echo '			</div>' . "\n";
			
			echo an_build_snippet($tool_key, $request_params);

			echo '		</div>' . "\n";

		//Can we do the default preview?
		} elseif(isset($an_settings['an_ebay_user']) && ! empty($an_settings['an_ebay_user'])) {
			echo '		<div id="an-shortcode-preview" class="an-tab-right">' . "\n";
			echo '			<div class="an-shortcode-container" id="an-shortcode-' . $tool_key . '">' . "\n";
			echo an_build_shortcode($tool_key, an_request_parameters_defaults($tool_key, true));
			echo '			</div>' . "\n";

			echo an_build_snippet($tool_key, an_request_parameters_defaults($tool_key, true));
			echo '		</div>' . "\n";
		} else {
			echo '[Welcome!]';
		}
	}

	echo '		<div class="clear"></div>' . "\n";

 	echo '	</div>' . "\n";
	echo '</div>' . "\n";

	echo '<div id="adblock-test" class="auction-nudge"></div>';
}

/**
 * Settings page tabs
 */
function an_admin_tabs($current = 'general') {
  $tabs = array(
  	'shortcodes' => 'Shortcodes',
  	'general' => 'Options',
  	'legacy' => 'Legacy'
  );
  $links = array();
  foreach($tabs as $slug => $name) {
		if($slug == $current) {
			$links[] = '<a class="nav-tab nav-tab-active nav-tab-' . $slug . '" href="?page=an_options_page&tab=' . $slug . '">' . $name . '</a>';
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
		$an_settings = an_get_settings();

		register_setting('an_options', 'an_options', 'an_options_validate');

		//General...
		
		//eBay ID
		add_settings_section('an_ebay_defaults', 'Your eBay Defaults', 'an_ebay_defaults_text', 'an_general');
		add_settings_field('an_ebay_user', 'eBay Username', 'an_ebay_user_setting', 'an_general', 'an_ebay_defaults');
		add_settings_field('an_ebay_site', 'eBay Site', 'an_ebay_site_setting', 'an_general', 'an_ebay_defaults');

		//Requests
		add_settings_section('an_request', 'Caching', 'an_request_text', 'an_general');
		add_settings_field('an_local_requests', 'Use WordPress Cache?', 'an_local_requests_setting', 'an_general', 'an_request');		

		
		//Legacy...
		//Only display each if value exists

		//CSS - only if it exists
		if(isset($an_settings['an_css_rules']) && ! empty($an_settings['an_css_rules'])) {
			add_settings_section('an_css', 'Your CSS Rules', 'an_css_text', 'an_legacy');
			add_settings_field('an_css_rules', 'Insert CSS Rules', 'an_css_setting', 'an_legacy', 'an_css');		
		}
		
		//Items
		if(isset($an_settings['an_items_code']) && ! empty($an_settings['an_items_code'])) {
			add_settings_section('an_items', 'Your eBay Listings', 'an_items_text', 'an_legacy');
			add_settings_field('an_items_code_snippet', 'Insert code snippet', 'an_items_setting', 'an_legacy', 'an_items');
		}

		//Profile
		if(isset($an_settings['an_profile_code']) && ! empty($an_settings['an_profile_code'])) {
			add_settings_section('an_profile', 'Your eBay Profile', 'an_profile_text', 'an_legacy');
			add_settings_field('an_profile_code_snippet', 'Insert code snippet', 'an_profile_setting', 'an_legacy', 'an_profile');
		}

		//Feedback
		if(isset($an_settings['an_feedback_code']) && ! empty($an_settings['an_feedback_code'])) {
			add_settings_section('an_feedback', 'Your eBay Feedback', 'an_feedback_text', 'an_legacy');
			add_settings_field('an_feedback_code_snippet', 'Insert code snippet', 'an_feedback_setting', 'an_legacy', 'an_feedback');
		}
	}
}
add_action('admin_init', 'an_admin_settings');

/**
 * eBay defaults
 */
function an_ebay_defaults_text() {
	echo '<p>Entering a default eBay username and site here will save you from re-entering them every time.</p>' . "\n";
}

/**
 * Output eBay ID option
 */
function an_ebay_user_setting() {
	$an_settings = an_get_settings();
	
	//Option set?
	if(is_array($an_settings) && array_key_exists('an_ebay_user', $an_settings)) {
		$ebay_user_setting = $an_settings['an_ebay_user'];
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
	$an_settings = an_get_settings();

	//Option set?
	if(is_array($an_settings) && array_key_exists('an_ebay_site', $an_settings)) {
		$ebay_site_setting = $an_settings['an_ebay_site'];
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
	$an_settings = an_get_settings();
	
	$an_local_requests = isset($an_settings['an_local_requests']) ? $an_settings['an_local_requests'] : '1';
	
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
 * CSS text
 */
function an_css_text() {
	echo '';
}

/**
 * Output CSS option
 */
function an_css_setting() {
	$an_settings = an_get_settings();
	
	$an_css_rules = isset($an_settings['an_css_rules']) ? $an_settings['an_css_rules'] : '';
	
	echo '<textarea id="an_css_rules" name="an_options[an_css_rules]">' . $an_css_rules . '</textarea>' . "\n";		
}

/**
 * Items
 */
function an_items_text() {
	echo '';
}

function an_items_setting() {
	$an_settings = an_get_settings();

	$an_items_code = isset($an_settings['an_items_code']) ? $an_settings['an_items_code'] : '';
	
	echo '<textarea name="an_options[an_items_code]">' . $an_items_code  . '</textarea>' . "\n";
}

/**
 * Profile
 */
function an_profile_text() {
	echo '';
}

function an_profile_setting() {
	$an_settings = an_get_settings();
	
	$an_profile_code = isset($an_settings['an_profile_code']) ? $an_settings['an_profile_code'] : '';	
	
	echo '<textarea name="an_options[an_profile_code]">' . $an_profile_code . '</textarea>' . "\n";
}

/**
 * Feedback
 */
function an_feedback_text() {
	echo '';
}

function an_feedback_setting() {
	$an_settings = an_get_settings();
	
	$an_feedback_code = isset($an_settings['an_feedback_code']) ? $an_settings['an_feedback_code'] : '';		
	
	echo '<textarea name="an_options[an_feedback_code]">' . $an_feedback_code . '</textarea>' . "\n";
}