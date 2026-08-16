<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Register The Meta Boxes
/*-----------------------------------------------------------------------------------*/
add_action("admin_init", "kavkaz_posts_options_init");
function kavkaz_posts_options_init(){
	add_meta_box("kavkaz_post_options", THEME_NAME .' - '. __( 'Post Options', 'kavkaz' ), "kavkaz_post_options_module", "post", "normal", "high");
	add_meta_box("kavkaz_university_options", THEME_NAME .' - '. __( 'University Options', 'kavkaz' ), "kavkaz_university_options_module", "university", "normal", "high");
	add_meta_box("kavkaz_country_options", THEME_NAME .' - '. __( 'Country Options', 'kavkaz' ), "kavkaz_country_options_module", "country", "normal", "high");
	add_meta_box("kavkaz_event_options", THEME_NAME .' - '. __( 'Event Options', 'kavkaz' ), "kavkaz_event_options_module", "event", "normal", "high");
	add_meta_box("kavkaz_course_options", THEME_NAME .' - '. __( 'Course Options', 'kavkaz' ), "kavkaz_course_options_module", "course", "normal", "high");
	add_meta_box("kavkaz_school_options", THEME_NAME .' - '. __( 'School Options', 'kavkaz' ), "kavkaz_school_options_module", "school", "normal", "high");
	add_meta_box("kavkaz_faqs_options", THEME_NAME .' - '. __( 'Faqs Options', 'kavkaz' ), "kavkaz_faqs_options_module", "faqs", "normal", "high");	
	add_meta_box("kavkaz_page_options", THEME_NAME .' - '. __( 'Page Options', 'kavkaz' ), "kavkaz_page_options_module", "page", "normal", "high");
}

/*-----------------------------------------------------------------------------------*/
# Post Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_post_options_module(){
	global $post, $wp_roles ;
	$get_meta = get_post_custom($post->ID); ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />

	<div class="option-item" id="kavkaz_excerpt">
        <span class="label" for="excerpt"><?php _e('Excerpt', 'kavkaz'); ?></span>
        <textarea name="excerpt" id="excerpt" type="textarea" cols="100%" rows="4"><?php if ( has_excerpt() ){ echo get_the_excerpt(); } ?></textarea>
    </div>	

	<div class="kavkazpanel-item" id="kavkaz_post_options_box">
		<?php
				
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'AUTO IMAGE URL : ', 'kavkaz' ),
					"id"	=> "posterimage",
					"type"	=> "text"));

		?>
	</div>	

  <?php
}

/*-----------------------------------------------------------------------------------*/
# University Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_university_options_module(){
	global $post, $wp_roles ;
	$get_meta = get_post_custom($post->ID); ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />
	<div class="option-item" id="kavkaz_excerpt">
        <span class="label" for="excerpt"><?php _e('Excerpt', 'kavkaz'); ?></span>
        <textarea name="excerpt" id="excerpt" type="textarea" cols="100%" rows="4"><?php if ( has_excerpt() ){ echo get_the_excerpt(); } ?></textarea>
    </div>	
	<div class="kavkazpanel-item" id="kavkaz_post_options_box">
		<?php
	
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Country Rank : ', 'kavkaz' ),
					"id"	=> "country_rank",
					"type"	=> "text"));
	
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'World Rank : ', 'kavkaz' ),
					"id"	=> "world_rank",
					"type"	=> "text"));	
	
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Video Image : ', 'kavkaz' ),
					"id"	=> "video_image",
					"type"	=> "upload"));	
	
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Video Url : ', 'kavkaz' ),
					"id"	=> "video_url",
					"type"	=> "text"));	
				
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'AUTO IMAGE URL : ', 'kavkaz' ),
					"id"	=> "posterimage",
					"type"	=> "text"));

		?>
	</div>	

  <?php
}

/*-----------------------------------------------------------------------------------*/
# Country Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_country_options_module(){
	global $post, $wp_roles ;
	$get_meta = get_post_custom($post->ID); ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />

	<div class="option-item" id="kavkaz_excerpt">
        <span class="label" for="excerpt"><?php _e('Excerpt', 'kavkaz'); ?></span>
        <textarea name="excerpt" id="excerpt" type="textarea" cols="100%" rows="4"><?php if ( has_excerpt() ){ echo get_the_excerpt(); } ?></textarea>
    </div>	

	<div class="kavkazpanel-item" id="kavkaz_post_options_box">
		<?php
				

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Flag Image : ', 'kavkaz' ),
					"id"	=> "upload_flag",
					"type"	=> "upload"));
				

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'AUTO IMAGE URL : ', 'kavkaz' ),
					"id"	=> "posterimage",
					"type"	=> "text"));

		?>
	</div>	

  <?php
}

/*-----------------------------------------------------------------------------------*/
# Event Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_event_options_module(){
	global $post, $wp_roles ;
	$get_meta = get_post_custom($post->ID); ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />

	<div class="option-item" id="kavkaz_excerpt">
        <span class="label" for="excerpt"><?php _e('Excerpt', 'kavkaz'); ?></span>
        <textarea name="excerpt" id="excerpt" type="textarea" cols="100%" rows="4"><?php if ( has_excerpt() ){ echo get_the_excerpt(); } ?></textarea>
    </div>	

	<div class="kavkazpanel-item" id="kavkaz_post_options_box">
		<?php
				

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Price : ', 'kavkaz' ),
					"id"	=> "price",
					"type"	=> "text"));

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Weight : ', 'kavkaz' ),
					"id"	=> "weight",
					"type"	=> "text"));
					
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Dimensions : ', 'kavkaz' ),
					"id"	=> "dimensions",
					"type"	=> "text"));					

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'AUTO IMAGE URL : ', 'kavkaz' ),
					"id"	=> "posterimage",
					"type"	=> "text"));

		?>
	</div>	

  <?php
}

/*-----------------------------------------------------------------------------------*/
# Course Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_course_options_module(){
	global $post, $wp_roles ;
	$get_meta = get_post_custom($post->ID); ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />

	<div class="option-item" id="kavkaz_excerpt">
        <span class="label" for="excerpt"><?php _e('Excerpt', 'kavkaz'); ?></span>
        <textarea name="excerpt" id="excerpt" type="textarea" cols="100%" rows="4"><?php if ( has_excerpt() ){ echo get_the_excerpt(); } ?></textarea>
    </div>	

	<div class="kavkazpanel-item" id="kavkaz_post_options_box">
		<?php
				
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Icon Image : ', 'kavkaz' ),
					"id"	=> "upload_flag",
					"type"	=> "upload"));
	
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'AUTO IMAGE URL : ', 'kavkaz' ),
					"id"	=> "posterimage",
					"type"	=> "text"));

		?>
	</div>	

  <?php
}

/*-----------------------------------------------------------------------------------*/
# School Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_school_options_module(){
	global $post, $wp_roles ;
	$get_meta = get_post_custom($post->ID); ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />

	<div class="option-item" id="kavkaz_excerpt">
        <span class="label" for="excerpt"><?php _e('Excerpt', 'kavkaz'); ?></span>
        <textarea name="excerpt" id="excerpt" type="textarea" cols="100%" rows="4"><?php if ( has_excerpt() ){ echo get_the_excerpt(); } ?></textarea>
    </div>	

	<div class="kavkazpanel-item" id="kavkaz_post_options_box">
		<?php
				

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Price : ', 'kavkaz' ),
					"id"	=> "price",
					"type"	=> "text"));

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Weight : ', 'kavkaz' ),
					"id"	=> "weight",
					"type"	=> "text"));
					
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Dimensions : ', 'kavkaz' ),
					"id"	=> "dimensions",
					"type"	=> "text"));					

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'AUTO IMAGE URL : ', 'kavkaz' ),
					"id"	=> "posterimage",
					"type"	=> "text"));

		?>
	</div>	

  <?php
}

/*-----------------------------------------------------------------------------------*/
# Faqs Main Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_faqs_options_module(){
	global $post, $wp_roles ;
	$get_meta = get_post_custom($post->ID); ?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />

	<div class="kavkazpanel-item" id="kavkaz_post_options_box">
		<?php
				
		kavkaz_post_meta_box(
			array(	"name"	=> __( 'Video URL : ', 'kavkaz' ),
					"id"	=> "video_url",
					"type"	=> "text"));

		?>
	</div>	

  <?php
}

/*-----------------------------------------------------------------------------------*/
# Page Meta Boxes
/*-----------------------------------------------------------------------------------*/
function kavkaz_page_options_module(){
	global $post, $wp_roles ;

	$get_meta = get_post_custom($post->ID);

	?>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
		  jQuery('.on-of').checkbox({empty:'<?php echo get_template_directory_uri(); ?>/framework/admin/images/empty.png'});
		 });
	</script>

	<input type="hidden" name="kavkaz_hidden_flag" value="true" />

	<div class="option-item" id="kavkaz_excerpt">
        <span class="label" for="excerpt"><?php _e('Excerpt', 'kavkaz'); ?></span>
        <textarea name="excerpt" id="excerpt" type="textarea" cols="100%" rows="4"><?php if ( has_excerpt() ){ echo get_the_excerpt(); } ?></textarea>
    </div>		

	<div class="kavkazpanel-item" id="kavkaz_post_options_box">

		<?php

		kavkaz_post_meta_box(
			array(	"name"	=> __( 'AUTO IMAGE URL : ', 'kavkaz' ),
					"id"	=> "posterimage",
					"type"	=> "text"));
					
		?>
	</div>		
	
  <?php
}

/*-----------------------------------------------------------------------------------*/
# Get The Post Options
/*-----------------------------------------------------------------------------------*/
function kavkaz_post_meta_box ( $value ){
	global $post;
	$data = false;
	$id = $value['id'];
	$get_meta = get_post_custom($post->ID);
	if( isset( $get_meta[$id][0] ) ) $data = $get_meta[$id][0];
	kavkaz_options_build ( $value, $id, $data  );
}


/*-----------------------------------------------------------------------------------*/
# Save Post Options
/*-----------------------------------------------------------------------------------*/
add_action('save_post', 'kavkaz_save_post');
function kavkaz_save_post( $post_id ){
	global $post;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;

    if (isset($_POST['kavkaz_hidden_flag'])) {

		$custom_meta_fields = array(
			'posterimage',
			'country_rank',
			'world_rank',
			'video_url',
			'upload_flag',
			'video_image',
			'video_text'
		);

		foreach( $custom_meta_fields as $custom_meta_field ){
			if( isset( $_POST[$custom_meta_field] ) && !empty( $_POST[ $custom_meta_field] ) ){
				$custom_meta_field_data = $_POST[$custom_meta_field];
				if( is_array( $custom_meta_field_data ) ){
					$custom_meta_field_data	= array_filter( $custom_meta_field_data );
					if( !empty( $custom_meta_field_data ) ){
						update_post_meta( $post_id, $custom_meta_field, $custom_meta_field_data );
					}else{
						delete_post_meta( $post_id, $custom_meta_field );
					}
				}else{
					if( !empty( $custom_meta_field_data ) ){
						update_post_meta( $post_id, $custom_meta_field, htmlspecialchars(stripslashes( $custom_meta_field_data )) );
					}else{
						delete_post_meta( $post_id, $custom_meta_field );
					}
				}
			}else{
				delete_post_meta( $post_id, $custom_meta_field );
			}
		}
		
		// AUTO THUMBNAIL
		if (!has_post_thumbnail()) {
			$new_thumbnail = $_POST['posterimage'];
			if ($new_thumbnail) {
				kavkaz_video_upload_image($new_thumbnail, $post->ID);
			}
		}		

	}
}

//REMOVE EXCERPT BOX
function kavkaz_remove_normal_excerpt() {
	$post_typies = array('post', 'page', 'university', 'country', 'event', 'course', 'school' );
	foreach($post_typies as $post_type ){
		remove_meta_box( 'postexcerpt', $post_type, 'normal' );
	}
}
add_action( 'admin_menu' , 'kavkaz_remove_normal_excerpt' );

?>