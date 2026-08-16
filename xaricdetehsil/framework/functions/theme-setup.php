<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Setup Theme
/*-----------------------------------------------------------------------------------*/

function kavkaz_theme_setup(){

	/*
	 * Make theme available for translation.
	*/
	load_theme_textdomain( 'kavkaz' );
	
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );	
 
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
 
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://wordpress.org/support/article/post-formats/
	 */
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat' ) );
 
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );
 
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style', 'navigation-widgets' ) );
 
    // custom background
    add_theme_support( 'custom-background', array(
        'default-image'          => '',
        'default-preset'         => 'default',
        'default-size'           => 'cover',
        'default-repeat'         => 'no-repeat',
        'default-attachment'     => 'scroll',
    ) );
 
    // custom header
    add_theme_support( 'custom-header', array(
        'default-image'          => '',
        'width'                  => 300,
        'height'                 => 60,
        'flex-height'            => true,
        'flex-width'             => true,
        'default-text-color'     => '',
        'header-text'            => true,
        'uploads'                => true,
    ) );
 
    // custom log
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
	
	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for custom line height controls.
	add_theme_support( 'custom-line-height' );	
 
	// Gutenberg
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'align-wide' );

	// This theme uses wp_nav_menu() in two locations.	
	register_nav_menus( array(
        'header_menu' => esc_html__('Header Menu', 'kavkaz'),
		'footer_menu' => esc_html__('Footer Menu', 'kavkaz')
	));
 
}
add_action('after_setup_theme','kavkaz_theme_setup');

/*-----------------------------------------------------------------------------------*/
# Get Theme Options
/*-----------------------------------------------------------------------------------*/
function kavkaz_get_option( $name ) {
	$get_options = get_option( 'kavkaz_options' );

	if( !empty( $get_options[$name] ))
		 return $get_options[$name];

	return false ;
}

/*-----------------------------------------------------------------------------------*/
# Permision Upload File
/*-----------------------------------------------------------------------------------*/
add_filter( 'upload_mimes', 'kavkaz_permision_myme_types', 1, 1 );
function kavkaz_permision_myme_types($mime_types) {

    $mime_types['webp'] = 'image/webp';
    $mime_types['svg'] = 'image/svg+xml';
    $mime_types['json'] = 'application/json';
    
    unset( $mime_types['xls'] );
    unset( $mime_types['xlsx'] );
    
    return $mime_types;
}

/*-----------------------------------------------------------------------------------*/
# Custom Dashboard login page logo
/*-----------------------------------------------------------------------------------*/
function kavkaz_login_logo(){
	if( kavkaz_get_option('dashboard_logo') )
    echo '<style  type="text/css"> .login h1 a {  background-image:url('.kavkaz_get_option('dashboard_logo').')  !important; background-size: 274px 63px; width: 326px; height: 67px; } body.login { background-color: '.kavkaz_get_option('dashboard_backgorund_color').' !important; } </style>';
}
add_action('login_head',  'kavkaz_login_logo');

function kavkaz_login_logo_url() {
   	 return kavkaz_get_option('dashboard_logo_url');
}
if( kavkaz_get_option('dashboard_logo_url') )
add_filter( 'login_headerurl', 'kavkaz_login_logo_url' );


/*-----------------------------------------------------------------------------------*/
# Custom Gravatar
/*-----------------------------------------------------------------------------------*/
function kavkaz_custom_gravatar ($avatar) {
	$kavkaz_gravatar = kavkaz_get_option( 'gravatar' );
	if($kavkaz_gravatar){
		$custom_avatar = kavkaz_get_option( 'gravatar' );
		$avatar[$custom_avatar] = "Custom Gravatar";
	}
	return $avatar;
}
add_filter( 'avatar_defaults', 'kavkaz_custom_gravatar' );


/*-----------------------------------------------------------------------------------*/
# Custom Favicon
/*-----------------------------------------------------------------------------------*/
function kavkaz_favicon() {
	
	$default_favicon = get_template_directory_uri()."/favicon.ico";
	$custom_favicon = kavkaz_get_option('favicon');
	
	$default_apple_icon = get_template_directory_uri()."/apple_icon.png";
	$custom_apple_icon = kavkaz_get_option('apple_icon');
	
	$favicon = (empty($custom_favicon)) ? $default_favicon : $custom_favicon;
	$apple_icon = (empty($custom_apple_icon)) ? $default_apple_icon : $custom_apple_icon;
	
	echo '<link rel="shortcut icon" href="'.$favicon.'" type="image/x-icon" />' . "\n";
	echo '<link rel="apple-touch-icon" href="'.$apple_icon.'" />' . "\n";
}
add_action('wp_head', 'kavkaz_favicon');

/*-----------------------------------------------------------------------------------*/
# Remove from Wp Admin Bar
/*-----------------------------------------------------------------------------------*/
if (!current_user_can('administrator')){
    add_filter('show_admin_bar', '__return_false');
    remove_action('personal_options', '_admin_bar_preferences');
} else {
    if (kavkaz_get_option('disable_admin_bar')){
        add_filter('show_admin_bar', '__return_false');
    }
}

/*-----------------------------------------------------------------------------------*/
# Custom Admin Bar Menus
/*-----------------------------------------------------------------------------------*/
function kavkaz_admin_bar() {
	global $wp_admin_bar;

	if ( current_user_can( 'switch_themes' ) ){
		$wp_admin_bar->add_menu( array(
			'parent' => 0,
			'id' => 'mpanel_page',
			'title' => THEME_NAME ,
			'href' => admin_url( 'admin.php?page=panel')
		) );
	}
}
add_action( 'wp_before_admin_bar_render', 'kavkaz_admin_bar' );
