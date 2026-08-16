<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Brands
/*-----------------------------------------------------------------------------------*/
add_action('init', 'kavkaz_brands_post_type_register');
function kavkaz_brands_post_type_register()
{
    $labels = [
        'name' => __('Brands', 'kavkaz'),
        'singular_name' => __('Brands', 'kavkaz'),
        'add_new_item' => __('Add New Brand', 'kavkaz'),
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-block-default',
        'can_export' => true,
        'exclude_from_search' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 6,
        'rewrite' => ['slug' => 'brands'],
        'supports' => ['title'],
    ];

    register_post_type('brands', $args);
}

add_action("admin_init", "kavkaz_brands_init");
function kavkaz_brands_init(){
	add_meta_box("kavkaz_brands_slides", "Brands", "kavkaz_brands_slides", "brands", "normal", "high");
}


function kavkaz_brands_slides(){
	global $post;
	$slider = '';
	$custom = get_post_custom($post->ID);

	if( !empty($custom["custom_brands"][0]) )
		$slider = unserialize( $custom["custom_brands"][0] );

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
				jQuery('#kavkaz-slider-items').append('<li id="listItem_'+ nextCell +'" class="ui-state-default"><div class="widget-content option-item"><div class="slider-img"><img src="'+attachment.url+'" alt=""></div><label for="custom_brands['+ nextCell +'][title]"><span><?php _e( 'Brand Title:', 'kavkaz' ) ?></span><input id="custom_brands['+ nextCell +'][title]" name="custom_brands['+ nextCell +'][title]" value="" type="text" /></label><label for="custom_brands['+ nextCell +'][link]"><span><?php _e( 'Brand Link:', 'kavkaz' ) ?></span><input id="custom_brands['+ nextCell +'][link]" name="custom_brands['+ nextCell +'][link]" value="" type="text" /></label><label for="custom_brands['+ nextCell +'][caption]"><span class="slide-caption"><?php _e( 'Brand Caption:', 'kavkaz' ) ?></span><textarea name="custom_brands['+ nextCell +'][caption]" id="custom_brands['+ nextCell +'][caption]"></textarea></label><input id="custom_brands['+ nextCell +'][id]" name="custom_brands['+ nextCell +'][id]" value="'+attachment.id+'" type="hidden" /><a class="del-cat"></a></div></li>');
				nextCell ++ ;
			});
		});

		kavkaz_uploader.open();
	});

});

  </script>

 <input id="upload_add_slide" type="button" class="button builder_active" value="<?php _e( 'Add New Brand', 'kavkaz' ) ?>">

	<ul id="kavkaz-slider-items">
	<?php
	$i=0;
	if( !empty( $slider ) ){
	foreach( $slider as $slide ):
		$i++; ?>
		<li id="listItem_<?php echo $i ?>"  class="ui-state-default">
			<div class="widget-content option-item">
				<div class="slider-img"><?php echo wp_get_attachment_image( $slide['id'] , 'thumbnail' );  ?></div>
				<label for="custom_brands[<?php echo $i ?>][title]"><span><?php _e( 'Brand Title:', 'kavkaz' ) ?> </span><input id="custom_brands[<?php echo $i ?>][title]" name="custom_brands[<?php echo $i ?>][title]" value="<?php  echo stripslashes( $slide['title'] )  ?>" type="text" /></label>
				<label for="custom_brands[<?php echo $i ?>][link]"><span><?php _e( 'Brand Link:', 'kavkaz' ) ?></span><input id="custom_brands[<?php echo $i ?>][link]" name="custom_brands[<?php echo $i ?>][link]" value="<?php  echo stripslashes( $slide['link'] )  ?>" type="text" /></label>
				<label for="custom_brands[<?php echo $i ?>][caption]"><span class="slide-caption"><?php _e( 'Brand Caption:', 'kavkaz' ) ?></span><textarea name="custom_brands[<?php echo $i ?>][caption]" id="custom_brands[<?php echo $i ?>][caption]"><?php echo stripslashes($slide['caption']) ; ?></textarea></label>
				<input id="custom_brands[<?php echo $i ?>][id]" name="custom_brands[<?php echo $i ?>][id]" value="<?php  echo $slide['id']  ?>" type="hidden" />
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



add_action('save_post', 'kavkaz_save_brands');
function kavkaz_save_brands(){
  global $post;

  	if( !empty( $_POST['custom_brands'] ) && $_POST['custom_brands'] != "" ){
		update_post_meta($post->ID, 'custom_brands' , $_POST['custom_brands']);
	}
	else{
		if( isset($post->ID) )
			delete_post_meta($post->ID, 'custom_brands' );
	}
}


add_filter("manage_edit-brands_columns", "brands_edit_columns");
function brands_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => __( 'Title', 'kavkaz' ),
	"slides" => __( 'Number of Partner', 'kavkaz' ),
	"id" => __( 'ID', 'kavkaz' ),
    "date" => __( 'Date', 'kavkaz' ),
  );

  return $columns;
}


add_action("manage_brands_posts_custom_column",  "brands_custom_columns");
function brands_custom_columns($column){
	global $post;

	$original_post = $post;

	switch ($column) {
		case "slides":
			$custom_brands_args = array( 'post_type' => 'brands', 'p' => $post->ID, 'no_found_rows' => 1  );
			$custom_brands = new WP_Query( $custom_brands_args );
			while ( $custom_brands->have_posts() ) {
				$number =0;
				$custom_brands->the_post();
				$custom = get_post_custom($post->ID);
				if( !empty($custom["custom_brands"][0])){
					$slider = unserialize( $custom["custom_brands"][0] );
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