<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# PageNavi
/*-----------------------------------------------------------------------------------*/
function kavkaz_pagenavi($query = '', $before = '', $after = '') {

	global $wp_query;
	
	if ($query) $wp_query = $query;
	
    $pagenavi_options = array();
    $pagenavi_options['pages_text'] = __kavkaztext('Total %TOTAL_PAGES% pages, %CURRENT_PAGE% page is showing.');
    $pagenavi_options['current_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['page_text'] = '%PAGE_NUMBER%';
    $pagenavi_options['first_text'] = '<<';
    $pagenavi_options['last_text'] = '>>';
    $pagenavi_options['next_text'] = '<i class="bx bx-chevron-right"></i>';
    $pagenavi_options['prev_text'] = '<i class="bx bx-chevron-left"></i>';
    $pagenavi_options['dotright_text'] = '...';
    $pagenavi_options['dotleft_text'] = '...';
    $pagenavi_options['num_pages'] = 5;
    $pagenavi_options['always_show'] = 0;
    $pagenavi_options['num_larger_page_numbers'] = 0;
	$pagenavi_options['larger_page_numbers_multiple'] = 5;
	
    if (!is_single()) {
        $request = $wp_query->request;
        $posts_per_page = intval(get_query_var('posts_per_page'));
        $paged = intval(get_query_var('paged'));
        $numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;
		
        if (empty($paged) || $paged == 0) {
            $paged = 1;
		}
		
        $pages_to_show = intval($pagenavi_options['num_pages']);
        $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
        $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
        $pages_to_show_minus_1 = $pages_to_show - 1;
        $half_page_start = floor($pages_to_show_minus_1 / 2);
        $half_page_end = ceil($pages_to_show_minus_1 / 2);
		$start_page = $paged - $half_page_start;
		
        if ($start_page <= 0) {
            $start_page = 1;
		}
		
        $end_page = $paged + $half_page_end;
        if (($end_page - $start_page) != $pages_to_show_minus_1) {
            $end_page = $start_page + $pages_to_show_minus_1;
		}
		
        if ($end_page > $max_page) {
            $start_page = $max_page - $pages_to_show_minus_1;
            $end_page = $max_page;
		}
		
        if ($start_page <= 0) {
            $start_page = 1;
		}
		
        $larger_per_page = $larger_page_to_show * $larger_page_multiple;
        $larger_start_page_start = (kavkaz_round_num($start_page, 10) + $larger_page_multiple) - $larger_per_page;
        $larger_start_page_end = kavkaz_round_num($start_page, 10) + $larger_page_multiple;
        $larger_end_page_start = kavkaz_round_num($end_page, 10) + $larger_page_multiple;
		$larger_end_page_end = kavkaz_round_num($end_page, 10) + ($larger_per_page);
		
        if ($larger_start_page_end - $larger_page_multiple == $start_page) {
            $larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
            $larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		
        if ($larger_start_page_start <= 0) {
            $larger_start_page_start = $larger_page_multiple;
		}
		
        if ($larger_start_page_end > $max_page) {
            $larger_start_page_end = $max_page;
		}
		
        if ($larger_end_page_end > $max_page) {
            $larger_end_page_end = $max_page;
		}
		
        if ($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
            $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
            $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
            echo $before . '<div class="col-lg-12 col-md-12 col-sm-12"><div class="pagination-area text-center">' . "\n";
					
			
			if ($paged > 1) {
                echo '' . get_previous_posts_link($pagenavi_options['prev_text']) . '';
            }
							
			
            if ($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
                for ($i = $larger_start_page_start;$i < $larger_start_page_end;$i+= $larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="' . esc_url(get_pagenum_link($i)) . '" title="' . $page_text . '" class="page-numbers">' . $page_text . '</a>';
                }
			}
			
            for ($i = $start_page;$i <= $end_page;$i++) {
                if ($i == $paged) {
                    $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
                    echo '<span class="page-numbers current" aria-current="page">' . $current_page_text . '</span>';
                } else {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="' . esc_url(get_pagenum_link($i)) . '" title="' . $page_text . '" class="page-numbers">' . $page_text . '</a>';
                }
			}	

			$nextpage = intval($paged) + 1;
			
            if ($nextpage <= $max_page) {
                echo '' . get_next_posts_link($pagenavi_options['next_text'], $max_page) . ''; 
            }
				
			
            if ($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
                for ($i = $larger_end_page_start;$i <= $larger_end_page_end;$i+= $larger_page_multiple) {
                    $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
                    echo '<a href="' . esc_url(get_pagenum_link($i)) . '" title="' . $page_text . '" class="page-numbers">' . $page_text . '</a>';
                }
			}
			
            echo '</div></div>' . $after . "\n";
        }
    }
}

add_filter('next_posts_link_attributes', 'kavkaz_next_posts_link');
add_filter('previous_posts_link_attributes', 'kavkaz_previous_posts_link');

function kavkaz_previous_posts_link() {
  return ' class="prev page-numbers" rel="prev" ';
}

function kavkaz_next_posts_link() {
	return ' class="next page-numbers" rel="next" ';
}

// Round num
function kavkaz_round_num($num, $to_nearest) {
    return floor($num / $to_nearest) * $to_nearest;
}

// Load Pagenavi Post
add_action('wp_ajax_loadmore_masonry_post', 'kavkaz_ajax_load_masonry_content');
add_action('wp_ajax_nopriv_loadmore_masonry_post', 'kavkaz_ajax_load_masonry_content');

function kavkaz_ajax_load_masonry_content(){

	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1;
    $args['post_status'] = 'publish';
    $args['post_type'] = 'post';
    query_posts( $args );
    
	if( have_posts() ) :

	while( have_posts() ): the_post(); ?>
        <div class="card">
            <?php get_template_part( 'includes/item' ); ?>
        </div>
    <?php
    endwhile;
	endif;
	die;
}

// Load Pagenavi Comment
add_action('wp_ajax_loadmore_comment', 'kavkaz_ajax_load_comment');
add_action('wp_ajax_nopriv_loadmore_comment', 'kavkaz_ajax_load_comment');

function kavkaz_ajax_load_comment(){

    global $post;
    
	$post = get_post( $_POST['post_id'] );
	setup_postdata( $post );
 
    wp_list_comments( array(
        'type'        => 'comment',
        'callback'   => 'kavkaz_comment_lists',
        'avatar_size' => 36,
        'per_page'    => get_option('comments_per_page'),
        'style'       => 'ol',
        'short_ping'  => true,
        'reply_text'  => __kavkaztext( 'Reply' ),
    ) );

    die;
    
}

?>