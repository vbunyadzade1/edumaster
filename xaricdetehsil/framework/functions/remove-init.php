<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

define('WEBSITE_HOME_PATH', function_exists('get_home_path') ? get_home_path() : ABSPATH);

/*-----------------------------------------------------------------------------------*/
# Remove Query Strings From Static Resources
/*-----------------------------------------------------------------------------------*/
function kavkaz_remove_ver_param( $url ) {
	return remove_query_arg( 'ver', $url );
}
// add_filter( 'script_loader_src', 'kavkaz_remove_ver_param'  );
// add_filter( 'style_loader_src', 'kavkaz_remove_ver_param'  );
/*-----------------------------------------------------------------------------------*/
# Remove WordPress version from RSS feeds
/*-----------------------------------------------------------------------------------*/
function kavkaz_remove_wp_version_from_rss() {
    return '';
}
add_filter('the_generator', 'kavkaz_remove_wp_version_from_rss');

function kavkaz_remove_wp_generator() {
    remove_action('wp_head', 'wp_generator');
}
add_action('init', 'kavkaz_remove_wp_generator');
/*-----------------------------------------------------------------------------------*/
# Block XML-RPC requests for non-logged-in users
/*-----------------------------------------------------------------------------------*/
function kavkaz_block_xmlrpc_requests() {
    if (is_user_logged_in()) {
        return;
    }
    if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) {
        header('HTTP/1.1 403 Forbidden');
        exit();
    }
}
add_action('init', 'kavkaz_block_xmlrpc_requests');
/*-----------------------------------------------------------------------------------*/
# Disable XML-RPC
/*-----------------------------------------------------------------------------------*/
add_filter('xmlrpc_enabled', '__return_false');
/*-----------------------------------------------------------------------------------*/
# Remove rel=EditURI and rel=wlwmanifest links
/*-----------------------------------------------------------------------------------*/
add_action('init', 'kavkaz_remheadlink');
function kavkaz_remheadlink() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
/*-----------------------------------------------------------------------------------*/
# Remove from Wp Defult Widget
/*-----------------------------------------------------------------------------------*/
function unregister_default_wp_widgets()
{
    unregister_widget('WP_Widget_Pages');
    unregister_widget('WP_Widget_Calendar');
    unregister_widget('WP_Widget_Archives');
    unregister_widget('WP_Widget_Links');
    unregister_widget('WP_Widget_Meta');
    unregister_widget('WP_Widget_Search');
    unregister_widget('WP_Widget_Categories');
    unregister_widget('WP_Widget_Recent_Posts');
    unregister_widget('WP_Widget_Recent_Comments');
    unregister_widget('WP_Widget_RSS');
    unregister_widget('WP_Widget_Tag_Cloud');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);
/*-----------------------------------------------------------------------------------*/
# Remove X-Pingback
/*-----------------------------------------------------------------------------------*/
function kavkaz_adminify_remove_pingback_head($headers){
    if (isset($headers['X-Pingback'])) {
        unset($headers['X-Pingback']);
    }
    return $headers;
}

function kavkaz_adminify_remove_pingback(){
    if (function_exists('header_remove')) {
        header_remove('X-Pingback');
    }
}
add_filter('wp_headers', 'kavkaz_adminify_remove_pingback_head');
add_action('wp', 'kavkaz_adminify_remove_pingback');
/*-----------------------------------------------------------------------------------*/
# Remove from Wp Head
/*-----------------------------------------------------------------------------------*/
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'wp_head', 'wp_oembed_add_host_js' );
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
/*-----------------------------------------------------------------------------------*/
# Remove from WP EMOJI
/*-----------------------------------------------------------------------------------*/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
/*-----------------------------------------------------------------------------------*/
# Remove from Force scripts into Footer
/*-----------------------------------------------------------------------------------*/
// remove wp-embed script
function my_deregister_scripts()
{
    wp_deregister_script('wp-embed');
	wp_dequeue_script( 'wp-embed' );
}
add_action('wp_footer', 'my_deregister_scripts');

add_filter('wp_default_scripts', 'remove_jquery_migrate');
function remove_jquery_migrate(&$scripts)
{
    if (!is_admin())
    {
        $scripts->remove('jquery');
        $scripts->add('jquery', false, ['jquery-core'], '1.2.1');
    }
}

// remove thickbox
function kavkaz_remove_thickbox()
{
    if (!is_admin())
    {
        wp_deregister_style('thickbox');
        wp_deregister_script('thickbox');
    }
}
add_action('init', 'kavkaz_remove_thickbox');

// remove wp_block library css
function kavkaz_remove_wp_block_library_css()
{
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
		wp_dequeue_style('global-styles');
		wp_dequeue_style('classic-theme-styles');
    }
}
add_action('wp_enqueue_scripts', 'kavkaz_remove_wp_block_library_css', 100);

/*-----------------------------------------------------------------------------------*/
# Remove RSS
/*-----------------------------------------------------------------------------------*/
if ( kavkaz_get_option('remove_rss') ) {
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );

	function kavkaz_disable_feed() {
		wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
	}

	add_action('do_feed', 'kavkaz_disable_feed', 1);
	add_action('do_feed_rdf', 'kavkaz_disable_feed', 1);
	add_action('do_feed_rss', 'kavkaz_disable_feed', 1);
	add_action('do_feed_rss2', 'kavkaz_disable_feed', 1);
	add_action('do_feed_atom', 'kavkaz_disable_feed', 1);
	add_action('do_feed_rss2_comments', 'kavkaz_disable_feed', 1);
	add_action('do_feed_atom_comments', 'kavkaz_disable_feed', 1);
}
/*-----------------------------------------------------------------------------------*/
# .htaccess file protect
/*-----------------------------------------------------------------------------------*/
function kavkaz_htaccess_file_chmod() {
	
	$htaccess_file = WEBSITE_HOME_PATH . '.htaccess';
	if (is_file($htaccess_file) && !is_writable($htaccess_file)){
	  chmod($htaccess_file, 0644);
	}
}

function kavkaz_htaccess_file_protect() {
	
	$htaccess_file = WEBSITE_HOME_PATH . '.htaccess';
	if (is_file($htaccess_file) && is_writable($htaccess_file)){
	  chmod($htaccess_file, 0444);
	}
}
/*-----------------------------------------------------------------------------------*/
# wp-config.php file protect
/*-----------------------------------------------------------------------------------*/
function kavkaz_config_file_chmod() {
	
	$config_file = WEBSITE_HOME_PATH . 'wp-config.php';
	if (is_file($config_file) && !is_writable($config_file)){
	  chmod($config_file, 0644);
	}
}

function kavkaz_config_file_protect() {
	
	$config_file = WEBSITE_HOME_PATH . 'wp-config.php';
	if (is_file($config_file) && is_writable($config_file)){
	  chmod($config_file, 0444);
	}
}
/*-----------------------------------------------------------------------------------*/
# readme.html file delete
/*-----------------------------------------------------------------------------------*/
function kavkaz_readme_file_delete() {
	
	$readme_file = WEBSITE_HOME_PATH . 'readme.html';
	if (is_file($readme_file)){
	  wp_delete_file( $readme_file );
	}
}

if(kavkaz_get_option('readme_file_delete')){
	kavkaz_readme_file_delete();
}
/*-----------------------------------------------------------------------------------*/
# license.txt file delete
/*-----------------------------------------------------------------------------------*/
function kavkaz_license_file_delete() {
	
	$license_file = WEBSITE_HOME_PATH . 'license.txt';
	if (is_file($license_file)){
	  wp_delete_file( $license_file );
	}
}

if(kavkaz_get_option('license_file_delete')){
	kavkaz_license_file_delete();
}
/*-----------------------------------------------------------------------------------*/
# Disable wp-json rest api
/*-----------------------------------------------------------------------------------*/
if ( kavkaz_get_option('json_rest_api') ) {
	add_filter( 'rest_authentication_errors', function( $result ) {
		if ( ! empty( $result ) ) {
			return $result;
		}
		if ( ! is_user_logged_in() ) {
			return new WP_Error( 'restx_logged_out', 'Sorry, you must be logged in to make a request.', array( 'status' => 401 ) );
		}
			return $result;
	});
}
remove_action('rest_api_init', 'wp_oembed_register_route');
add_filter ('json_enabled', '__return_false');
add_filter ('json_jsonp_enabled', '__return_false');
/*-----------------------------------------------------------------------------------*/
# .htaccess writer
/*-----------------------------------------------------------------------------------*/
 function insert_with_x($file_path, $marker_text, $insertion)
 {
     if (!function_exists('insert_with_markers')) {
         if (file_exists(ABSPATH . '/wp-admin/includes/misc.php')) {
             include_once ABSPATH . '/wp-admin/includes/misc.php';
         } else {
             return;
         }
     }
     if ($insertion || file_exists($file_path)) {
       return insert_with_markers($file_path, $marker_text, explode("\n", $insertion));
     }
 }

function kavkaz_htaccess_write() {
    
    
    $htaccess_file = WEBSITE_HOME_PATH . '.htaccess';   
    
    if ( kavkaz_get_option('htaccess_security_code') ) {
        	
        if (is_file($htaccess_file) && is_writable($htaccess_file)){
		
$htaccess_code = '
<Files wp-config.php>
    order allow,deny
    deny from all
</Files>

<Files .htaccess>
    order allow,deny
    deny from all
</Files>

<Files xmlrpc.php>
    order allow,deny
    deny from all
</Files>

<Files readme.html>
    order allow,deny
    deny from all
</Files>

<Files license.txt>
    order allow,deny
    deny from all
</Files>

<Files error_log>
    order allow,deny
    deny from all
</Files>

<FilesMatch "(^wp-config\.php|^readme\.html|^license\.txt)">
    deny from all
</FilesMatch>

<Files ~ "^.*\.([Hh][Tt][Aa])">
    order allow,deny
    deny from all
    satisfy all
</Files>

';
        kavkaz_htaccess_file_chmod();		
        return insert_with_x($htaccess_file, 'KAVKAZ-SECURITY', $htaccess_code);

        }
	
    } else {
    	    
        kavkaz_htaccess_file_chmod();
        return insert_with_x($htaccess_file, 'KAVKAZ-SECURITY', ''); 	    
    	    
    }
}
add_action('init', 'kavkaz_htaccess_write' );
/*-----------------------------------------------------------------------------------*/
# Fix hotlink issue
/*-----------------------------------------------------------------------------------*/
function kavkaz_hotlinkfix() {
    
    
    $home_url =  get_home_url();    
    
	if ( kavkaz_get_option('hotlink_fix') ) {
        		
$htaccess_code = '
RewriteEngine on
RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^'. $home_url .' [NC]
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?google.com [NC]
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?bing.com [NC]
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?yahoo.com [NC]
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?yandex.com [NC]
RewriteRule \.(jpg|jpeg|png|gif)$ – [NC,F,L]
';
        
        kavkaz_htaccess_file_chmod();
        return insert_with_x(WEBSITE_HOME_PATH . '.htaccess' , 'KAVKAZ-FIX-HOTLINK', $htaccess_code);
        		
    } else {
    		    
        kavkaz_htaccess_file_chmod();
        return insert_with_x(WEBSITE_HOME_PATH . '.htaccess' , 'KAVKAZ-FIX-HOTLINK', '');
        		
	}
}
add_action('init', 'kavkaz_hotlinkfix' );
/*-----------------------------------------------------------------------------------*/
# Bad Bot (Spam) Blocking
/*-----------------------------------------------------------------------------------*/
function kavkaz_bad_bot_blocking() {
    
	if ( kavkaz_get_option('bad_bot_blocking') ) {
        		
$htaccess_code = '
RewriteEngine On 
RewriteCond %{HTTP_USER_AGENT} ^BlackWidow [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Bot\ mailto:craftbot@yahoo.com [OR] 
RewriteCond %{HTTP_USER_AGENT} ^ChinaClaw [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Custo [OR] 
RewriteCond %{HTTP_USER_AGENT} ^DISCo [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Download\ Demon [OR] 
RewriteCond %{HTTP_USER_AGENT} ^eCatch [OR] 
RewriteCond %{HTTP_USER_AGENT} ^EirGrabber [OR] 
RewriteCond %{HTTP_USER_AGENT} ^EmailSiphon [OR] 
RewriteCond %{HTTP_USER_AGENT} ^EmailWolf [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Express\ WebPictures [OR] 
RewriteCond %{HTTP_USER_AGENT} ^ExtractorPro [OR] 
RewriteCond %{HTTP_USER_AGENT} ^EyeNetIE [OR] 
RewriteCond %{HTTP_USER_AGENT} ^FlashGet [OR] 
RewriteCond %{HTTP_USER_AGENT} ^GetRight [OR] 
RewriteCond %{HTTP_USER_AGENT} ^GetWeb! [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Go!Zilla [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Go-Ahead-Got-It [OR] 
RewriteCond %{HTTP_USER_AGENT} ^GrabNet [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Grafula [OR] 
RewriteCond %{HTTP_USER_AGENT} ^HMView [OR] 
RewriteCond %{HTTP_USER_AGENT} HTTrack [NC,OR] 
RewriteCond %{HTTP_USER_AGENT} ^Image\ Stripper [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Image\ Sucker [OR] 
RewriteCond %{HTTP_USER_AGENT} Indy\ Library [NC,OR] 
RewriteCond %{HTTP_USER_AGENT} ^InterGET [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Internet\ Ninja [OR] 
RewriteCond %{HTTP_USER_AGENT} ^JetCar [OR] 
RewriteCond %{HTTP_USER_AGENT} ^JOC\ Web\ Spider [OR] 
RewriteCond %{HTTP_USER_AGENT} ^larbin [OR] 
RewriteCond %{HTTP_USER_AGENT} ^LeechFTP [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Mass\ Downloader [OR] 
RewriteCond %{HTTP_USER_AGENT} ^MIDown\ tool [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Mister\ PiX [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Navroad [OR] 
RewriteCond %{HTTP_USER_AGENT} ^NearSite [OR] 
RewriteCond %{HTTP_USER_AGENT} ^NetAnts [OR] 
RewriteCond %{HTTP_USER_AGENT} ^NetSpider [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Net\ Vampire [OR] 
RewriteCond %{HTTP_USER_AGENT} ^NetZIP [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Octopus [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Offline\ Explorer [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Offline\ Navigator [OR] 
RewriteCond %{HTTP_USER_AGENT} ^PageGrabber [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Papa\ Foto [OR] 
RewriteCond %{HTTP_USER_AGENT} ^pavuk [OR] 
RewriteCond %{HTTP_USER_AGENT} ^pcBrowser [OR] 
RewriteCond %{HTTP_USER_AGENT} ^RealDownload [OR] 
RewriteCond %{HTTP_USER_AGENT} ^ReGet [OR] 
RewriteCond %{HTTP_USER_AGENT} ^SiteSnagger [OR] 
RewriteCond %{HTTP_USER_AGENT} ^SmartDownload [OR] 
RewriteCond %{HTTP_USER_AGENT} ^SuperBot [OR] 
RewriteCond %{HTTP_USER_AGENT} ^SuperHTTP [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Surfbot [OR] 
RewriteCond %{HTTP_USER_AGENT} ^tAkeOut [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Teleport\ Pro [OR] 
RewriteCond %{HTTP_USER_AGENT} ^VoidEYE [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Web\ Image\ Collector [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Web\ Sucker [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebAuto [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebCopier [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebFetch [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebGo\ IS [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebLeacher [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebReaper [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebSauger [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Website\ eXtractor [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Website\ Quester [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebStripper [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebWhacker [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WebZIP [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Wget [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Widow [OR] 
RewriteCond %{HTTP_USER_AGENT} ^WWWOFFLE [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Xaldon\ WebSpider [OR] 
RewriteCond %{HTTP_USER_AGENT} ^Zeus 
RewriteRule ^.* - [F,L]
';
        
        kavkaz_htaccess_file_chmod();
        return insert_with_x(WEBSITE_HOME_PATH . '.htaccess' , 'KAVKAZ-BAD-BOT-BLOCKING', $htaccess_code);
        		
    } else {
    		    
        kavkaz_htaccess_file_chmod();
        return insert_with_x(WEBSITE_HOME_PATH . '.htaccess' , 'KAVKAZ-BAD-BOT-BLOCKING', '');
        		
	}
}
add_action('init', 'kavkaz_bad_bot_blocking' );
/*-----------------------------------------------------------------------------------*/
# Slow down the wordpress hearbeat
/*-----------------------------------------------------------------------------------*/
function kavkaz_slow_heartbeat( $settings ) {
    $settings['interval'] = 60;
    return $settings;
}

if ( kavkaz_get_option('slow_heartbeat') ) {
    add_filter( 'heartbeat_settings', 'kavkaz_slow_heartbeat'  );
}
/*-----------------------------------------------------------------------------------*/
# File Protect
/*-----------------------------------------------------------------------------------*/
if(kavkaz_get_option('htaccess_file_protect')){
	kavkaz_htaccess_file_protect();
} else {
	kavkaz_htaccess_file_chmod();
}

if(kavkaz_get_option('config_file_protect')){
	kavkaz_config_file_protect();
} else {
	kavkaz_config_file_chmod();
}

/*-----------------------------------------------------------------------------------*/
# Create htaccess to upload
/*-----------------------------------------------------------------------------------*/
function kavkaz_create_htaccess_to_upload() {
	
	if ( kavkaz_get_option('htaccess_to_upload') ) {
		
		$upload      = wp_upload_dir();
		$upload_dir  = $upload['basedir'];	
		$filename    = $upload_dir . '/.htaccess';

		if ( file_exists($filename) ){
			//file exists, then it does nothing.
		} else {		
			$htaccess = fopen($upload_dir . '/.htaccess', 'w') or die("Unable to open file!");
$code = '

<Files *.php>
    deny from all
</Files>

';
			fwrite($htaccess, $code);
			fclose($htaccess);
		}
	}
}
add_action( 'init', 'kavkaz_create_htaccess_to_upload' );

/*-----------------------------------------------------------------------------------*/
# Block Feed and Comments robots.txt
/*-----------------------------------------------------------------------------------*/
add_filter( 'robots_txt', 'kavkaz_custom_robots_txt', 20, 2 );
function kavkaz_custom_robots_txt( $output, $public ) {
	if ( '1' == $public ) {
		$output .= "\n" . "# Block Feed and Comments" . "\n" . "User-agent: *" . "\n" . "Disallow: /feed/" . "\n" . "Disallow: /feed/$" . "\n" . "Disallow: /comments/feed" . "\n" . "Disallow: /trackback/" . "\n" . "Disallow: */?author=*" . "\n" . "Disallow: */author/*" . "\n" . "Disallow: /author*" . "\n" . "Disallow: /author/" . "\n" . "Disallow: */comments$" . "\n" . "Disallow: */feed" . "\n" . "Disallow: */feed/*" . "\n" . "Disallow: */feed$" . "\n" . "Disallow: */trackback" . "\n" . "Disallow: */trackback$" . "\n" . "Disallow: /?feed=" . "\n" . "Disallow: /wp-comments" . "\n" . "Disallow: /wp-feed" . "\n" . "Disallow: /wp-trackback" . "\n" . "Disallow: */replytocom=" . "\n";
		$output .= "\n" . "# Block Files" . "\n" . "User-agent: *" . "\n" . "Disallow: /cdn-cgi/" . "\n";
        $output .= "\n" . "# Block Woocommerce assets" . "\n" . "User-agent: *" . "\n" . "Disallow: /cart/" . "\n" . "Disallow: /checkout/" . "\n" . "Disallow: /my-account/" . "\n" . "Disallow: /*?orderby=price" . "\n" . "Disallow: /*?orderby=rating" . "\n" . "Disallow: /*?orderby=date" . "\n" . "Disallow: /*?orderby=price-desc" . "\n" . "Disallow: /*?orderby=popularity" . "\n" . "Disallow: /*?filter" . "\n" . "Disallow: /*add-to-cart=*" . "\n" . "Disallow: /*?add_to_wishlist=*" . "\n";
		$output .= "\n" . "# Block Search assets" . "\n" . "User-agent: *" . "\n" . "Disallow: /search/" . "\n" . "Disallow: *?s=*" . "\n" . "Disallow: *?p=*" . "\n" . "Disallow: *&p=*" . "\n" . "Disallow: *&preview=*" . "\n" . "Disallow: /search" . "\n";
    }
	return $output;
}
