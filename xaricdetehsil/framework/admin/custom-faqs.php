<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Faqs
/*-----------------------------------------------------------------------------------*/
add_action('init', 'kavkaz_faqs_post_type_register');
function kavkaz_faqs_post_type_register()
{
    $labels = [
        'name' => __('Faqs', 'kavkaz'),
        'singular_name' => __('Faqs', 'kavkaz'),
        'add_new_item' => __('Add New Faq', 'kavkaz'),
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'menu_icon' => 'dashicons-editor-kitchensink',
        'can_export' => true,
        'exclude_from_search' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_position' => 6,
        'rewrite' => ['slug' => 'faqs'],
        'supports' => array(
            'title',
            'thumbnail'
        ) ,
    ];

    register_post_type('faqs', $args);
}

/*-----------------------------------------------------------------------------------*/
# Faqs Metabox
/*-----------------------------------------------------------------------------------*/
add_action('admin_init', 'faqs_add_meta_boxes', 1);
function faqs_add_meta_boxes()
{
    add_meta_box(
        'add_faqs',
        'Add faq',
        'kavkaz_faqs_meta_box_display',
        'faqs',
        'normal',
        'default'
    );
}

function kavkaz_faqs_meta_box_display()
{
    global $post;

    $add_faqs = get_post_meta($post->ID, 'add_faqs', true);

    wp_nonce_field('kavkaz_faqs_meta_box_nonce', 'kavkaz_faqs_meta_box_nonce');
    ?>
<table id="download-urlet-one" width="100%">
   <thead>
      <tr>
         <th width="46%"><?php _e('Faq Title'); ?></th>
         <th width="46%"><?php _e('Faq Description'); ?></th>
         <th width="8%"></th>
      </tr>
   </thead>
   <tbody>
      <?php if ($add_faqs):
    foreach ($add_faqs as $field)
    { ?>
      <tr>
         <td><input type="text" class="widefat" name="faq_name[]" value="<?php if ($field['faq_name'] != '')
        {
            echo esc_attr($field['faq_name']);
        } ?>" /></td>
         <td>
            <textarea class="widefat" name="faq_desc[]" rows="4" cols="50"><?php if ($field['faq_desc'] != '')
        {
            echo esc_attr($field['faq_desc']);
        } ?></textarea>
         </td>
         <td><a class="button remove-row" href="#">Remove</a></td>
      </tr>
      <?php
    }
    else:
?>
      <tr>
         <td><input type="text" class="widefat" name="faq_name[]" /></td>
         <td><textarea class="widefat" name="faq_desc[]" rows="4" cols="50"></textarea></td>
         <td><a class="button remove-row" href="#">Remove</a></td>
      </tr>
      <?php
    endif; ?>
      <tr class="empty-row screen-reader-text">
         <td><input type="text" class="widefat" name="faq_name[]" /></td>
         <td><textarea class="widefat" name="faq_desc[]" rows="4" cols="50"></textarea></td>
         <td><a class="button remove-row" href="#">Remove</a></td>
      </tr>
   </tbody>
</table>
<p><a id="add-row" class="button" href="#">Add New</a></p>
<?php
}
add_action('save_post', 'kavkaz_faqs_meta_box_save');

function kavkaz_faqs_meta_box_save($post_id)
{
    if (!isset($_POST['kavkaz_faqs_meta_box_nonce']) || !wp_verify_nonce($_POST['kavkaz_faqs_meta_box_nonce'], 'kavkaz_faqs_meta_box_nonce'))
    {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    {
        return;
    }

    if (!current_user_can('edit_post', $post_id))
    {
        return;
    }

    $old = get_post_meta($post_id, 'add_faqs', true);
    $new = [];

    $faq_name = $_POST['faq_name'];
    $faq_desc = $_POST['faq_desc'];

    $count = count($faq_name);

    for ($i = 0;$i < $count;$i++)
    {
        if ($faq_name[$i] != ''):
            $new[$i]['faq_name'] = stripslashes(strip_tags($faq_name[$i]));

            if ($faq_desc[$i] != '')
            {
                $new[$i]['faq_desc'] = stripslashes(strip_tags($faq_desc[$i]));
            }
        endif;
    }

    if (!empty($new) && $new != $old)
    {
        update_post_meta($post_id, 'add_faqs', $new);
    }
    elseif (empty($new) && $old)
    {
        delete_post_meta($post_id, 'add_faqs', $old);
    }
}

/*-----------------------------------------------------------------------------------*/
# Kavkaz Metabox Ajax
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_faq_posts_post_name', 'kavkaz_get_posts_ajax_callback');
add_action('wp_ajax_nopriv_faq_posts_post_name', 'kavkaz_get_posts_ajax_callback');

function kavkaz_get_posts_ajax_callback(){
	
	$return = array();

	$search_results = new WP_Query( array( 
        's'=> $_GET['q'],
        'post_type' => 'faqs',
		'post_status' => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page' => 50 
	) );

	if( $search_results->have_posts() ) :
		while( $search_results->have_posts() ) : $search_results->the_post();	
			$title = ( mb_strlen( $search_results->post->post_title ) > 50 ) ? mb_substr( $search_results->post->post_title, 0, 49 ) . '...' : $search_results->post->post_title;
			$return[] = array( $search_results->post->ID, $title );
		endwhile;
	endif;

	wp_send_json( $return );

}

/*-----------------------------------------------------------------------------------*/
# Kavkaz Metabox
/*-----------------------------------------------------------------------------------*/

function kavkaz_meta_box(){

add_meta_box('my-meta-box-id','Faq Seçin','kavkaz_meta_box_editor','country','normal','high');

}
add_action( 'add_meta_boxes', 'kavkaz_meta_box' ) ;

function kavkaz_meta_box_editor($post){

global $wbdb;

?>
<div class="option-item" id="faq_posts_post_name-item">
   <?php 
      $html = '';
      $html .= '<select id="faq_posts_post_name" name="faq_posts_post_name" style="width:100%">';
      $appended_posts = get_post_meta( $post->ID, 'faq_posts_post_name', true );
      if( $appended_posts ) {
      	$title = get_the_title( get_post_meta($post->ID, "faq_posts_post_name", true) );
      	$title = ( mb_strlen( $title ) > 50 ) ? mb_substr( $title, 0, 49 ) . '...' : $title;
      	$html .=  '<option value="' . get_post_meta($post->ID, "faq_posts_post_name", true) . '" selected="selected">' . $title . '</option>';
      }
      $html .= '</select>';
      echo $html;	
      ?>	
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
   (function($) {
       "use strict";
	   
       if ($('#faq_posts_post_name-item select#faq_posts_post_name').length > 0) {
           $('#faq_posts_post_name-item select#faq_posts_post_name').select2({
               ajax: {
                   url: ajaxurl,
                   dataType: 'json',
                   delay: 250,
                   data: function(params) {
                       return {
                           q: params.term,
                           action: 'faq_posts_post_name'
                       };
                   },
                   processResults: function(data) {
                       var options = [];
                       if (data) {
                           $.each(data, function(index, text) {
                               options.push({ id: text[0], text: text[1] });
                           });
   
                       }
                       return {
                           results: options
                       };
                   },
                   cache: true
               },
               minimumInputLength: 2
           });
       }	
   
   })(jQuery);
</script>
<?php        
}

function kavkaz_meta_box_editor_save($post){

    $editor = $_POST['faq_posts_post_name'];
    update_post_meta(  $post, 'faq_posts_post_name', $editor);

}
add_action('save_post','kavkaz_meta_box_editor_save');


?>