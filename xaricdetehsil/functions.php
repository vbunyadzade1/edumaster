<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/**
 * KavKaz functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage KavKaz
 * @since KavKaz 1.0
 */

/*-----------------------------------------------------------------------------------*/
# KavKaz Freamwork
/*-----------------------------------------------------------------------------------*/
define ('THEME_NAME',   'KavKaz Panel' );                            //Theme Name
define ('THEME_FOLDER', 'xaricdetehsilorg' );                        //Theme Folder Name
define ('THEME_VER',    '2.8'  );	                                 //Theme Version
define ('THEME_URL',    get_template_directory_uri() );               //Theme URL
define ('TEMPLATE_URL', get_template_directory() );                   //Template URL
define ('NO_IMAGE',     THEME_URL . '/assets/img/noimage.jpg' );     //No Image URL

/*-----------------------------------------------------------------------------------*/
# Works with PHP 5.3 or Later
/*-----------------------------------------------------------------------------------*/
if ( version_compare( phpversion(), '5.3', '<' ) ) {
	require TEMPLATE_URL . '/framework/functions/php-disable.php';

	return;
}

if ( ! isset( $content_width ) ) $content_width = 618;

// Main Functions
require_once ( TEMPLATE_URL . '/framework/functions/theme-functions.php' );
require_once ( TEMPLATE_URL . '/framework/functions/theme-setup.php'     );
require_once ( TEMPLATE_URL . '/framework/functions/core-functions.php'  );
require_once ( TEMPLATE_URL . '/framework/functions/custom-posts.php'    );
require_once ( TEMPLATE_URL . '/framework/functions/views.php'           );
require_once ( TEMPLATE_URL . '/framework/functions/pagenavi.php'        );
require_once ( TEMPLATE_URL . '/framework/functions/menu.php'            );
require_once ( TEMPLATE_URL . '/framework/functions/comment.php'         );
require_once ( TEMPLATE_URL . '/framework/functions/top-posts.php'       );
require_once ( TEMPLATE_URL . '/framework/functions/excerpt.php'         );
require_once ( TEMPLATE_URL . '/framework/functions/remove-init.php'     );
require_once ( TEMPLATE_URL . '/framework/functions/thumbnail.php'       );
require_once ( TEMPLATE_URL . '/framework/functions/wp-document.php'     );
require_once ( TEMPLATE_URL . '/framework/functions/common-scripts.php'  );
require_once ( TEMPLATE_URL . '/framework/widgets.php'                   );
require_once ( TEMPLATE_URL . '/framework/admin/framework-admin.php'     );

if ( kavkaz_get_option('enable_smtp') ) :
require_once ( TEMPLATE_URL . '/framework/functions/smtp.php'            );
endif;

if ( kavkaz_get_option('enable_minify_html') ) :
require_once ( TEMPLATE_URL . '/framework/functions/minify.php'          );
endif;

if ( kavkaz_get_option('DISALLOW_FILE_EDIT') && !defined('DISALLOW_FILE_EDIT') ) :
define('DISALLOW_FILE_EDIT', true);
endif;

if ( kavkaz_get_option('FORCE_SSL_ADMIN') && !defined('FORCE_SSL_ADMIN') ) :
define('FORCE_SSL_ADMIN', true);
endif;

if ( kavkaz_get_option('Limit_Login_Attempts') ) :
new Limit_Login_Attempts();
endif;
