<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Gallery Metabox
/*-----------------------------------------------------------------------------------*/

add_action("admin_init", "kavkaz_gallery_init");
function kavkaz_gallery_init(){
	$post_typies = array("university", "country");
	add_meta_box("kavkaz_gallery_imagies", "Gallery Imagies", "kavkaz_gallery_imagies", $post_typies, "normal", "high");
}


function kavkaz_gallery_imagies(){
	global $post;
	$gallery = '';
	$custom = get_post_custom($post->ID);

	if( !empty($custom["custom_gallery"][0]) )
		$gallery = unserialize( $custom["custom_gallery"][0] );

	wp_enqueue_media();
?>
  <script>
  jQuery(document).ready(function() {

	jQuery(function() {
		jQuery( "#kavkaz-gallery-items" ).sortable({placeholder: "ui-state-highlight"});
	});

	/* Uploading files */
	var kavkaz_uploader;
	jQuery(document).on( 'click', '#upload_add_galleries' , function(event){

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
				jQuery('#kavkaz-gallery-items').append('<li id="listItem_'+ nextCell +'" class="ui-state-default"><div class="widget-content option-item"><div class="gallery-img"><img src="'+attachment.url+'" alt=""></div><input id="custom_gallery['+ nextCell +'][id]" name="custom_gallery['+ nextCell +'][id]" value="'+attachment.id+'" type="hidden" /><a class="del-cat"></a></div></li>');
				nextCell ++ ;
			});
		});

		kavkaz_uploader.open();
	});

});

  </script>

 <input id="upload_add_galleries" type="button" class="button button-large button-primary builder_active" value="<?php _e( 'Add New Image', 'kavkaz' ) ?>">

	<ul id="kavkaz-gallery-items">
	<?php
	$i=0;
	if( !empty( $gallery ) ){
	foreach( $gallery as $galleries ):
		$i++; ?>
		<li id="listItem_<?php echo $i ?>"  class="ui-state-default">
			<div class="widget-content option-item">
				<div class="gallery-img"><?php echo wp_get_attachment_image( $galleries['id'] , 'thumbnail' );  ?></div>
                <input id="custom_gallery[<?php echo $i ?>][id]" name="custom_gallery[<?php echo $i ?>][id]" value="<?php  echo $galleries['id']  ?>" type="hidden" />
				<a class="del-cat"></a>
			</div>
		</li>
	<?php endforeach;
	}else{
		echo '<p>'. __( 'Use the button above to add imagies.', 'kavkaz' ).'</p>';
	}?>
	</ul>
	<script> var nextCell = <?php echo $i+1 ?> ;</script>

  <?php
}



add_action('save_post', 'kavkaz_save_galleries');
function kavkaz_save_galleries(){
  global $post;

  	if( !empty( $_POST['custom_gallery'] ) && $_POST['custom_gallery'] != "" ){
		update_post_meta($post->ID, 'custom_gallery' , $_POST['custom_gallery']);
	}
	else{
		if( isset($post->ID) )
			delete_post_meta($post->ID, 'custom_gallery' );
	}
}

?>