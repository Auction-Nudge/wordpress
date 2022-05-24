<?php
	
/**
 * ======================================================== 
 * =================== FRONT END ==========================
 * ========================================================
 */

/**
 * Shortcode
 */
function an_shortcode($shortcode_attrs){
	global $post;
	
	//Get tool key
	if(is_array($shortcode_attrs) && in_array($shortcode_attrs['tool'], array('listings', 'ads', 'profile', 'feedback'))) {
		$tool_key = $shortcode_attrs['tool'];
		$tool_key = str_replace(array('listings', 'ads'), array('item', 'ad'), $tool_key);
	} else {
		$tool_key = 'item';
	}
	
	//Get post meta
	$post_meta = get_post_meta($post->ID);
	
	//We don't have the data we need...
	if(! array_key_exists('item_siteid', $post_meta)) {
		//Woocommerce enabled and this is a shop page...
		if(function_exists('is_woocommerce') && is_woocommerce() && function_exists('is_shop') && is_shop()) {
			$post_meta = get_post_meta(woocommerce_get_page_id('shop'));
		}		
	}
	
	//Get request parameters
	$request_parameters = an_request_parameters_from_assoc_array($tool_key, $post_meta);
	
	//Get snippet
	$out = an_build_snippet($tool_key, $request_parameters);
	
	return $out;
}
add_shortcode(an_get_config('shortcode'), 'an_shortcode');

/**
 * Build the snippet
 */
function an_build_snippet($tool_key = 'item', $request_parameters){
	//We'll want to check that this loaded correctly
	wp_enqueue_script('an_check_js');
	add_action('wp_footer', 'an_output_load_check');
	
	//Profile JS or iframe?
	$profile_is_framed = array_key_exists('profile_theme', $request_parameters) && $request_parameters['profile_theme'] == 'overview';
	
	//Request endpoint
	$request_endpoint = home_url('/');		
	
	//Request string
	$request_string = an_request_parameters_to_request_string($request_parameters);
	
	//Get options
	$options = get_option('an_options');
	
	//Local requests
	if(! array_key_exists('an_local_requests', $options) || $options['an_local_requests'] == '1') {
		//We encode this, wp_enqueue_script encodes the others
		if($tool_key == 'ad' || ($tool_key == 'profile' && $profile_is_framed)) {
			$request_string = urlencode($request_string);
		}

		$request_url = add_query_arg(array('an_tool_key' => $tool_key, 'an_request' => $request_string), $request_endpoint);		
	//Remote requests
	} else {
		//Get request config
		$request_config = an_get_config($tool_key . '_request');
		
		//Process request parameters
		$request_parameters = an_request_parameters_from_assoc_array($tool_key, $request_parameters, true, true);

		//Modify request config
		$request_config = an_modify_request_config($request_config, $tool_key, $request_parameters);
		
		$request_url = an_build_request_url($request_config, $request_string);
	}
	
	//Build snippet
	switch($tool_key) {
		case 'profile' :
			//Iframe
			if($profile_is_framed) {
				//Output right away
				return '<iframe width="250px" height="288px" style="border:none" frameborder="0" src="' . $request_url . '"></iframe>';												
			//JS
			} else {
				//Enqueue
				wp_enqueue_script(md5($request_url), $request_url, array(), an_get_config('plugin_version'), true);
				
				return '<div id="auction-nudge-profile">&nbsp;</div>';				
			}
			
			break;
		case 'feedback' :
				//Enqueue
				wp_enqueue_script(md5($request_url), $request_url, array(), an_get_config('plugin_version'), true);

				return '<div id="auction-nudge-feedback">&nbsp;</div>';
		
			break;
		case 'ad' :
			if(an_get_option('an_ads_disable') == true) {
				return '';
				
				break;
			}
			
			//Output right away	
			$format_dimensions = explode('x', $request_parameters['ad_format']);
			return '<iframe width="' . $format_dimensions[0] . '" height="' . $format_dimensions[1] . '" style="border:none" frameborder="0" src="' . $request_url . '" class="auction-nudge"></iframe>';
		
			break;
		case 'item' :
		default :
			//Enqueue
			wp_enqueue_script(md5($request_url), $request_url, array(), an_get_config('plugin_version'), true);
		
			return '<div id="auction-nudge-items">&nbsp;</div>';
					
			break;
	}
}

/**
 * Output version #
 */
function an_output_version() {
	echo '<!-- AN v' . an_get_config('plugin_version') . ' -->' . "\n";	
}
add_action('wp_head','an_output_version');

/**
 * Load check HTML
 */
function an_output_load_check() {
	echo '<span id="an-load-check" class="auction-nudge"></span>' . "\n";
}

/**
 * Load check JS
 */
function an_output_load_check_js() {
	wp_register_script('an_check_js', plugins_url('assets/js/check.js', dirname(__FILE__)), array(), an_get_config('plugin_version'), true);
}
add_action('wp_head', 'an_output_load_check_js');

/**
 * Load custom CSS
 */
function an_load_css() {
	$options = get_option('an_options');
	
	//Only output if CSS rules set
	if(isset($options['an_css_rules']) && strlen($options['an_css_rules'])) {
		echo '<style type="text/css">' . "\n";
		echo $options['an_css_rules'] . "\n";
		echo '</style>' . "\n";		
	}
}
add_action('wp_head', 'an_load_css');

/**
 * =================== LOCAL REQUESTS =====================
 */

/**
 * Register the triggers with WP
 */
function an_trigger_add($vars) {
	$vars[] = 'an_tool_key';
	$vars[] = 'an_request';
	
	return $vars;
}
add_filter('query_vars','an_trigger_add');

/**
 * Check for the triggers
 */ 
function an_trigger_check() {
	//Get URL data
	$tool_key = get_query_var('an_tool_key');
	$request_string = get_query_var('an_request');

	//Do we have a valid tool key
	if($tool_key && in_array($tool_key, array('item', 'ad', 'profile', 'feedback'))) {
		an_perform_local_request($tool_key, $request_string);
	//Valid tool key not present
	} else {
		//WP loads normally
	}
}
add_action('template_redirect', 'an_trigger_check');

/**
 * ==================== LEGACY ============================
 */

/**
 * Replace markers
 */
function an_the_content($content) {
	$options = get_option('an_options');
	
	//Is this legacy feature in use?		
	if(isset($options['an_items_code']) || isset($options['an_profile_code']) || isset($options['an_feedback_code'])) {
		$old = array(
			'[an_items]',
			'[an_profile]',
			'[an_feedback]'
		);
		$new = array(
			isset($options['an_items_code']) ? $options['an_items_code'] : '',
			isset($options['an_profile_code']) ? $options['an_profile_code'] : '',
			isset($options['an_feedback_code']) ? $options['an_feedback_code'] : ''
		);	
		
		return str_replace($old, $new, $content);		
	//Not in use, so we don't need to do anthing
	} else {
		return $content;		
	}
}
add_filter('the_content', 'an_the_content');

/**
 * Output items
 */
function an_items() {
	echo an_get_option('an_items_code');
}

/**
 * Output profile
 */
function an_profile() {
	echo an_get_option('an_profile_code');
}

/**
 * Output feedback
 */
function an_feedback() {
	echo an_get_option('an_feedback_code');
}