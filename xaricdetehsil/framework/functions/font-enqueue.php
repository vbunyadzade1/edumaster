<?php

defined('ABSPATH') || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# Enqueue Fonts From Google
/*-----------------------------------------------------------------------------------*/
function kavkaz_enqueue_font ( $got_font) {
	if ($got_font) {

		$char_set = '';
		if( kavkaz_get_option('typography_latin_extended') || kavkaz_get_option('typography_cyrillic') ||
		kavkaz_get_option('typography_cyrillic_extended') || kavkaz_get_option('typography_greek') ||
		kavkaz_get_option('typography_greek_extended') || kavkaz_get_option('typography_vietnamese') || kavkaz_get_option('typography_khmer') ){

			$char_set = '&subset=latin';
			if( kavkaz_get_option('typography_latin_extended') )
				$char_set .= ',latin-ext';
			if( kavkaz_get_option('typography_cyrillic') )
				$char_set .= ',cyrillic';
			if( kavkaz_get_option('typography_cyrillic_extended') )
				$char_set .= ',cyrillic-ext';
			if( kavkaz_get_option('typography_greek') )
				$char_set .= ',greek';
			if( kavkaz_get_option('typography_greek_extended') )
				$char_set .= ',greek-ext';
			if( kavkaz_get_option('typography_khmer') )
				$char_set .= ',khmer';
			if( kavkaz_get_option('typography_vietnamese') )
				$char_set .= ',vietnamese';
		}

		$font_pieces = explode(":", $got_font);
		$font_name = $font_pieces[0];
		$font_type = $font_pieces[1];
		$font_name = str_replace (" ","+", $font_pieces[0] );
		$font_variants = str_replace ("|",",", $font_pieces[1] );
		$protocol = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( $font_name , $protocol.'://fonts.googleapis.com/css?family='.$font_name . ':' . $font_variants.$char_set );
		
	}
}


/*-----------------------------------------------------------------------------------*/
# Get Font Name
/*-----------------------------------------------------------------------------------*/
function kavkaz_get_font ( $got_font ) {
	if ($got_font) {
		$font_pieces = explode(":", $got_font);
		$font_name = $font_pieces[0];
		$font_name = str_replace('&quot;' , '"' , $font_pieces[0] );
		if (strpos($font_name, ',') !== false)
			return $font_name;
		else
			return "'".$font_name."'";
	}
}


/*-----------------------------------------------------------------------------------*/
# Typography Elements Array
/*-----------------------------------------------------------------------------------*/
$custom_typography = array(
	"body" => "typography_general"
);


/*-----------------------------------------------------------------------------------*/
# Get Custom Typography
/*-----------------------------------------------------------------------------------*/
add_action('wp_enqueue_scripts', 'kavkaz_typography');
function kavkaz_typography(){
	global $custom_typography;

	foreach( $custom_typography as $selector => $value){
		$option = kavkaz_get_option( $value );
		if( !empty($option['font']))
			kavkaz_enqueue_font( $option['font'] );
	}
}

?>