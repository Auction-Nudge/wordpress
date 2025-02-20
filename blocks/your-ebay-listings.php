<?php
/**
 * Plugin Name: Your eBay Listings Block
 * Description: A WordPress Block to display your active eBay items anywhere on the page.
 * Version: 1.0
 * Author: Your Name
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

	register_block_type('your-ebay-listings/block', [
		'editor_script' => 'your-ebay-listings-block',
		'editor_style' => 'your-ebay-listings-editor-style',
		'render_callback' => 'your_ebay_listings_render_callback',
		'attributes' => [
			'sellerID' => [
				'type' => 'string',
				'default' => '',
			],
			'siteID' => [
				'type' => 'string',
				'default' => '0',
			],
			'theme' => [
				'type' => 'string',
				'default' => 'responsive',
			],
			'language' => [
				'type' => 'string',
				'default' => 'english',
			],
			'sortOrder' => [
				'type' => 'string',
				'default' => '',
			],
		],
	]);
}
add_action('init', 'your_ebay_listings_block_init');

function your_ebay_listings_render_callback($attributes) {
	$base_url = "https://www.auctionnudge.com/feed/item/js";
	$options = array_filter($attributes, function ($value, $key) {
		$default_values = [
			'sellerID' => '',
			'siteID' => '0',
			'theme' => 'responsive',
			'language' => 'english',
			'sortOrder' => '',
		];
		return isset($default_values[$key]) && $value !== $default_values[$key];
	}, ARRAY_FILTER_USE_BOTH);

	$url_parts = [];
	foreach ($options as $key => $value) {
		$id = str_replace('item_', '', $key);
		$url_parts[] = "$id/$value";
	}

	$href = $base_url . '/' . implode('/', $url_parts);

	return '<div id="auction-nudge-items"></div>' .
	'<script src="' . esc_url($href) . '"></script>';
}
