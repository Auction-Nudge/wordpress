<?php

function an_init() {
	if (! is_admin()) {
		// Set defaults
		an_update_parameter_defaults();

		add_shortcode(an_get_config('shortcode'), 'an_shortcode');
	}
}
add_action('init', 'an_init');

/**
 * ========================================================
 * =================== FRONT END ==========================
 * ========================================================
 */

/**
 * Shortcode
 */
function an_shortcode($shortcode_attrs, $shortcode_content, $shortcode_name) {
	global $post;

	//Get tool key
	if (! isset($shortcode_attrs['tool']) || ! in_array($shortcode_attrs['tool'], ['listings', 'ads', 'profile', 'feedback'])) {
		return false;
	}
	$tool_key = str_replace(['listings', 'ads'], ['item', 'ad'], $shortcode_attrs['tool']);
	unset($shortcode_attrs['tool']);

	// 1 - Defaults from Config / Settings
	$request_parameters = an_request_parameters_defaults($tool_key, true);

	// 2 - Meta Box (if not disabled)
	if (! an_get_settings('an_meta_disable', true)) {
		$meta_parameters = an_get_post_meta($post->ID);
		$meta_parameters = an_request_parameters_from_assoc_array($tool_key, $meta_parameters);
		$request_parameters = array_merge($request_parameters, $meta_parameters);
	}

	// 3 - Shortcode attribtues
	$request_parameters = array_merge($request_parameters, an_shortcode_parameters_to_request_parameters($tool_key, $shortcode_attrs, true));

	//By tool
	switch ($tool_key) {
	case 'item':
		//Create target from Shortcode attributes
		$request_parameters['item_target'] = an_target_hash($shortcode_attrs);

		break;
	}

// 	echo '<pre>';
// 	print_r($request_parameters);
// 	echo '</pre>';

	$out = an_build_snippet($tool_key, $request_parameters);

	return $out;
}

/**
 * Build the snippet
 */
function an_build_snippet($tool_key = 'item', $request_parameters = [], $enqueue = true, $inner_html = '&nbsp;') {
	//Build unique hash for this request
	$request_hash = an_target_hash($request_parameters);

	//Request string
	$request_string = an_request_parameters_to_request_string($request_parameters);

	//Get Settings
	$an_settings = an_get_settings();

	//Local requests
	if (! array_key_exists('an_local_requests', $an_settings) || $an_settings['an_local_requests'] == '1') {
		//Request endpoint
		$request_endpoint = home_url('/');

		//We encode this, wp_enqueue_script encodes the others
		if ($tool_key == 'ad') {
			$request_string = urlencode($request_string);
		}

		$request_url = add_query_arg(['an_tool_key' => $tool_key, 'an_request' => $request_string], $request_endpoint);
		//Remote requests
	} else {
		//Get request config
		$request_config = an_get_config($tool_key . '_request');

		//Process request parameters
		$request_parameters = an_request_parameters_from_assoc_array($tool_key, $request_parameters, true, true, ['item_target']);

		//Modify request config
		$request_config = an_modify_request_config($request_config, $tool_key, $request_parameters);

		$request_url = an_build_request_url($request_config, $request_string);
	}

	//Build snippet
	switch ($tool_key) {
	case 'profile':
		return '<script>console.log("[Auction Nudge] The Your eBay Profile tool has been retired. More information: https://www.auctionnudge.com/changes#v2024.4.0");</script>';

		break;
	case 'feedback':
		return '<script>console.log("[Auction Nudge] The Your eBay Feedback tool has been retired. More information: https://www.auctionnudge.com/changes#v2024.4.0");</script>';

		break;
	case 'ad':
		if (an_get_option('an_ads_disable') == true) {
			return '';

			break;
		}

		//Output right away
		$format_dimensions = explode('x', $request_parameters['ad_format']);
		return '<iframe width="' . $format_dimensions[0] . '" height="' . $format_dimensions[1] . '" style="border:none" frameborder="0" src="' . $request_url . '" class="auction-nudge"></iframe>';

		break;
	case 'item':
	default:
		$html = '';

		//Enqueue
		if ($enqueue) {
			wp_enqueue_script($request_hash, $request_url, [], an_get_config('plugin_version'), true);
		} else {
			$html .= '<script src="' . esc_url($request_url) . '"></script>';
		}

		if (isset($request_parameters['item_target']) && is_string($request_parameters['item_target'])) {
			return '<div id="auction-nudge-' . $request_parameters['item_target'] . '">' . $inner_html . '</div>';
		} else {
			$html .= '<div id="auction-nudge-items">' . $inner_html . '</div>';
		}

		return $html;

		break;
	}
}

/**
 * Output version #
 */
function an_output_version() {
	echo '<!-- AN v' . esc_html(an_get_config('plugin_version')) . ' -->' . "\n";
}
add_action('wp_head', 'an_output_version');

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
add_filter('query_vars', 'an_trigger_add');

/**
 * Check for the triggers
 */
function an_trigger_check() {
	//Get URL data
	$tool_key = get_query_var('an_tool_key');
	$request_string = get_query_var('an_request');

	//Do we have a valid tool key
	if ($tool_key && in_array($tool_key, ['item', 'ad', 'profile', 'feedback'])) {
		an_perform_local_request($tool_key, $request_string);
		//Block Preview
	} elseif ($tool_key == 'block_preview') {
		//Get request parameters
		$request_parameters = an_request_parameters_from_request_string($request_string);

		echo an_iframe_wrap(an_build_snippet('item', $request_parameters, false), 'Block Preview');

		die;

	} else {
		//WP loads normally
	}
}
add_action('template_redirect', 'an_trigger_check');
