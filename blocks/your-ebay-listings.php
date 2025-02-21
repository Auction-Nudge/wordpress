<?php
/**
 * Plugin Name: Your eBay Listings Block
 * Description: A WordPress Block to display your active eBay items anywhere on the page.
 * Version: 1.0
 * Author: Joe Hawes
 */

$an_item_attributes = [
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
	'lang' => [
		'type' => 'string',
		'default' => 'english',
	],
	'cats_output' => [
		'type' => 'string',
		'default' => 'dropdown',
	],
	'MaxEntries' => [
		'type' => 'string',
		'default' => '6',
	],
	'page' => [
		'type' => 'string',
		'default' => 'init',
	],
	'search_box' => [
		'type' => 'string',
		'default' => '1',
	],
	'grid_cols' => [
		'type' => 'string',
		'default' => '2',
	],
	'grid_width' => [
		'type' => 'string',
		'default' => '100%',
	],
	'show_logo' => [
		'type' => 'string',
		'default' => '1',
	],
	'blank' => [
		'type' => 'string',
		'default' => '0',
	],
	'img_size' => [
		'type' => 'string',
		'default' => '120',
	],
	'user_profile' => [
		'type' => 'string',
		'default' => '0',
	],
	'sortOrder' => [
		'type' => 'string',
		'default' => '',
	],
	'listing_type' => [
		'type' => 'string',
		'default' => '',
	],
	'keyword' => [
		'type' => 'string',
		'default' => '',
	],
	'categoryId' => [
		'type' => 'string',
		'default' => '',
	],
];

function your_ebay_listings_block_init() {
	global $an_item_attributes;

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
		'attributes' => $an_item_attributes,
	]);
}
add_action('init', 'your_ebay_listings_block_init');

function your_ebay_listings_render_callback($attributes) {

	$base_url = "https://www.auctionnudge.com/feed/item/js";
	$options = array_filter($attributes, function ($value, $key) {
		global $an_item_attributes;

		$default_values = [];
		foreach ($an_item_attributes as $key => $value) {
			$default_values[$key] = $value['default'];
		}

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
