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
	// Set defaults
	an_update_parameter_defaults();

	//Permissions
	if (current_user_can('manage_options')) {
		// Default parameters
		add_action('admin_head-post.php', 'an_update_parameter_defaults');
		add_action('admin_head-post-new.php', 'an_update_parameter_defaults');

		//Add CSS
		wp_register_style('an_admin_css', plugins_url('assets/css/admin.css', dirname(__FILE__)), [], an_get_config('plugin_version'));
		wp_enqueue_style('an_admin_css');

		//Add JS
		wp_register_script('an_admin_js', plugins_url('assets/js/admin.js', dirname(__FILE__)), ['jquery'], an_get_config('plugin_version'));
		wp_enqueue_script('an_admin_js');
	}
}
add_action('admin_init', 'an_admin_init');

/**
 * Validate our options
 */
function an_options_validate($input) {
	$output = [];
	foreach ($input as $o_key => $o_value) {
		$output[$o_key] = trim($o_value);
	}
	return $output;
}

/**
 * Get plugin options
 */
function an_get_option($option_key) {
	$an_settings = an_get_settings();

	if (is_array($an_settings) && array_key_exists($option_key, $an_settings)) {
		return $an_settings[$option_key];
	} else {
		return false;
	}
}

/**
 * Helpful upgrade notification
 */
function an_show_upgrade_notification($current_plugin_metadata, $new_plugin_metadata) {
	//Check Upgrade Notice
	if (isset($new_plugin_metadata->upgrade_notice) && strlen(trim($new_plugin_metadata->upgrade_notice)) > 0) {
		echo '<br /><br /><strong style="color:#f56e28">Important Update!</strong><br />' . strip_tags($new_plugin_metadata->upgrade_notice);
	}
}
add_action('in_plugin_update_message-auction-nudge/auctionnudge.php', 'an_show_upgrade_notification', 10, 2);

/**
 * Modify plugin action links
 */
function an_add_action_links($links) {
	$links_before = [];
	$links_after = [
		'<a href="' . admin_url('options-general.php?page=an_options_page') . '">Settings</a>',
		'<a href="' . admin_url('options-general.php?page=an_options_page&tab=shortcodes') . '">Shortcode Generator</a>',
	];

	return array_merge($links_before, $links, $links_after);
}
add_filter('plugin_action_links_auction-nudge/auctionnudge.php', 'an_add_action_links');

/**
 * Create the custom field form
 */
function an_create_shortcode_form($tools_meta = [], $inital_tool = 'item', $show_shortcode = false) {
	global $post;

	//Do we have?
	if (isset($post->ID)) {
		//Get meta for tools
		$tools_meta = an_get_post_meta($post->ID);
	}

	$out = '<div id="an-shortcode-form-container">' . "\n";

	// == Item tool ==

	$style = ($inital_tool == 'item') ? '' : ' style="display:none"';
	$out .= '<div' . $style . ' id="listings-tab" class="an-custom-field-tab">' . "\n";

	//Get stored post meta values
	$tool_parameters = an_request_parameters_from_assoc_array('item', $tools_meta, false);
	$out .= an_create_tool_custom_fields('item', $tool_parameters);

	//Output Shortcode
	if ($show_shortcode) {
		$out .= an_build_shortcode('item');
	}

	$out .= '</div>' . "\n";

	$out .= '</div> <!-- END #an-shortcode-form-container -->' . "\n";
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
	foreach (an_get_config($tool_key . '_parameters') as $field) {
		//Does this tool have groups?
		if ($tool_has_groups = (an_get_config($tool_key . '_parameter_groups') !== false)) {
			$parameter_groups = an_get_config($tool_key . '_parameter_groups');
			$group = $parameter_groups[$field['group']];

			//Output group?
			if ($current_group != $group) {
				//Close previous fieldset?
				if ($current_group !== false) {
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
		if (array_key_exists($field['name'], $tool_params)) {
			//Is array?
			if (is_array($tool_params[$field['name']])) {
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
		if (array_key_exists('default', $field)) {
			//No default
		} else {
			$field['default'] = false;
		}

		//Get the input
		$add_class = ($count % 2) ? 'alt' : '';
		$out .= an_create_custom_field_input($field, $set_value, $add_class);

		$count++;
	}

	if ($tool_has_groups) {
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
	$out .= '	<label class="control-label" for="' . $field['name'] . '">' . $field['title'] . '</label>' . "\n";
	$out .= '	<div class="controls">' . "\n";

	//Default type
	if (! array_key_exists('type', $field)) {
		$field['type'] = 'text';
	}

	//Create input
	$out .= an_create_input($field, $set_value);

	//Tip
	if ($field['tip']) {
		$out .= ' <a class="an-tooltip" data-title="' . $field['tip'] . '';
		if (array_key_exists('tip_link', $field)) {
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
 * ================== SETTINGS PAGE =======================
 */

/**
 * Create settings page
 */
function an_admin_page() {
	//Permissions
	if (current_user_can('manage_options')) {
		add_options_page(an_get_config('plugin_name') . ' Settings', an_get_config('plugin_name'), 'manage_options', 'an_options_page', 'an_options_page');
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

	//Determine default tab
	$default_tab = 'general';
	if (isset($an_settings['an_ebay_user']) && ! empty($an_settings['an_ebay_user'])) {
		$default_tab = 'shortcodes';
	}

	//Tabs
	$active_tab = (isset($_GET['tab'])) ? $_GET['tab'] : $default_tab;
	an_admin_tabs($active_tab);

	echo '	<div id="an-settings-tabs">' . "\n";

	echo '	<div style="margin:10px;">' . "\n";
	echo an_admin_notice('October 2024 – The <b>Your eBay Profile</b> and <b>Your eBay Feedback</b> tools are being retired. Read more <a target="_blank" href="https://www.auctionnudge.com/changes#v2024.4.0">here</a>.', 'error');
	echo '</div>' . "\n";

	//Settings
	if (in_array($active_tab, ['general'])) {
		//Open form
		echo '		<form class="an-tab-left an-tab-content" action="' . admin_url('options.php') . '" method="post">' . "\n";
		settings_fields('an_options');

		$style = ($active_tab != 'general') ? ' style="display:none"' : '';
		echo '		<div id="an-settings-general"' . $style . '>' . "\n";
		do_settings_sections('an_general');
		echo '		</div>';

		//Submit
		echo '		<input class="button button-primary" name="Submit" type="submit" value="Save Settings" />' . "\n";
		echo '	</form>' . "\n";

		echo '	<div class="an-tab-right an-tab-content" id="an-about">' . "\n";
		echo '		<img width="120" height="120" alt="Joe\'s mug" src="https://www.morehawes.co.uk/assets/images/Joe1BW.jpg" />' . "\n";
		echo '		<p class="an-lead"><b>Hi, I\'m Joe.</b>Please <a target="_blank" href="https://wordpress.org/support/plugin/auction-nudge/#new-post">reach out</a> if you have any issues.</p>' . "\n";

		echo '<p style="margin-top: 30px">';
		//Prompt to set default
		if (! an_get_settings('an_ebay_user')) {
			//Don't link if already on the defaults tab
			if ($active_tab != 'general') {
				echo '<a href="' . admin_url('options-general.php?page=an_options_page&tab=general') . '">Set a default eBay Username</a>,' . "\n";
			} else {
				echo 'Set a default eBay Username,' . "\n";
			}
			echo 'then display Your eBay Listings with this Shortcode:' . "\n";
			//Username set
		} else {
			echo 'Display Your eBay Listings with this Shortcode:' . "\n";
		}
		echo '</p>';

		echo an_build_shortcode('item');

		echo '		<p>Use the <a href="' . admin_url('options-general.php?page=an_options_page&tab=shortcodes') . '">Shortcode Generator</a> to customise your content.</p>' . "\n";

		echo '		<hr />' . "\n";

		echo '		<p>Most common issues are solved by reading the <a target="_blank" href="https://www.auctionnudge.com/wordpress-plugin/usage">Help</a> section.</p>' . "\n";
		echo '		<p>Please <a target="_blank" href="https://wordpress.org/support/plugin/auction-nudge/#new-post">report bugs and errors</a>, I will do my best to help.</p>' . "\n";

		echo '		<p><b>Cheers!</b></p>' . "\n";
		echo '		<footer>v' . an_get_config('plugin_version') . ' | Since 2008</footer>' . "\n";
		echo '	</div>' . "\n";

		//Not Settings
	} else {
		//Get tool key
		$tool_key = (isset($_POST['tool_key'])) ? $_POST['tool_key'] : 'item';

		$tab_url = 'options-general.php?page=an_options_page&tab=shortcodes';

		//Preview submitted?
		$request_params = an_request_parameters_from_assoc_array($tool_key, $_POST);
		if (sizeof($request_params)) {
			echo '		<div id="an-shortcode-preview" class="an-tab-left an-tab-content">' . "\n";

			echo an_build_shortcode($tool_key, $request_params);

			echo an_build_snippet($tool_key, $request_params);

			echo '		</div>' . "\n";

			//Can we do the default preview?
		} elseif (isset($an_settings['an_ebay_user']) && ! empty($an_settings['an_ebay_user'])) {
			echo '		<div id="an-shortcode-preview" class="an-tab-left an-tab-content">' . "\n";

			echo an_build_shortcode($tool_key, an_request_parameters_defaults($tool_key, true));

			echo an_build_snippet($tool_key, an_request_parameters_defaults($tool_key, true));

			echo '		</div>' . "\n";
			//Nothing to Preview - Welcome screen
		} else {
			echo '		<div id="an-welcome" class="an-tab-left an-tab-content">' . "\n";
			echo '			<p class="an-lead">Your eBay Username is required.</p>' . "\n";
			echo '			<p>Save time by <a href="' . admin_url('options-general.php?page=an_options_page') . '">setting a default</a>!</p>';
			echo '		</div>' . "\n";
		}

		//Start Preview Form
		echo '		<form id="an-shortcode-form" class="an-tab-right an-tab-content" action="' . admin_url($tab_url) . '" method="post">' . "\n";
		echo '			<h2>Shortcode Generator</h2>' . "\n";
		echo '			<p>Add Shortcodes anywhere they are supported.</p>' . "\n";

		//Display form, propogated with any user submitted values
		echo an_create_shortcode_form($_POST, $tool_key);
		echo '		<input class="button button-primary" name="preview_tools" type="submit" value="Preview" />' . "\n";

		echo '	</form>' . "\n";
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
	$tabs = [
		'shortcodes' => 'Shortcodes',
		'general' => 'Settings',
	];

	$links = [];
	foreach ($tabs as $slug => $name) {
		if ($slug == $current) {
			$links[] = '<a class="nav-tab nav-tab-active nav-tab-' . $slug . '" href="?page=an_options_page&tab=' . $slug . '">' . $name . '</a>';
		} else {
			$links[] = '<a class="nav-tab nav-tab-' . $slug . '" href="?page=an_options_page&tab=' . $slug . '">' . $name . '</a>';
		}
	}

	//Add Help
	$links[] = '<a class="nav-tab nav-tab-help" href="https://www.auctionnudge.com/wordpress-plugin/usage" target="_blank">Help <span class="wp-menu-image dashicons-before dashicons-external"></span></a>';

	echo '<h2 class="nav-tab-wrapper">';
	foreach ($links as $link) {
		echo $link;
	}
	echo '</h2>';
}

/**
 * Define settings
 */
function an_admin_settings() {
	//Permissions
	if (current_user_can('manage_options')) {
		$an_settings = an_get_settings();

		register_setting('an_options', 'an_options', 'an_options_validate');

		//General...

		//eBay ID
		add_settings_section('an_ebay_defaults', 'Defaults', 'an_ebay_defaults_text', 'an_general');
		add_settings_field('an_ebay_user', 'eBay Username', 'an_ebay_user_setting', 'an_general', 'an_ebay_defaults');
		add_settings_field('an_ebay_site', 'eBay Site', 'an_ebay_site_setting', 'an_general', 'an_ebay_defaults');

		//Requests
		add_settings_section('an_request', 'Caching', 'an_request_text', 'an_general');
		add_settings_field('an_local_requests', '', 'an_local_requests_setting', 'an_general', 'an_request');
	}
}
add_action('admin_init', 'an_admin_settings');

/**
 * eBay defaults
 */
function an_ebay_defaults_text() {
	echo '<p class="an-lead">Save time when generating <a href="' . admin_url('options-general.php?page=an_options_page&tab=shortcodes') . '">Shortcodes</a>!</p>' . "\n";
}

/**
 * Output eBay ID option
 */
function an_ebay_user_setting() {
	$an_settings = an_get_settings();

	//Option set?
	if (is_array($an_settings) && array_key_exists('an_ebay_user', $an_settings)) {
		$ebay_user_setting = $an_settings['an_ebay_user'];
	} else {
		$ebay_user_setting = '';
	}

	echo '<input type="text" id="an_ebay_user" class="regular-text" name="an_options[an_ebay_user]" value="' . $ebay_user_setting . '" />' . "\n";
	echo '<a class="an-tooltip" data-title="This is your eBay ID &ndash; the username you are known by on eBay and appears on your listings. This is not your store name." href="#" onclick="return false;">?</a>' . "\n";
}

/**
 * Output eBay site option
 */
function an_ebay_site_setting() {
	$an_settings = an_get_settings();

	//Option set?
	if (is_array($an_settings) && array_key_exists('an_ebay_site', $an_settings)) {
		$ebay_site_setting = $an_settings['an_ebay_site'];
	} else {
		$ebay_site_setting = '0';
	}

	$siteids = [
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
		'193' => 'eBay Switzerland',
	];

	echo '<select name="an_options[an_ebay_site]" id="an_ebay_site">' . "\n";
	foreach ($siteids as $siteid => $description) {
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
	echo '<p class="an-lead">The WordPress cache improves load performance.</p>' . "\n";
}

/**
 * Local Requests option
 */
function an_local_requests_setting() {
	$an_settings = an_get_settings();

	$an_local_requests = isset($an_settings['an_local_requests']) ? $an_settings['an_local_requests'] : '1';

	echo '<select id="an_local_requests" name="an_options[an_local_requests]">' . "\n";
	$selected = ($an_local_requests == '1') ? ' selected="selected"' : '';
	echo '	<option value="1"' . $selected . '>Enabled</option>' . "\n";
	$selected = ($an_local_requests == '0') ? ' selected="selected"' : '';
	echo '	<option value="0"' . $selected . '>Disabled</option>' . "\n";
	echo '</select>' . "\n";

	echo '<a class="an-tooltip" data-title="Try disabling if you are experiencing issues with Auction Nudge (like if nothing is displayed). Don\'t worry, other caching mechanisms are still in place." href="#" onclick="return false;">?</a>' . "\n";
}

function an_admin_notice($text = '', $type = 'info', $tag = 'div') {
	if (! $text) {
		return;
	}

	$out = '<' . $tag . ' class="an-notice notice notice-alt inline';

	if (in_array($type, ['info', 'success', 'warning', 'error'])) {
		$out .= ' notice-' . $type . '';
	}

	$out .= '"><p>' . $text . '</p></' . $tag . '>';

	return $out;
}
