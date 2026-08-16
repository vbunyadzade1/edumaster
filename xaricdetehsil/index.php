<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

// banner
get_template_part( 'includes/home-banner' ); 

// countries
get_template_part( 'includes/home-countries' ); 

// universities
get_template_part( 'includes/home-universities-category' ); 

// counter
get_template_part( 'includes/home-counter' ); 

// about
get_template_part( 'includes/home-about' ); 

// courses
get_template_part( 'includes/home-courses' ); 

// how it works
//get_template_part( 'includes/home-howitworks' );

// feedback form
// get_template_part( 'includes/home-feedback' ); 

// faqs
get_template_part( 'includes/home-faqs' ); 

// cta
get_template_part( 'includes/home-cta' ); 

// teem
get_template_part( 'includes/home-teem' ); 

// testimonials
get_template_part( 'includes/home-testimonials' ); 

// partner
get_template_part( 'includes/home-partner' ); 

// news
get_template_part( 'includes/home-news' ); 

get_footer();

?>