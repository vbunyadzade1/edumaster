<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Register main Scripts and Styles
/*-----------------------------------------------------------------------------------*/
add_action('wp_enqueue_scripts', 'kavkaz_register');
function kavkaz_register(){

	global $wp_query;

	## Register All CSS file
	wp_register_style('main', get_template_directory_uri() . '/assets/css/main.css' , array() , false, 'all');	
	wp_register_style('style', get_template_directory_uri() . '/assets/css/style.css' , array() , false, 'all');
	wp_register_style('responsive', get_template_directory_uri() . '/assets/css/responsive.css' , array() , false, 'all');

	## Get Global CSS	
	wp_enqueue_style('main');
	wp_enqueue_style('style');
	wp_enqueue_style('responsive');

    ## Register All Scripts file
	wp_register_script('all', get_template_directory_uri() . '/assets/js/all.js', array( 'jquery' ) , false, true);
    wp_register_script('particles', get_template_directory_uri() . '/assets/js/particles.min.js', array( 'jquery' ) , false, true);
    wp_register_script('main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ) , false, true);
	
	wp_localize_script('main', 'kavkaz_ajax', array('url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('ajax-nonce'), 'security' => wp_create_nonce("ajax-security"), 'siteurl' => get_bloginfo('template_url') ));

    ## Get Global Scripts
	wp_enqueue_script('all');
	wp_enqueue_script('particles');
	wp_enqueue_script('main');
}

/*-----------------------------------------------------------------------------------*/
# ADD defer and async Scripts
/*-----------------------------------------------------------------------------------*/
function kavkaz_add_async_attribute($tag, $handle) {

	$scripts_to_async = array('all', 'particles', 'main');
	
	foreach($scripts_to_async as $async_script) {
	   if ($async_script === $handle) {
		  return str_replace(' src', ' crossorigin="anonymous" defer src', $tag);
	   }
	}
	
	return $tag;
}

add_filter('script_loader_tag', 'kavkaz_add_async_attribute', 10, 2);

?>