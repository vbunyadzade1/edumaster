<?php

/**
 * The template for displaying the header
 *
 *
 *░█▄▀▒▄▀▄░█▒█░█▄▀▒▄▀▄░▀█▀░░░▀█▀░█▄█▒██▀░█▄▒▄█▒██▀
 *░█▒█░█▀█░▀▄▀░█▒█░█▀█░█▄▄▒░░▒█▒▒█▒█░█▄▄░█▒▀▒█░█▄▄
 * 
 * 
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#2991D6">
<meta name="msapplication-navbutton-color" content="#2991D6">
<meta name="apple-mobile-web-app-status-bar-style" content="#2991D6">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<link rel="preconnect" href="https://ajax.googleapis.com" crossorigin />
<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
<link rel="preconnect" href="https://www.googletagmanager.com" crossorigin />
<link rel="preconnect" href="https://www.google.com" crossorigin />
<link rel="preconnect" href="https://www.googleadservices.com" crossorigin />
<link rel="preconnect" href="https://www.google-analytics.com" crossorigin />
<link rel="preconnect" href="https://www.gstatic.com" crossorigin>
<link rel="preconnect" href="https://mc.yandex.ru" crossorigin />
<link rel="dns-prefetch" href="https://ajax.googleapis.com" />
<link rel="dns-prefetch" href="https://fonts.googleapis.com" />
<link rel="dns-prefetch" href="https://www.googletagmanager.com" />
<link rel="dns-prefetch" href="https://www.google.com" />
<link rel="dns-prefetch" href="https://www.googleadservices.com" />
<link rel="dns-prefetch" href="https://www.google-analytics.com" />
<link rel="dns-prefetch" href="https://www.gstatic.com" />
<link rel="dns-prefetch" href="//www.youtube.com" />
<link rel="dns-prefetch" href="https://mc.yandex.ru" />
<link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
<?php if ( kavkaz_get_option('enable_preload') ) : ?>
<link rel="preload" href="<?php echo THEME_URL; ?>/assets/fonts/boxicons.woff2" as="font" type="font/woff2" crossorigin />
<?php endif; ?>
<?php wp_head(); ?>

<meta name="google-site-verification" content="K4fV9clIPxAiRPH4tNrthz2pyvw57j71UO1TCnscvWA" />
<meta name="p:domain_verify" content="219bdad4e90715a5400b23bc1f76e093"/>
<meta name="facebook-domain-verification" content="i4t7mb5xn3blq7d0h41qcf3rbqhzy5" />

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-K7SQWVN');</script>
<!-- End Google Tag Manager -->

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"fmvdx1hT6z20ES", domain:"xaricdetehsil.org",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://certify.alexametrics.com/atrk.gif?account=fmvdx1hT6z20ES" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->  

</head>
<body id="webpage" <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
<meta itemprop="inLanguage" content="<?php echo get_bloginfo("language"); ?>" />

<?php

if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
}

?>
	
<?php if( kavkaz_get_option('theme_preloader') ): ?>
<div class="preloader">
   <div class="loader">
      <div class="shadow"></div>
      <div class="box"></div>
   </div>
</div>
<?php endif; ?>
	
<header id="wpheader" class="header-area p-relative" itemscope itemtype="https://schema.org/WPHeader">
   <div class="navbar-area navbar-style-three">
      <div class="raque-responsive-nav">
         <div class="container">
            <div class="raque-responsive-menu">
               <div class="logo">
                  <?php if( kavkaz_get_option('logo_setting') == 'logo' ): ?>
                  <a title="<?php bloginfo('name'); ?>" href="<?php echo home_url('/'); ?>">
                  </a>
                  <?php elseif( kavkaz_get_option('logo_setting') == 'title' ): ?>	  
                  <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>">
                     <div class="logo-title"><?php bloginfo('name'); ?></div>
                  </a>
                  <?php endif; ?> 
               </div>
            </div>
         </div>
      </div>
      <div class="raque-nav">
         <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
               <?php if( kavkaz_get_option('logo_setting') == 'logo' ): ?>
               <a title="<?php bloginfo('name'); ?>" href="<?php echo home_url('/'); ?>" class="navbar-brand">
               </a>
               <?php elseif( kavkaz_get_option('logo_setting') == 'title' ): ?>	  
               <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" class="navbar-brand">
                  <div class="logo-title"><?php bloginfo('name'); ?></div>
               </a>
               <?php endif; ?> 
               <div class="collapse navbar-collapse mean-menu">
                  <?php
                     if ( has_nav_menu( 'header_menu' ) ){
                     
                       wp_nav_menu( array(
                         'theme_location' => 'header_menu',
                         'container'      => false,
                         'menu_class'     => 'navbar-nav',
                         'fallback_cb'    => '__return_false',
                         'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                         'depth'          => 2,
                         'walker'         => new kavkaz_menu()
                       ) );
                     
                     }
                     
                     ?>
                  <div class="others-option">
                     <div class="search-box d-inline-block">
                        <i class='bx bx-search'></i>
                     </div>
                  </div>
               </div>
            </nav>
         </div>
      </div>
   </div>
   <div class="navbar-area navbar-style-three header-sticky">
      <div class="raque-nav">
         <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
               <?php if( kavkaz_get_option('logo_setting') == 'logo' ): ?>
               <a title="<?php bloginfo('name'); ?>" href="<?php echo home_url('/'); ?>" class="navbar-brand">
               </a>
               <?php elseif( kavkaz_get_option('logo_setting') == 'title' ): ?>	  
               <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?>" class="navbar-brand">
                  <div class="logo-title"><?php bloginfo('name'); ?></div>
               </a>
               <?php endif; ?>  
               <div class="collapse navbar-collapse">
                  <?php
                     if ( has_nav_menu( 'header_menu' ) ){
                     
                       wp_nav_menu( array(
                         'theme_location' => 'header_menu',
                         'container'      => false,
                         'menu_class'     => 'navbar-nav',
                         'fallback_cb'    => '__return_false',
                         'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                         'depth'          => 2,
                         'walker'         => new kavkaz_menu()
                       ) );
                     
                     }
                     
                     ?>
                  <div class="others-option">
                     <div class="search-box d-inline-block">
                        <i class='bx bx-search'></i>
                     </div>
                  </div>
               </div>
            </nav>
         </div>
      </div>
   </div>

<!--Nextsale Pixel-->
<script>(function (w,r){w['NextsaleObject']=r;w[r]=w[r]||function(){(w[r].q = w[r].q || []).push(arguments)};})(window, 'nsio');</script>
<script src="https://sdk.nextsale.io/nextsale.min.js?key=pk_03e7b9f22cb7804a60f119bd960adc1c17c009fb" async></script>
<!--End Nextsale Pixel-->

</header>
<div class="search-overlay">
   <div class="d-table">
      <div class="d-table-cell">
         <div class="search-overlay-layer"></div>
         <div class="search-overlay-layer"></div>
         <div class="search-overlay-layer"></div>
         <div class="search-overlay-close">
            <span class="search-overlay-close-line"></span>
            <span class="search-overlay-close-line"></span>
         </div>
         <div class="search-overlay-form" itemscope itemtype="https://schema.org/WebSite">
			<link itemprop="url" content="<?php echo home_url( '/' ); ?>"/>
            <form action="<?php echo home_url( '/' ); ?>" method="get" itemprop="potentialAction" itemscope itemtype="https://schema.org/SearchAction">
			   <meta itemprop="target" content="<?php echo home_url( '/' ); ?>?s={s}"/>
               <input itemprop="query-input" type="text" name="s" id="s" class="input-search" placeholder="Axtar..." required>
               <button type="submit"><i class='bx bx-search-alt'></i></button>
            </form>
         </div>
      </div>
   </div>
</div>
