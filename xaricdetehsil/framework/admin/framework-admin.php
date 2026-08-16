<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Admin Settings
/*-----------------------------------------------------------------------------------*/

if( is_admin() ){

	//OPTIONS FUNCTIONS
	require_once ( get_template_directory() . '/framework/admin/framework-options.php');

	//KAVKAZ PANEL
	require_once ( get_template_directory() . '/framework/admin/framework-panel.php');

	//POSTS META-BOXES
	require_once ( get_template_directory() . '/framework/admin/framework-metaboxes.php');

	//CUSTOM SLIDER POST TYPE
	require_once ( get_template_directory() . '/framework/admin/custom-slider.php');

	//PARTNERS
	require_once ( get_template_directory() . '/framework/admin/custom-partners.php');

	//OURWORKS
	require_once ( get_template_directory() . '/framework/admin/custom-ourworks.php');

	//Testimonials
	require_once ( get_template_directory() . '/framework/admin/custom-faqs.php');
	
	//Faqs
	require_once ( get_template_directory() . '/framework/admin/custom-testimonials.php');	
	
	//Gallery Metabox
	require_once ( get_template_directory() . '/framework/admin/gallery-metabox.php');	

	/*-----------------------------------------------------------------------------------*/
	# Register main Scripts and Styles
	/*-----------------------------------------------------------------------------------*/
	function kavkaz_admin_register() {
		global $pagenow;

		$ver = time(); // Avoid browser cache for admins
		wp_register_script( 'kavkaz-admin-main', get_template_directory_uri() . '/framework/admin/js/kavkaz.js', array( 'jquery', 'jquery-ui-tooltip' ), $ver, false );
		wp_register_script( 'kavkaz-admin-colorpicker', get_template_directory_uri() . '/framework/admin/js/colorpicker.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-sortable', 'jquery-ui-slider' ), $ver, false );
		wp_register_style( 'kavkaz-style', get_template_directory_uri().'/framework/admin/style.css', array(), $ver, 'all' );

		wp_enqueue_script( 'kavkaz-admin-main' );
		wp_enqueue_script( 'kavkaz-admin-colorpicker' );
		wp_enqueue_style( 'kavkaz-style' );
	}
	add_action( 'admin_enqueue_scripts', 'kavkaz_admin_register' );


	// INSTALL THE THEME
	global $pagenow;
	if ( isset( $_GET['activated'] ) && $pagenow == 'themes.php' ){
		add_action( 'init', 'kavkaz_install_theme', 1 );
	}

	function kavkaz_install_theme() {
		global $default_data;

		if( !get_option('kavkaz_active') ){
			kavkaz_save_settings( $default_data );
			update_option( 'kavkaz_active' , THEME_VER );
		}

	}

}

function __kavkaztext($text){
    $sanitize_text = kavkaz_sanitize_title(htmlspecialchars($text));

    if (kavkaz_get_option($sanitize_text)){
        return htmlspecialchars_decode(kavkaz_get_option($sanitize_text));
    }else{
        return __($text, 'kavkaz');
    }
}

function _kavkaz($text){
    echo __kavkaztext($text);
}


//DEFAULT OPTIONS
$default_data = Array(
	"kavkaz_options"	=> Array(
		'meta_theme_color' 			=> 		'#164888',
		'favicon'                   =>      THEME_URL . '/favicon.ico',
		'preloader' 				=> 		true,
		'logo_setting' 				=> 		'title',
		'top_social' 	 			=> 		true,
		'footer_social'				=>		true,
		'back_top'					=>		true,
		'footer_one' 				=> 		'&#169; Copyright %year%, All Rights Reserved',
		'global_color' 				=> 		'#164888',
		'modern_scrollbar' 			=> 		false,
		'facebook_url' 				=> 		'#',
		'twitter_url' 				=> 		'#',
		'linkedin_url' 				=> 		'#',
		'youtube_url' 				=> 		'#',
		'instagram_url' 			=> 		'#',
		'display_contact_number' 	=> 		false,
		'display_contact_email' 	=> 		false,
		'display_contact_address' 	=> 		false,
		'display_contact_hours' 	=> 		false,
		'enable_preload' 			=> 		true,
		'disable_admin_bar' 		=> 		true,
		'notify_theme'				=>		false,
		'disable_responsive' 		=> 		false,
		'dashboard_logo_url' 		=> 		home_url(),
		'dashboard_backgorund_color' =>     '#f5f5f5',
		'enable_smtp' 				=> 		false,
		'smtp_auto_tls' 			=> 		false,
		'smtp_encryption' 			=> 		'ssl',
		'smtp_authentication' 		=> 		false

	)
);

?>
