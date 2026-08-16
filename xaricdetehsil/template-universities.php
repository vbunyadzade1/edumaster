<?php

/* Template Name: Universities */
   
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
		  <?php 
		  $terms = get_terms( array(
				'taxonomy' => 'university_cat',
				'hide_empty' => false,
			) );
		  
		  if($terms):
		  ?>
         <div class="col-lg-12 col-md-12 pb-70">
			 <ul class="universities-cat-lists">
				 <?php foreach($terms as $term): ?>
				 <li>
				 	<a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a>
				 </li>
				 <?php endforeach; ?>
			 </ul>
		</div>	 
		<?php endif; ?>
         <div class="col-lg-12 col-md-12">
            <?php 
			 
			  global $wp_query;
			 
			  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			 
               $args = array(
				  'paged' => $paged, 
                  'posts_per_page' => 8,
                  'post_status' => 'publish',
                  'ignore_sticky_posts' => 1,
                  'post_type' => 'university'
               );
               
               $wp_query = new WP_Query($args);
               if ( $wp_query->have_posts() ) :
               ?>
            <div class="row">
               <?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>
               <div class="col-lg-4 col-md-6">
                  <div class="single-courses-box mb-30">
                     <div class="courses-image">
                        <a href="<?php echo get_the_permalink(); ?>" class="d-block">
                        <?php if ( has_post_thumbnail() ) { ?>
                        <?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true' ) ); ?>
                        <?php } ?>
                        </a>
                     </div>
                     <div class="courses-content">
                        <h3>
							<a href="<?php echo get_the_permalink(); ?>" class="d-inline-block" title="<?php echo get_the_title(); ?>">
								<?php echo get_the_title(); ?>
							</a>
						</h3>
                     </div>
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