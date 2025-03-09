<?php
/**
 * Plugin Name: Your eBay Listings Block
 * Description: A WordPress Block to display your active eBay items anywhere on the page.
 * Version: 1.0
 * Author: Joe Hawes
 */

function your_ebay_listings_block_init() {
	// Automatically load dependencies and version
	$asset_file = include plugin_dir_path(__FILE__) . 'build/index.asset.php';

	wp_register_script(
		'your-ebay-listings-block',
		plugins_url('build/index.js', __FILE__),
		$asset_file['dependencies'],
		$asset_file['version']
	);

	// Defaults
	$defaults = [
		'an_ebay_site' => '0',
		'an_ebay_user' => '',
	];

	// Get Settings
	$an_settings = array_merge($defaults, an_get_settings());

	// Site
	if (isset($an_settings['an_ebay_site'])) {
		$defaults['an_ebay_site'] = $an_settings['an_ebay_site'];
	}

	// Username
	if (isset($an_settings['an_ebay_user'])) {
		$defaults['an_ebay_user'] = $an_settings['an_ebay_user'];
	}

	// Localize script
	wp_localize_script('your-ebay-listings-block', 'an_block_js', $defaults);

	// Use unprefixed parameters
	$item_parameters = [];
	foreach (an_get_block_parameters() as $key => $value) {
		$item_parameters[an_unprefix($key)] = $value;
	}

	register_block_type('your-ebay-listings/block', [
		'editor_script' => 'your-ebay-listings-block',
		'editor_style' => 'your-ebay-listings-editor-style',
		'render_callback' => 'your_ebay_listings_render_callback',
		'attributes' => $item_parameters,
		'example' => [
			'attributes' => [
				'SellerID' => $defaults['an_ebay_user'] ? $defaults['an_ebay_user'] : 'soundswholesale',
				'siteid' => $defaults['an_ebay_site'] ? $defaults['an_ebay_site'] : '3',
			],
		],

	]);
}
add_action('init', 'your_ebay_listings_block_init');

function your_ebay_listings_render_callback($attributes) {
	$request_parameters = [];

	foreach (an_get_block_parameters() as $prefixed_key => $value) {
		$unprefixed_key = an_unprefix($prefixed_key);

		// If set
		if (array_key_exists($unprefixed_key, $attributes)) {
			// Process
			$request_parameters[$unprefixed_key] = an_perform_parameter_processing_by_key($prefixed_key, $attributes[$unprefixed_key]);
			// Use default
		} elseif (array_key_exists('default', $value)) {
			$request_parameters[$unprefixed_key] = $value['default'];
		} else {
			$request_parameters[$unprefixed_key] = '';
		}
	}

	// Backend (preview)
	if (wp_is_serving_rest_request()) {
		// Open links in parent window
		$request_parameters['blank'] = '1';

		// Height based on number of items
		$iframe_height = ($request_parameters['MaxEntries'] / 2) * 250 + 150;

		$html = '<iframe src="' . home_url('/') . '/?an_tool_key=block_preview&an_request=' . urlencode(an_request_parameters_to_request_string($request_parameters)) . '" width="100%" height="' . $iframe_height . 'px" style="border:7px solid #f5f5f5;cursor:pointer" frameborder="0"></iframe>';
		// Frontend
	} else {
		// Build hash
		$request_parameters['item_target'] = an_target_hash($request_parameters);

		$html = an_build_snippet('item', $request_parameters);
	}

	return $html;
}
