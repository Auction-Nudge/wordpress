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

	wp_register_style(
		'your-ebay-listings-editor-style',
		plugins_url('src/editor.css', __FILE__),
		[],
		filemtime(plugin_dir_path(__FILE__) . 'src/editor.css')
	);

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
	]);
}
add_action('init', 'your_ebay_listings_block_init');

function your_ebay_listings_render_callback($attributes) {
	foreach (an_get_block_parameters() as $prefixed_key => $value) {
		$unprefixed_key = an_unprefix($prefixed_key);

		// If set
		if (array_key_exists($unprefixed_key, $attributes)) {
			// Process
			$url_data[$unprefixed_key] = an_perform_parameter_processing_by_key($prefixed_key, $attributes[$unprefixed_key]);
			// Use default
		} elseif (array_key_exists('default', $value)) {
			$url_data[$unprefixed_key] = $value['default'];
		} else {
			$url_data[$unprefixed_key] = '';
		}
	}

	// Add target
	$url_data['target'] = an_target_hash($url_data);

	// Get endpoint
	$request_endpoint = an_get_config('item_request')['endpoint'];

	// Iterate over each attribute
	$url_parts = [];
	foreach ($url_data as $key => $value) {
		// If not empty string
		if ($value !== '') {
			$url_parts[] = "$key/$value";
		}
	}

	$href = 'https:' . $request_endpoint . '/' . implode('/', $url_parts);

	$html = '<div id="auction-nudge-' . $url_data['target'] . '">' . json_encode($url_data) . '</div>' . "\n";
	$html .= '<script src="' . esc_url($href) . '"></script>' . "\n";

	return $html;
}
