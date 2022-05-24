<?php
	
/**
 * ======================================================== 
 * ===================== REQUEST ==========================
 * ========================================================
 */

/**
 * Perform a local request
 */
function an_perform_local_request($tool_key, $request_string) {
	//Get request parameters
	$request_parameters = an_request_parameters_from_request_string($request_string);

	//Do we have valid parameters?
	if(sizeof($request_parameters) > 1) {
		//Modify request string
		$request_string = an_modify_request_string($request_string, $tool_key, $request_parameters);
				
		//Get request config
		$request_config = an_get_config($tool_key . '_request');

		//Modify request config
		$request_config = an_modify_request_config($request_config, $tool_key, $request_parameters);
		
		//Build request URL
		$request_url = an_build_request_url($request_config, $request_string);
		
		//Perform remote request
		$response = an_perform_remote_request($request_url, $request_config);

		//Problem with request?		
		if($response == false) {
			//Redirect user to request URL
			header('Location: ' . $request_url);
			
			die;			
		}
		
		//Modify response			
		$response = an_modify_response($response, $tool_key, $request_config);

		//Output response
		an_output_response($response, $request_config);
		
		//...we died!
	}
}

/**
 * Modify the request
 */
function an_modify_request_string($request_string, $tool_key, $request_parameters) {
	//Re-encode some parameters, because it automatically gets decoded in the $_GET superglobal
	if($tool_key == 'item') {
		//Keyword string
		if(array_key_exists('keyword', $request_parameters)) {
			$request_string = str_replace($request_parameters['keyword'], an_keyword_encode($request_parameters['keyword']), $request_string);				
		}
		
		//Grid width
		if(array_key_exists('grid_width', $request_parameters)) {
			$request_string = str_replace($request_parameters['grid_width'], str_replace("%", "%25", $request_parameters['grid_width']), $request_string);				
		}
	}
	
	return $request_string;	
}

/**
 * Modify the tool request config
 */
function an_modify_request_config($request_config, $tool_key, $request_parameters) {
	switch($tool_key) {
		case 'profile' :
			//Iframe
			if(array_key_exists('theme', $request_parameters) && $request_parameters['theme'] == 'overview'	|| array_key_exists('profile_theme', $request_parameters) && $request_parameters['profile_theme'] == 'overview') {
				$request_config['content_type'] = 'text/html';
				$request_config['endpoint'] = str_replace('profile/js', 'profile/iframe', $request_config['endpoint']);			
			}	
			
			break;											
	}
	
	return $request_config;
}

/**
 * Build the request URL
 */
function an_build_request_url($request_config, $request_string) {
	//Protocol
	$protocol = is_ssl() ? 'https' : 'http';

	//Remote endpoint
	$endpoint = $protocol . ':' . $request_config['endpoint'];
	
	//Put it together
	return $endpoint . '/' . $request_string;	
}

/**
 * Modify the response
 */
function an_modify_response($response, $tool_key, $request_config) {
	switch($tool_key) {
		case 'item' :
			//Protocol
			$protocol = is_ssl() ? 'https' : 'http';
		
			//Remote endpoint
			$remote_endpoint = $protocol . ':' . $request_config['endpoint'];
		
			//Local endpoint
			$local_endpoint = trim(add_query_arg(array('an_tool_key' => 'item', 'an_request' => '/'), home_url('/')), '/');				
			
			//Replace
			$response = str_replace($remote_endpoint, $local_endpoint, $response);
			
			break;
	}	
	
	return $response;
}

/**
 * Remote request to the Auction Nudge server (check cache first)
 */
function an_perform_remote_request($request_url, $request_config) {
	$response = false;
	
	//We can make remote file requests?
	if(ini_get('allow_url_fopen')) {
		//Protocol
		$protocol = is_ssl() ? 'https' : 'http';
		
		//Build cache ID
		$cache_id = 'an_' . md5($request_url . $protocol);

		//Do we have a copy in the cache?
		if(false === ($response = get_transient($cache_id))) {
			//Get the script
			$response = file_get_contents($request_url);
			
			//Request failure
			if($response == false || strpos($response, 'Auction Nudge') === false) {
				return false;
			}
			
			//Add to cache
			set_transient($cache_id, $response, $request_config['cache_minutes'] * MINUTE_IN_SECONDS);		
		}		
	//No remote file requests
	} else {
		return false;
	}
	
	return $response;
}

/**
 * Output the response to the browser
 */
function an_output_response($response, $request_config) {
	//Gzip supported?
	if(function_exists('gzcompress') && ! in_array('ob_gzhandler', ob_list_handlers())) {
		ob_start("ob_gzhandler");							
	} else {
		ob_start();							
	}
			
	header('Content-type: ' . $request_config['content_type']);	
	header('Cache-control: public,max-age=' . $request_config['cache_minutes'] * MINUTE_IN_SECONDS);	    
	
	echo $response;	

	die;		
}