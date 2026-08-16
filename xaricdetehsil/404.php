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
               <span itemprop="name">Ana Səhifə</span>
               </a>
               <meta itemprop="position" content="1">
            </li>
            <li>Axtardığınız səhifə tapılmadı!</li>
         </ul>
         <h1>Axtardığınız səhifə tapılmadı!</h1>
      </div>
   </div>
</div>
<div class="error-404-area">
   <div class="container">
      <div class="notfound">
         <div class="notfound-bg">
            <div></div>
            <div></div>
            <div></div>
         </div>
         <h1>Oops!</h1>
         <h3>Error 404 : Səhifə tapılmadı!</h3>
         <p>Bu səhifə ya silinib ya da axtarışınıza uyğun nəticə yoxdur. Xaiş edirik yenidən yoxlayın.</p>
         <a href="<?php echo home_url('/'); ?>" class="default-btn">
			 <i class='bx bx-home-circle icon-arrow before'></i><span class="label">Əsas səhifə</span><i class="bx bx-home-circle icon-arrow after"></i>
		  </a>
      </div>
   </div>
</div>
<?php get_footer(); ?>