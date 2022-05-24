<?php
	
/**
 * ======================================================== 
 * ==================== WIDGETS ===========================
 * ========================================================
 */

class Auction_Nudge_Widget extends WP_Widget {
	protected $tool_key;
	
	/**
	 * Snippet output
	 */
	public function widget($args, $instance) {
		//Get the request parameters from the instance
		$request_parameters = an_request_parameters_from_assoc_array($this->tool_key, $instance);

		$tool_key_to_widget_class = array(
			'item' => 'an-listings-widget',
			'ad' => 'an-ads-widget',
			'profile' => 'an-profile-widget',
			'feedback' => 'an-feedback-widget'										
		);
		
		//Widget wrapper
		echo '<aside class="widget ' . $tool_key_to_widget_class[$this->tool_key] . '">' . "\n";
		
		//Output title if specified		
		echo $this->an_display_widget_title($instance);
		
		//Output the snippet
		echo an_build_snippet($this->tool_key, $request_parameters);
		
		echo '</aside>' . "\n";
	}

	/**
	 * Admin form
	 */
	public function form($instance) {
		//Get the request parameters from the instance
		$instance_parameters = an_request_parameters_from_assoc_array($this->tool_key, $instance, false);

		//Form wrap
		echo '<div class="an-widget-container">' . "\n";	
		
		//Widget title input
		echo $this->an_build_widget_title_input($instance, $this->get_field_name('an_widget_title'));

		//Output custom fields for this tool
		$field_name_format = $this->get_field_name('%s');
		echo an_create_tool_custom_fields($this->tool_key, $instance_parameters, $field_name_format);

		echo '</div>' . "\n";
	}

	/**
	 * Update
	 */
	public function update($new_instance, $old_instance) {
		$instance = an_update_widget_instance($this->tool_key, $new_instance);
		
		//Do we have a title?
		if(! empty($new_instance['an_widget_title'])) {
			$instance['an_widget_title'] = strip_tags($new_instance['an_widget_title']);
		//No title
		} else {
			$instance['an_widget_title'] = false;
		}
	
		return $instance;
	}	

	/**
	 * Front-end widget title output
	 */	
	protected function an_display_widget_title($instance) {
		if(array_key_exists('an_widget_title', $instance) && $instance['an_widget_title']) {
			return '<h1 class="widget-title">' . $instance['an_widget_title'] . '</h1>' . "\n";
		}	else {
			return '';
		}
	}

	/**
	 * Admin widget title output
	 */	
	protected function an_build_widget_title_input($instance, $widget_field_name) {
		$field = array(
			'name' => 'an_widget_title',
			'id' => 'an_widget_title',
			'tip' => 'A title to appear above the widget (optional)',
			'title' => 'Widget Title'
		);
		$set_value = (isset($instance[$field['name']])) ? $instance[$field['name']] : false;
		$field['name'] = $widget_field_name;
	
		return an_create_custom_field_input($field, $set_value);
	}	
}

class Auction_Nudge_Widget_Listings extends Auction_Nudge_Widget {

	public function __construct() {
		parent::__construct(
			'an_listings_widget',
			'Your eBay Listings',
			array(
				'description' => 'Use this widget to add your active eBay listings to your site, the feed will update itself automatically (note: only one set of eBay listings can be loaded per page)'
			)
		);		
		
		$this->tool_key = 'item';
	}
}

class Auction_Nudge_Widget_Ads extends Auction_Nudge_Widget {

	public function __construct() {
		parent::__construct(
			'an_ads_widget',
			'Your eBay Ads',
			array(
				'description' => 'Use this widget to create interactive banner ads containing your active eBay items. A selection of the common ad sizes are available which will automatically update themselves.'
			)
		);		
		
		$this->tool_key = 'ad';		
	}
}

class Auction_Nudge_Widget_Profile extends Auction_Nudge_Widget {

	public function __construct() {
		parent::__construct(
			'an_profile_widget',
			'Your eBay Profile',
			array(
				'description' => 'Use this widget to display information about your eBay profile such as feedback score and date of registration. Different themes / badges are available.'
			)
		);		
		
		$this->tool_key = 'profile';
	}
}

class Auction_Nudge_Widget_Feedback extends Auction_Nudge_Widget {

	public function __construct() {
		parent::__construct(
			'an_feedback_widget',
			'Your eBay Feedback',
			array(
				'description' => 'Use this widget to display up to 5 of your most recent eBay feedback comments. The feedback shown is live and will update once more feedback is received.'
			)
		);		
		
		$this->tool_key = 'feedback';
	}
}

function an_widgets_init() {
	an_update_parameter_defaults();
	
	register_widget('Auction_Nudge_Widget_Listings');
	if(an_get_option('an_ads_disable') == false) {
		register_widget('Auction_Nudge_Widget_Ads');	
	}
	register_widget('Auction_Nudge_Widget_Profile');
	register_widget('Auction_Nudge_Widget_Feedback');	
}
add_action('widgets_init', 'an_widgets_init');