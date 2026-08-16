<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
   'posts_per_page' => -1,
   'post_status' => 'publish',
   'ignore_sticky_posts' => 1,
   'post_type' => 'course'
);

$post_query = new WP_Query($args);

if ( $post_query->have_posts() ) :

?>
<section class="courses-categories-area bg-image pt-100 pb-70">
   <div class="container">
      <div class="section-title text-left">
         <span class="sub-title">Xaricdə təhsil Kursları</span>
         <h2>Təhsilin üçün imtahan kursları</h2>
         <a href="" class="default-btn" title="<?php echo get_the_title(); ?>"><i class='bx bx-show-alt icon-arrow before'></i><span class="label">Hamısına Bax</span><i class="bx bx-show-alt icon-arrow after"></i></a>
      </div>
      <div class="courses-categories-slides owl-carousel owl-theme">
         <?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
         <div class="single-categories-courses-item mb-30" data-bg-image="<?php echo get_post_meta( get_the_ID(), "upload_flag", true ); ?>">
            <h3><?php echo get_the_title(); ?></h3>
            <a href="<?php echo get_the_permalink(); ?>" class="learn-more-btn" title="Daha çoxu">Daha çoxu <i class='bx bx-book-reader'></i></a>
            <a href="<?php echo get_the_permalink(); ?>" class="link-btn" title="<?php echo get_the_title(); ?>"></a>
         </div>
         <?php endwhile; ?>
      </div>
   </div>
   <div id="particles-js-circle-bubble-2"></div>
</section>
<?php endif; ?>
<?php wp_reset_query(); ?>