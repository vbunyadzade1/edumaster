<?php

defined('ABSPATH') || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Post Thumbnails
/*-----------------------------------------------------------------------------------*/
function kavkaz_image()
{
    global $post;
	
    $first_img = "";
    ob_start();
    ob_end_clean();
    $output = preg_match_all("/<img.+src=['\"]([^'\"]+)['\"][^>]*>/i", $post->post_content, $matches);
	
    $first_img = $matches[1][0];
    if( $first_img && empty($first_img) ){
        $first_img = $matches[1][0];
    } else {
        $first_img = NO_IMAGE;		
	}
	
    return $first_img;
}

function kavkaz_get_image($width, $height, $name, $itemprop = "thumbnailUrl")
{

    $first_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ) , "" . $name . "" );
    $myimage = get_post_meta( get_the_ID(), "posterimage", true );
	
    if (has_post_thumbnail())
    {
        echo "<img src=\"" . $first_image[0] . "\" alt=\"" . get_the_title( get_the_ID() ) . "\" title=\"" . get_the_title( get_the_ID() ) . "\" width=\"" . $width . "\"  height=\"" . $height . "\" loading=\"lazy\" decoding=\"async\" itemprop=\"" . $itemprop . "\" data-qazy=\"true\" />";
    }
    else if ($myimage != "")
    {
        echo "<img src=\"" . $myimage . "\" alt=\"" . get_the_title( get_the_ID() ) . "\" title=\"" . get_the_title( get_the_ID() ) . "\" width=\"" . $width . "\"  height=\"" . $height . "\" loading=\"lazy\" decoding=\"async\" itemprop=\"" . $itemprop . "\" data-qazy=\"true\" />";
    }
}

function kavkaz_get_image_lazy($class, $width, $height, $name, $itemprop = "thumbnailUrl")
{

    $first_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ) , "" . $name . "" );
    $myimage = get_post_meta( get_the_ID(), "posterimage", true );
	
    if (has_post_thumbnail())
    {
        echo "<img class=\"" . $class . " \" data-src=\"" . $first_image[0] . "\" alt=\"" . get_the_title( get_the_ID() ) . "\" title=\"" . get_the_title( get_the_ID() ) . "\" width=\"" . $width . "\"  height=\"" . $height . "\" loading=\"lazy\" decoding=\"async\" itemprop=\"" . $itemprop . "\" data-qazy=\"true\" />";
    }
    else if ($myimage != "")
    {
        echo "<img class=\"" . $class . " \" data-src=\"" . $myimage . "\" alt=\"" . get_the_title( get_the_ID() ) . "\" title=\"" . get_the_title( get_the_ID() ) . "\" width=\"" . $width . "\"  height=\"" . $height . "\" loading=\"lazy\" decoding=\"async\" itemprop=\"" . $itemprop . "\" data-qazy=\"true\" />";
    }
}

if (function_exists('add_image_size'))
{
    add_image_size('posterimage', 600, 400, true);
}

/*-----------------------------------------------------------------------------------*/
# lazyIMG
/*-----------------------------------------------------------------------------------*/
add_filter('the_content', 'kavkaz_lazy_img');
add_filter('the_excerpt', 'kavkaz_lazy_img');

function kavkaz_lazy_img($content)
{
    $content = str_replace('<img', '<img loading="lazy" decoding="async" itemprop="thumbnailUrl"', $content);
    return $content;
}

/*-----------------------------------------------------------------------------------*/
# Thumb SRC
/*-----------------------------------------------------------------------------------*/
function kavkaz_thumb_src($size = 'full')
{
    global $post;
    $image_id = get_post_thumbnail_id( get_the_ID() );
    $image_url = wp_get_attachment_image_src($image_id, $size);
    return !empty($image_url[0]) ? $image_url[0] : false;
}

/*-----------------------------------------------------------------------------------*/
# Slider Thumb
/*-----------------------------------------------------------------------------------*/

function kavkaz_slider_img_src($image_id, $size)
{
    global $post;
    $image_url = wp_get_attachment_image_src($image_id, $size);
    return !empty($image_url[0]) ? $image_url[0] : false;
}

/*-----------------------------------------------------------------------------------*/
# Fallback Image
/*-----------------------------------------------------------------------------------*/
function kavkaz_fallback_image()
{
    global $post;
    $first_img = NO_IMAGE;
    ob_start();
    ob_end_clean();
    $first_img = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches[1][0]);

    if (empty($first_img))
    {
        $first_img = NO_IMAGE;
    }
    echo '<img class="img-responsive" src="' . $first_img . '" alt="' . get_the_title() . '" itemprop="thumbnailUrl" decoding="async" loading="lazy">';
}

function kavkaz_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0]; 
}
