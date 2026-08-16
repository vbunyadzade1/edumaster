<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Testimonials
/*-----------------------------------------------------------------------------------*/
add_action('init', 'kavkaz_testimonials_post_type_register');
function kavkaz_testimonials_post_type_register()
{
    $labels = [
        'name' => __('Testimonials', 'kavkaz'),
        'singular_name' => __('Testimonials', 'kavkaz'),
        'add_new_item' => __('Add New Testimonial', 'kavkaz'),
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-format-quote',
        'can_export' => true,
        'exclude_from_search' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_position' => 6,
        'rewrite' => ['slug' => 'testimonials'],
        'supports' => ['title'],
    ];

    register_post_type('testimonials', $args);
}

add_action("admin_init", "kavkaz_testimonials_init");
function kavkaz_testimonials_init(){
	add_meta_box("kavkaz_testimonials_slides", "Testimonials", "kavkaz_testimonials_slides", "testimonials", "normal", "high");
}

function kavkaz_testimonials_slides(){
	global $post;
	$slider = '';
	$custom = get_post_custom($post->ID);

	if( !empty($custom["custom_testimonials"][0]) )
		$slider = unserialize( $custom["custom_testimonials"][0] );

	wp_enqueue_media();
?>
  <script>
  jQuery(document).ready(function() {

	jQuery(function() {
		jQuery( "#kavkaz-slider-items" ).sortable({placeholder: "ui-state-highlight"});
	});

	/* Uploading files */
	var kavkaz_uploader;
	jQuery(document).on( 'click', '#upload_add_slide' , function(event){

		event.preventDefault();
		kavkaz_uploader = wp.media.frames.kavkaz_uploader = wp.media({
			title: '<?php _e( 'Insert Images | Hold CTRL to Multi Select .', 'kavkaz' ) ?>',
			library: {
				type: 'image'
			},
			button: {
				text: 'Select',
			},
			multiple: true
		});

		kavkaz_uploader.on( 'select', function() {
			var selection = kavkaz_uploader.state().get('selection');

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();
				jQuery('#kavkaz-slider-items').append('<li id="listItem_'+ nextCell +'" class="ui-state-default"><div class="widget-content option-item"><div class="slider-img"><img src="'+attachment.url+'" alt=""></div><label for="custom_testimonials['+ nextCell +'][title]"><span><?php _e( 'Testimonial Title:', 'kavkaz' ) ?></span><input id="custom_testimonials['+ nextCell +'][title]" name="custom_testimonials['+ nextCell +'][title]" value="" type="text" /></label><label for="custom_testimonials['+ nextCell +'][link]"><span><?php _e( 'Testimonial Link:', 'kavkaz' ) ?></span><input id="custom_testimonials['+ nextCell +'][link]" name="custom_testimonials['+ nextCell +'][link]" value="" type="text" /></label><label for="custom_testimonials['+ nextCell +'][caption]"><span class="slide-caption"><?php _e( 'Testimonial Caption:', 'kavkaz' ) ?></span><textarea name="custom_testimonials['+ nextCell +'][caption]" id="custom_testimonials['+ nextCell +'][caption]"></textarea></label><input id="custom_testimonials['+ nextCell +'][id]" name="custom_testimonials['+ nextCell +'][id]" value="'+attachment.id+'" type="hidden" /><a class="del-cat"></a></div></li>');
				nextCell ++ ;
			});
		});

		kavkaz_uploader.open();
	});

});

  </script>

 <input id="upload_add_slide" type="button" class="button builder_active" value="<?php _e( 'Add New Testimonial', 'kavkaz' ) ?>">

	<ul id="kavkaz-slider-items">
	<?php
	$i=0;
	if( !empty( $slider ) ){
	foreach( $slider as $slide ):
		$i++; ?>
		<li id="listItem_<?php echo $i ?>"  class="ui-state-default">
			<div class="widget-content option-item">
				<div class="slider-img"><?php echo wp_get_attachment_image( $slide['id'] , 'thumbnail' );  ?></div>
				<label for="custom_testimonials[<?php echo $i ?>][title]"><span><?php _e( 'Testimonial Title:', 'kavkaz' ) ?> </span><input id="custom_testimonials[<?php echo $i ?>][title]" name="custom_testimonials[<?php echo $i ?>][title]" value="<?php  echo stripslashes( $slide['title'] )  ?>" type="text" /></label>
				<label for="custom_testimonials[<?php echo $i ?>][link]"><span><?php _e( 'Testimonial Link:', 'kavkaz' ) ?></span><input id="custom_testimonials[<?php echo $i ?>][link]" name="custom_testimonials[<?php echo $i ?>][link]" value="<?php  echo stripslashes( $slide['link'] )  ?>" type="text" /></label>
				<label for="custom_testimonials[<?php echo $i ?>][caption]"><span class="slide-caption"><?php _e( 'Testimonial Caption:', 'kavkaz' ) ?></span><textarea name="custom_testimonials[<?php echo $i ?>][caption]" id="custom_testimonials[<?php echo $i ?>][caption]"><?php echo stripslashes($slide['caption']) ; ?></textarea></label>
				<input id="custom_testimonials[<?php echo $i ?>][id]" name="custom_testimonials[<?php echo $i ?>][id]" value="<?php  echo $slide['id']  ?>" type="hidden" />
				<a class="del-cat"></a>
			</div>
		</li>
	<?php endforeach;
	}else{
		echo '<p>'. __( 'Use the button above to add slides.', 'kavkaz' ).'</p>';
	}?>
	</ul>
	<script> var nextCell = <?php echo $i+1 ?> ;</script>

  <?php
}



add_action('save_post', 'kavkaz_save_testimonials');
function kavkaz_save_testimonials(){
  global $post;

  	if( !empty( $_POST['custom_testimonials'] ) && $_POST['custom_testimonials'] != "" ){
		update_post_meta($post->ID, 'custom_testimonials' , $_POST['custom_testimonials']);
	}
	else{
		if( isset($post->ID) )
			delete_post_meta($post->ID, 'custom_testimonials' );
	}
}


add_filter("manage_edit-testimonials_columns", "testimonials_edit_columns");
function testimonials_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => __( 'Title', 'kavkaz' ),
	"slides" => __( 'Number of Testimonial', 'kavkaz' ),
	"id" => __( 'ID', 'kavkaz' ),
    "date" => __( 'Date', 'kavkaz' ),
  );

  return $columns;
}


add_action("manage_testimonials_posts_custom_column",  "testimonials_custom_columns");
function testimonials_custom_columns($column){
	global $post;

	$original_post = $post;

	switch ($column) {
		case "slides":
			$custom_testimonials_args = array( 'post_type' => 'testimonials', 'p' => $post->ID, 'no_found_rows' => 1  );
			$custom_testimonials = new WP_Query( $custom_testimonials_args );
			while ( $custom_testimonials->have_posts() ) {
				$number =0;
				$custom_testimonials->the_post();
				$custom = get_post_custom($post->ID);
				if( !empty($custom["custom_testimonials"][0])){
					$slider = unserialize( $custom["custom_testimonials"][0] );
					echo $number = count($slider);
				}
				else echo 0;
			}

			$post = $original_post;
			wp_reset_query();
		break;
		case "id":
			echo $post->ID;
		break;
	}
}
?>