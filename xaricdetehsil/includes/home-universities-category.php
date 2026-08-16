<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$terms = get_terms( array(
	'taxonomy' => 'university_cat',
	'hide_empty' => false,
  	'orderby'    => 'count',
    'order'      => 'DESC'	
) );
		  
if($terms):

?>
<section class="unicat-area pt-100 pb-70">
   <div class="container">
      <div class="section-title text-left">
         <span class="sub-title">Unversitetler</span>
         <h2>Partnyor universitetlərimiz</h2>
         <p></p>
         <a href="universitetler/" class="default-btn">
         <i class='bx bx-show-alt icon-arrow before'></i><span class="label">Hamısı</span><i class="bx bx-show-alt icon-arrow after"></i>
         </a>
      </div>
      <div class="unversity-courcel swiper-container">
         <div class="swiper-wrapper">
            <?php foreach($terms as $term): ?>
            <div class="swiper-slide">
               <div class="single-unicat-box mb-30">
                  <div class="unicat-image">
                     <a href="<?php echo get_term_link($term->term_id); ?>" class="d-block">
                     <?php 
						if ( get_term_meta( $term->term_id, 'category-image-id', true ) ) { 
							echo wp_get_attachment_image( get_term_meta( $term->term_id, 'category-image-id', true ), 'full', "", array( 'class' => 'img-responsive', 'alt' => $term->name, 'itemprop' => 'thumbnailUrl', ' data-qazy' => 'true', 'loading' => 'lazy' ) );
                        } else {
						 	kavkaz_fallback_image();
						} 
						 ?>
                     </a>
                  </div>
                  <?php if( $term->count > 0 ){ ?>
                  <div class="listing-counter"><span><?php echo $term->count; ?></span> Uni</div>
                  <?php } ?> 
                  <div class="listing-item-cat">
                     <h3><a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a></h3>
                  </div>
               </div>
            </div>
            <?php endforeach; ?>
         </div>
         <div class="swiper-pagination"></div>
      </div>
   </div>
</section>
<?php endif; ?>