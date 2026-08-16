<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

setPostViews(get_the_ID());

$post_cat = get_the_category();

?>
<div class="page-title-area" style="background-image: url(<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>);">
   <div class="container">
      <div class="page-title-content">
          <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
             <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
		     	<a href="<?php echo home_url('/'); ?>" title="Ana Səyfə" itemprop="item">
					<span itemprop="name">Ana Səhifə</span>
				</a>
				<meta itemprop="position" content="1">
			 </li>
             <li><?php the_title(); ?></li>
         </ul>
         <h1><?php the_title(); ?></h1>
      </div>
   </div>
</div>
<section class="blog-details-area ptb-100">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="university-contenet-full">
			   <?php if ( has_excerpt() ) : ?>
			   <div class="country_the_excerpt"> <?php the_excerpt(); ?></div>
			   <?php endif; ?>
               <?php the_content(); ?>
				   <?php if( get_post_meta( get_the_ID(), 'country_rank', true ) ){ ?>
                   <li>Ölkə Rankı: <span><?php echo get_post_meta( get_the_ID(), 'country_rank', true ); ?></span> </li>
				   <?php } ?>
				   <?php if( get_post_meta( get_the_ID(), 'world_rank', true ) ){ ?>
                   <li>Dünya Rankı: <span><?php echo get_post_meta( get_the_ID(), 'world_rank', true ); ?></span></li>
				   <?php } ?>				
            </div>
         </div>
      </div>
   </div>
</section>
<?php if( get_post_meta( get_the_ID(), 'video_url', true ) && get_post_meta( get_the_ID(), 'video_image', true ) ): ?>
<section class="faq-area bg-f8e8e9 pb-100 pt-100">
   <div class="container">
      <div class="section-title text-center">
         <span class="sub-title"><?php the_title(); ?></span>
         <h2>Tanıtım Videosu</h2>
      </div>	   
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="faq-video">
				
			   <?php if( get_post_meta( get_the_ID(), 'video_image', true ) ): ?>
               <img src="<?php echo get_post_meta( get_the_ID(), 'video_image', true ); ?>" alt="image">
			   <?php endif; ?>
				
			   <?php if( get_post_meta( get_the_ID(), 'video_url', true ) ): ?>
               <a href="<?php echo get_post_meta( get_the_ID(), 'video_url', true ); ?>" class="video-btn popup-youtube"><i class='bx bx-play'></i></a>
			   <?php endif; ?>
				
            </div>
         </div>
      </div>
   </div>
</section>
<?php endif; ?>

<?php get_template_part( 'includes/page-cta' );  ?>

<?php 
   $image_ids = '';
   $custom = get_post_custom($post->ID);
   if( !empty($custom["custom_gallery"][0]) )
   $image_ids = unserialize( $custom["custom_gallery"][0] );
   $size = 'full' ;
   if ( $image_ids ) : 
?>  	
<!-- Gallery Section Start -->
<section class="gallery-area pt-100 pb-70">
   <div class="container">
      <div class="row">
         <div class="section-title">
            <h2>Universitetdə Təhsil Səkilləri</h2>
         </div>
         <div class="testimonials-slides owl-carousel owl-theme">
            <?php
               if ( ! empty( $image_ids ) ) :
               foreach($image_ids as $image_id) {
             ?>   
            <div class="single-gallery-item">
               <img src="<?php echo wp_get_attachment_url( $image_id['id'], 'full' ); ?>" alt="Gallery Image" data-original="<?php echo wp_get_attachment_url( $image_id['id'], 'full' ); ?>" width="342" height="228" decoding="async" loading="lazy" itemprop="thumbnailUrl" data-qazy="true">
            </div>
            <?php } ?>
			<?php endif; ?>
         </div>
      </div>
   </div>
</section>
<!-- Gallery Section End -->
<?php endif; ?>

<?php get_template_part( 'includes/home-news' );  ?>

<?php

endwhile;  

endif;

get_footer();

?>