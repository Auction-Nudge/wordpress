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
	$search = array('item_', 'ad_', 'profile_', 'feedback_');
	$replace = array('', '', '', '');
	
	return str_replace($search, $replace, $key);	
}

/**
 * Get a config item
 */
function an_get_config($key) {
	global $an_plugin_config;

	if(is_array($an_plugin_config) && array_key_exists($key, $an_plugin_config)) {
		return $an_plugin_config[$key];
	}	else {
		return false;
	}
}

/**
 * Encode the keywork so it is URL safe
 */
function an_keyword_encode($keyword_string) {
	if(strpos($keyword_string, ':') === false) {
		$keyword_string = str_replace(array(', ', '( ', ' )', '()'), array(',', '(', ')', ''), $keyword_string);
		$keyword_string = urlencode($keyword_string);
		$keyword_string = str_replace(array('+'), array('%20'), $keyword_string);
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
	
	switch($field['type']) {
		case 'select' :
			$out .= '		<select name="' . $field['name'] . '" id="' . $field['id'] . '">' . "\n";
			foreach($field['options'] as $value => $description) {
				//Always use strings
				$value = (string)$value;
				
				$out .= '			<option value="' . $value . '"';
				//Has this value already been set
				if($set_value === $value) {
					$out .= ' selected="selected"';
				//Do we have a default?
				}	elseif($set_value === false && (array_key_exists('default', $field) && $field['default'] == $value)) {
					$out .= ' selected="selected"';				
				}		
				$out .= '>' . $description . '</option>' . "\n";
			}
			$out .= '		</select>' . "\n";
			break;
		case 'checkbox' :
			//Value submitted?
			$checked = false;

			if($set_value && ($set_value == 'true' || $set_value == $field['value'])) {
				$checked = true;
			} elseif($field['default'] == 'true') {
				$checked = true;								
			}
			$value = ($field['value']) ? $field['value'] : 'true';
			$out .= '		<input type="checkbox" name="' . $field['name'] . '" value="' . $value . '" id="' . $field['id'] . '"';
			if($checked) {
				$out .= ' checked="checked"';			
			}
			$out .= ' />' . "\n";			
			break;
		case 'radio' :
			foreach($field['options'] as $value => $description) {
				$checked = false;

				//Always use strings
				$value = (string)$value;
				
				//If we have a stored value
				if($set_value === $value) {
					$checked = true;
				//Otherwise is this the default value?
				} elseif($set_value === false && $value == $field['default']) {
					$checked = true;
				}
				$out .= '<div class="radio">' . "\n";
				$out .= '	<input type="radio" name="' . $field['name'] . '" value="' . $value . '"';
				if($checked) {
					$out .= ' checked="checked"';			
				}				
				$out .= ' />' . "\n";						
				$out .= $description . '<br />' . "\n";						
				$out .= '</div>' . "\n";
			}
			break;						
		case 'text' :
		default :
			$out .= '		<input type="text" name="' . $field['name'] . '" id="' . $field['id'] . '"';
			//Do we have a value for this post?
			if($value = htmlspecialchars($set_value)) {
				$out .= ' value="' . $value . '"';
			//Do we have a default?
			}	elseif(array_key_exists('default', $field)) {
				$value = $field['default'];
				
				$out .= ' value="' . $value . '"';			
			}
			$out .= ' />' . "\n";
			break;
	}	
	
	return $out;
}