<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();

setPostViews(get_the_ID());

$post_cat = get_the_category();

?>
<div class="page-title-area" style="background-image: url(<?php bloginfo('template_directory'); ?>/assets/img/blog-header-bg.jpg);">
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
      </div>
   </div>
</div>
<section class="blog-details-area ptb-100">
   <div class="container">
      <div class="row">
         <div class="col-lg-8 col-md-12">
            <div class="blog-details-desc">
				<div class="article-image">
					<?php if ( has_post_thumbnail() ) { ?>
					<?php the_post_thumbnail('full', array( 'class' => 'img-responsive', 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'image', ' data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>			 
					<?php } ?>
				</div>				
               <div class="article-content mt-3">
				  <h1 class="article-title"><?php the_title(); ?></h1>
                  <?php the_content(); ?>
                  <div class="entry-meta">
                     <ul>
                        <li>
                           <i class='bx bx-folder-open'></i>
                           <span>Kateqoriya</span>
                           <?php if($post_cat){ ?>
                           <a href="<?php echo get_term_link($post_cat[0]->term_id); ?>" title="<?php echo $post_cat[0]->name; ?>"><?php echo $post_cat[0]->name; ?></a>
                           <?php } ?>
                        </li>
                        <li>
                           <i class='bx bx-group'></i>
                           <span>Oxunma</span>
                           <?php echo getPostViews(get_the_ID()); ?>
                        </li>
                        <li>
                           <i class='bx bx-calendar'></i>
                           <span>Tarix</span>
                           <?php echo get_the_date('d/m/Y'); ?>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="article-footer">
                  <?php if(has_tag()) { ?>
                  <div class="article-tags">
                     <span><i class='bx bx-purchase-tag'></i></span>
                     <?php the_tags(); ?>
                  </div>
                  <?php } ?>
                  <div class="article-share">
                     <ul class="social">
                        <li><span>Paylaş:</span></li>
                        <li><a href="https://www.facebook.com/sharer/sharer.php?s=100&amp;p[url]=<?php the_permalink(); ?>" class="facebook" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                        <li><a href="https://twitter.com/intent/tweet?text=<?php the_title(); ?>+<?php the_permalink(); ?>" class="twitter" target="_blank"><i class='bx bxl-twitter'></i></a></li>
                        <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=some%20summary%20if%20you%20want" class="linkedin" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
                     </ul>
                  </div>
               </div>
               <?php 
                  $next_post = get_next_post();
                  $prev_post = get_previous_post();
                  
                  if (!empty($next_post) or !empty($prev_post)) { ?>
               <div class="raque-post-navigation">
                  <?php if (!empty($prev_post)) { ?>
                  <div class="prev-link-wrapper">
                     <div class="info-prev-link-wrapper">
                        <a href="<?php echo esc_url(get_permalink($prev_post->ID)) ?>" title="<?php echo get_the_title($prev_post->ID); ?>">
                        <span class="image-prev">
                        <?php echo get_the_post_thumbnail( $prev_post->ID, array(100,81), array( 'alt' => get_the_title($prev_post->ID), 'title' => get_the_title($prev_post->ID), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
                        <span class="post-nav-title">Əvvəlki</span>
                        </span>
                        <span class="prev-link-info-wrapper">
                        <span class="prev-title"><?php echo get_the_title($prev_post->ID); ?></span>
                        <span class="meta-wrapper">
                        <span class="date-post"><?php echo get_the_date("d/m/Y",$prev_post->ID); ?></span>
                        </span>
                        </span>
                        </a>
                     </div>
                  </div>
                  <?php } ?>
                  <?php if (!empty($next_post)) { ?>
                  <div class="next-link-wrapper">
                     <div class="info-next-link-wrapper">
                        <a href="<?php echo esc_url(get_permalink($next_post->ID)) ?>" title="<?php echo get_the_title($next_post->ID); ?>">
                        <span class="next-link-info-wrapper">
                        <span class="next-title"><?php echo get_the_title($next_post->ID); ?></span>
                        <span class="meta-wrapper">
                        <span class="date-post"><?php echo get_the_date("d/m/Y",$next_post->ID); ?></span>
                        </span>
                        </span>
                        <span class="image-next">
                        <?php echo get_the_post_thumbnail( $prev_post->ID, array(100,81), array( 'alt' => get_the_title($next_post->ID), 'title' => get_the_title($next_post->ID), 'itemprop' => 'next_post', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
                        <span class="post-nav-title">Sonrakı</span>
                        </span>
                        </a>
                     </div>
                  </div>
                  <?php } ?>
               </div>
               <?php } ?>
				<?php 
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;			 
				 ?>
            </div>
         </div>
         <div class="col-lg-4 col-md-12">
            <aside id="wpsidebar" class="widget-area" itemscope itemtype="https://schema.org/WPSideBar">
               <section class="widget widget_search">
                  <form class="search-form" action="<?php echo home_url( '/' ); ?>" method="get">
                     <label>
                     <input type="search" name="s" id="s" class="search-field" placeholder="Axtar..." required>
                     </label>
                     <button type="submit"><i class="bx bx-search-alt"></i></button>
                  </form>
               </section>
               <?php 
                  $args = array(
                     'posts_per_page' => 5,
                     'post_status' => 'publish',
                     'ignore_sticky_posts' => 1,
                     'post_type' => 'post'
                  );
                  
                  $post_query_pop = new WP_Query($args);
                  
                  if ( $post_query_pop->have_posts() ) :			
                  				
                  ?>	
               <section class="widget widget_raque_posts_thumb">
                  <h3 class="widget-title">Son Bloqlar</h3>
                  <?php while ( $post_query_pop->have_posts() ) : $post_query_pop->the_post(); ?>
                  <article class="item">
                     <a href="<?php echo get_the_permalink(); ?>" class="thumb" title="<?php echo get_the_title(); ?>">
                     <?php if ( has_post_thumbnail() ) { ?>
                     <?php echo get_the_post_thumbnail( get_the_ID(), array(80,80), array( 'class' => 'fullimage', 'alt' => get_the_title(), 'title' => get_the_title(), 'itemprop' => 'thumbnailUrl', 'data-qazy' => 'true', 'loading' => 'lazy' ) ); ?>
                     <?php } ?>						 
                     </a>
                     <div class="info">
                        <time datetime="<?php echo get_the_date('Y-m-d'); ?>"><?php echo get_the_date(); ?></time>
                        <h4 class="title usmall"><a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a></h4>
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
                        <a href="<?php echo get_term_link($get_blog_cat->term_id); ?>" title="<?php echo $get_blog_cat->name; ?>">
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
                  <h3 class="widget-title">Etiketlər</h3>
                  <div class="tagcloud">
                     <?php foreach($get_blog_tags as $get_blog_tag){ ?>
                     <a href="<?php echo get_term_link($get_blog_tag->term_id); ?>" title="<?php echo $get_blog_tag->name; ?>">
                     <?php echo $get_blog_tag->name; ?> <span class="tag-link-count"> (<?php echo $get_blog_tag->count; ?>)</span></a>
                     <?php } ?>
                  </div>
               </section>
               <?php } ?>			
            </aside>
         </div>
      </div>
   </div>
</section>
<?php

endwhile;  

endif;

get_footer();

?>