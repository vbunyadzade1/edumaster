<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Home Slider
/*-----------------------------------------------------------------------------------*/
add_action('init', 'kavkaz_slider_register');
function kavkaz_slider_register() {

	$labels = array(
		'name' => __( 'Home Sliders', 'kavkaz' ),
		'singular_name' => __( 'Slider', 'kavkaz' ),
		'add_new_item' => __( 'Add New Slider', 'kavkaz' ),
	);

	$args = array(
		'labels' => $labels,
		'public' => false,
		'show_ui' => true,
		'menu_icon' => '',
		'can_export' => true,
		'exclude_from_search' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 6,
		'rewrite' => array('slug' => 'slider'),
		'supports' => array('title')
	  );

	register_post_type( 'kavkaz_slider' , $args );
}


add_action("admin_init", "kavkaz_slider_init");
function kavkaz_slider_init(){
	add_meta_box("kavkaz_slider_slides", "Slides", "kavkaz_slider_slides", "kavkaz_slider", "normal", "high");
}


function kavkaz_slider_slides(){
	global $post;
	$slider = '';
	$custom = get_post_custom($post->ID);

	if( !empty($custom["custom_slider"][0]) )
		$slider = unserialize( $custom["custom_slider"][0] );

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
				jQuery('#kavkaz-slider-items').append('<li id="listItem_'+ nextCell +'" class="ui-state-default"><div class="widget-content option-item"><div class="slider-img"><img src="'+attachment.url+'" alt=""></div><label for="custom_slider['+ nextCell +'][title]"><span><?php _e( 'Slide Title:', 'kavkaz' ) ?></span><input id="custom_slider['+ nextCell +'][title]" name="custom_slider['+ nextCell +'][title]" value="" type="text" /></label><label for="custom_slider['+ nextCell +'][link]"><span><?php _e( 'Slide Link:', 'kavkaz' ) ?></span><input id="custom_slider['+ nextCell +'][link]" name="custom_slider['+ nextCell +'][link]" value="" type="text" /></label><label for="custom_slider['+ nextCell +'][caption]"><span class="slide-caption"><?php _e( 'Slide Caption:', 'kavkaz' ) ?></span><textarea name="custom_slider['+ nextCell +'][caption]" id="custom_slider['+ nextCell +'][caption]"></textarea></label><input id="custom_slider['+ nextCell +'][id]" name="custom_slider['+ nextCell +'][id]" value="'+attachment.id+'" type="hidden" /><a class="del-cat"></a></div></li>');
				nextCell ++ ;
			});
		});

		kavkaz_uploader.open();
	});

});

  </script>

 <input id="upload_add_slide" type="button" class="button button-large button-primary builder_active" value="<?php _e( 'Add New Slide', 'kavkaz' ) ?>">

	<ul id="kavkaz-slider-items">
	<?php
	$i=0;
	if( !empty( $slider ) ){
	foreach( $slider as $slide ):
		$i++; ?>
		<li id="listItem_<?php echo $i ?>"  class="ui-state-default">
			<div class="widget-content option-item">
				<div class="slider-img"><?php echo wp_get_attachment_image( $slide['id'] , 'thumbnail' );  ?></div>
				<label for="custom_slider[<?php echo $i ?>][title]"><span><?php _e( 'Slide Title:', 'kavkaz' ) ?> </span><input id="custom_slider[<?php echo $i ?>][title]" name="custom_slider[<?php echo $i ?>][title]" value="<?php  echo stripslashes( $slide['title'] )  ?>" type="text" /></label>
				<label for="custom_slider[<?php echo $i ?>][link]"><span><?php _e( 'Slide Link:', 'kavkaz' ) ?></span><input id="custom_slider[<?php echo $i ?>][link]" name="custom_slider[<?php echo $i ?>][link]" value="<?php  echo stripslashes( $slide['link'] )  ?>" type="text" /></label>
				<label for="custom_slider[<?php echo $i ?>][caption]"><span class="slide-caption"><?php _e( 'Slide Caption:', 'kavkaz' ) ?></span><textarea name="custom_slider[<?php echo $i ?>][caption]" id="custom_slider[<?php echo $i ?>][caption]"><?php echo stripslashes($slide['caption']) ; ?></textarea></label>
				<input id="custom_slider[<?php echo $i ?>][id]" name="custom_slider[<?php echo $i ?>][id]" value="<?php  echo $slide['id']  ?>" type="hidden" />
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



add_action('save_post', 'kavkaz_save_slide');
function kavkaz_save_slide(){
  global $post;

  	if( !empty( $_POST['custom_slider'] ) && $_POST['custom_slider'] != "" ){
		update_post_meta($post->ID, 'custom_slider' , $_POST['custom_slider']);
	}
	else{
		if( isset($post->ID) )
			delete_post_meta($post->ID, 'custom_slider' );
	}
}


add_filter("manage_edit-kavkaz_slider_columns", "kavkaz_slider_edit_columns");
function kavkaz_slider_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => __( 'Title', 'kavkaz' ),
	"slides" => __( 'Number of slides', 'kavkaz' ),
	"id" => __( 'ID', 'kavkaz' ),
    "date" => __( 'Date', 'kavkaz' ),
  );

  return $columns;
}


add_action("manage_kavkaz_slider_posts_custom_column",  "kavkaz_slider_custom_columns");
function kavkaz_slider_custom_columns($column){
	global $post;

	$original_post = $post;

	switch ($column) {
		case "slides":
			$custom_slider_args = array( 'post_type' => 'kavkaz_slider', 'p' => $post->ID, 'no_found_rows' => 1  );
			$custom_slider = new WP_Query( $custom_slider_args );
			while ( $custom_slider->have_posts() ) {
				$number =0;
				$custom_slider->the_post();
				$custom = get_post_custom($post->ID);
				if( !empty($custom["custom_slider"][0])){
					$slider = unserialize( $custom["custom_slider"][0] );
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