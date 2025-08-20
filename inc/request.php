<?php

/**
 * ========================================================
 * ===================== REQUEST ==========================
 * ========================================================
 */

/**
 * Perform a local request
 */
function an_perform_local_request($request_string) {
	//Get request parameters
	$request_parameters = an_request_parameters_from_request_string($request_string);

	//Do we have valid parameters?
	if (sizeof($request_parameters) > 1) {
		//Modify request string
		$request_string = an_modify_request_string($request_string, $request_parameters);

		//Get request config
		$request_config = an_get_config('item_request');

		//Build request URL
		$request_url = an_build_request_url($request_config, $request_string);

		//Perform remote request
		$response = an_perform_remote_request($request_url, $request_config);

		//Problem with request?
		if ($response == false) {
			//Redirect user to request URL
			header('Location: ' . $request_url);

			die;
		}

		//Modify response
		$response = an_modify_response($response, $request_config);

		//Output response
		an_output_response($response, $request_config);

		//...we died!
	}
}

/**
 * Modify the request
 */
function an_modify_request_string($request_string, $request_parameters) {
	//Re-encode some parameters, because it automatically gets decoded in the $_GET superglobal

	//Keyword string
	if (array_key_exists('keyword', $request_parameters)) {
		$request_string = str_replace($request_parameters['keyword'], an_keyword_encode($request_parameters['keyword']), $request_string);
	}

	//Grid width
	if (array_key_exists('grid_width', $request_parameters)) {
		$request_string = str_replace($request_parameters['grid_width'], str_replace("%", "%25", $request_parameters['grid_width']), $request_string);
	}

	return $request_string;
}

/**
 * Build the request URL
 */
function an_build_request_url($request_config, $request_string) {
	//Remote endpoint
	$endpoint = 'https:' . $request_config['endpoint'];

	//Put it together
	return $endpoint . '/' . $request_string;
}

/**
 * Modify the response
 */
function an_modify_response($response, $request_config) {
	//Remote endpoint
	$remote_endpoint = 'https:' . $request_config['endpoint'];

	//Local endpoint
	$local_endpoint = trim(add_query_arg(['an_action' => 'item_request', 'an_request' => '/'], home_url('/')), '/');

	//Replace Endpoint
	$response = str_replace($remote_endpoint, $local_endpoint, $response);

	// Replace View Details iframe URL
	$response = str_replace(
		'auctionnudge.com/feed/details/iframe',
		'auctionnudge.app/feed/details/iframe',
		$response
	);

	return $response;
}

/**
 * Remote request to the Auction Nudge server (check cache first)
 */
function an_perform_remote_request($request_url, $request_config) {
	$response = false;

	//We can make remote file requests?
	if (ini_get('allow_url_fopen')) {
		//Build cache ID
		$cache_id = 'an_' . md5($request_url . 'https');

		//Do we have a copy in the cache?
		if (false === ($response = get_transient($cache_id))) {
			//Get the script
			$response = file_get_contents($request_url);

			//Request failure
			if ($response == false || strpos($response, 'auctionnudge.com') === false) {
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
	if (function_exists('gzcompress') && ! in_array('ob_gzhandler', ob_list_handlers())) {
		ob_start("ob_gzhandler");
	} else {
		ob_start();
	}

	header('Content-type: ' . $request_config['content_type']);
	header('Cache-control: public,max-age=' . $request_config['cache_minutes'] * MINUTE_IN_SECONDS);

	echo $response;

	die;
}