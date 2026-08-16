<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
   'posts_per_page' => -1,
   'post_status' => 'publish',
   'ignore_sticky_posts' => 1,
   'post_type' => 'country',
   'orderby' => 'date',
   'order'   => 'ASC'
);

$post_query = new WP_Query($args);

if ( $post_query->have_posts() ) :

?>
<section class="courses-categories-area bg-F7F9FB pt-100 pb-70">
   <div class="container">
      <div class="section-title text-left">
         <span class="sub-title">Ölkələr</span>
         <h2>Bu ölkələrdə təhsil ala bilərsən!</h2>
         <a href="" class="default-btn"><i class='bx bx-show-alt icon-arrow before'></i><span class="label">Hamısına Bax</span><i class="bx bx-show-alt icon-arrow after"></i></a>
      </div>
      <div class="country-courcel swiper-container">
         <div class="swiper-wrapper">
            <?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
            <div class="swiper-slide single-courses-category mb-30">
               <a href="<?php echo get_the_permalink(); ?>">
               <?php if ( get_post_meta( get_the_ID(), "upload_flag", true ) ) { ?>
               <?php	
                  $image_id = kavkaz_get_image_id( get_post_meta( get_the_ID(), "upload_flag", true ) );
                  echo wp_get_attachment_image( $image_id, 'full', "", array( 'class' => 'img-responsive', 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'thumbnailUrl', ' data-qazy' => 'true', 'loading' => 'lazy' ) );
                  ?>
               <?php } ?>
               <span><?php echo get_the_title(); ?></span>
               </a>
            </div>
            <?php endwhile; ?>
         </div>
         <div class="swiper-pagination"></div>
      </div>
   </div>
   <div id="particles-js-circle-bubble-2"></div>
</section>
<?php endif; ?>
<?php wp_reset_query(); ?>