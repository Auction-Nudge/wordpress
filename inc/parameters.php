<?php

/**
 * ========================================================
 * ================== PARAMETERS ==========================
 * ========================================================
 */

/**
 * Update some defaults if we have a user setting
 */
function an_update_parameter_defaults() {
	global $an_plugin_config;

	//Get options
	$an_settings = an_get_settings();

	//If we have options
	if ($an_settings !== false) {
		//Check for default eBay Username
		if (array_key_exists('an_ebay_user', $an_settings) && ! empty($an_settings['an_ebay_user'])) {
			$an_plugin_config['item_parameters']['item_SellerID']['default'] = $an_settings['an_ebay_user'];
			$an_plugin_config['ad_parameters']['ad_SellerID']['default'] = $an_settings['an_ebay_user'];
			$an_plugin_config['profile_parameters']['profile_UserID']['default'] = $an_settings['an_ebay_user'];
			$an_plugin_config['feedback_parameters']['feedback_UserID']['default'] = $an_settings['an_ebay_user'];
		}

		//Check for default eBay site
		if (array_key_exists('an_ebay_site', $an_settings) && ! empty($an_settings['an_ebay_site'])) {
			$an_plugin_config['item_parameters']['item_siteid']['default'] = $an_settings['an_ebay_site'];
			$an_plugin_config['ad_parameters']['ad_siteid']['default'] = $an_settings['an_ebay_site'];
			$an_plugin_config['profile_parameters']['profile_siteid']['default'] = $an_settings['an_ebay_site'];
			$an_plugin_config['feedback_parameters']['feedback_siteid']['default'] = $an_settings['an_ebay_site'];
		}
	}
}

/**
 * Build request parameters array from post meta
 */
function an_request_parameters_from_assoc_array($tool_key, $assoc_array, $do_output_processing = true, $is_prefixed = true, $extra_allow = []) {
	$request_parameters = [];

	//Allow some extra parameters
	if (is_array($extra_allow)) {
		foreach ($extra_allow as $allow_key) {
			if (array_key_exists($allow_key, $assoc_array)) {
				$request_parameters[$allow_key] = $assoc_array[$allow_key];
			}
		}
	}

	//Iterate over each parameter for the tool
	foreach (an_get_config($tool_key . '_parameters') as $param_defition) {
		//Param name (is the name prefixed?)
		if ($is_prefixed) {
			$param_name = $param_defition['name'];
		} else {
			$param_name = str_replace($tool_key . '_', '', $param_defition['name']);
		}

		//If we have a value for this parameter
		if (array_key_exists($param_name, $assoc_array)) {
			//Is the value an array?
			if (is_array($assoc_array[$param_name])) {
				$param_value = $assoc_array[$param_name][0];
			} else {
				$param_value = $assoc_array[$param_name];
			}

			// Sanitize the value
			$param_value = sanitize_text_field($param_value);

			//Are we processing it before output?
			if ($do_output_processing && array_key_exists('output_processing', $param_defition)) {
				foreach ($param_defition['output_processing'] as $process) {
					$param_value = an_perform_parameter_processing($param_value, $process);
				}
			}

			//Set it
			$request_parameters[$param_name] = $param_value;
		}
	}

	return $request_parameters;
}

/**
 * Build request string from parameters
 */
function an_request_parameters_to_request_string($request_parameters) {
	$request_string = '';

	foreach ($request_parameters as $p_key => $p_value) {
		//If we have a value
		if ($p_value !== '') {
			//Un-prefix keys
			$p_key = an_unprefix($p_key);

			//Add data
			$request_string .= $p_key . '/' . $p_value . '/';
		}
	}

	return trim($request_string, '/');
}

/**
 * Get parameters from request string
 */
function an_request_parameters_from_request_string($request_string) {
	$request_parameters = [];

	$request_string = trim($request_string, '/');
	$request_explode = explode('/', $request_string);

	if (is_array($request_explode)) {
		//Thanks! https://wordpress.org/support/topic/undefined-offset-in-parameters-php/
		for ($i = 0; $i < sizeof($request_explode); $i += 2) {
			$request_parameters[$request_explode[$i]] = $request_explode[$i + 1];
		}
	}

	return $request_parameters;
}

/**
 * Build array of default shortcode parameters
 */
function an_request_parameters_defaults($tool_key, $process_output = false) {
	$parameters_defaults = [];
	$an_settings = an_get_settings();

	//Config

	//Iterate over each parameter for the tool
	foreach (an_get_config($tool_key . '_parameters') as $param_defition) {
		$param_name = $param_defition['name'];

		//Is there a default?
		$param_value = '';

		if (isset($param_defition['default'])) {
			$param_value = $param_defition['default'];

			//Process output?
			if ($process_output && isset($param_defition['output_processing']) && is_array($param_defition['output_processing'])) {
				foreach ($param_defition['output_processing'] as $process) {
					$param_value = an_perform_parameter_processing($param_value, $process);
				}
			}

			$parameters_defaults[$param_name] = $param_value;
		}

		switch ($param_name) {
		case 'sellerid':

			if (array_key_exists('an_ebay_user', $an_settings) && ! empty($an_settings['an_ebay_user'])) {
				$parameters_defaults['sellerid'] = $an_settings['an_ebay_user'];
			}

			break;

		case 'siteid':

			if (array_key_exists('an_ebay_site', $an_settings) && ! empty($an_settings['an_ebay_site'])) {
				$parameters_defaults['siteid'] = $an_settings['an_ebay_site'];
			}

			break;
		}
	}

	return $parameters_defaults;
}

function an_shortcode_parameters_to_request_parameters($tool_key, $shortcode_parameters = []) {
	$request_parameters = [];

	foreach (an_get_config($tool_key . '_parameters') as $param_key => $param_defition) {
		$param_name = $param_defition['name'];

		$shortcode_name = an_unprefix(strtolower($param_name));

		//Does a lowercase equivalent exist?
		if (array_key_exists($shortcode_name, $shortcode_parameters)) {
			$request_parameters[$param_name] = $shortcode_parameters[$shortcode_name];
		}
	}

	return $request_parameters;
}

function an_shortcode_parameters_help_table($tool_keys = ['item', 'profile', 'feedback']) {
	$out = '<table>';

	$out .= '	<tr>
		<th>Attribute</th>
		<th>Options</th>
		<th>Tip</th>
		<th>Default</th>
	</td>';

	foreach ($tool_keys as $tool_key) {
		foreach (an_get_config($tool_key . '_parameters') as $param_key => $param_defition) {

			$options_out = '';
			if (isset($param_defition['options']) && is_array($param_defition['options'])) {
				$options_out = implode(',<br />', $param_defition['options']);
			}

			$out .= '	<tr>
				<th>' . strtolower(an_unprefix($param_key)) . '</th>
				<td>' . $options_out . '</td>
				<td>' . $param_defition['tip'] . '</th>
				<td>' . $param_defition['default'] . '</td>
			</td>';
		}
	}

	$out .= '</table>';

	return $out;
}

function an_perform_parameter_processing($value = '', $process = '') {
	switch ($process) {
	case 'username_encode':
		$value = an_username_encode($value);

		break;

	case 'keyword_encode':
		$value = an_keyword_encode($value);

		break;

	case 'ad_keyword_encode':
		$value = str_replace("+", "%20", urlencode($value));

		break;
	case 'replace_percent':
		$value = str_replace("%", "%25", $value);

		break;
	}

	return $value;
}

function an_perform_parameter_processing_by_key($key, $value) {
	// an_debug($key . ' => ' . $value);

	$item_parameters = an_get_config('item_parameters');

	$param_defition = $item_parameters[$key];

	if (isset($param_defition['output_processing'])) {
		foreach ($param_defition['output_processing'] as $process) {
			$value = an_perform_parameter_processing($value, $process);
		}
	}

	return $value;
}

function an_get_block_parameters() {
	an_update_parameter_defaults();

	$parameters = [];

	foreach (an_get_config('item_parameters') as $param_key => $param_defition) {
		$parameters[$param_key] = [
			'type' => 'string',
			'default' => '',
		];

		// Set default if we have one
		if (isset($param_defition['default'])) {
			$parameters[$param_key]['default'] = $param_defition['default'];
		}
	}

	return $parameters;
}
