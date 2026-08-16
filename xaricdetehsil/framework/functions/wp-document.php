<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Custom Theme Color
/*-----------------------------------------------------------------------------------*/
function kavkaz_theme_color( $color ){ ?>

::-webkit-scrollbar-thumb{
	background-color:<?php echo $color; ?> !important;
}

<?php
}


/*-----------------------------------------------------------------------------------*/
# Wp Head
/*-----------------------------------------------------------------------------------*/
add_action('wp_head', 'kavkaz_wp_head');
function kavkaz_wp_head() {
?>

<?php if ( kavkaz_get_option( 'enable_preload' ) ) : ?>
<link rel="preload" href="<?php bloginfo('template_directory'); ?>/assets/fonts/fontAwesomePro/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?php bloginfo('template_directory'); ?>/assets/fonts/fontAwesomePro/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?php bloginfo('template_directory'); ?>/assets/fonts/fontAwesomePro/fa-regular-400.woff2" as="font" type="font/woff2" crossorigin>	
<link rel="preload" href="<?php bloginfo('template_directory'); ?>/assets/fonts/fontAwesomePro/fa-light-300.woff2" as="font" type="font/woff2" crossorigin>
<?php endif; ?>

<?php
// Custom Header Code
echo htmlspecialchars_decode( kavkaz_get_option('header_code') ) , "\n";

?>
<?php if( kavkaz_get_option('css') || kavkaz_get_option('css_tablets') || kavkaz_get_option('css_wide_phones') || kavkaz_get_option('css_phones') ): ?>
<style type="text/css" media="screen">

<?php //Fonts

if (function_exists('kavkaz_get_font')) :

foreach( $custom_typography as $selector => $value){
	$option = kavkaz_get_option( $value );
	if( !empty( $option['font'] ) || !empty( $option['color'] ) || !empty( $option['size'] ) || !empty( $option['weight'] ) || !empty( $option['style'] ) ) {

	echo $selector."{\n"; ?>
	
<?php if( !empty( $option['font'] ) )
	echo "	font-family: ". kavkaz_get_font( $option['font']  ).";\n"?>
<?php if( !empty( $option['color'] ) )
	echo "	color :". $option['color'].";\n"?>
<?php if( !empty( $option['size'] ) )
	echo "	font-size : ".$option['size']."px;\n"?>
<?php if( !empty( $option['weight'] ) )
	echo "	font-weight: ".$option['weight'].";\n"?>
<?php if( !empty( $option['style'] ) )
	echo "	font-style: ". $option['style'].";\n"?>
}

<?php

}

}

endif;


// Modern Scrollbar  -------------------------------------------------------------- */
if(kavkaz_get_option('modern_scrollbar')) : ?>
::-webkit-scrollbar {
	width: 8px;
	height:8px;
}

<?php endif;



//highlighted color  --------------------------------------------------------------------------- */
if( kavkaz_get_option( 'highlighted_color' ) ): ?>

::-moz-selection { background: <?php echo kavkaz_get_option( 'highlighted_color' ) ?>;}
::selection { background: <?php echo kavkaz_get_option( 'highlighted_color' ) ?>; }
<?php endif;



// Theme Skin --------------------------------------------------------------------- */
if( kavkaz_get_option( 'global_color' ) )
	kavkaz_theme_color( kavkaz_get_option( 'global_color' ) );

elseif(kavkaz_get_option('theme_skin'))
	kavkaz_theme_color(kavkaz_get_option('theme_skin'));



// Links  ------------------------------------------------------------------------- */
$links_styling = array (
	"a"			=>	array (	'color' => 'links_color', 'decoration'=> 'links_decoration'	),
	"a:hover"	=>	array (	'color' => 'links_color_hover', 'decoration'=> 'links_decoration_hover'),
	"body.single .post .entry a, body.page .post .entry a"				=>	array ( 'color' => 'post_links_color', 'decoration'=> 'post_links_decoration' ),
	"body.single .post .entry a:hover, body.page .post .entry a:hover"	=>	array ( 'color' => 'post_links_color_hover', 'decoration'=> 'post_links_decoration_hover' )
);

foreach ( $links_styling as $selector => $values ){
	if( kavkaz_get_option( $values[ "color" ] ) || kavkaz_get_option( $values[ "decoration" ] ) ){

		echo "\n".$selector." {\n";
		if( kavkaz_get_option( $values[ "color" ] ) ) echo "	color: ".kavkaz_get_option( $values[ "color" ] ).";\n";
		if( kavkaz_get_option( $values[ "decoration" ] ) ) echo "	text-decoration: ".kavkaz_get_option( $values[ "decoration" ] ).";\n";
		echo '}
		';

	}
}

$pre_code = array("<pre>", "</pre>");

// Custom CSS Codes  ----------------------------------------------------- */
echo "\n".str_replace( $pre_code , "", htmlspecialchars_decode( kavkaz_get_option('css')) );

if( kavkaz_get_option('css_tablets') ) : ?>


@media only screen and (max-width: 985px) and (min-width: 768px){
<?php
	echo "\t".str_replace( $pre_code , "", htmlspecialchars_decode( kavkaz_get_option('css_tablets')) );
?>

}

<?php endif;

if( kavkaz_get_option('css_wide_phones') ) : ?>
@media only screen and (max-width: 767px) and (min-width: 480px){
<?php
	echo "\t".str_replace( $pre_code , "", htmlspecialchars_decode( kavkaz_get_option('css_wide_phones')) );
?>

}

<?php endif;

if( kavkaz_get_option('css_phones') ) : ?>
@media only screen and (max-width: 479px) and (min-width: 320px){
<?php
	echo "\t".str_replace( $pre_code , "", htmlspecialchars_decode( kavkaz_get_option('css_phones')) );
?>

}

<?php endif; ?>
</style>
<?php endif; ?>
<?php

}

/*-----------------------------------------------------------------------------------*/
# Wp Footer
/*-----------------------------------------------------------------------------------*/
add_action('wp_footer', 'kavkaz_wp_footer');
function kavkaz_wp_footer() {
	if ( kavkaz_get_option('footer_code')) echo htmlspecialchars_decode( stripslashes(kavkaz_get_option('footer_code') ));

}

?>