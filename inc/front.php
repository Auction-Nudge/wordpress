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

	// 1 - Defaults from Config / Settings
	$request_parameters = an_request_parameters_defaults(true);

	// 2 - Meta Box (if not disabled)
	if (! an_get_settings('an_meta_disable', true)) {
		$meta_parameters = an_get_post_meta($post->ID);
		$meta_parameters = an_request_parameters_from_assoc_array($meta_parameters);
		$request_parameters = array_merge($request_parameters, $meta_parameters);
	}

	// 3 - Shortcode attribtues
	$request_parameters = array_merge($request_parameters, an_shortcode_parameters_to_request_parameters($shortcode_attrs, true));

	//Create target from Shortcode attributes
	$request_parameters['item_target'] = an_target_hash($shortcode_attrs);

	$out = an_build_snippet($request_parameters);

	return $out;
}

/**
 * Build the snippet
 */
function an_build_snippet($request_parameters = [], $enqueue = true, $inner_html = '&nbsp;') {
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

		$request_url = add_query_arg(['an_action' => 'item_request', 'an_request' => $request_string], $request_endpoint);
		//Remote requests
	} else {
		//Get request config
		$request_config = an_get_config('item_request');

		//Process request parameters
		$request_parameters = an_request_parameters_from_assoc_array($request_parameters, true, true, ['item_target']);

		$request_url = an_build_request_url($request_config, $request_string);
	}

	//Build snippet
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
	$vars[] = 'an_action';
	$vars[] = 'an_request';

	return $vars;
}
add_filter('query_vars', 'an_trigger_add');

/**
 * Check for the triggers
 */
function an_trigger_check() {

	$request_string = get_query_var('an_request');

	switch (get_query_var('an_action')) {
	case 'item_request':
		//Perform the local request
		an_perform_local_request($request_string);

		die;

	case 'block_preview':
		//Block Preview
		//Get request parameters
		$request_parameters = an_request_parameters_from_request_string(get_query_var('an_request'));

		echo an_iframe_wrap(an_build_snippet($request_parameters, false), 'Block Preview');

		die;

	default:
		//WP loads normally
		break;
	}
}
add_action('template_redirect', 'an_trigger_check');
