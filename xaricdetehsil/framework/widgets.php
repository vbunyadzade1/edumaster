<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

## Main Widgets ------------------------------------------------------------
add_action( 'widgets_init', 'kavkaz_widgets_init' );
function kavkaz_widgets_init() {
	$before_widget =  '<div class="sidebar-widget">';
	$after_widget  =  '</div>';
	$before_title  =  '<h3 class="sidebar-widget-title mb-2">';
	$after_title   =  '</h3>';

	register_sidebar( array(
		'name' =>  __( 'Primary Widget Area', 'kavkaz' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The Primary widget area', 'kavkaz' ),
		'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
	) );

	//Custom Sidebars
	$sidebars = kavkaz_get_option( 'sidebars' ) ;
	if($sidebars){
		foreach ($sidebars as $sidebar) {
			register_sidebar( array(
				'name' => $sidebar,
				'id' => sanitize_title($sidebar),
				'before_widget' => $before_widget , 'after_widget' => $after_widget , 'before_title' => $before_title , 'after_title' => $after_title ,
			) );
		}
	}
}

## Custom Widgets ------------------------------------------------------------
locate_template ('framework/widgets/widget-categories.php', true, true);
locate_template ('framework/widgets/widget-tags.php', true, true);
locate_template ('framework/widgets/widget-category.php', true, true);
locate_template ('framework/widgets/widget-posts.php', true, true);

?>
