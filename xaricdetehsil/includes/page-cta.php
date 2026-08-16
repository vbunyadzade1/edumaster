<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<!-- Cta Section Start -->
<section class="cta-image-area_one cta-bg-image_two">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-xl-7 col-lg-7">
            <div class="cta-content md-text-center">
               <h3 class="heading">Xaricdə Təhsil Üçün <span class="text-color-primary">Müraciət Et</span></h3>
            </div>
         </div>
         <div class="col-xl-5 col-lg-5">
            <div class="cta-button-group--two text-center-flex">
               <?php if(kavkaz_get_option('contact_number')) { ?>
               <a href="https://edumaster.az/xaricde-tehsil-muraciet/" class="btn btn--white btn-one">Müraciət Et</a>
               <?php } ?>
               <?php if(kavkaz_get_option('whatsapp')) { ?>
               <a href="https://wa.me/<?php echo kavkaz_get_option( 'whatsapp' ); ?>" class="btn btn--secondary btn-two ">Wp ilə yaz</a>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Cta Section End -->