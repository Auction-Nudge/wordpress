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
	if($an_settings !== false) {		
		//Check for default eBay Username
		if(array_key_exists('an_ebay_user', $an_settings) && ! empty($an_settings['an_ebay_user'])) {
			$an_plugin_config['item_parameters']['item_SellerID']['default'] = $an_settings['an_ebay_user'];
			$an_plugin_config['ad_parameters']['ad_SellerID']['default'] = $an_settings['an_ebay_user'];
			$an_plugin_config['profile_parameters']['profile_UserID']['default'] = $an_settings['an_ebay_user'];
			$an_plugin_config['feedback_parameters']['feedback_UserID']['default'] = $an_settings['an_ebay_user'];
		}	
	
		//Check for default eBay site
		if(array_key_exists('an_ebay_site', $an_settings) && ! empty($an_settings['an_ebay_site'])) {
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
	$request_parameters = array();	

	//Allow some extra parameters
	if(is_array($extra_allow)) {
		foreach($extra_allow as $allow_key) {
			if(array_key_exists($allow_key, $assoc_array)) {
				$request_parameters[$allow_key] = $assoc_array[$allow_key];
			}		
		}
	}

	//Iterate over each parameter for the tool
	foreach(an_get_config($tool_key . '_parameters') as $param_defition) {
		//Param name (is the name prefixed?)
		if($is_prefixed) {
			$param_name = $param_defition['name'];
		} else {
			$param_name = str_replace($tool_key . '_', '', $param_defition['name']);			
		}
		
		//If we have a value for this parameter
		if(array_key_exists($param_name, $assoc_array)) {
			//Is the value an array?
			if(is_array($assoc_array[$param_name])) {
				$param_value = $assoc_array[$param_name][0];
			} else {
				$param_value = $assoc_array[$param_name];				
			}
			
			//Are we processing it before output?
			if($do_output_processing && array_key_exists('output_processing', $param_defition)) {
				foreach($param_defition['output_processing'] as $process) {
					eval("\$param_value = $process;");						
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
	
	foreach($request_parameters as $p_key => $p_value) {
		//If we have a value
		if($p_value !== '') {
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
	$request_parameters = array();

	$request_string = trim($request_string, '/');
	$request_explode = explode('/', $request_string);
	
	if(is_array($request_explode)) {	//Thanks! https://wordpress.org/support/topic/undefined-offset-in-parameters-php/
		for($i = 0; $i < sizeof($request_explode); $i+=2) {
			$request_parameters[$request_explode[$i]] = $request_explode[$i+1];
		}	
	}
	
	return $request_parameters;
}

/**
 * Save the tool parameters as post meta once form is posted
 */
function an_save_post_meta_from_form_post($post_id, $form_post) {
	//Posted form includes values for every tool
	$plugin_parameters = array_merge(
		an_get_config('item_parameters'),
		an_get_config('ad_parameters'),
		an_get_config('profile_parameters'),
		an_get_config('feedback_parameters')
	);
	
	//Iterate over each parameter
	foreach($plugin_parameters as $param_defition) {
		//Value exists
		if(isset($form_post[$param_defition['name']]) && trim($form_post[$param_defition['name']]) !== '') {
			$param_value = $form_post[$param_defition['name']];
			$param_value = trim($param_value);
			
			//Are we processing it before input?
			if(array_key_exists('input_processing', $param_defition)) {
				foreach($param_defition['input_processing'] as $process) {
					eval("\$param_value = $process;");						
				}
			}				
			
			update_post_meta($post_id, $param_defition['name'], $param_value);
		//No value exists
		} else {
			delete_post_meta($post_id, $param_defition['name']);
		}
	}
}

/**
 * Update widget instance
 */
function an_update_widget_instance($tool_key, $instance_in) {
	$instance_out = array();

	//Get parameter definitions
	$plugin_parameters = an_get_config($tool_key . '_parameters');

	//Iterate over each parameter
	foreach($plugin_parameters as $param_defition) {
		//Value exists
		if(isset($instance_in[$param_defition['name']])) {
			$param_value = $instance_in[$param_defition['name']];
			$param_value = trim($param_value);
			
			//Are we processing it before input?
			if(array_key_exists('input_processing', $param_defition)) {
				foreach($param_defition['input_processing'] as $process) {
					eval("\$param_value = $process;");						
				}
			}				
			
			$instance_out[$param_defition['name']] = $param_value;
		}
	}
	
	return $instance_out;
}

/**
 * Build array of default shortcode parameters
 *
 *
 */
function an_request_parameters_defaults($tool_key, $process_output = false) {
	$parameters_defaults = array();	
	$an_settings = an_get_settings();
	
	//Config
	
	//Iterate over each parameter for the tool
	foreach(an_get_config($tool_key . '_parameters') as $param_defition) {	
// 		$param_name = an_unprefix($param_defition['name']);
		$param_name = $param_defition['name'];
		
		// ====== Lowercase! ======
//  		$param_name = strtolower($param_name);
		
		//Is there a default?
		$param_value = '';
		
		if(isset($param_defition['default'])) {
			$param_value = $param_defition['default'];
			
			//Process output?	
			if($process_output && isset($param_defition['output_processing']) && is_array($param_defition['output_processing'])) {
				foreach($param_defition['output_processing'] as $process) {
					eval("\$param_value = $process;");						
				}		
			}
					
			$parameters_defaults[$param_name] = $param_value;
		}
		
		switch($param_name) {
			case 'sellerid' :

				if(array_key_exists('an_ebay_user', $an_settings) && ! empty($an_settings['an_ebay_user'])) {
					$parameters_defaults['sellerid'] = $an_settings['an_ebay_user'];
				}

				break;

			case 'siteid' :

				if(array_key_exists('an_ebay_site', $an_settings) && ! empty($an_settings['an_ebay_site'])) {
					$parameters_defaults['siteid'] = $an_settings['an_ebay_site'];
				}

				break;				
		}		
	}	

	return $parameters_defaults;
}

function an_shortcode_parameters_to_request_parameters($tool_key, $shortcode_parameters = []) {
	$request_parameters = [];
	
	foreach(an_get_config($tool_key . '_parameters') as $param_key => $param_defition) {
		$param_name = $param_defition['name'];
		
		$shortcode_name = an_unprefix(strtolower($param_name));
		
		//Does a lowercase equivalent exist?
		if(array_key_exists($shortcode_name, $shortcode_parameters)) {
			$request_parameters[$param_name] = $shortcode_parameters[$shortcode_name];
		}
	}
	
	return $request_parameters;
}

function an_shortcode_parameters_help_table($tool_keys = [ 'item', 'profile', 'feedback' ]) {
	$out = '<table>';
	
	$out .= '	<tr>
		<th>Attribute</th>
		<th>Options</th>
		<th>Tip</th>
		<th>Default</th>
	</td>';
	
	foreach($tool_keys as $tool_key) {

/*
	//Does this tool have groups?
	if($tool_has_groups = (an_get_config($tool_key . '_parameter_groups') !== false)) {
		$parameter_groups = an_get_config($tool_key . '_parameter_groups');
		$group = $parameter_groups[$field['group']];
				
		//Output group?
		if($current_group != $group) {
*/
	
		foreach(an_get_config($tool_key . '_parameters') as $param_key => $param_defition) {
		
			$options_out = '';
			if(isset($param_defition['options']) && is_array($param_defition['options'])) {
				$options_out = implode(',<br />', $param_defition['options']);
			}
		
			$out .= '	<tr>
				<th>' . strtolower(an_unprefix($param_key)) . '</th>
				<td>' . $options_out  . '</td>
				<td>' . $param_defition['tip'] . '</th>
				<td>' . $param_defition['default']  . '</td>
			</td>';
		}
	}

	$out .= '</table>';
	
	return $out;
}