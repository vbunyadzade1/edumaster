<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Clean options before store it in DB
/*-----------------------------------------------------------------------------------*/
function kavkaz_clean_options(&$value) {
  $value = htmlspecialchars(stripslashes( str_replace( 'kavkaz-open-tag', '', $value ) ));
}
function kavkaz_clean_imported_options(&$value) {
  $value = htmlspecialchars_decode( $value );
}


/*-----------------------------------------------------------------------------------*/
# Options Array
/*-----------------------------------------------------------------------------------*/
$array_options = array( "kavkaz_options" );


/*-----------------------------------------------------------------------------------*/
# Save Theme Settings
/*-----------------------------------------------------------------------------------*/
function kavkaz_save_settings ( $data , $refresh = 0 ) {
	global $array_options ;

	foreach( $array_options as $option ){
		if( isset( $data[$option] )){
			array_walk_recursive( $data[$option] , 'kavkaz_clean_options');
			update_option( $option ,  $data[$option] );
		}
	}

	if( $refresh == 2 )  	die('2');
	elseif( $refresh == 1 )	die('1');
}


/*-----------------------------------------------------------------------------------*/
# Save Options
/*-----------------------------------------------------------------------------------*/
add_action('wp_ajax_test_theme_data_save', 'kavkaz_save_ajax');
function kavkaz_save_ajax() {

	check_ajax_referer('test-theme-data', 'security');
	$data = $_POST;
	$refresh = 1;

	if( !empty( $data['kavkaz_import'] ) ){
		$refresh = 2;
		$data = unserialize(base64_decode( $data['kavkaz_import'] ));
		array_walk_recursive( $data , 'kavkaz_clean_imported_options');
	}

	kavkaz_save_settings ($data , $refresh );
}


/*-----------------------------------------------------------------------------------*/
# Add Panel Page
/*-----------------------------------------------------------------------------------*/
add_action('admin_menu', 'kavkaz_add_admin');
function kavkaz_add_admin() {

	$current_page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';

	add_menu_page( 'Theme Options' , 'Theme Options' ,'switch_themes', 'panel' , 'kavkaz_panel_options', 'dashicons-align-pull-left', 60  );
	$theme_page = add_submenu_page('panel', __( 'Theme Settings', 'kavkaz' ), __( 'Theme Settings', 'kavkaz' ) ,'switch_themes', 'panel' , 'kavkaz_panel_options');
	add_submenu_page('panel', __( 'Support', 'kavkaz' ), __( 'Support', 'kavkaz' ) ,'switch_themes', 'support' , 'kavkaz_get_support');


	function kavkaz_get_support(){
	?>
		<div class="theme_suppeort_wrap">
		<h1><?php echo THEME_NAME; ?><?php _e(' Theme Support', 'kavkaz'); ?></h1>
		<img src="<?php bloginfo('template_directory'); ?>/screenshot.png" alt="screenshot">
		<h2><?php _e('How to use? Ask us', 'kavkaz'); ?></h2>
		<div class="contact_fleex">
		<span><?php _e('Email : mayishaciyev@yandex.com', 'kavkaz'); ?></span>
		<span><?php _e('SKYPE : mayis.haciyev', 'kavkaz'); ?></span>
		<span><?php _e('Linkedin : Mayis Haciyev', 'kavkaz'); ?></span>
		</div>
		</div>
	<?php
	}

	add_action( 'admin_head-'. $theme_page, 'kavkaz_admin_head' );
	function kavkaz_admin_head(){

	?>
	<script type="text/javascript">
		var emptyImg = '<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png';

		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty: emptyImg});

		  jQuery('form#kavkaz_form').submit(function() {

		  	/* Disable Empty options */
			  jQuery('form#kavkaz_form input, form#kavkaz_form textarea, form#kavkaz_form select').each(function() {
					if (!jQuery(this).val()) jQuery(this).attr("disabled", true );
			  });
			   jQuery('#typography_test-item input, #typography_test-item select').attr("disabled", true );

				var data = jQuery(this).serialize().replace( /%3C/g, '%3Ckavkaz-open-tag' );

			/* Enable Empty options */
			  jQuery('form#kavkaz_form input:disabled, form#kavkaz_form textarea:disabled, form#kavkaz_form select:disabled').attr("disabled", false );

			  jQuery.post(ajaxurl, data, function(response) {
				  if(response == 1) {
					  jQuery('#save-alert').addClass('save-done');
					  t = setTimeout('fade_message()', 1000);
				  }
				else if( response == 2 ){
					location.reload();
				}
				else {
					 jQuery('#save-alert').addClass('save-error');
					  t = setTimeout('fade_message()', 1000);
				  }
			  });
			  return false;
		  });

		});

		function fade_message() {
			jQuery('#save-alert').fadeOut(function() {
				jQuery('#save-alert').removeClass('save-done');
			});
			clearTimeout(t);
		}

		jQuery(function() {
			jQuery( "#customList"   ).sortable({placeholder: "ui-state-highlight"});
		});
	</script>
	<?php
		wp_enqueue_media();
	}
	if( isset( $_REQUEST['action'] ) ){
		if( 'reset' == $_REQUEST['action']  && $current_page == 'panel' && check_admin_referer('reset-action-code' , 'resetnonce') ) {
			global $default_data;
			kavkaz_save_settings( $default_data );
			header("Location: admin.php?page=panel&reset=true");
			die;
		}
	}
}


/*-----------------------------------------------------------------------------------*/
# Get The Panel Options
/*-----------------------------------------------------------------------------------*/
function kavkaz_options ( $value ){
	$data = false;
	if( kavkaz_get_option( $value['id'] ) ) $data = kavkaz_get_option( $value['id'] );

	kavkaz_options_build ( $value, 'kavkaz_options['.$value["id"].']', $data );
}

/*-----------------------------------------------------------------------------------*/
# The Panel UI
/*-----------------------------------------------------------------------------------*/
function kavkaz_panel_options() {

	//Categories
	$categories_obj = get_categories('hide_empty=0');
	$categories = array();
	foreach ($categories_obj as $pn_cat) {
		$categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
	}

	$checked = 'checked="checked"';

$save='
	<div class="mpanel-submit">
		<input type="hidden" name="action" value="test_theme_data_save" />
        <input type="hidden" name="security" value="'. wp_create_nonce("test-theme-data").'" />
		<input name="save" class="mpanel-save" type="submit" value="'.__( "Save Changes", 'kavkaz' ).'" />
	</div>';
?>


<div id="save-alert"></div>

	<?php do_action( 'kavkaz_before_theme_panel' );?>

<div class="kavkaz-panel">
	<div class="kavkaz-panel-tabs">
		<div class="kavkaz-logo-title">
			<?php echo THEME_NAME; ?>
			<p><?php _e('Themes','kavkaz'); ?></p>
			<span><?php _e('Responsive Wordpress Themes','kavkaz'); ?></span>
		</div>
		<ul>
			<li class="kavkaz-tabs general"><a href="#tab_general"><span class="dashicons-before dashicons-admin-settings kavkaz-icon-menu"></span><?php _e( 'General Settings', 'kavkaz' ) ?></a></li>
			<li class="kavkaz-tabs header"><a href="#tab_header"><span class="dashicons-before dashicons-schedule kavkaz-icon-menu"></span><?php _e( 'Header Settings', 'kavkaz' ) ?></a></li>
			<li class="kavkaz-tabs sidebars"><a href="#tab_sidebars"><span class="dashicons-before dashicons-slides kavkaz-icon-menu"></span><?php _e( 'Sidebars', 'kavkaz' ) ?></a></li>
			<li class="kavkaz-tabs footer"><a href="#tab_footer"><span class="dashicons-before dashicons-editor-insertmore kavkaz-icon-menu"></span><?php _e( 'Footer Settings', 'kavkaz' ) ?></a></li>		
			<li class="kavkaz-tabs styling"><a href="#tab_styling"><span class="dashicons-before dashicons-admin-appearance kavkaz-icon-menu"></span><?php _e( 'Styling', 'kavkaz' ) ?></a></li>
			<li class="kavkaz-tabs social"><a href="#tab_social"><span class="dashicons-before dashicons-networking kavkaz-icon-menu"></span><?php _e( 'Social Networking', 'kavkaz' ) ?></a></li>
			<li class="kavkaz-tabs contact"><a href="#tab_contact"><span class="dashicons-before dashicons-whatsapp kavkaz-icon-menu"></span><?php _e( 'Contact Details', 'kavkaz' ) ?></a></li>
			<li class="kavkaz-tabs advanced"><a href="#tab_advanced"><span class="dashicons-before dashicons-admin-tools kavkaz-icon-menu"></span><?php _e( 'Advanced', 'kavkaz' ) ?></a></li>
			<li class="kavkaz-tabs email"><a href="#tab_email"><span class="dashicons-before dashicons-email-alt kavkaz-icon-menu"></span><?php _e( 'Mail SMTP', 'kavkaz' ) ?></a></li>
		</ul>
		<div class="clear"></div>
	</div> <!-- .kavkaz-panel-tabs -->


	<div class="kavkaz-panel-content">
	<form action="/" name="kavkaz_form" id="kavkaz_form">
		<div id="tab_general" class="tabs-wrap">
			<h2><?php _e( 'General Settings', 'kavkaz' ) ?></h2> <?php echo $save ?>
			<div class="kavkazpanel-item">
				<h3><?php _e( 'Theme Color Settings', 'kavkaz' ) ?></h3>
				<?php

					kavkaz_options(
						array(	"name"	=> __( 'Theme Main Color', 'kavkaz' ),
								"id"	=> "meta_theme_color",
								"type"	=> "color"));
				?>
			</div>	

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Custom Favicon', 'kavkaz' ) ?></h3>
				<?php
					kavkaz_options(
						array(	"name"	=> __( 'Custom Favicon', 'kavkaz' ),
								"id"	=> "favicon",
								"type"	=> "upload"));
				?>
			</div>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Custom Gravatar', 'kavkaz' ) ?></h3>
				<?php
					kavkaz_options(
						array(	"name"	=> __( 'Custom Gravatar', 'kavkaz' ),
								"id"	=> "gravatar",
								"type"	=> "upload"));
				?>
			</div>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Header Code', 'kavkaz' ) ?></h3>
				<div class="option-item">
					<small><?php _e( 'The following code will add to the &lt;head&gt; tag. Useful if you need to add additional codes such as CSS or JS.', 'kavkaz' ) ?></small>
					<textarea id="header_code" name="kavkaz_options[header_code]" style="width:100%" rows="7"><?php echo htmlspecialchars_decode(kavkaz_get_option('header_code'));  ?></textarea>
				</div>
			</div>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Footer Code', 'kavkaz' ) ?></h3>
				<div class="option-item">
					<small><?php _e( 'The following code will add to the footer before the closing  &lt;/body&gt; tag. Useful if you need to add Javascript or tracking code.', 'kavkaz' ) ?></small>
					<textarea id="footer_code" name="kavkaz_options[footer_code]" style="width:100%" rows="7"><?php echo htmlspecialchars_decode(kavkaz_get_option('footer_code'));  ?></textarea>
				</div>
			</div>

		</div>

		<div id="tab_header" class="tabs-wrap">
			<h2><?php _e( 'Header Settings', 'kavkaz' ) ?></h2> <?php echo $save ?>
			<div class="kavkazpanel-item">
				<h3><?php _e( 'Logo', 'kavkaz' ) ?></h3>
				<?php
					kavkaz_options(
						array( 	"name"		=> __( 'Logo Settings', 'kavkaz' ),
								"id"		=> "logo_setting",
								"type"		=> "radio",
								"options"	=> array(	"logo"	=> __( 'Custom Image Logo', 'kavkaz' ) ,
														"title"	=> __( 'Display Site Title', 'kavkaz' ) )));

					kavkaz_options(
						array(	"name"			=> __( 'Header Logo Image', 'kavkaz' ),
								"id"			=> "logo_header",
								"help"			=> __( 'Upload a logo image, or enter URL to an image if it is already uploaded. the theme default logo gets applied if the input field is left blank.', 'kavkaz' ),
								"type"			=> "upload",
								"extra_text"	=> __( 'Recommended size (MAX) : 324px x 96px', 'kavkaz' ) ));	
								
					kavkaz_options(
						array(	"name"			=> __( 'Footer Logo Image', 'kavkaz' ),
								"id"			=> "logo_footer",
								"help"			=> __( 'Upload a logo image, or enter URL to an image if it is already uploaded. the theme default logo gets applied if the input field is left blank.', 'kavkaz' ),
								"type"			=> "upload",
								"extra_text"	=> __( 'Recommended size (MAX) : 324px x 96px', 'kavkaz' ) ));								

				?>

			</div>

		</div>

		<div id="tab_social" class="tabs-wrap">
			<h2><?php _e( 'Social Networking', 'kavkaz' ) ?></h2> <?php echo $save ?>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Social Networking', 'kavkaz' ) ?></h3>
				<?php
					
					kavkaz_options(
						array(	"name"	=> __( 'Whatsapp Number', 'kavkaz' ),
								"id"	=> "whatsapp",
								"type"	=> "text"));
	
					kavkaz_options(
						array(	"name"	=> __( 'Facebook URL', 'kavkaz' ),
								"id"	=> "facebook_url",
								"type"	=> "text"));
					kavkaz_options(
						array(	"name"	=> __( 'Twitter URL', 'kavkaz' ),
								"id"	=> "twitter_url",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'LinkedIn URL', 'kavkaz' ),
								"id"	=> "linkedin_url",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'YouTube URL', 'kavkaz' ),
								"id"	=> "youtube_url",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'Instagram URL', 'kavkaz' ),
								"id"	=> "instagram_url",
								"type"	=> "text"));
				?>
			</div>

		</div><!-- Social Networking -->

		<div id="tab_footer" class="tabs-wrap">
			<h2><?php _e( 'Footer Settings', 'kavkaz' ) ?></h2> <?php echo $save ?>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Footer Settings', 'kavkaz' ) ?></h3>
				<?php			

					kavkaz_options(
						array(	"name"	=> __( 'Display Footer Social', 'kavkaz' ),
								"id"	=> "footer_social",
								"type"	=> "checkbox"));	

					kavkaz_options(
						array(	"name"	=> __( 'Display Back Top Button', 'kavkaz' ),
								"id"	=> "back_top",
								"type"	=> "checkbox"));	

				?>
			</div>			

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Footer Text', 'kavkaz' ) ?></h3>
				<div class="option-item">
					<textarea id="kavkaz_footer_one" name="kavkaz_options[footer_one]" style="width:100%" rows="4"><?php echo htmlspecialchars_decode(kavkaz_get_option('footer_one'));  ?></textarea>
					<span style="padding:0" class="extra-text"><strong style="font-size: 12px;"><?php _e( 'Variables', 'kavkaz' ) ?></strong>
						<?php _e( 'These tags can be included in the textarea above and will be replaced when a page is displayed.', 'kavkaz' ) ?>
						<br />
						<strong>%year%</strong> : <em><?php _e( 'Replaced with the current year.', 'kavkaz' ) ?></em><br />
						<strong>%site%</strong> : <em><?php _e( "Replaced with The site's name.", 'kavkaz' ) ?></em><br />
						<strong>%url%</strong>  : <em><?php _e( "Replaced with The site's URL.", 'kavkaz' ) ?></em>
					</span>
				</div>
			</div>

		</div><!-- Footer Settings -->

		<div id="tab_sidebars" class="tab_content tabs-wrap">
			<h2><?php _e( 'Sidebars', 'kavkaz' ) ?></h2>
			<?php echo $save ?>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Add Sidebar', 'kavkaz' ) ?></h3>
				<div class="option-item">
					<span class="label"><?php _e( 'Sidebar Name', 'kavkaz' ) ?></span>

					<input id="sidebarName" type="text" size="56" style="direction:ltr; text-laign:left" name="sidebarName" value="" />
					<input id="sidebarAdd"  class="button" type="button" value="<?php _e( 'Add', 'kavkaz' ) ?>" />

					<ul id="sidebarsList">
					<?php $sidebars = kavkaz_get_option( 'sidebars' ) ;
						if($sidebars){
							foreach ($sidebars as $sidebar) { ?>
						<li>
							<div class="widget-head"><?php echo $sidebar ?>  <input id="kavkaz_sidebars" name="kavkaz_options[sidebars][]" type="hidden" value="<?php echo $sidebar ?>" /><a class="del-sidebar"></a></div>
						</li>
							<?php }
						}
					?>
					</ul>
				</div>
			</div>

			<div class="kavkazpanel-item" id="custom-sidebars">
				<h3><?php _e( 'Custom Sidebars', 'kavkaz' ) ?></h3>
				<?php

				$new_sidebars = array(''=> __( 'Default' , 'kavkaz' ));

				if($sidebars){
					foreach ($sidebars as $sidebar) {
						$new_sidebars[$sidebar] = $sidebar;
					}
				}

				kavkaz_options(
					array(	"name"		=> __( 'Archives Sidebar', 'kavkaz' ),
							"id"		=> "sidebar_archive",
							"type"		=> "select",
							"options"	=> $new_sidebars ));

				kavkaz_options(
					array(	"name"		=> __( 'Search Sidebar', 'kavkaz' ),
							"id"		=> "sidebar_search",
							"type"		=> "select",
							"options"	=> $new_sidebars ));

				kavkaz_options(
					array(	"name"		=> __( 'Single Article Sidebar', 'kavkaz' ),
							"id"		=> "sidebar_post",
							"type"		=> "select",
							"options"	=> $new_sidebars ));

				kavkaz_options(
					array(	"name"		=> __( 'Single Page Sidebar', 'kavkaz' ),
							"id"		=> "sidebar_page",
							"type"		=> "select",
							"options"	=> $new_sidebars ));

				?>
			</div>
		</div> <!-- Sidebars -->

		<div id="tab_styling" class="tab_content tabs-wrap">
			<h2><?php _e( 'Styling', 'kavkaz' ) ?></h2>	<?php echo $save ?>
			<div class="kavkazpanel-item">
				<h3><?php _e( 'Theme Color and Settings', 'kavkaz' ) ?></h3>

				<?php
					kavkaz_options(
						array(	"name"	=> __( 'Custom Theme Color', 'kavkaz' ),
								"id"	=> "global_color",
								"type"	=> "color"));

					kavkaz_options(
						array(	"name"			=> __( 'Modern Colored Scrollbar', 'kavkaz' ),
								"id"			=> "modern_scrollbar",
								"type"			=> "checkbox",
								"extra_text"	=> __( 'For Chrome and Safari only.', 'kavkaz' ) ));
				?>
			</div>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Custom CSS', 'kavkaz' ) ?></h3>
				<div class="option-item">
					<p><strong><?php _e( 'Global CSS :', 'kavkaz' ) ?></strong></p>
					<textarea id="kavkaz_css" name="kavkaz_options[css]" class="code kavkaz-css" style="width:100%" rows="7"><?php echo kavkaz_get_option('css');  ?></textarea>
				</div>
				<div class="option-item">
					<p><strong><?php _e( 'Tablets:', 'kavkaz' ) ?></strong><?php _e( '768 - 985px', 'kavkaz' ) ?> </p>
					<textarea id="kavkaz_css_tablets" name="kavkaz_options[css_tablets]" class="code kavkaz-css"  style="width:100%" rows="7"><?php echo kavkaz_get_option('css_tablets');  ?></textarea>
				</div>
				<div class="option-item">
					<p><strong><?php _e( 'Wide Phones:', 'kavkaz' ) ?></strong><?php _e( '480 - 767px', 'kavkaz' ) ?></p>
					<textarea id="kavkaz_css_wphones" name="kavkaz_options[css_wide_phones]" class="code kavkaz-css"  style="width:100%" rows="7"><?php echo kavkaz_get_option('css_wide_phones');  ?></textarea>
				</div>
				<div class="option-item">
					<p><strong><?php _e( 'Phones:', 'kavkaz' ) ?></strong><?php _e( '320 - 479px', 'kavkaz' ) ?></p>
					<textarea id="kavkaz_css_phones" name="kavkaz_options[css_phones]" class="code kavkaz-css"  style="width:100%" rows="7"><?php echo kavkaz_get_option('css_phones');  ?></textarea>
				</div>
			</div>

		</div> <!-- Styling -->

		<div id="tab_advanced" class="tab_content tabs-wrap">
			<h2><?php _e( 'Advanced Settings', 'kavkaz' ) ?></h2>	<?php echo $save ?>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Advanced Settings', 'kavkaz' ) ?></h3>
				<?php

					kavkaz_options(
						array(	"name"	=> __( 'Enable Theme Preloader', 'kavkaz' ),
								"id"	=> "theme_preloader",
								"type"	=> "checkbox"));
					
					kavkaz_options(
						array(	"name"	=> __( 'Disable WP Admin Bar', 'kavkaz' ),
								"id"	=> "disable_admin_bar",
								"type"	=> "checkbox"));
	
					kavkaz_options(
						array(	"name"	=> __( 'Limit Login Attempts', 'kavkaz' ),
								"id"	=> "Limit_Login_Attempts",
								"type"	=> "checkbox"));		
	
					kavkaz_options(
						array(	"name"	=> __( 'WEBSITE SECURITY', 'kavkaz' ),
								"id"	=> "htaccess_security_code",
								"type"	=> "checkbox"));
	
					kavkaz_options(
						array(	"name"	=> __( 'FORCE SSL ADMIN', 'kavkaz' ),
								"id"	=> "FORCE_SSL_ADMIN",
								"type"	=> "checkbox"));
	
					kavkaz_options(
						array(	"name"	=> __( 'DISALLOW FILE EDIT', 'kavkaz' ),
								"id"	=> "DISALLOW_FILE_EDIT",
								"type"	=> "checkbox"));	

				?>
			</div>			

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Speed Up Settings', 'kavkaz' ) ?></h3>
				<?php
					
					kavkaz_options(
						array(	"name"	=> __( 'Enable Google Preload', 'kavkaz' ),
								"id"	=> "enable_preload",
								"type"	=> "checkbox"));					

					kavkaz_options(
						array(	"name"	=> __( 'Enable HTML Minify', 'kavkaz' ),
								"id"	=> "enable_minify_html",
								"type"	=> "checkbox"));
	
					kavkaz_options(
						array(	"name"	=> __( 'Remove Emoji', 'kavkaz' ),
								"id"	=> "remove_emoji",
								"type"	=> "checkbox"));
	
					kavkaz_options(
						array(	"name"	=> __( 'Slow down the wordpress hearbeat', 'kavkaz' ),
								"id"	=> "slow_heartbeat",
								"type"	=> "checkbox"));	
	
					kavkaz_options(
						array(	"name"	=> __( 'Remove RSS', 'kavkaz' ),
								"id"	=> "remove_rss",
								"type"	=> "checkbox"));	
	
					kavkaz_options(
						array(	"name"	=> __( 'Fix hotlink issue', 'kavkaz' ),
								"id"	=> "hotlink_fix",
								"type"	=> "checkbox"));	
	
					kavkaz_options(
						array(	"name"	=> __( 'Bad Bot (Spam) Blocking', 'kavkaz' ),
								"id"	=> "bad_bot_blocking",
								"type"	=> "checkbox"));
	
					kavkaz_options(
						array(	"name"	=> __( 'Create htaccess to upload', 'kavkaz' ),
								"id"	=> "htaccess_to_upload",
								"type"	=> "checkbox"));	
	
					kavkaz_options(
						array(	"name"	=> __( 'Disable wp-json rest api', 'kavkaz' ),
								"id"	=> "json_rest_api",
								"type"	=> "checkbox"));

				?>
			</div>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'File Delete or Protect Settings', 'kavkaz' ) ?></h3>
				<p class="kavkaz_message_hint"><?php _e( 'Do the above first before doing this.', 'kavkaz' ) ?></p>				
				<?php

					kavkaz_options(
						array(	"name"	=> __( '.htaccess file protect', 'kavkaz' ),
								"id"	=> "htaccess_file_protect",
								"type"	=> "checkbox"));		
	
					kavkaz_options(
						array(	"name"	=> __( 'wp-config.php file protect', 'kavkaz' ),
								"id"	=> "config_file_protect",
								"type"	=> "checkbox"));	
	
					kavkaz_options(
						array(	"name"	=> __( 'readme.html file delete', 'kavkaz' ),
								"id"	=> "readme_file_delete",
								"type"	=> "checkbox"));						
	
					kavkaz_options(
						array(	"name"	=> __( 'license.txt file delete', 'kavkaz' ),
								"id"	=> "license_file_delete",
								"type"	=> "checkbox"));
				?>

			</div>			

			<div class="kavkazpanel-item">
				<h3><?php _e( 'WordPress Login page Logo', 'kavkaz' ) ?></h3>
				<?php
					kavkaz_options(
						array(	"name"	=> __( 'WordPress Login page Logo', 'kavkaz' ),
								"id"	=> "dashboard_logo",
								"type"	=> "upload"));

					kavkaz_options(
						array(	"name"	=> __( 'WordPress Login page Logo URL', 'kavkaz' ),
								"id"	=> "dashboard_logo_url",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'WordPress Login page Background color', 'kavkaz' ),
								"id"	=> "dashboard_backgorund_color",
								"type"	=> "color"));

				?>

			</div>
			<?php
				global $array_options ;

				$current_options = array();
				foreach( $array_options as $option ){
					if( get_option( $option ) )
						$current_options[$option] =  get_option( $option ) ;
				}
			?>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Export', 'kavkaz' ) ?></h3>
				<div class="option-item">
					<textarea style="width:100%" rows="7"><?php echo $currentsettings = base64_encode( serialize( $current_options )); ?></textarea>
				</div>
			</div>
			<div class="kavkazpanel-item">
				<h3><?php _e( 'Import', 'kavkaz' ) ?></h3>
				<div class="option-item">
					<textarea id="kavkaz_import" name="kavkaz_import" style="width:100%" rows="7"></textarea>
				</div>
			</div>


		</div> <!-- Advanced -->

		<div id="tab_email" class="tab_content tabs-wrap">
			<h2><?php _e( 'Mail SMTP Settings', 'kavkaz' ) ?></h2>	<?php echo $save ?>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Mail SMTP Settings', 'kavkaz' ) ?></h3>
				<?php

					kavkaz_options(
						array(	"name"	=> __( 'Enable SMTP', 'kavkaz' ),
								"id"	=> "enable_smtp",
								"type"	=> "checkbox"));

					kavkaz_options(
						array(	"name"	=> __( 'From Email', 'kavkaz' ),
								"id"	=> "mail_from_email",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'SMTP Host', 'kavkaz' ),
								"id"	=> "smtp_host",
								"type"	=> "text"));

					kavkaz_options(
						array( 	"name"		=> __( 'Encryption', 'kavkaz' ),
								"id"		=> "smtp_encryption",
								"type"		=> "radio",
								"options"	=> array(	"none"	=> __( 'None', 'kavkaz' ) ,
								                        "ssl"	=> __( 'SSL', 'kavkaz' ) ,
														"tls"	=> __( 'TLS', 'kavkaz' ) )));
					?>

					<p class="kavkaz_message_hint"><?php _e( 'For most servers TLS is the recommended option. If your SMTP provider offers both SSL and TLS options, we recommend using TLS.', 'kavkaz' ) ?></p>

					<?php

					kavkaz_options(
						array(	"name"	=> __( 'SMTP Port', 'kavkaz' ),
								"id"	=> "smtp_port",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'Auto TLS', 'kavkaz' ),
								"id"	=> "smtp_auto_tls",
								"type"	=> "checkbox"));
					?>

					<p class="kavkaz_message_hint"><?php _e( 'By default TLS encryption is automatically used if the server supports it, which is recommended. In some cases, due to server misconfigurations, this can cause issues and may need to be disabled.', 'kavkaz' ) ?></p>

					<?php

					kavkaz_options(
						array(	"name"	=> __( 'Authentication', 'kavkaz' ),
								"id"	=> "smtp_authentication",
								"type"	=> "checkbox"));

					kavkaz_options(
						array(	"name"	=> __( 'SMTP Username', 'kavkaz' ),
								"id"	=> "smtp_username",
								"type"	=> "text"));


					kavkaz_options(
						array(	"name"	=> __( 'SMTP Password', 'kavkaz' ),
								"id"	=> "smtp_password",
								"type"	=> "text"));

				?>

				<p class="kavkaz_message_hint"><?php _e( 'The password is encrypted in the database, but for improved security we recommend using your site\'s WordPress configuration file to set your password.', 'kavkaz' ) ?></p>

			</div>

		</div> <!-- Mail SMTP -->


		<div id="tab_contact" class="tab_content tabs-wrap">
			<h2><?php _e( 'Contact Details', 'kavkaz' ) ?></h2>	<?php echo $save ?>

			<div class="kavkazpanel-item">
				<h3><?php _e( 'Contact Details', 'kavkaz' ) ?></h3>
				<?php

					kavkaz_options(
						array(	"name"	=> __( 'Email for Contact Form', 'kavkaz' ),
								"id"	=> "contact_form_email",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'Display Contact Number', 'kavkaz' ),
								"id"	=> "display_contact_number",
								"type"	=> "checkbox"));

					kavkaz_options(
						array(	"name"	=> __( 'Contact Number', 'kavkaz' ),
								"id"	=> "contact_number",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'Contact Number Two', 'kavkaz' ),
								"id"	=> "contact_number_two",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'Display Contact Email', 'kavkaz' ),
								"id"	=> "display_contact_email",
								"type"	=> "checkbox"));

					kavkaz_options(
						array(	"name"	=> __( 'Contact Email', 'kavkaz' ),
								"id"	=> "contact_email",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'Contact Email Two', 'kavkaz' ),
								"id"	=> "contact_email_two",
								"type"	=> "text"));								

					kavkaz_options(
						array(	"name"	=> __( 'Display Contact Adress', 'kavkaz' ),
								"id"	=> "display_contact_address",
								"type"	=> "checkbox"));

					kavkaz_options(
						array(	"name"	=> __( 'Contact Address', 'kavkaz' ),
								"id"	=> "contact_address",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"	=> __( 'Display Open Hours', 'kavkaz' ),
								"id"	=> "display_contact_hours",
								"type"	=> "checkbox"));

					kavkaz_options(
						array(	"name"	=> __( 'Open Hours', 'kavkaz' ),
								"id"	=> "contact_hours",
								"type"	=> "text"));

					kavkaz_options(
						array(	"name"  => __( 'Contact Text Area', 'kavkaz' ),
								"id"    => "contact_textarea",
								"type"  => "textarea"));				
								
					kavkaz_options(
						array(	"name"  => __( 'Contact Iframe Map Area', 'kavkaz' ),
								"id"    => "contact_map",
								"type"  => "textarea"));								


					?>

			</div>

		</div> <!-- Contact Details -->			

		<div class="kavkaz-footer">
		<?php echo $save; ?>
		</form>

			<form method="post">
				<div class="mpanel-reset">
					<input type="hidden" name="resetnonce" value="<?php echo wp_create_nonce('reset-action-code'); ?>" />
					<input name="reset" class="mpanel-reset-button" type="submit" onClick="if(confirm('<?php _e( 'All settings will be rest .. Are you sure ?', 'kavkaz' ) ?>')) return true ; else return false; " value="<?php _e( 'Reset All Settings', 'kavkaz' ) ?>" />
					<input type="hidden" name="action" value="reset" />
				</div>
			</form>
		</div><!-- .kavkaz-panel-footer -->

	</div><!-- .kavkaz-panel-content -->
	<div class="clear"></div>
</div><!-- .kavkaz-panel -->
<?php
}

?>
