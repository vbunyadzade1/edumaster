<?php

/* Template Name: Countries */
   
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
   
?>
<div class="page-title-area item-bg2">
   <div class="container">
      <div class="page-title-content">
         <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
               <a href="<?php echo home_url('/'); ?>" title="Ana Səyfə" itemprop="item">
               <span itemprop="name">Ana Səhifə</span>
               </a>
               <meta itemprop="position" content="1">
            </li>
            <li><?php echo get_the_title(); ?></li>
         </ul>
         <h1><?php echo get_the_title(); ?></h1>
      </div>
   </div>
</div>
<section class="blog-area ptb-100">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <?php 
			 
		       global $wp_query;
			 
			   $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			 
               $args = array(
				  'paged' => $paged,
                  'posts_per_page' => 12,
                  'post_status' => 'publish',
                  'ignore_sticky_posts' => 1,
                  'post_type' => 'country',
				  'orderby' => 'date',
				  'order'   => 'ASC'			   
               );
               
               $wp_query = new WP_Query($args);
               if ( $wp_query->have_posts() ) :
            ?>
            <div class="row">
               <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
               <div class="col-lg-4 col-md-6">
                  <div class="single-box single-box-2 bg-4">
                     <i class="flaticon-statistics">
                     <?php if ( get_post_meta( get_the_ID(), "upload_flag", true ) ) { ?>
                     <img src="<?php echo get_post_meta( get_the_ID(), "upload_flag", true ); ?>" alt="<?php echo get_the_title(); ?>" title="<?php echo get_the_title(); ?>" loading="lazy" decoding="async" itemprop="thumbnailUrl" width="50" height="50">
                     <?php } ?>	
                     </i>
                     <h3><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h3>
                     <p><?php echo mb_strimwidth(strip_tags(get_the_content()), 0, 200, "..."); ?></p>
                     <a class="default-btn" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>">Daha Çox</a>
                  </div>
               </div>
               <?php endwhile; ?>
               <?php kavkaz_pagenavi(); ?>
            </div>
            <?php endif; ?>
         </div>
      </div>
   </div>
</section>
<?php get_footer(); ?>