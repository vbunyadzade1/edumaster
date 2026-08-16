<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

?>
<div class="page-title-area item-bg2 jarallax" data-jarallax='{"speed": 0.3}'>
   <div class="container">
      <div class="page-title-content">
          <ul class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
             <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
		     	<a href="<?php echo home_url('/'); ?>" title="Ana Səhifə" itemprop="item">
					<span itemprop="name">Ana Səhifə</span>
				</a>
				<meta itemprop="position" content="1">
			 </li>
             <li>Axtarış</li>
         </ul>
         <h1><?php the_search_query(); ?></h1>
      </div>
   </div>
</div>
<section class="blog-area ptb-100">
   <div class="container">
      <?php if ( have_posts() ) : ?>
      <div class="row">
         <?php while ( have_posts() ) : the_post(); ?>
         <div class="col-lg-4 col-md-6">
            <div class="single-blog-post mb-30">
               <div class="post-image">
                  <a href="<?php echo get_the_permalink(); ?>" class="d-block">
                  <?php if ( has_post_thumbnail() ) { ?>
                  <?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'alt' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
                  <?php } else { ?>
                  <?php kavkaz_fallback_image(); ?>
                  <?php } ?>
                  </a>
               </div>
               <div class="post-content">
                  <h3><a href="<?php echo get_the_permalink(); ?>" class="d-inline-block"><?php echo get_the_title(); ?></a></h3>
                  <a href="<?php echo get_the_permalink(); ?>" class="read-more-btn">Daha Çox <i class='bx bx-right-arrow-alt'></i></a>
               </div>
            </div>
         </div>
         <?php endwhile; ?>
         <?php kavkaz_pagenavi();  ?>
      </div>
      <?php endif; ?>
   </div>
</section>
<?php get_footer(); ?>