<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
 
?>

<div id="wpsidebar" class="col-lg-4 col-12 order-lg-2 mb-10" temscope itemtype="https://schema.org/WPSideBar>
<div class="sidebar-widget-wrapper">

<?php

$kavkaz_sidebar_pos = $kavkaz_sidebar_post = '';

if (is_home())
{

    $sidebar_home = kavkaz_get_option('sidebar_home');
    if (!empty($sidebar_home)) dynamic_sidebar(sanitize_title($sidebar_home));

    else dynamic_sidebar('primary-widget-area');

}
elseif (is_page())
{

    global $get_meta;

    if (!empty($get_meta["kavkaz_sidebar_pos"][0])) $kavkaz_sidebar_pos = $get_meta["kavkaz_sidebar_pos"][0];

    if ($kavkaz_sidebar_pos != 'full')
    {

        if (!empty($get_meta["kavkaz_sidebar_post"][0])) $kavkaz_sidebar_post = sanitize_title($get_meta["kavkaz_sidebar_post"][0]);

        $sidebar_page = kavkaz_get_option('sidebar_page');
        if (!empty($kavkaz_sidebar_post)) dynamic_sidebar($kavkaz_sidebar_post);

        elseif ($sidebar_page) dynamic_sidebar(sanitize_title($sidebar_page));

        else dynamic_sidebar('primary-widget-area');
    }

}
elseif (is_single())
{

    global $get_meta;

    if (!empty($get_meta["kavkaz_sidebar_pos"][0])) $kavkaz_sidebar_pos = $get_meta["kavkaz_sidebar_pos"][0];

    if ($kavkaz_sidebar_pos != 'full')
    {

        if (!empty($get_meta["kavkaz_sidebar_post"][0])) $kavkaz_sidebar_post = sanitize_title($get_meta["kavkaz_sidebar_post"][0]);

        $sidebar_post = kavkaz_get_option('sidebar_post');
        if (!empty($kavkaz_sidebar_post)) dynamic_sidebar($kavkaz_sidebar_post);

        elseif ($sidebar_post) dynamic_sidebar(sanitize_title($sidebar_post));

        else dynamic_sidebar('primary-widget-area');
    }

}
elseif (is_archive())
{

    $category_id = get_query_var('cat');
    $kavkaz_cats_options = get_option('kavkaz_cats_options');
    if (!empty($kavkaz_cats_options[$category_id])) $cat_options = $kavkaz_cats_options[$category_id];

    if (!empty($cat_options['cat_sidebar'])) $cat_sidebar = $cat_options['cat_sidebar'];

    $sidebar_archive = kavkaz_get_option('sidebar_archive');

    if (!empty($cat_sidebar)) dynamic_sidebar(sanitize_title($cat_sidebar));

    elseif ($sidebar_archive) dynamic_sidebar(sanitize_title($sidebar_archive));

    else dynamic_sidebar('primary-widget-area');

}
elseif (is_search())
{

    $sidebar_search = kavkaz_get_option('sidebar_search');
    if (!empty($sidebar_search)) dynamic_sidebar(sanitize_title($sidebar_search));

    else dynamic_sidebar('primary-widget-area');

}
else
{

    $sidebar_archive = kavkaz_get_option('sidebar_archive');
    if (!empty($sidebar_archive))
    {
        dynamic_sidebar(sanitize_title($sidebar_archive));
    }
    else dynamic_sidebar('primary-widget-area');

}

?>
</div>
</div>