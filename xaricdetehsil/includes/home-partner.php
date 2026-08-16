<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<section class="partner-area bg-color ptb-100">
   <div class="container">
      <div class="section-title">
         <h2>Əməkdaş Universitetlər</h2>
      </div>
      <div class="partner-slides owl-carousel owl-theme">
            <?php 
               $custom_slider_args = array( 'post_type' => 'brands', 'no_found_rows' => 1 );
               $custom_slider = new WP_Query( $custom_slider_args );
               while ( $custom_slider->have_posts() ):
               $custom_slider->the_post();
               $custom = get_post_custom($post->ID);
               $slider = unserialize( $custom["custom_brands"][0] );
               if( $slider ):
               foreach( $slider as $slide ):
            ?>     		  
         <div class="single-partner-item">
           <img class="owl-lazy" data-src="<?php echo wp_get_attachment_url( $slide['id'] , 'full' ); ?>" alt="<?php echo $slide['title']; ?>" title="<?php echo $slide['title']; ?>" itemprop="thumbnailUrl" decoding="async" loading="lazy" width="120" height="97">
         </div>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php endwhile; wp_reset_postdata(); ?>
      </div>
   </div>
</section>