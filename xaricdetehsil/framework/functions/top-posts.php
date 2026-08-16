<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Get Most Recent posts
/*-----------------------------------------------------------------------------------*/
function kavkaz_last_posts($posts_number = 5){
	global $post;
	$original_post = $post;

	$args = array(
		'posts_per_page'		 => $posts_number,
		'no_found_rows'          => true,
		'post_status'            => 'publish',
		'ignore_sticky_posts'    => true,
		'post_type'              => 'post'
	);

	$get_posts_query = new WP_Query( $args );

	if ( $get_posts_query->have_posts() ):
		while ( $get_posts_query->have_posts() ) : $get_posts_query->the_post(); ?>
        <li>
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </li>
		<?php
		endwhile;
	endif;

	$post = $original_post;
	wp_reset_query();
}


/*-----------------------------------------------------------------------------------*/
# Get Most Recent posts from Category
/*-----------------------------------------------------------------------------------*/
function kavkaz_last_posts_cat($posts_number = 5 , $cats = 1){
	global $post;
	$original_post = $post;

	$args = array(
		'posts_per_page'		 => $posts_number,
		'cat'					 => $cats,
		'no_found_rows'          => true,
		'post_status'            => 'publish',
		'post_type'              => 'post',
		'ignore_sticky_posts'	 => true
	);

	$get_posts_query = new WP_Query( $args );

	if ( $get_posts_query->have_posts() ):
		while ( $get_posts_query->have_posts() ) : $get_posts_query->the_post(); ?>
        <li>
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </li>
		<?php
		endwhile;
	endif;

	$post = $original_post;
	wp_reset_query();
}

/*-----------------------------------------------------------------------------------*/
# Get Random posts
/*-----------------------------------------------------------------------------------*/
function kavkaz_random_posts($posts_number = 5){
	global $post;
	$original_post = $post;

	$args = array(
		'posts_per_page'		 => $posts_number,
		'orderby'				 => 'rand',
		'no_found_rows'          => true,
		'post_status'            => 'publish',
		'post_type'              => 'post'
	);

	$get_posts_query = new WP_Query( $args );

	if ( $get_posts_query->have_posts() ):
		while ( $get_posts_query->have_posts() ) : $get_posts_query->the_post(); ?>
        <li>
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </li>
		<?php
		endwhile;
	endif;

	$post = $original_post;
	wp_reset_query();
}


/*-----------------------------------------------------------------------------------*/
# Get Popular posts
/*-----------------------------------------------------------------------------------*/
function kavkaz_popular_posts( $posts_number = 5){
	global $post;
	$original_post = $post;

	$args = array(
		'orderby'				 => 'comment_count',
		'order'					 => 'DESC',
		'posts_per_page'		 => $posts_number,
		'post_status'            => 'publish',
		'post_type'              => 'post',
		'no_found_rows'          => true,
		'ignore_sticky_posts'	 => true
	);

	$popularposts = new WP_Query( $args );
	if ( $popularposts->have_posts() ):
		while ( $popularposts->have_posts() ) : $popularposts->the_post(); ?>
        <li>
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </li>
	<?php
	endwhile;
	endif;

	$post = $original_post;
	wp_reset_query();
}

/*-----------------------------------------------------------------------------------*/
# Get Popular posts / Views
/*-----------------------------------------------------------------------------------*/
function kavkaz_most_viewed( $posts_number = 5){
	global $post;
	$original_post = $post;

	$args = array(
		'orderby'				 => 'meta_value_num',
		'meta_key'				 => 'post_views_count',
		'posts_per_page'		 => $posts_number,
		'post_status'            => 'publish',
		'post_type'              => 'post',
		'no_found_rows'          => true,
		'ignore_sticky_posts'	 => true
	);

	$popularposts = new WP_Query( $args );
	if ( $popularposts->have_posts() ):
		while ( $popularposts->have_posts() ) : $popularposts->the_post(); ?>
        <li>
        <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
        </li>
	<?php
		endwhile;
	endif;

	$post = $original_post;
	wp_reset_query();
}


/*-----------------------------------------------------------------------------------*/
# Get Most commented posts
/*-----------------------------------------------------------------------------------*/
function kavkaz_most_commented($comment_posts = 5 , $avatar_size = 55){
$comments = get_comments('status=approve&number='.$comment_posts);
foreach ($comments as $comment) { ?>
	<li>
		<div class="post-thumbnail" style="width:<?php echo $avatar_size ?>px">
			<?php echo get_avatar( $comment, $avatar_size ); ?>
		</div>
		<a href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>">
		<?php echo strip_tags($comment->comment_author); ?>: <?php echo wp_html_excerpt( $comment->comment_content, 80 ); ?>... </a>
	</li>
<?php }
}

?>