<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Post Views
/*-----------------------------------------------------------------------------------*/
function getPostViews($postID){

    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == ''){

        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }

    return number_format( round( $count ) );
}

function setPostViews($postID){
    
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count == ''){

        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {

        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

//Admin Filter add views
add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views', 5, 2);

function posts_column_views($defaults){
    $defaults['post_views'] = esc_html__('Views', 'kavkaz');
    return $defaults;
}

function posts_custom_column_views($column_name, $id){
    if ($column_name === 'post_views')
    {
        echo getPostViews( get_the_ID() );
    }
}

?>