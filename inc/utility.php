<?php

/**
 * ========================================================
 * ==================== UTILITY ===========================
 * ========================================================
 */

/**
 * Remove the prefix from a parameter name
 */
function an_unprefix($key) {
	$search = ['item_', 'ad_', 'profile_', 'feedback_'];
	$replace = ['', '', '', ''];

	return str_replace($search, $replace, $key);
}

/**
 * Get a config item
 */
function an_get_config($key) {
	global $an_plugin_config;

	if (is_array($an_plugin_config) && array_key_exists($key, $an_plugin_config)) {
		return $an_plugin_config[$key];
	} else {
		return false;
	}
}

/**
 * Encode the keywork so it is URL safe
 */
function an_keyword_encode($keyword_string) {
	if (strpos($keyword_string, ':') === false) {
		//Pre-encode tweaks
		$keyword_string = str_replace(
			[', ', '( ', ' )', '()'],
			[',', '(', ')', ''],
			$keyword_string
		);

		//Replace allowed characters
		$keyword_string = str_replace(
			an_get_config('keyword_chars_decoded'),
			an_get_config('keyword_chars_encoded'),
			$keyword_string
		);
	}

	return $keyword_string;
}

/**
 * Encode eBay username
 */
function an_username_encode($username) {
	return str_replace(an_get_config('username_bad'), an_get_config('username_good'), $username);
}

/**
 * Build a HTML input
 */
function an_create_input($field, $set_value) {
	$out = '';

	if (! array_key_exists('default', $field)) {
		$field['default'] = null;
	}

	switch ($field['type']) {
	case 'radio':
	case 'select':
		$out .= '		<select data-default="' . $field['default'] . '" name="' . $field['name'] . '" id="' . $field['id'] . '">' . "\n";
		foreach ($field['options'] as $value => $description) {
			//Always use strings
			$value = (string) $value;

			$out .= '			<option value="' . $value . '"';
			//Has this value already been set
			if ($set_value === $value) {
				$out .= ' selected="selected"';
				//Do we have a default?
			} elseif ($set_value === false && $field['default'] === $value) {
				$out .= ' selected="selected"';
			}
			$out .= '>' . $description . '</option>' . "\n";
		}
		$out .= '		</select>' . "\n";

		break;

	case 'text':
	default:
		$out .= '		<input data-default="' . $field['default'] . '" type="text" name="' . $field['name'] . '" id="' . $field['id'] . '"';
		//Do we have a value for this post?
		if ($value = htmlspecialchars($set_value)) {
			$out .= ' value="' . esc_attr($value) . '"';
			//Use default
		} else {
			$out .= ' value="' . $field['default'] . '"';
		}
		$out .= ' />' . "\n";

		break;
	}

	return $out;
}

function an_debug($thing, $die = true) {
	if (! defined('WP_DEBUG') || ! WP_DEBUG) {
		return;
	}

	echo '<pre>';
	print_r($thing);
	echo '</pre>';
	if ($die) {
		die;
	}
}

function an_get_post_meta($post_id) {

	$post_meta = get_post_meta($post_id);

	//We don't have the data we need...
	if (! array_key_exists('item_siteid', $post_meta)) {
		//Woocommerce enabled and this is a shop page...
		if (function_exists('is_woocommerce') && is_woocommerce() && function_exists('is_shop') && is_shop()) {
			$post_meta = get_post_meta(woocommerce_get_page_id('shop'));
		}
	}

	return $post_meta;
}

function an_get_settings($key = false, $default_value = null) {
	$settings = get_option('an_options');

	//By key?
	if (is_string($key)) {
		if (isset($settings[$key])) {
			return trim($settings[$key]);
		} else {
			return $default_value;
		}
	}

	//Not yet set
	if (! is_array($settings)) {
		$settings = [];
	}

	return $settings;
}

function an_validate_tool_key($tool_key) {
	if (! is_string($tool_key)) {
		return false;
	}

	if (! in_array($tool_key, an_get_config('tool_keys'))) {
		return false;
	}

	return $tool_key;
}

function an_build_shortcode($tool_key = 'item', $tool_data = [], $wrap = true) {
	if (! an_validate_tool_key($tool_key)) {
		return false;
	}

	if ($wrap) {
		$out = '<div class="an-shortcode-container" id="an-shortcode-' . $tool_key . '">' . "\n";
	} else {
		$out = '';
	}

	//Parse
	$tool_data = an_request_parameters_from_assoc_array($tool_key, $tool_data);

	//Legacy
	$tool_key = ($tool_key == 'item') ? 'listings' : $tool_key;

	//Output
	$out .= '[' . an_get_config('shortcode') . ' tool="' . $tool_key . '"';

	foreach ($tool_data as $key => $value) {
		$out .= ' ' . esc_attr(strtolower($key)) . '="' . esc_attr($value) . '"';
	}

	$out .= ']';

	if ($wrap) {
		$out .= '</div>';
	}

	return $out;
}

function an_allowable_tags() {
	return [
		'p' => [
			'class' => [],
		],
		'b' => [],
		'div' => [
			'id' => [],
			'class' => [],
			'title' => [],
		],
		'fieldset' => [
			'class' => [],
		],
		'legend' => [
			'title' => [],
		],
		'link' => [
			'rel' => [],
			'href' => [],
			'media' => [],
			'id' => [],
		],
		'textarea' => [
			'class' => [],
			'name' => [],
			'data-id' => [],
			'rows' => [],
			'cols' => [],
			'id' => [],
		],
		'a' => [
			'data-title' => [],
			'href' => [],
			'onclick' => [],
			'class' => [],
			'target' => [],
		],
		'label' => [
			'for' => [],
			'class' => [],
		],
		'input' => [
			'type' => [],
			'name' => [],
			'data-id' => [],
			'value' => [],
			'class' => [],
			'id' => [],
			'data-default' => [],
		],
		'select' => [
			'id' => [],
			'multiple' => [],
			'class' => [],
			'name' => [],
			'data-id' => [],
			'data-multi-value' => [],
			'data-default' => [],
		],
		'option' => [
			'value' => [],
			'selected' => [],
		],
		'button' => [
			'type' => [],
			'class' => [],
			'data-id' => [],
		],
		'span' => [
			'class' => [],
		],
		'small' => [
			'class' => [],
		],
	];
}