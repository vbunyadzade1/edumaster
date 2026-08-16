<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# KavKaz Limit Login Attemps
/*-----------------------------------------------------------------------------------*/
if ( ! class_exists( 'Limit_Login_Attempts' ) ) {
    class Limit_Login_Attempts {
 
        var $failed_login_limit = 3;                    //Number of authentification accepted
        var $lockout_duration   = 1800;                 //Stop authentification process for 30 minutes: 60*30 = 1800
        var $transient_name     = 'attempted_login';    //Transient used
 
        public function __construct() {
            add_filter( 'authenticate', array( $this, 'check_attempted_login' ), 30, 3 );
            add_action( 'wp_login_failed', array( $this, 'login_failed' ), 10, 1 );
        }

        public function check_attempted_login( $user, $username, $password ) {
            if ( get_transient( $this->transient_name ) ) {
                $datas = get_transient( $this->transient_name );
 
                if ( $datas['tried'] >= $this->failed_login_limit ) {
                    $until = get_option( '_transient_timeout_' . $this->transient_name );
                    $time = $this->when( $until );
 
                    //Display error message to the user when limit is reached 
                    return new WP_Error( 'too_many_tried', sprintf( __( '<strong>ERROR</strong>: You have reached authentification limit, you will be able to try again in %1$s.' ) , $time ) );
                }
            }
 
            return $user;
        }
 
        public function login_failed( $username ) {
            if ( get_transient( $this->transient_name ) ) {
                $datas = get_transient( $this->transient_name );
                $datas['tried']++;
 
                if ( $datas['tried'] <= $this->failed_login_limit )
                    set_transient( $this->transient_name, $datas , $this->lockout_duration );
            } else {
                $datas = array(
                    'tried'     => 1
                );
                set_transient( $this->transient_name, $datas , $this->lockout_duration );
            }
        }

        private function when( $time ) {
            if ( ! $time )
                return;
 
            $right_now = time();
 
            $diff = abs( $right_now - $time );
 
            $second = 1;
            $minute = $second * 60;
            $hour = $minute * 60;
            $day = $hour * 24;
 
            if ( $diff < $minute )
                return floor( $diff / $second ) . ' secondes';
 
            if ( $diff < $minute * 2 )
                return "about 1 minute ago";
 
            if ( $diff < $hour )
                return floor( $diff / $minute ) . ' minutes';
 
            if ( $diff < $hour * 2 )
                return 'about 1 hour';
 
            return floor( $diff / $hour ) . ' hours';
        }
    }
}

/*-----------------------------------------------------------------------------------*/
# KavKaz Display ID Admin Panel Filter
/*-----------------------------------------------------------------------------------*/
function kavkaz_add_column($columns)
{
    $columns['kavkaz_post_id_clmn'] = 'ID';
    return $columns;
}

$arrayas = ['post', 'university', 'country', 'event', 'course', 'school'];

foreach ($arrayas as $array)
{
    add_filter('manage_' . $array . '_posts_columns', 'kavkaz_add_column', 5);
}

function kavkaz_column_content($column, $id)
{
    if ($column === 'kavkaz_post_id_clmn')
    {
        echo $id;
    }
}

add_action('manage_posts_custom_column', 'kavkaz_column_content', 5, 2);

/*-----------------------------------------------------------------------------------*/
# Posts Display Admin Panel Filter
/*-----------------------------------------------------------------------------------*/
function kavkaz_featured_image_column($column_array)
{
    $column_array = array_slice($column_array, 0, 1, true) + ['featured_image' => __("Image") ] + array_slice($column_array, 1, null, true);
    return $column_array;
}

$arrayas = ['post', 'university', 'country', 'event', 'course', 'school'];

foreach ($arrayas as $array)
{
	add_filter('manage_' . $array . '_posts_columns', 'kavkaz_featured_image_column');
}

function kavkaz_render_the_column($column_name, $post_id)
{
    if ($column_name == 'featured_image')
    {
        if (has_post_thumbnail($post_id))
        {
            $thumb_id = get_post_thumbnail_id($post_id);
            echo '<img data-id="' . $thumb_id . '" src="' . wp_get_attachment_url($thumb_id) . '" />';
        }
        else
        {
            echo '<img data-id="-1" src="' . NO_IMAGE . '" />';
        }
    }
}
add_action('manage_posts_custom_column', 'kavkaz_render_the_column', 10, 2);

/*-----------------------------------------------------------------------------------*/
# Author Box Widget
/*-----------------------------------------------------------------------------------*/
function kavkaz_author_box_widget($avatar = true, $social = true, $name = false , $user_id = false  ){
?>
<div class="widget-author">
   <?php if( $avatar ): ?>
   <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="image">
   <?php $author_image = get_the_author_meta( 'author-image' ); if( !empty( $author_image ) ): ?>
   <img src="<?php echo $author_image ?>" alt="image" />
   <?php endif; ?>
   </a>
   <?php endif; ?>
   <h6><span><?php the_author(); ?></span></h6>
   <p><?php the_author_meta( 'description' , $user_id ); ?></p>
   <?php if( $social ) : ?>
   <div class="social-media">
      <ul class="list-inline">
         <?php if ( get_the_author_meta( 'facebook' , $user_id ) ) : ?>
         <li>
            <a href="<?php the_author_meta( 'facebook' , $user_id ); ?>" class="color-facebook" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-facebook"></i>
            </a>
         </li>
         <?php endif ?>
         <?php if ( get_the_author_meta( 'instagram' , $user_id ) ) : ?>
         <li>
            <a href="<?php the_author_meta( 'instagram' , $user_id ); ?>" class="color-instagram" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-instagram"></i>
            </a>
         </li>
         <?php endif ?>
         <?php if ( get_the_author_meta( 'twitter' , $user_id  ) ) : ?>
         <li>
            <a href="https://twitter.com/<?php the_author_meta( 'twitter' , $user_id ); ?>" class="color-twitter" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-twitter"></i>
            </a>
         </li>
         <?php endif ?>
         <?php if ( get_the_author_meta( 'youtube' , $user_id ) ) : ?>
         <li>
            <a href="<?php the_author_meta( 'youtube' , $user_id ); ?>" class="color-youtube" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-youtube-play"></i>
            </a>
         </li>
         <?php endif ?>
         <?php if ( get_the_author_meta( 'flickr' , $user_id ) ) : ?>
         <li>
            <a href="<?php the_author_meta( 'flickr' , $user_id ); ?>" class="color-flickr" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-flickr"></i>
            </a>
         </li>
         <?php endif ?>
         <?php if ( get_the_author_meta( 'linkedin' , $user_id ) ) : ?>
         <li>
            <a href="<?php the_author_meta( 'linkedin' , $user_id ); ?>" class="color-linkedin" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-linkedin"></i>
            </a>
         </li>
         <?php endif ?>									
         <?php if ( get_the_author_meta( 'pinterest' , $user_id ) ) : ?>
         <li>
            <a href="<?php the_author_meta( 'pinterest' , $user_id ); ?>" class="color-pinterest" target="_blank" rel="noopener noreferrer">
            <i class="fa fa-pinterest"></i>
            </a>
         </li>
         <?php endif ?>
      </ul>
   </div>
   <?php endif; ?>
</div>
<?php
}

/*-----------------------------------------------------------------------------------*/
# Author Box
/*-----------------------------------------------------------------------------------*/
function kavkaz_author_box( $user_id = false  ){
	
$author_cover_bg = get_the_author_meta( 'author-cover-bg' );
$author_image = get_the_author_meta( 'author-image' );

?>
<section class="section author full-space mb-40 pt-55 bg-author-cover" style="background-image: url(<?php if( !empty( $author_cover_bg ) ){ echo $author_cover_bg; }else{ echo $author_image; } ?>)">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12">
            <div class="widget-author inner-width">
               <?php if( !empty( $author_image ) ): ?>
               <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="image">	
               <img src="<?php echo $author_image ?>" alt="image" />
               </a>
               <?php endif; ?>
               <h6><span><?php the_author(); ?></span></h6>
               <div class="link"><?php echo count_user_posts( get_queried_object_id(), 'post' ); ?> <?php _kavkaz('Articles'); ?></div>
               <p><?php the_author_meta( 'description' , $user_id ); ?></p>
               <div class="social-media">
                  <ul class="list-inline">
                     <?php if ( get_the_author_meta( 'facebook' , $user_id ) ) : ?>
                     <li>
                        <a href="<?php the_author_meta( 'facebook' , $user_id ); ?>" class="color-facebook" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-facebook"></i>
                        </a>
                     </li>
                     <?php endif ?>
                     <?php if ( get_the_author_meta( 'instagram' , $user_id ) ) : ?>
                     <li>
                        <a href="<?php the_author_meta( 'instagram' , $user_id ); ?>" class="color-instagram" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-instagram"></i>
                        </a>
                     </li>
                     <?php endif ?>
                     <?php if ( get_the_author_meta( 'twitter' , $user_id  ) ) : ?>
                     <li>
                        <a href="https://twitter.com/<?php the_author_meta( 'twitter' , $user_id ); ?>" class="color-twitter" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-twitter"></i>
                        </a>
                     </li>
                     <?php endif ?>
                     <?php if ( get_the_author_meta( 'youtube' , $user_id ) ) : ?>
                     <li>
                        <a href="<?php the_author_meta( 'youtube' , $user_id ); ?>" class="color-youtube" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-youtube-play"></i>
                        </a>
                     </li>
                     <?php endif ?>
                     <?php if ( get_the_author_meta( 'flickr' , $user_id ) ) : ?>
                     <li>
                        <a href="<?php the_author_meta( 'flickr' , $user_id ); ?>" class="color-flickr" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-flickr"></i>
                        </a>
                     </li>
                     <?php endif ?>
                     <?php if ( get_the_author_meta( 'linkedin' , $user_id ) ) : ?>
                     <li>
                        <a href="<?php the_author_meta( 'linkedin' , $user_id ); ?>" class="color-linkedin" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-linkedin"></i>
                        </a>
                     </li>
                     <?php endif ?>									
                     <?php if ( get_the_author_meta( 'pinterest' , $user_id ) ) : ?>
                     <li>
                        <a href="<?php the_author_meta( 'pinterest' , $user_id ); ?>" class="color-pinterest" target="_blank" rel="noopener noreferrer">
                        <i class="fa fa-pinterest"></i>
                        </a>
                     </li>
                     <?php endif ?>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php
}

/*-----------------------------------------------------------------------------------*/
# Social
/*-----------------------------------------------------------------------------------*/
function kavkaz_get_social( $newtab = true, $colored = true, $tooltip='ttip' ){
	$social = kavkaz_get_option('social');

	if( !empty( $social ) && is_array( $social ) ){
		extract($social);
	}

	if ( !empty( $newtab ) ) $newtab = "target=\"_blank\"";
	else $newtab = '';

	if ( !empty( $colored ) ) $colored = " social-colored";
	else $colored = '';

		?>
		<div class="social-icons<?php echo $colored ?>">
		<?php
		// RSS
		if ( kavkaz_get_option('rss_icon') ){
		if ( kavkaz_get_option('rss_url') != '' && kavkaz_get_option('rss_url') != ' ' ) $rss = kavkaz_get_option('rss_url') ;
		else $rss = get_bloginfo('rss2_url');
			?><a class="<?php echo $tooltip; ?>" title="Rss" href="<?php echo esc_url( $rss ) ; ?>" <?php echo $newtab; ?>><i class="fa fa-rss"></i></a><?php
		}
		// Facebook
		if ( !empty($facebook) && $facebook != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Facebook" href="<?php echo esc_url( $facebook ); ?>" <?php echo $newtab; ?>><i class="fa fa-facebook"></i></a><?php
		}
		// Twitter
		if ( !empty($twitter) && $twitter != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="Twitter" href="<?php echo esc_url( $twitter ); ?>" <?php echo $newtab; ?>><i class="fa fa-twitter"></i></a><?php
		}
		// Pinterest
		if ( !empty($Pinterest) && $Pinterest != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="Pinterest" href="<?php echo esc_url( $Pinterest ); ?>" <?php echo $newtab; ?>><i class="fa fa-pinterest"></i></a><?php
		}
		// LinkedIN
		if ( !empty($linkedin) && $linkedin != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="LinkedIn" href="<?php echo esc_url( $linkedin ); ?>" <?php echo $newtab; ?>><i class="fa fa-linkedin"></i></a><?php
		}
		// Flickr
		if ( !empty($flickr) && $flickr != ' ') {
			?><a class="<?php echo $tooltip; ?>" title="Flickr" href="<?php echo esc_url( $flickr ); ?>" <?php echo $newtab; ?>><i class="fa fa-flickr"></i></a><?php
		}
		// YouTube
		if ( !empty($youtube) && $youtube != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Youtube" href="<?php echo esc_url( $youtube ); ?>" <?php echo $newtab; ?>><i class="fa fa-youtube-play"></i></a><?php
		}
		// Tumblr
		if ( !empty($tumblr) && $tumblr != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="Tumblr" href="<?php echo esc_url( $tumblr ); ?>" <?php echo $newtab; ?>><i class="fa fa-tumblr"></i></a><?php
		}
		// instagram
		if ( !empty( $instagram ) && $instagram != '' && $instagram != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="instagram" href="<?php echo esc_url( $instagram ); ?>" <?php echo $newtab; ?>><i class="fa fa-instagram"></i></a><?php
		}
		// spotify
		if ( !empty( $spotify ) && $spotify != '' && $spotify != ' ' ) {
			?><a class="<?php echo $tooltip; ?>" title="spotify" href="<?php echo esc_url( $spotify ); ?>" <?php echo $newtab; ?>><i class="fa fa-spotify"></i></a><?php
		}

		?>

		<?php //Custom Social Networking

		for( $i=1 ; $i<=5 ; $i++ ){
			if ( kavkaz_get_option( "custom_social_icon_$i" )  && kavkaz_get_option( "custom_social_url_$i" ) ) {
				?><a class="<?php echo $tooltip; ?>" <?php if ( kavkaz_get_option( "custom_social_title_$i" ) ) echo ' title="'.kavkaz_get_option( "custom_social_title_$i" ).'"'; ?> href="<?php echo esc_url( kavkaz_get_option( 'custom_social_url_'.$i ) ) ?>" <?php echo $newtab; ?>><i class="fa <?php echo kavkaz_get_option( "custom_social_icon_$i" ) ?>"></i></a><?php
			}
		}

		?>
	</div>

<?php
}

/*-----------------------------------------------------------------------------------*/
# Add user's social accounts
/*-----------------------------------------------------------------------------------*/
add_action( 'show_user_profile', 'kavkaz_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'kavkaz_show_extra_profile_fields' );
function kavkaz_show_extra_profile_fields( $user ) {
	wp_enqueue_media();
?>
	<table class="form-table">
		<tr>
			<th><label for="author-image"><?php _e( 'Profile Image', 'kavkaz' ) ?></label></th>
			<td>
				<?php $author_image = get_the_author_meta( 'author-image', $user->ID ) ; ?>
				<input id="author-image" class="img-path" type="text" size="56" style="direction:ltr; text-laign:left" name="author-image" value="<?php if( !empty( $author_image ) ) echo esc_attr( $author_image );  ?>" />
				<input id="upload_author-image_button" type="button" class="button" value="<?php _e( 'Upload', 'kavkaz' ) ?>" />

				<div id="author-image-preview" class="img-preview" <?php if( empty( $author_image ) ) echo 'style="display:none;"' ?>>
					<img src="<?php if( !empty( $author_image ) ) echo $author_image ; else echo get_template_directory_uri().'/framework/admin/images/empty.png'; ?>" alt="" />
					<a class="del-img" title="Delete"></a>
				</div>

				<script type='text/javascript'>
					jQuery('#author-image').change(function(){
						jQuery('#author-image-preview').show();
						jQuery('#author-image-preview img').attr("src", jQuery(this).val());
					});
					kavkaz_set_uploader( 'author-image' );
				</script>
			</td>
		</tr>
	</table>
	<table class="form-table">
		<tr>
			<th><label for="author-cover-bg"><?php _e( 'Cover Image', 'kavkaz' ) ?></label></th>
			<td>
				<?php $author_cover_bg = get_the_author_meta( 'author-cover-bg', $user->ID ) ; ?>
				<input id="author-cover-bg" class="img-path" type="text" size="56" style="direction:ltr; text-laign:left" name="author-cover-bg" value="<?php if( !empty( $author_cover_bg ) ) echo esc_attr( $author_cover_bg );  ?>" />
				<input id="upload_author-cover-bg_button" type="button" class="button" value="<?php _e( 'Upload', 'kavkaz' ) ?>" />

				<div id="author-cover-bg-preview" class="img-preview" <?php if( empty( $author_cover_bg ) ) echo 'style="display:none;"' ?>>
					<img src="<?php if( !empty( $author_cover_bg ) ) echo $author_cover_bg ; else echo get_template_directory_uri().'/framework/admin/images/empty.png'; ?>" alt="" />
					<a class="del-img" title="Delete"></a>
				</div>

				<script type='text/javascript'>
					jQuery('#author-cover-bg').change(function(){
						jQuery('#author-cover-bg-preview').show();
						jQuery('#author-cover-bg-preview img').attr("src", jQuery(this).val());
					});
					kavkaz_set_uploader( 'author-cover-bg' );
				</script>
			</td>
		</tr>
	</table>
	<table class="form-table">
		<tr>
			<th><label for="twitter"><?php _e( 'Twitter Username', 'kavkaz' ) ?></label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="facebook"><?php _e( 'Facebook URL', 'kavkaz' ) ?></label></th>
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_url( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="linkedin"><?php _e( 'LinkedIn URL', 'kavkaz' ) ?></label></th>
			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_url( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="flickr"><?php _e( 'Flickr URL', 'kavkaz' ) ?></label></th>
			<td>
				<input type="text" name="flickr" id="flickr" value="<?php echo esc_url( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="youtube"><?php _e( 'YouTube URL', 'kavkaz' ) ?></label></th>
			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_url( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="pinterest"><?php _e( 'Pinterest URL', 'kavkaz' ) ?></label></th>
			<td>
				<input type="text" name="pinterest" id="pinterest" value="<?php echo esc_url( get_the_author_meta( 'pinterest', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>
		<tr>
			<th><label for="instagram"><?php _e( 'Instagram URL', 'kavkaz' ) ?></label></th>
			<td>
				<input type="text" name="instagram" id="instagram" value="<?php echo esc_url( get_the_author_meta( 'instagram', $user->ID ) ); ?>" class="regular-text" /><br />
			</td>
		</tr>

	</table>
<?php }

## Save user's social accounts
add_action( 'personal_options_update', 'kavkaz_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'kavkaz_save_extra_profile_fields' );
function kavkaz_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_user_meta( $user_id, 'author-image', 			$_POST['author-image'] );
	update_user_meta( $user_id, 'author-cover-bg', 			$_POST['author-cover-bg'] );
	update_user_meta( $user_id, 'pinterest', 				$_POST['pinterest'] );
	update_user_meta( $user_id, 'twitter', 					$_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', 				$_POST['facebook'] );
	update_user_meta( $user_id, 'linkedin', 				$_POST['linkedin'] );
	update_user_meta( $user_id, 'flickr', 					$_POST['flickr'] );
	update_user_meta( $user_id, 'youtube', 					$_POST['youtube'] );
	update_user_meta( $user_id, 'instagram', 				$_POST['instagram'] );
}

/*-----------------------------------------------------------------------------------*/
# Comment unapproved to approved
/*-----------------------------------------------------------------------------------*/
add_action('comment_unapproved_to_approved', 'kavkaz_comment_unapproved_to_approved');
function kavkaz_comment_unapproved_to_approved($comment)
{

    $html = 'mime-version: 1.0' . "\r\n";
    $html .= 'content-type: text/html; charset=utf-8' . "\r\n";
    $commenter_email = $comment->comment_author_email;
    $commenter_name = $comment->comment_author;
    $post_url = get_comment_link($comment);
    $logo_url = home_url();
    $logo_name = get_bloginfo('name');
    $subject = "Your comment is up!";
    $message = "<div style='padding: 15px;background: #2296f9;font-size: 20px;color: #fff;border-radius: 10px 10px 0 0;'><a href='$logo_url' title='$logo_name'>$logo_name</a></div><div style='padding: 15px;font-size: 17px;background: #ffffff;box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);-webkit-box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);border-radius: 10px;'>Hello <strong>" . $commenter_name . "</strong>,<br>Your comment has been approved!<br>You can view it below:<br>" . $post_url . "<br>Thank you for sharing your ideas with us!</div>";
    wp_mail($commenter_email, $subject, $message, $html);

}

/*-----------------------------------------------------------------------------------*/
# For Empty Widgets Titles
/*-----------------------------------------------------------------------------------*/
function kavkaz_widget_title($title){
	if( empty( $title ) )
		return ' ';
	else return $title;
}
add_filter('widget_title', 'kavkaz_widget_title');

/*-----------------------------------------------------------------------------------*/
# Titles for WordPress before 4.1
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function kavkaz_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'kavkaz_slug_render_title' );
endif;


/*-----------------------------------------------------------------------------------*/
# Sanitizes a title, replacing whitespace and a few other characters with dashes.
/*-----------------------------------------------------------------------------------*/
function kavkaz_sanitize_title( $title ){
	$title = strip_tags($title);
	$title = preg_replace('/&.+?;/', '', $title);
	$title = str_replace('.', '-', $title);
	$title = strtolower($title);
	$title = preg_replace('/[^%a-z0-9 :-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');

	return $title;
}

/*-----------------------------------------------------------------------------------*/
# Archive Title
/*-----------------------------------------------------------------------------------*/
function kavkaz_archive_title( $title ){
    if (is_category()){
        $title = single_cat_title('', false);
    } elseif (is_tag()){
        $title = single_tag_title('', false);
    } elseif (is_author()){
        $title = get_the_author();
    } elseif (is_post_type_archive()){
        $title = post_type_archive_title('', false);
    } elseif (is_tax()){
        $title = single_term_title('', false);
	}

    return $title;
}
add_filter('get_the_archive_title', 'kavkaz_archive_title');

/*-----------------------------------------------------------------------------------*/
# KavKaz Adding field to categories
/*-----------------------------------------------------------------------------------*/
if ( ! class_exists( 'CT_TAX_META' ) ) {

	class CT_TAX_META {
	
	  public function __construct() {
		//
	  }

	 public function init() {
         
	   add_action( 'category_add_form_fields', array ( $this, 'add_category_fields' ), 10, 2 );
	   add_action( 'created_category', array ( $this, 'save_category_fields' ), 10, 2 );
	   add_action( 'category_edit_form_fields', array ( $this, 'update_category_fields' ), 10, 2 );
	   add_action( 'edited_category', array ( $this, 'updated_category_fields' ), 10, 2 );
		 
	   add_action( 'university_cat_add_form_fields', array ( $this, 'add_category_fields' ), 10, 2 );
	   add_action( 'created_university_cat', array ( $this, 'save_category_fields' ), 10, 2 );
	   add_action( 'university_cat_edit_form_fields', array ( $this, 'update_category_fields' ), 10, 2 );
	   add_action( 'edited_university_cat', array ( $this, 'updated_category_fields' ), 10, 2 );	 
		 
	   add_action( 'country_category_add_form_fields', array ( $this, 'add_category_fields' ), 10, 2 );
	   add_action( 'created_country_category', array ( $this, 'save_category_fields' ), 10, 2 );
	   add_action( 'country_category_edit_form_fields', array ( $this, 'update_category_fields' ), 10, 2 );
	   add_action( 'edited_country_category', array ( $this, 'updated_category_fields' ), 10, 2 );	
		 
	   add_action( 'event_category_add_form_fields', array ( $this, 'add_category_fields' ), 10, 2 );
	   add_action( 'created_event_category', array ( $this, 'save_category_fields' ), 10, 2 );
	   add_action( 'event_category_edit_form_fields', array ( $this, 'update_category_fields' ), 10, 2 );
	   add_action( 'edited_event_category', array ( $this, 'updated_category_fields' ), 10, 2 );	
		 
	   add_action( 'course_category_add_form_fields', array ( $this, 'add_category_fields' ), 10, 2 );
	   add_action( 'created_course_category', array ( $this, 'save_category_fields' ), 10, 2 );
	   add_action( 'course_category_edit_form_fields', array ( $this, 'update_category_fields' ), 10, 2 );
	   add_action( 'edited_course_category', array ( $this, 'updated_category_fields' ), 10, 2 );			 
		 
	   add_action( 'admin_enqueue_scripts', array( $this, 'load_media' ) );
	   add_action( 'admin_footer', array ( $this, 'add_script' ) );		 
		 
	 }

	 public function add_category_fields ( $taxonomy ) { ?>
        <div class="form-field term-group">
            <label for="category-content"><?php _e('Content', 'kavkaz'); ?></label>
            <textarea id="category-content" name="category-content" rows="4" cols="50"></textarea>
        </div>
        <div class="form-field term-group">
            <label for="category-image-id"><?php _e('Image', 'kavkaz'); ?></label>
            <input type="hidden" id="category-image-id" name="category-image-id" class="custom_media_url" value="">
            <div id="category-image-wrapper"></div>
            <p>
            <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'kavkaz' ); ?>" />
            <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'kavkaz' ); ?>" />
            </p>
        </div>
	 <?php
	 }

	 public function save_category_fields ( $term_id, $tt_id ) {
		 
	   if( isset( $_POST['category-content'] ) && '' !== $_POST['category-content'] ){
		 $image = $_POST['category-content'];
		 add_term_meta( $term_id, 'category-content', $image, true );
	   }
		 
	   if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
		 $image = $_POST['category-image-id'];
		 add_term_meta( $term_id, 'category-image-id', $image, true );
	   }
		 
	 }

	 public function update_category_fields ( $term, $taxonomy ) { ?>
	   <tr class="form-field term-group-wrap">
         <th scope="row"><label for="description">Content</label></th>		   
		 <td>
		 <?php $image_id = get_term_meta ( $term -> term_id, 'category-content', true ); ?>
		 <textarea id="category-content" name="category-content" rows="4" cols="50"><?php echo $image_id; ?></textarea>
		 </td>
	   </tr>
	   <tr class="form-field term-group-wrap">
		 <th scope="row">
		   <label for="category-image-id"><?php _e( 'Image', 'kavkaz' ); ?></label>
		 </th>
		 <td>
		   <?php $image_id = get_term_meta ( $term -> term_id, 'category-image-id', true ); ?>
		   <input type="hidden" id="category-image-id" name="category-image-id" value="<?php echo $image_id; ?>">
		   <div id="category-image-wrapper">
			 <?php if ( $image_id ) { ?>
			   <?php echo wp_get_attachment_image ( $image_id, 'thumbnail' ); ?>
			 <?php } ?>
		   </div>
		   <p>
			 <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e( 'Add Image', 'kavkaz' ); ?>" />
			 <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e( 'Remove Image', 'kavkaz' ); ?>" />
		   </p>
		 </td>
	   </tr>
	 <?php
	 }

	 public function updated_category_fields ( $term_id, $tt_id ) {
		 
	   if( isset( $_POST['category-content'] ) && '' !== $_POST['category-content'] ){
		 $image = $_POST['category-content'];
		 update_term_meta ( $term_id, 'category-content', $image );
	   } else {
		 update_term_meta ( $term_id, 'category-content', '' );
	   }
		 
	   if( isset( $_POST['category-image-id'] ) && '' !== $_POST['category-image-id'] ){
		 $image = $_POST['category-image-id'];
		 update_term_meta ( $term_id, 'category-image-id', $image );
	   } else {
		 update_term_meta ( $term_id, 'category-image-id', '' );
	   }		 
		 
	 }
		
	public function load_media() {
	 	wp_enqueue_media();
	}
		
    public function add_script() {
        ?>
        <script>
            jQuery(document).ready( function($) {
            function ct_media_upload(button_class) {
                var _custom_media = true,
                _orig_send_attachment = wp.media.editor.send.attachment;
                $('body').on('click', button_class, function(e) {
                var button_id = '#'+$(this).attr('id');
                var send_attachment_bkp = wp.media.editor.send.attachment;
                var button = $(button_id);
                _custom_media = true;
                wp.media.editor.send.attachment = function(props, attachment){
                    if ( _custom_media ) {
                    $('#category-image-id').val(attachment.id);
                    $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    $('#category-image-wrapper .custom_media_image').attr('src',attachment.url).css('display','block');
                    } else {
                    return _orig_send_attachment.apply( button_id, [props, attachment] );
                    }
                    }
                wp.media.editor.open(button);
                return false;
            });
            }
            ct_media_upload('.ct_tax_media_button.button'); 
            $('body').on('click','.ct_tax_media_remove',function(){
            $('#category-image-id').val('');
            $('#category-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
            });

            $(document).ajaxComplete(function(event, xhr, settings) {
            var queryStringArr = settings.data.split('&');
            if( $.inArray('action=add-tag', queryStringArr) !== -1 ){
                var xml = xhr.responseXML;
                $response = $(xml).find('term_id').text();
                if($response!=""){
                $('#category-image-wrapper').html('');
                }
            }
            });
        });
        </script>
        <?php 
    }

}		
	
	$CT_TAX_META = new CT_TAX_META();
	$CT_TAX_META -> init();
	 
}

?>