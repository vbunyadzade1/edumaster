<?php

defined('ABSPATH') || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Change The Default WordPress Excerpt Length
/*-----------------------------------------------------------------------------------*/
function kavkaz_excerpt_global_length($length)
{
    if (kavkaz_get_option('exc_length')) return kavkaz_get_option('exc_length');
    else return 60;
}

function kavkaz_excerpt_home_length($length)
{
    global $get_meta;

    if (!empty($get_meta['home_exc_length'][0])) return $get_meta['home_exc_length'][0];
    else return 15;
}

function kavkaz_excerpt()
{
    add_filter('excerpt_length', 'kavkaz_excerpt_global_length', 999);
    echo get_the_excerpt();
}

function kavkaz_excerpt_home()
{
    add_filter('excerpt_length', 'kavkaz_excerpt_home_length', 999);
    echo get_the_excerpt();
}

/*-----------------------------------------------------------------------------------*/
# KavKaz Excerpt
/*-----------------------------------------------------------------------------------*/
function kavkaz_content_limit($text, $chars = 120)
{
    $text = wp_strip_all_tags($text);
    $text = $text . ' ';
    $text = mb_substr($text, 0, $chars, 'UTF-8');
    $text = $text . '&#8230;';
    return $text;
}

/*-----------------------------------------------------------------------------------*/
# Modify excerpts
/*-----------------------------------------------------------------------------------*/
function kavkaz_modify_post_excerpt($text = '')
{
    $raw_excerpt = $text;
    if ('' == $text)
    {
        $text = get_the_content('');

        $text = apply_filters('kavkaz_exclude_content', $text);

        $text = strip_shortcodes($text);
        $text = apply_filters('the_content', $text);
        $text = str_replace(']]>', ']]>', $text);

        $excerpt_length = apply_filters('excerpt_length', 30);
        $excerpt_more = apply_filters('excerpt_more', ' ' . '[&hellip;]');
        $text = wp_trim_words($text, $excerpt_length, $excerpt_more);
    }
    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
add_filter('get_the_excerpt', 'kavkaz_modify_post_excerpt', 9);

/*-----------------------------------------------------------------------------------*/
# KavKaz Excerpt
/*-----------------------------------------------------------------------------------*/
function kavkaz_get_meta($key, $post_ID = "")
{
    if (!$post_ID)
    {
        global $post;
        $post_ID = $post->ID;
    }

    $meta = get_post_meta($post_ID, apply_filters("" . "kavkaz_meta_" . $key, $key) , true);
    if ($meta)
    {
        return $meta;
    }

    return false;
}

function kavkaz_get_blog_content()
{
    global $post;
    $text = get_the_content();
    $str = "120";
    if ($str < strlen($text))
    {
        $sep = "...";
    }

    $text = wp_strip_all_tags($text);
    $text = str_replace(array(
        "\n",
        "\r",
        "\t"
    ) , "", $text);
    $text = mb_substr($text, 0, $str);
    $description = trim(stripslashes($text . $sep));
    return $description;
}

/*-----------------------------------------------------------------------------------*/
# Read More Functions
/*-----------------------------------------------------------------------------------*/
function kavkaz_remove_excerpt($more)
{
    return ' &hellip;';
}
add_filter('excerpt_more', 'kavkaz_remove_excerpt');

?>