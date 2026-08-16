<?php

defined('ABSPATH') || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# University
/*-----------------------------------------------------------------------------------*/
function kavkaz_university_taxonomy()
{

    $labels = array(
        'name' => __('Universities') ,
        'singular_name' => __('Universities') ,
        'menu_name' => __('Universities') ,
        'all_items' => __('All Universities') ,
        'add_new_item' => __('Add New University') ,
        'add_new' => __('Add New') ,
    );

    $args = array(
        'label' => __('Universities') ,
        'labels' => $labels,
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt'
        ) ,
        'taxonomies' => array(
            kavkaz_university_category_name()
        ) ,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-welcome-learn-more',
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
		'show_in_rest' => true,
        'capability_type' => 'post'
    );
    register_post_type(kavkaz_university_post_type() , $args);

}
add_action('init', 'kavkaz_university_taxonomy', 0);

function kavkaz_university_taxonomy_category()
{
    register_taxonomy(kavkaz_university_category_name() , kavkaz_university_post_type() , array(
        'labels' => array(
            'name' => __('University Categories') ,
        ) ,
        'hierarchical' => true,
		'public' => true,		
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => true
    ));
}
add_action('init', 'kavkaz_university_taxonomy_category', 0);

function kavkaz_university_taxonomy_tag()
{
    register_taxonomy(kavkaz_university_tag_name() , kavkaz_university_post_type() , array(
        'labels' => array(
            'name' => __('University Tags') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_university_tag_slug()
        ) ,
        'query_var' => true,
        'hierarchical' => false,
    ));
}
add_action('init', 'kavkaz_university_taxonomy_tag', 0);

function kavkaz_university_post_type()
{
    return apply_filters('kavkaz_university_post_type', 'university');
}
function kavkaz_university_category_name()
{
    return apply_filters('kavkaz_university_category_name', 'university_cat');
}
function kavkaz_university_tag_name()
{
    return apply_filters('kavkaz_university_tag_name', 'university_tag');
}
function kavkaz_university_post_type_slug()
{
    return apply_filters('kavkaz_university_post_type_slug', __('universitet'));
}
function kavkaz_university_category_slug()
{
    return apply_filters('kavkaz_university_category_slug', __('universitet-kateqoriya'));
}
function kavkaz_university_tag_slug()
{
    return apply_filters('kavkaz_university_tag_slug', __('universitet-teq'));
}

/*-----------------------------------------------------------------------------------*/
# Country
/*-----------------------------------------------------------------------------------*/
function kavkaz_country_taxonomy()
{

    $labels = array(
        'name' => __('Countries') ,
        'singular_name' => __('Countries') ,
        'menu_name' => __('Countries') ,
        'all_items' => __('All Countries') ,
        'add_new_item' => __('Add New Country') ,
        'add_new' => __('Add New') ,
    );

    $args = array(
        'label' => __('Countries') ,
        'labels' => $labels,
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt'
        ) ,
        'taxonomies' => array(
            kavkaz_country_category_name(), kavkaz_university_category_name(), "category"
        ) ,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-admin-site',
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
		'show_in_rest' => true,
        'capability_type' => 'post'
    );
    register_post_type(kavkaz_country_post_type() , $args);

}
add_action('init', 'kavkaz_country_taxonomy', 0);

function kavkaz_country_taxonomy_category()
{
    register_taxonomy(kavkaz_country_category_name() , kavkaz_country_post_type() , array(
        'labels' => array(
            'name' => __('Country Categories') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_country_category_slug()
        ) ,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true
    ));
}
add_action('init', 'kavkaz_country_taxonomy_category', 0);

function kavkaz_country_taxonomy_tag()
{
    register_taxonomy(kavkaz_country_tag_name() , kavkaz_country_post_type() , array(
        'labels' => array(
            'name' => __('Country Tags') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_country_tag_slug()
        ) ,
        'query_var' => true,
        'hierarchical' => false,
    ));
}
add_action('init', 'kavkaz_country_taxonomy_tag', 0);

function kavkaz_country_post_type()
{
    return apply_filters('kavkaz_country_post_type', 'country');
}
function kavkaz_country_category_name()
{
    return apply_filters('kavkaz_country_category_name', 'country_category');
}
function kavkaz_country_tag_name()
{
    return apply_filters('kavkaz_country_tag_name', 'country_tag');
}
function kavkaz_country_post_type_slug()
{
    return apply_filters('kavkaz_country_post_type_slug', __('olke'));
}
function kavkaz_country_category_slug()
{
    return apply_filters('kavkaz_country_category_slug', __('olke-kateqoriya'));
}
function kavkaz_country_tag_slug()
{
    return apply_filters('kavkaz_country_tag_slug', __('olke-teq'));
}

/*-----------------------------------------------------------------------------------*/
# Event
/*-----------------------------------------------------------------------------------*/
function kavkaz_event_taxonomy()
{

    $labels = array(
        'name' => __('Events') ,
        'singular_name' => __('Events') ,
        'menu_name' => __('Events') ,
        'all_items' => __('All Events') ,
        'add_new_item' => __('Add New Event') ,
        'add_new' => __('Add New') ,
    );

    $args = array(
        'label' => __('Events') ,
        'labels' => $labels,
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt'
        ) ,
        'taxonomies' => array(
            kavkaz_event_category_name()
        ) ,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-welcome-write-blog',
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
		'show_in_rest' => true,
        'capability_type' => 'post'
    );
    register_post_type(kavkaz_event_post_type() , $args);

}
add_action('init', 'kavkaz_event_taxonomy', 0);

function kavkaz_event_taxonomy_category()
{
    register_taxonomy(kavkaz_event_category_name() , kavkaz_event_post_type() , array(
        'labels' => array(
            'name' => __('Event Categories') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_event_category_slug()
        ) ,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true
    ));
}
add_action('init', 'kavkaz_event_taxonomy_category', 0);

function kavkaz_event_taxonomy_tag()
{
    register_taxonomy(kavkaz_event_tag_name() , kavkaz_event_post_type() , array(
        'labels' => array(
            'name' => __('Event Tags') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_event_tag_slug()
        ) ,
        'query_var' => true,
        'hierarchical' => false,
    ));
}
add_action('init', 'kavkaz_event_taxonomy_tag', 0);

function kavkaz_event_post_type()
{
    return apply_filters('kavkaz_event_post_type', 'event');
}
function kavkaz_event_category_name()
{
    return apply_filters('kavkaz_event_category_name', 'event_category');
}
function kavkaz_event_tag_name()
{
    return apply_filters('kavkaz_event_tag_name', 'event_tag');
}
function kavkaz_event_post_type_slug()
{
    return apply_filters('kavkaz_event_post_type_slug', __('tedbir'));
}
function kavkaz_event_category_slug()
{
    return apply_filters('kavkaz_event_category_slug', __('tedbir-kateqoriya'));
}
function kavkaz_event_tag_slug()
{
    return apply_filters('kavkaz_event_tag_slug', __('tedbir-teq'));
}

/*-----------------------------------------------------------------------------------*/
# Course
/*-----------------------------------------------------------------------------------*/
function kavkaz_course_taxonomy()
{

    $labels = array(
        'name' => __('Courses') ,
        'singular_name' => __('Courses') ,
        'menu_name' => __('Courses') ,
        'all_items' => __('All Courses') ,
        'add_new_item' => __('Add New Course') ,
        'add_new' => __('Add New') ,
    );

    $args = array(
        'label' => __('Courses') ,
        'labels' => $labels,
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt'
        ) ,
        'taxonomies' => array(
            kavkaz_course_category_name()
        ) ,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-editor-paste-word',
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
		'show_in_rest' => true,
        'capability_type' => 'post'
    );
    register_post_type(kavkaz_course_post_type() , $args);

}
add_action('init', 'kavkaz_course_taxonomy', 0);

function kavkaz_course_taxonomy_category()
{
    register_taxonomy(kavkaz_course_category_name() , kavkaz_course_post_type() , array(
        'labels' => array(
            'name' => __('Course Categories') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_course_category_slug()
        ) ,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true
    ));
}
add_action('init', 'kavkaz_course_taxonomy_category', 0);

function kavkaz_course_taxonomy_tag()
{
    register_taxonomy(kavkaz_course_tag_name() , kavkaz_course_post_type() , array(
        'labels' => array(
            'name' => __('Course Tags') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_course_tag_slug()
        ) ,
        'query_var' => true,
        'hierarchical' => false,
    ));
}
add_action('init', 'kavkaz_course_taxonomy_tag', 0);

function kavkaz_course_post_type()
{
    return apply_filters('kavkaz_course_post_type', 'course');
}
function kavkaz_course_category_name()
{
    return apply_filters('kavkaz_course_category_name', 'course_category');
}
function kavkaz_course_tag_name()
{
    return apply_filters('kavkaz_course_tag_name', 'course_tag');
}
function kavkaz_course_post_type_slug()
{
    return apply_filters('kavkaz_course_post_type_slug', __('kurslar'));
}
function kavkaz_course_category_slug()
{
    return apply_filters('kavkaz_course_category_slug', __('kurslar-kateqoriya'));
}
function kavkaz_course_tag_slug()
{
    return apply_filters('kavkaz_course_tag_slug', __('kurslar-teq'));
}

/*-----------------------------------------------------------------------------------*/
# School
/*-----------------------------------------------------------------------------------*/
function kavkaz_school_taxonomy()
{

    $labels = array(
        'name' => __('Schools') ,
        'singular_name' => __('Schools') ,
        'menu_name' => __('Schools') ,
        'all_items' => __('All Schools') ,
        'add_new_item' => __('Add New School') ,
        'add_new' => __('Add New') ,
    );

    $args = array(
        'label' => __('Schools') ,
        'labels' => $labels,
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
            'excerpt'
        ) ,
        'taxonomies' => array(
            kavkaz_school_category_name()
        ) ,
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-admin-multisite',
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
		'show_in_rest' => true,
        'capability_type' => 'post'
    );
    register_post_type(kavkaz_school_post_type() , $args);

}
add_action('init', 'kavkaz_school_taxonomy', 0);

function kavkaz_school_taxonomy_category()
{
    register_taxonomy(kavkaz_school_category_name() , kavkaz_school_post_type() , array(
        'labels' => array(
            'name' => __('School Categories') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_school_category_slug()
        ) ,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true
    ));
}
add_action('init', 'kavkaz_school_taxonomy_category', 0);

function kavkaz_school_taxonomy_tag()
{
    register_taxonomy(kavkaz_school_tag_name() , kavkaz_school_post_type() , array(
        'labels' => array(
            'name' => __('School Tags') ,
        ) ,
        'rewrite' => array(
            'slug' => kavkaz_school_tag_slug()
        ) ,
        'query_var' => true,
        'hierarchical' => false,
    ));
}
add_action('init', 'kavkaz_school_taxonomy_tag', 0);

function kavkaz_school_post_type()
{
    return apply_filters('kavkaz_school_post_type', 'school');
}
function kavkaz_school_category_name()
{
    return apply_filters('kavkaz_school_category_name', 'school_category');
}
function kavkaz_school_tag_name()
{
    return apply_filters('kavkaz_school_tag_name', 'school_tag');
}
function kavkaz_school_post_type_slug()
{
    return apply_filters('kavkaz_school_post_type_slug', __('dil-mektebleri'));
}
function kavkaz_school_category_slug()
{
    return apply_filters('kavkaz_school_category_slug', __('dil-mektebleri-kateqoriya'));
}
function kavkaz_school_tag_slug()
{
    return apply_filters('kavkaz_school_tag_slug', __('dil-mektebleri-teq'));
}

/*-----------------------------------------------------------------------------------*/
# Remove Custom Post Type Name from Permalink
/*-----------------------------------------------------------------------------------*/
// country
function kavkaz_remove_country_slug( $post_link, $post, $leavename ) {

    if ( 'country' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'kavkaz_remove_country_slug', 10, 3 );
// university
function kavkaz_remove_university_slug( $post_link, $post, $leavename ) {

    if ( 'university' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'kavkaz_remove_university_slug', 10, 3 );
// event
function kavkaz_remove_event_slug( $post_link, $post, $leavename ) {

    if ( 'event' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'kavkaz_remove_event_slug', 10, 3 );
// school
function kavkaz_remove_school_slug( $post_link, $post, $leavename ) {

    if ( 'school' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'kavkaz_remove_school_slug', 10, 3 );
// course
function kavkaz_remove_course_slug( $post_link, $post, $leavename ) {

    if ( 'course' != $post->post_type || 'publish' != $post->post_status ) {
        return $post_link;
    }

    $post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );

    return $post_link;
}
add_filter( 'post_type_link', 'kavkaz_remove_course_slug', 10, 3 );

function na_parse_request( $query ) {

    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'country', 'university', 'event', 'school', 'course', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'na_parse_request' );

?>