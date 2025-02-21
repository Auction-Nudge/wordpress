<?php
/**
 * Plugin Name: Your eBay Listings Block
 * Description: A WordPress Block to display your active eBay items anywhere on the page.
 * Version: 1.0
 * Author: Joe Hawes
 */

function your_ebay_listings_block_init() {
	$item_parameters = an_get_block_parameters();

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

	register_block_type('your-ebay-listings/block', [
		'editor_script' => 'your-ebay-listings-block',
		'editor_style' => 'your-ebay-listings-editor-style',
		'render_callback' => 'your_ebay_listings_render_callback',
		'attributes' => $item_parameters,
	]);
}
add_action('init', 'your_ebay_listings_block_init');

function your_ebay_listings_render_callback($attributes) {
	$item_parameters = an_get_block_parameters();

	an_debug($attributes);

	foreach ($item_parameters as $key => $value) {
		// Blocks use unprefixed keys
		$unprefixed_key = an_unprefix($key);

		// If set
		if (array_key_exists($unprefixed_key, $attributes)) {
			// Process
			$url_data[$unprefixed_key] = an_perform_parameter_processing_by_key($key, $attributes[$unprefixed_key]);
			// Use default
		} elseif (array_key_exists('default', $value)) {
			$url_data[$unprefixed_key] = $value['default'];
		} else {
			$url_data[$unprefixed_key] = '';
		}
	}

	$base_url = "https://www.auctionnudge.com/feed/item/js";

	// Iterate over each attribute
	$url_parts = [];
	foreach ($url_data as $key => $value) {
		// If not empty string
		if ($value !== '') {
			$url_parts[] = "$key/$value";
		}
	}

	$href = $base_url . '/' . implode('/', $url_parts);

	return '<div id="auction-nudge-items">' . json_encode($url_data) . '</div>' .
	'<script src="' . esc_url($href) . '"></script>';
}
