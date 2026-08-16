<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<footer id="wpfooter" class="footer-area" itemscope itemtype="https://schema.org/WPFooter">
   <div class="container">
      <div class="row">
         <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="single-footer-widget mb-30">
               <h3>Əlaqə</h3>
               <ul class="contact-us-link">
                  <?php if(kavkaz_get_option('display_contact_address')) { ?>	
                  <li>
                     <i class='bx bx-map'></i>
                     <?php echo kavkaz_get_option( 'contact_address' ); ?>
                  </li>
                  <?php } ?>
                  <?php if(kavkaz_get_option('display_contact_number')) { ?>
                  <li>
                     <i class='bx bx-phone-call'></i>
                     <a href="tel:<?php echo kavkaz_get_option( 'contact_number' ); ?>"><?php echo kavkaz_get_option( 'contact_number' ); ?></a>
                  </li>
                  <?php } ?>
                  <?php if(kavkaz_get_option('display_contact_email')) { ?>	     
                  <li>
                     <i class='bx bx-envelope'></i>
                     <a href="mailto:<?php echo kavkaz_get_option( 'contact_email' ); ?>"><?php echo kavkaz_get_option( 'contact_email' ); ?></a>
                  </li>
                  <?php } ?>
               </ul>
               <ul class="social-link">
                  <?php if(kavkaz_get_option('facebook_url')) { ?>
                  <li><a href="<?php echo kavkaz_get_option( 'facebook_url' ); ?>" class="d-block" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                  <?php } ?>
                  <?php if(kavkaz_get_option('twitter_url')) { ?>	
                  <li><a href="<?php echo kavkaz_get_option( 'twitter_url' ); ?>" class="d-block" target="_blank"><i class='bx bxl-twitter'></i></a></li>
                  <?php } ?>
                  <?php if(kavkaz_get_option('instagram_url')) { ?>	
                  <li><a href="<?php echo kavkaz_get_option( 'instagram_url' ); ?>" class="d-block" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                  <?php } ?>
                  <?php if(kavkaz_get_option('linkedin_url')) { ?>	
                  <li><a href="<?php echo kavkaz_get_option( 'linkedin_url' ); ?>" class="d-block" target="_blank"><i class='bx bxl-linkedin'></i></a></li>
                  <?php } ?>    
                  <?php if(kavkaz_get_option('youtube_url')) { ?>
                  <li><a href="<?php echo kavkaz_get_option( 'youtube_url' ); ?>" class="d-block" target="_blank"><i class='bx bxl-pinterest-alt'></i></a></li>
                  <?php } ?>
                  <?php if(kavkaz_get_option('whatsapp')) { ?>
                  <li><a href="https://wa.me/<?php echo kavkaz_get_option( 'whatsapp' ); ?>" class="d-block"><i class='bx bxl-whatsapp'></i></a></li>
                  <?php } ?>				   
               </ul>
            </div>
         </div>
         <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="single-footer-widget mb-30">
               <h3>Əsas səhifələr</h3>
               <ul class="support-link">
                  <li><a href="https://edumaster.az/olkeler/">Xaricdə təhsil ölkələr</a></li>
                  <li><a href="https://edumaster.az/universitetler/#">Universitetlər</a></li>
                  <li><a href="https://edumaster.az/bloqlar/">Bloqlar</a></li>
               </ul>
            </div>
         </div>
         <div class="col-lg-2 col-md-6 col-sm-6">
            <div class="single-footer-widget mb-30">
               <h3>Məlumat səhifələri</h3>
               <ul class="useful-link">
                  <li><a href="https://edumaster.az/haqqimizda">Haqqımızda</a></li>
                  <li><a href="https://edumaster.az/%c9%99laq%c9%99/">Əlaqə</a></li>
               </ul>
            </div>
         </div>
         <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="single-footer-widget mb-30">
               <h3>Xəbərlər</h3>
               <div class="newsletter-box">
                  <p>Ən yeni xaricdə təhsil yazılarından xəbərdar ol!</p>
                  <form class="newsletter-form" data-bs-toggle="validator">
                     <label>E-mail ünvanınız:</label>
                     <input type="email" class="input-newsletter" placeholder="Email ilə abonə ol." name="EMAIL" required="" autocomplete="off">
                     <button type="submit">Abonə ol</button>
                     <div id="validator-newsletter" class="form-result"></div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="footer-bottom-area">
      <div class="container">
         <div class="logo">
            <?php if( kavkaz_get_option('logo_setting') == 'logo' ): ?>
            <a title="<?php bloginfo('name'); ?>" href="<?php echo home_url('/'); ?>" class="d-inline-block">
            <img src="<?php echo kavkaz_get_option( 'logo_header' ); ?>" width="164" height="45" alt="<?php bloginfo('name'); ?>" title="<?php bloginfo('name'); ?>">
            </a>
            <?php elseif( kavkaz_get_option('logo_setting') == 'title' ): ?>	  
            <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" class="d-inline-block">
               <div class="logo-title"><?php bloginfo('name'); ?></div>
            </a>
            <?php endif; ?>
         </div>
         <p>
            <?php
               $footer_vars = array('%year%' , '%site%' , '%url%');
               $footer_val  = array( date('Y') , get_bloginfo('name') , home_url() );
               $footer_one  = str_replace( $footer_vars , $footer_val , kavkaz_get_option( 'footer_one' ));
               echo htmlspecialchars_decode( $footer_one );
               ?>
         </p>
      </div>
   </div>
</footer>
<?php if( kavkaz_get_option('back_top') ): ?>
<div class="go-top"><i class='bx bx-up-arrow-alt'></i></div>
<?php endif; ?>
<?php wp_footer(); ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K7SQWVN"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
</body>
</html>