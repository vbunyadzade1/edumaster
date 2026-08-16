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
               <a href="<?php echo home_url('/'); ?>" title="Ana Səyfə" itemprop="item">
               <span itemprop="name">Ana Səhifə</span>
               </a>
               <meta itemprop="position" content="1">
            </li>
            <li><?php echo get_the_archive_title(); ?></li>
         </ul>
         <h2><?php echo get_the_archive_title(); ?></h2>
         <?php echo get_the_archive_description(); ?>
      </div>
   </div>
</div>
<section class="blog-area ptb-100">
   <div class="container">
      <div class="row">
         <div class="col-lg-8 col-md-12">
            <?php if ( have_posts() ) : ?>
            <div class="row">
               <?php while ( have_posts() ) : the_post(); ?>
               <div class="col-lg-6 col-md-6">
                  <div class="single-blog-post mb-30">
                     <div class="post-image">
                        <a href="<?php echo get_the_permalink(); ?>" class="d-block">
                        <?php if ( has_post_thumbnail() ) { ?>
                        <?php echo get_the_post_thumbnail( get_the_ID(), 'full', array( 'alt' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
                        <?php } else { ?>
                        <?php kavkaz_fallback_image(); ?>
                        <?php } ?>
                        </a>
                        <?php 
                           $cat = get_the_category();
                           if($cat){
                           ?>
                        <div class="tag">
                           <a href="<?php echo get_term_link( $cat[0]->term_id ); ?>"><?php echo $cat[0]->name; ?></a>
                        </div>
                        <?php } ?>
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
         <div class="col-lg-4 col-md-12">
            <aside class="widget-area">
               <section class="widget widget_search">
                  <form class="search-form" action="<?php echo home_url( '/' ); ?>" method="get">
                     <label>
                     <input type="search" name="s" id="s" class="search-field" placeholder="Axtar...">
                     </label>
                     <button type="submit"><i class="bx bx-search-alt"></i></button>
                  </form>
               </section>
               <?php 
                  $args = array(
                     'posts_per_page' => 3,
                     'post_status' => 'publish',
                     'ignore_sticky_posts' => 1,
                     'post_type' => 'post',
                     'meta_key' => 'post_views_count',
                     'orderby' => 'meta_value_num',				
                  );
                  
                  $post_query = new WP_Query($args);
                  if ( $post_query->have_posts() ) :
               ?>
               <section class="widget widget_raque_posts_thumb">
                  <h3 class="widget-title">Popular Bloqlar</h3>
                  <?php while ( $post_query->have_posts() ) : $post_query->the_post(); ?>
                  <article class="item">
                     <a href="<?php echo get_the_permalink(); ?>" class="thumb">
                     <?php if ( has_post_thumbnail() ) { ?>
                     <?php echo get_the_post_thumbnail( get_the_ID(), array('80','80'), array( 'class' => 'fullimage', 'alt' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
                     <?php } else { ?>
                     <?php kavkaz_fallback_image(); ?>
                     <?php } ?>						 
                     </a>
                     <div class="info">
                        <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date(); ?></time>
                        <h4 class="title usmall"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
                     </div>
                     <div class="clear"></div>
                  </article>
                  <?php endwhile; ?>
               </section>
               <?php endif; ?>
               <?php wp_reset_query(); ?>
               <?php $get_blog_cats = get_categories(); ?>			
               <?php if($get_blog_cats){ ?>
               <section class="widget widget_categories">
                  <h3 class="widget-title">Kataqoriyalar</h3>
                  <ul>
                     <?php foreach($get_blog_cats as $get_blog_cat){ ?>
                     <li>
                        <a href="<?php echo get_term_link($get_blog_cat->term_id); ?>">
                        <?php echo $get_blog_cat->name; ?> <span class="post-count">(<?php echo $get_blog_cat->count; ?>)</span>
                        </a>
                     </li>
                     <?php } ?>
                  </ul>
               </section>
               <?php } ?>
               <?php $get_blog_tags = get_tags(); ?>			
               <?php if($get_blog_tags){ ?>
               <section class="widget widget_tag_cloud">
                  <h3 class="widget-title">Teqler</h3>
                  <div class="tagcloud">
                     <?php foreach($get_blog_tags as $get_blog_tag){ ?>
                     <a href="<?php echo get_term_link($get_blog_tag->term_id); ?>">
                     <?php echo $get_blog_tag->name; ?> <span class="tag-link-count"> (<?php echo $get_blog_tag->count; ?>)</span></a>
                     <?php } ?>
                  </div>
               </section>
               <?php } ?>
            </aside>
         </div>
         <div class="col-lg-12 col-md-12 pt-100 pb-70">
            <?php if(get_term_meta(get_queried_object_id(), 'category-content', true )): ?>
            <p><?php echo get_term_meta(get_queried_object_id(), 'category-content', true ); ?></p>
            <?php endif; ?>	
         </div>
      </div>
   </div>
</section>
<?php get_footer(); ?>