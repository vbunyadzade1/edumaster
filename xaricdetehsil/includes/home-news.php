<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
   'posts_per_page' => -1,
   'post_status' => 'publish',
   'ignore_sticky_posts' => 1,
   'post_type' => 'post'
);

$post_query = new WP_Query($args);

if ( $post_query->have_posts() ) :

?>

<section class="blog-area pt-100 pb-70">
   <div class="container">
      <div class="section-title text-left">
         <span class="sub-title">Bloqlar</span>
         <h2>Xaricdə təhsil haqqında bloqlar</h2>
         <a href="" class="default-btn"><i class='bx bx-book-reader icon-arrow before'></i><span class="label">Hamısına Bax</span><i class="bx bx-book-reader icon-arrow after"></i></a>
      </div>
      <div class="blog-slides owl-carousel owl-theme">
         <?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
         <div class="single-blog-post mb-30">
            <div class="post-image">
               <a href="<?php echo get_the_permalink(); ?>" title="<?php the_title(); ?>">
               <?php if ( has_post_thumbnail() ) { ?>
               <?php the_post_thumbnail( get_the_ID(), 'full', array( 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
               <?php } ?>
               </a>
            </div>
            <div class="post-content">
               <h3><a href="<?php echo get_the_permalink(); ?>" class="d-inline-block" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
               <a href="<?php echo get_the_permalink(); ?>" class="read-more-btn" title="Daha Çox">Daha Çox <i class='bx bx-right-arrow-alt'></i></a>
            </div>
         </div>
         <?php endwhile; ?>
      </div>
   </div>
</section>

<?php endif; ?>
<?php wp_reset_query(); ?>