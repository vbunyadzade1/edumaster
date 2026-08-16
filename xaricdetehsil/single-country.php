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
            </div>
         </div>
      </div>
   </div>
</section>

<?php 
   $faq_ids = '';
   $custom = get_post_custom( get_post_meta($post->ID, "faq_posts_post_name", true) );
   if( !empty($custom["add_faqs"][0]) )
   $faq_ids = unserialize( $custom["add_faqs"][0] );
   if ( $faq_ids ) : 
   ?>  
<!-- Faqs Section Start -->
<section class="faq-area bg-f8e8e9 pb-100 pt-100">
   <div class="container">
      <div class="section-title text-left">
         <span class="sub-title">Ən çox verilən suallar və cavavbları</span>
         <h2><?php echo get_the_title(); ?> Haqqında</h2>
      </div>	   
      <div class="row">
         <div class="col-lg-6 col-md-12">
			 <?php if ( get_post_meta( get_the_ID(), "faq_posts_post_name", true ) ) { ?>
            <div class="faq-video">
               <?php echo get_the_post_thumbnail( get_post_meta( get_the_ID(), "faq_posts_post_name", true ), "full", array( 'alt' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true' ) ); ?>
               <a href="<?php echo get_post_meta( get_post_meta( get_the_ID(), "faq_posts_post_name", true ), "video_url", true ); ?>" class="video-btn popup-youtube"><i class='bx bx-play'></i></a>
            </div>
			  <?php } ?>
         </div>
         <div class="col-lg-6 col-md-12">
            <div class="faq-accordion faq-accordion-style-two">
               <ul class="accordion" itemscope itemtype="https://schema.org/FAQPage">
            <?php
               if ( ! empty( $faq_ids ) ) :
			   $count = 0;
               foreach($faq_ids as $faq_id) {
			   $count++;   
               ?>   				   
                  <li class="accordion-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                     <a class="accordion-title<?php if( $count == 1 ){ echo " active"; } ?>" href="javascript:void(0)">
                     <i class='bx bx-chevron-down'></i>
                     <span itemprop="name"><?php if($faq_id['faq_name'] != '') echo ''. esc_attr( $faq_id['faq_name'] ) . ''; ?></span>
                     </a>
                     <div class="accordion-content<?php if( $count == 1 ){ echo " show"; } ?>" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <p itemprop="text"><?php if($faq_id['faq_desc'] != '') echo ''. esc_attr( $faq_id['faq_desc'] ) . ''; ?></p>
                     </div>
                  </li>
             <?php } ?>
            <?php endif; ?>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Faqs Section End -->
<?php endif; ?>

<?php get_template_part( 'includes/page-cta' );  ?>

<?php
   $uni_term_obj_list = get_the_terms( get_the_ID(), 'university_cat' );
   $uni_terms_string = join(', ', wp_list_pluck($uni_term_obj_list, 'slug'));
   
   $uni_args = array(
      'posts_per_page' => 6,
      'post_status' => 'publish',
      'ignore_sticky_posts' => 1,
      'post_type' => 'university',
       'tax_query' => array(
           array(
               'taxonomy' => 'university_cat',
               'field'    => 'slug',
               'terms'    => $uni_terms_string
            )
   		
   	)
   );
   
   $uni_query = new WP_Query($uni_args);
   
   if ( $uni_query->have_posts() ) :
   
   ?>
<!-- Unversity Section Start -->
<section class="team-area ptb-100">
   <div class="container">
	  <?php if($uni_term_obj_list): ?>  
      <div class="section-title">
         <h2><?php echo $uni_term_obj_list[0]->name; ?></h2>
      </div>
	  <?php endif; ?> 
      <div class="row">
         <?php while ( $uni_query->have_posts() ) : $uni_query->the_post(); ?>	
         <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="single-instructor-member mb-30">
               <div class="member-image">
                  <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
                  <?php if ( has_post_thumbnail() ) { ?>
                  <?php echo get_the_post_thumbnail( get_the_ID(), array(352,285), array( 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true' ) ); ?>
                  <?php } ?>
                  </a>
               </div>
               <div class="member-content">
                  <h3><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                  <ul class="social">
                     <?php if( get_post_meta( get_the_ID(), 'country_rank', true ) ){ ?>
                     <li><span>Country Rank: <?php echo get_post_meta( get_the_ID(), 'country_rank', true ); ?></span></li>
                     <?php } ?>	
                     <?php if( get_post_meta( get_the_ID(), 'world_rank', true ) ){ ?>
                     <li><span>World Rank: <?php echo get_post_meta( get_the_ID(), 'world_rank', true ); ?></span></li>
                     <?php } ?>
                  </ul>
               </div>
            </div>
         </div>
         <?php endwhile; ?>
      </div>
	  <?php if($uni_term_obj_list): ?>
	  <div class="read-more-center-box">
		<a href="<?php echo get_term_link( $uni_term_obj_list[0]->term_id ); ?>" class="default-btn">
			<i class="bx bx-show-alt icon-arrow before"></i><span class="label">Hamısına Bax</span><i class="bx bx-show-alt icon-arrow after"></i>
		</a>
	  </div>
	  <?php endif; ?>
   </div>
   <div id="particles-js-circle-bubble-3"></div>
</section>
<!-- Unversity Section End -->
<?php endif; ?>
<?php wp_reset_query(); ?>


<?php 
   $image_ids = '';
   $custom = get_post_custom($post->ID);
   if( !empty($custom["custom_gallery"][0]) )
   $image_ids = unserialize( $custom["custom_gallery"][0] );
   if ( $image_ids ) : 
   ?>  	
<!-- Gallery Section Start -->
<section class="gallery-area pb-70">
   <div class="container">
      <div class="row">
         <div class="section-title">
            <h2><?php echo get_the_title(); ?> Şəkilləri</h2>
         </div>
         <div class="testimonials-slides owl-carousel owl-theme">
            <?php
               if ( ! empty( $image_ids ) ) :
               foreach($image_ids as $image_id) {
               ?>   
            <div class="single-gallery-item">
               <img src="<?php echo wp_get_attachment_url( $image_id['id'], 'full' ); ?>" alt="Gallery Image" data-original="<?php echo wp_get_attachment_url( $image_id['id'], 'full' ); ?>" width="342" height="228">
            </div>
            <?php } ?>
            <?php endif; ?>
         </div>
      </div>
   </div>
</section>
<!-- Gallery Section End -->
<?php endif; ?>

<?php
   $blog_term_obj_list = get_the_terms( get_the_ID(), 'category' );
   $blog_terms_string = join(', ', wp_list_pluck($blog_term_obj_list, 'slug'));
   
   $blog_args = array(
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'ignore_sticky_posts' => 1,
      'post_type' => 'post',
       'tax_query' => array(
           array(
               'taxonomy' => 'category',
               'field'    => 'slug',
               'terms'    => $blog_terms_string
            )
   		
   	)
   );
   
   $blog_query = new WP_Query($blog_args);
   
   if ( $blog_query->have_posts() ) :
   
   $cat = get_the_category();
   
   ?>
<section class="blog-area pt-100 pb-70">
   <div class="container">
      <div class="section-title text-left">
         <span class="sub-title">Bloqlar</span>
         <h2>Xaricdə təhsil haqqında bloqlar</h2>
         <a href="" class="default-btn"><i class='bx bx-book-reader icon-arrow before'></i><span class="label">Hamısına Bax</span><i class="bx bx-book-reader icon-arrow after"></i></a>
      </div>
      <div class="blog-slides owl-carousel owl-theme">
         <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
         <div class="single-blog-post mb-30">
            <div class="post-image">
               <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">
               <?php if ( has_post_thumbnail() ) { ?>
               <?php echo get_the_post_thumbnail( get_the_ID(), array(352,285), array( 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true' ) ); ?>
               <?php } ?>
               </a>
               <?php if($cat){ ?>
               <div class="tag">
                  <a href="<?php echo get_term_link($cat[0]->term_id); ?>" title="<?php echo $cat[0]->name; ?>"><?php echo $cat[0]->name; ?></a>
               </div>
               <?php } ?>
            </div>
            <div class="post-content">
               <h3><a href="<?php echo get_the_permalink(); ?>" class="d-inline-block" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h3>
               <a href="<?php echo get_the_permalink(); ?>" class="read-more-btn" title="Daha Çox">Daha Çox <i class='bx bx-right-arrow-alt'></i></a>
            </div>
         </div>
         <?php endwhile; ?>
      </div>
   </div>
</section>
<?php endif; ?>
<?php wp_reset_query(); ?>
<?php

endwhile;  

endif;

get_footer();

?>