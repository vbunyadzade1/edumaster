<?php

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
               <span itemprop="name">Ana Səyfə</span>
               </a>
               <meta itemprop="position" content="1">
            </li>
            <li><?php echo get_the_archive_title(); ?></li>
         </ul>
         <h1><?php echo get_the_archive_title(); ?></h1>
         <?php echo get_the_archive_description(); ?>
      </div>
   </div>
</div>
<section class="blog-area ptb-100">
   <div class="container">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <?php if ( have_posts() ) : ?>
            <div class="row">
              <?php while ( have_posts() ) : the_post(); ?>
               <div class="col-lg-4 col-md-6">
                  <div class="single-courses-box mb-30">
                     <div class="courses-image">
                        <a href="<?php echo get_the_permalink(); ?>" class="d-block" title="<?php echo get_the_title(); ?>">
                        <?php if ( has_post_thumbnail() ) { ?>
                        <?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
                        <?php } ?>
                        </a>
                     </div>
                     <div class="courses-content">
                        <h3><a href="<?php echo get_the_permalink(); ?>" class="d-inline-block" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h3>
                     </div>
                  </div>
               </div>
               <?php endwhile; ?>
               <?php kavkaz_pagenavi(); ?>
            </div>
            <?php endif; ?>
         </div>
         <div class="col-lg-12 col-md-12 pt-100">
            <?php if(get_term_meta(get_queried_object_id(), 'category-content', true )): ?>
            <p><?php echo get_term_meta(get_queried_object_id(), 'category-content', true ); ?></p>
            <?php endif; ?>	
         </div>		  
      </div>
   </div>
</section>
<?php get_footer(); ?>