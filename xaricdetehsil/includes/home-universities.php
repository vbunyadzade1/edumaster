<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$args = array(
   'posts_per_page' => -1,
   'post_status' => 'publish',
   'ignore_sticky_posts' => 1,
   'post_type' => 'university'
);

$terms = get_terms( 'university_cat', array(
    'hide_empty' => false,
) );

$post_query = new WP_Query($args);

if ( $post_query->have_posts() ) :

$count_posts = wp_count_posts('university');
 
if ( $count_posts ) {
    $draft_posts = $count_posts->publish;
}

?>
<section class="courses-area pt-100 pb-70">
   <div class="container">
      <div class="section-title text-left">
         <span class="sub-title">Unversitetler</span>
         <h2>Partnyor universitetlərimiz</h2>
         <p></p>
         <a href="" class="default-btn">
         <i class='bx bx-show-alt icon-arrow before'></i><span class="label">Hamısı</span><i class="bx bx-show-alt icon-arrow after"></i>
         </a>
      </div>
      <div class="shorting-menu">
         <button class="filter" data-filter="all">Hamısına bax (<?php echo $draft_posts; ?>)</button>
         <?php foreach($terms as $term){ ?>
         <button class="filter" data-filter=".<?php echo str_replace('-', '', $term->slug); ?>"><?php echo $term->name; ?> (<?php echo $term->count; ?>)</button>
         <?php } ?>
      </div>
      <div class="shorting">
         <div class="unversity-courcel swiper-container">
            <div class="swiper-wrapper">
               <?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
				<?php $post_terms = get_the_terms( get_the_ID(), 'university_cat'); ?>				
               <div class="swiper-slide mix all <?php foreach($post_terms as $post_term){ echo str_replace('-', '', $post_term->slug) . " "; } ?>">
                  <div class="single-courses-box mb-30">
                     <div class="courses-image">
                        <a href="<?php echo get_the_permalink(); ?>" class="d-block">
                        <?php if ( has_post_thumbnail() ) { ?>
                        <?php echo get_the_post_thumbnail( get_the_ID(), array(352,198), array( 'alt' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true' ) ); ?>
                        <?php } else { ?>
                        <?php kavkaz_fallback_image(); ?>
                        <?php } ?>
                        </a>
                     </div>
                     <div class="courses-content">
                        <h3><a href="<?php echo get_the_permalink(); ?>" class="d-inline-block"><?php echo get_the_title(); ?></a></h3>
                     </div>
                  </div>
               </div>
               <?php endwhile; ?>
            </div>
            <div class="swiper-pagination"></div>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>
<?php wp_reset_query(); ?>