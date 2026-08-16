<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

## ------------------------------------------ #
/*
Weather Widget developed By : Fouad Badawy | kavkazLabs
Based On :  Awesome Weather Widget http://halgatewood.com/awesome-weather
*/


// THE LOGIC
function kavkaz_weather_logic( $atts ){

	$rtn 				= "";
	$weather_data		= array();
	$location 			= isset($atts['location']) ? $atts['location'] : false;
	$api_key 			= isset($atts['api_key']) ? $atts['api_key'] : false;
	$units 				= (isset($atts['units']) AND strtoupper($atts['units']) == "C") ? "metric" : "imperial";
	$units_display		= $units == "metric" ? __('C', 'kavkaz') : __('F', 'kavkaz');
	$days_to_show 		= isset($atts['forecast_days']) ? $atts['forecast_days'] : 5;
	$locale				= 'en';

	$sytem_locale = get_locale();
	$available_locales = array( 'en', 'sp', 'fr', 'it', 'de', 'pt', 'ro', 'pl', 'ru', 'ua', 'fi', 'nl', 'bg', 'se', 'tr', 'zh_tw', 'zh_cn' );

    // CHECK FOR LOCALE
    if( in_array( $sytem_locale , $available_locales ) ){
    	$locale = $sytem_locale;
    }

    // CHECK FOR LOCALE BY FIRST TWO DIGITS
    if( in_array(substr($sytem_locale, 0, 2), $available_locales ) ){
    	$locale = substr($sytem_locale, 0, 2);
    }

	// NO LOCATION, ABORT ABORT!!!1!
	if( !$location ) { return kavkaz_weather_error(); }

	//FIND AND CACHE CITY ID
	if( is_numeric($location) ){
		$city_name_slug 			= $location;
		$api_query					= "id=" . $location;
	}else{
		$city_name_slug 			= sanitize_title( $location );
		$api_query					= "q=" . $location;
	}

	// TRANSIENT NAME
	$weather_transient_name 		= 'kavkaz_' . $city_name_slug . "_" . strtolower($units_display) . '_' . $locale;

	// GET WEATHER DATA
	if( get_transient( $weather_transient_name ) ){
		$weather_data = get_transient( $weather_transient_name );
	}
	else{
		$weather_data['now'] = array();
		$weather_data['forecast'] = array();

		// NOW
		$now_ping = "http://api.openweathermap.org/data/2.5/weather?" . $api_query . "&lang=" . $locale . "&units=" . $units."&APPID=".$api_key;
		$now_ping = str_replace(" ", "", $now_ping);

		$now_ping_get = wp_remote_get( $now_ping, array( 'timeout' => 120 ) );

		if( is_wp_error( $now_ping_get ) ){
			return kavkaz_weather_error( $now_ping_get->get_error_message()  );
		}

		$city_data = json_decode( $now_ping_get['body'] );

		if( isset($city_data->cod) AND $city_data->cod == 404 ){
			return kavkaz_weather_error( $city_data->message );
		}else
		{
			$weather_data['now'] = $city_data;
		}

		// FORECAST
		if( $days_to_show != "hide" )
		{
			$forecast_ping = "http://api.openweathermap.org/data/2.5/forecast/daily?" . $api_query . "&lang=" . $locale . "&units=" . $units ."&cnt=7&APPID=".$api_key;
			$forecast_ping = str_replace(" ", "", $forecast_ping);

			$forecast_ping_get = wp_remote_get( $forecast_ping, array( 'timeout' => 120 ) );

			if( is_wp_error( $forecast_ping_get ) ){
				return kavkaz_weather_error( $forecast_ping_get->get_error_message()  );
			}

			$forecast_data = json_decode( $forecast_ping_get['body'] );

			if( isset($forecast_data->cod) AND $forecast_data->cod == 404 ){
				return kavkaz_weather_error( $forecast_data->message );
			}else{
				$weather_data['forecast'] = $forecast_data;
			}
		}

		if($weather_data['now'] OR $weather_data['forecast']){
			// SET THE TRANSIENT, CACHE FOR A LITTLE OVER THREE HOURS
			set_transient( $weather_transient_name, $weather_data, apply_filters( 'awesome_weather_cache', 11000 ) );
		}
	}

	// NO WEATHER
	if( !$weather_data OR !isset($weather_data['now'])) { return kavkaz_weather_error(); }


	// TODAYS TEMPS & ICONS
	$today 			= $weather_data['now'];
	$today_temp 	= round($today->main->temp);
	$today_high 	= round($today->main->temp_max);
	$today_low 		= round($today->main->temp_min);

	// DATA
	$today->main->humidity 		= round($today->main->humidity);
	$today->wind->speed 		= round($today->wind->speed);

	$wind_label = array (
							__('N', 'kavkaz'),
							__('NNE', 'kavkaz'),
							__('NE', 'kavkaz'),
							__('ENE', 'kavkaz'),
							__('E', 'kavkaz'),
							__('ESE', 'kavkaz'),
							__('SE', 'kavkaz'),
							__('SSE', 'kavkaz'),
							__('S', 'kavkaz'),
							__('SSW', 'kavkaz'),
							__('SW', 'kavkaz'),
							__('WSW', 'kavkaz'),
							__('W', 'kavkaz'),
							__('WNW', 'kavkaz'),
							__('NW', 'kavkaz'),
							__('NNW', 'kavkaz')
						);

	$wind_direction = $wind_label[ fmod((($today->wind->deg + 11) / 22.5),16) ];

	// ICONS
	$today_icon 	= $today->weather[0]->icon;
	$icon_class 	= 'cloud';
	if( $today_icon == '01d' ) $icon_class ='sun';
	elseif( $today_icon == '01n' ) $icon_class ='moon';
	elseif( $today_icon == '02d' ) $icon_class ='cloud-sun';
	elseif( $today_icon == '02n' ) $icon_class ='cloud-moon';
	elseif( $today_icon == '04d'  || $today_icon == '04n' ) $icon_class ='clouds';
	elseif( $today_icon == '09d'  || $today_icon == '09n' || $today_icon == '10d'  || $today_icon == '10n' ) $icon_class ='rain';
	elseif( $today_icon == '11d'  || $today_icon == '11n' ) $icon_class ='clouds-flash-alt';
	elseif( $today_icon == '13d'  || $today_icon == '13n' ) $icon_class ='hail';
	elseif( $today_icon == '50d'  || $today_icon == '50n' ) $icon_class ='fog';

	// DISPLAY WIDGET
	$rtn .= "
		<div id=\"kavkaz-weather-{$city_name_slug}\" class=\"kavkaz-weather-wrap\">
	";

	$rtn .= "
			<div class=\"kavkaz-weather-current-temp\">
				<div class=\"weather-icon\"><i class=\"kavkazicon-{$icon_class}\"></i></div>
				$today_temp<sup>{$units_display}</sup>
			</div> <!-- /.kavkaz-weather-current-temp -->
	";


	$speed_text = ($units == "metric") ? __('km/h', 'kavkaz') : __('mph', 'kavkaz');

	$rtn .= "

			<div class=\"kavkaz-weather-todays-stats\">
				<div class=\"weather_name\">{$today->name}</div>
				<div class=\"weather_desc\">{$today->weather[0]->description}</div>
				<div class=\"weather_humidty\">" . __('humidity:', 'kavkaz') . " {$today->main->humidity}% </div>
				<div class=\"weather_wind\">" . __('wind:', 'kavkaz') . " {$today->wind->speed}" . $speed_text . " {$wind_direction}</div>
				<div class=\"weather_highlow\"> "  .__('H', 'kavkaz') . " {$today_high} &bull; " . __('L', 'kavkaz') . " {$today_low} </div>
			</div> <!-- /.kavkaz-weather-todays-stats -->
	";


	if($days_to_show != "hide")
	{
		$rtn .= "<div class=\"kavkaz-weather-forecast weather_days_{$days_to_show}\">";
		$c = 1;
		$dt_today = date( 'Ymd', current_time( 'timestamp', 0 ) );
		$forecast = $weather_data['forecast'];
		$days_to_show = (int) $days_to_show;

		foreach( (array) $forecast->list as $forecast )
		{
			if( $dt_today >= date('Ymd', $forecast->dt)) continue;
			$days_of_week = array( __('Sun' ,'kavkaz'), __('Mon' ,'kavkaz'), __('Tue' ,'kavkaz'), __('Wed' ,'kavkaz'), __('Thu' ,'kavkaz'), __('Fri' ,'kavkaz'), __('Sat' ,'kavkaz') );

			$forecast->temp = (int) $forecast->temp->day;
			$day_of_week = $days_of_week[ date('w', $forecast->dt) ];
			$rtn .= "
				<div class=\"kavkaz-weather-forecast-day\">
					<div class=\"kavkaz-weather-forecast-day-temp\">{$forecast->temp}<sup>{$units_display}</sup></div>
					<div class=\"kavkaz-weather-forecast-day-abbr\">$day_of_week</div>
				</div>
			";
			if($c == $days_to_show) break;
			$c++;
		}
		$rtn .= " </div> <!-- /.kavkaz-weather-forecast -->";
	}


	$rtn .= "</div> <!-- /.kavkaz-weather-wrap -->";
	return $rtn;
}


// RETURN ERROR
function kavkaz_weather_error( $msg = false )
{
	if(!$msg) $msg = __('No weather information available', 'kavkaz');
	return apply_filters( 'kavkaz_weather_error', "<!-- kavkaz WEATHER ERROR: " . $msg . " -->" );
}



// AWESOME WEATHER WIDGET, WIDGET CLASS, SO MANY WIDGETS
class kavkaz_WeatherWidget extends WP_Widget
{
	public function __construct(){
		parent::__construct(false, $name =  THEME_NAME .' - '.__( 'Weather' , 'kavkaz' ) );
	}

    public function widget($args, $instance)
    {
        extract( $args );

        $location 			= isset($instance['location']) ? $instance['location'] : false;
        $api_key 			= isset($instance['api_key']) ? $instance['api_key'] : false;
        $widget_title 		= isset($instance['widget_title']) ? $instance['widget_title'] : false;
        $units 				= isset($instance['units']) ? $instance['units'] : false;
        $forecast_days 		= isset($instance['forecast_days']) ? $instance['forecast_days'] : false;

		echo $before_widget;
		echo $before_title . $widget_title . $after_title;
		echo kavkaz_weather_logic( array( 'location' => $location, 'api_key' => $api_key, 'units' => $units, 'forecast_days' => $forecast_days ));
		echo $after_widget;
    }

    public function update($new_instance, $old_instance)
    {
		$instance = $old_instance;
		$instance['location'] 			= strip_tags($new_instance['location']);
		$instance['api_key'] 			= strip_tags($new_instance['api_key']);
		$instance['widget_title'] 		= strip_tags($new_instance['widget_title']);
		$instance['units'] 				= strip_tags($new_instance['units']);
		$instance['forecast_days'] 		= strip_tags($new_instance['forecast_days']);
        return $instance;
    }

    public function form($instance)
    {
    	$defaults = array( 'widget_title' =>__('Weather', 'kavkaz') );
		$instance = wp_parse_args( (array) $instance, $defaults );

        $location 			= isset($instance['location']) ? esc_attr($instance['location']) : "";
        $api_key 			= isset($instance['api_key']) ? esc_attr($instance['api_key']) : "";
        $widget_title 		= isset($instance['widget_title']) ? esc_attr($instance['widget_title']) : "";
        $units 				= (isset($instance['units']) AND strtoupper($instance['units']) == "C") ? "C" : "F";
        $forecast_days 		= isset($instance['forecast_days']) ? esc_attr($instance['forecast_days']) : 5;


	?>
	       <p>
          <label for="<?php echo $this->get_field_id('widget_title'); ?>"><?php _e('Title:', 'kavkaz'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" type="text" value="<?php echo $widget_title; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('location'); ?>">
          	<?php _e('Location:', 'kavkaz'); ?> - <a href="http://openweathermap.org/find" target="_blank"><?php _e('Find Your Location', 'kavkaz'); ?></a><br />
          	<small><?php _e('(i.e: London,UK or New York City,NY)', 'kavkaz'); ?></small>
          </label>
          <input class="widefat" style="margin-top: 4px;" id="<?php echo $this->get_field_id('location'); ?>" name="<?php echo $this->get_field_name('location'); ?>" type="text" value="<?php echo $location; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('api_key'); ?>">
          	<?php _e('API key:', 'kavkaz'); ?> - <a href="http://openweathermap.org/appid#get" target="_blank"><?php _e('How to get API key', 'kavkaz'); ?></a><br />
          </label>
          <input class="widefat" style="margin-top: 4px;" id="<?php echo $this->get_field_id('api_key'); ?>" name="<?php echo $this->get_field_name('api_key'); ?>" type="text" value="<?php echo $api_key; ?>" />
        </p>

        <p>
          <label for="<?php echo $this->get_field_id('units'); ?>"><?php _e('Units:', 'kavkaz'); ?></label>  &nbsp;
          <input id="<?php echo $this->get_field_id('units'); ?>" name="<?php echo $this->get_field_name('units'); ?>" type="radio" value="F" <?php if($units == "F") echo ' checked="checked"'; ?> /> <?php _e('F', 'kavkaz'); ?> &nbsp; &nbsp;
          <input id="<?php echo $this->get_field_id('units'); ?>" name="<?php echo $this->get_field_name('units'); ?>" type="radio" value="C" <?php if($units == "C") echo ' checked="checked"'; ?> /> <?php _e('C', 'kavkaz'); ?>
        </p>


		<p>
          <label for="<?php echo $this->get_field_id('forecast_days'); ?>"><?php _e('Forecast:', 'kavkaz'); ?></label>
          <select class="widefat" id="<?php echo $this->get_field_id('forecast_days'); ?>" name="<?php echo $this->get_field_name('forecast_days'); ?>">
          	<option value="5"<?php if($forecast_days == 5) echo " selected=\"selected\""; ?>><?php _e('5 Days', 'kavkaz'); ?></option>
          	<option value="4"<?php if($forecast_days == 4) echo " selected=\"selected\""; ?>><?php _e('4 Days', 'kavkaz'); ?></option>
          	<option value="3"<?php if($forecast_days == 3) echo " selected=\"selected\""; ?>><?php _e('3 Days', 'kavkaz'); ?></option>
          	<option value="2"<?php if($forecast_days == 2) echo " selected=\"selected\""; ?>><?php _e('2 Days', 'kavkaz'); ?></option>
          	<option value="1"<?php if($forecast_days == 1) echo " selected=\"selected\""; ?>><?php _e('1 Day', 'kavkaz'); ?></option>
          	<option value="hide"<?php if($forecast_days == 'hide') echo " selected=\"selected\""; ?>><?php _e("Don't Show", 'kavkaz'); ?></option>
          </select>
		</p>

        <?php
    }
}

add_action( 'widgets_init', 'kavkaz_weather_widget' );
function kavkaz_weather_widget() {
	register_widget( 'kavkaz_WeatherWidget' );
}
