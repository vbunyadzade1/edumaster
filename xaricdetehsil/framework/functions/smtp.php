<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*-----------------------------------------------------------------------------------*/
# SMTP
/*-----------------------------------------------------------------------------------*/
add_action( 'phpmailer_init', 'kavkaz_phpmailer_init' );
function kavkaz_phpmailer_init( $phpmailer ) {
    $phpmailer->Host = kavkaz_get_option('smtp_host');
    $phpmailer->Port = kavkaz_get_option('smtp_port');
    $phpmailer->Username = kavkaz_get_option('smtp_username');
    $phpmailer->Password = kavkaz_get_option('smtp_password');
    $phpmailer->SMTPAuth = kavkaz_get_option('smtp_authentication'); 
	$variable = kavkaz_get_option('smtp_encryption');
    switch ($variable) {
        case 'ssl':
            $phpmailer->SMTPSecure = 'ssl';
            break;
        case 'tls':
            $phpmailer->SMTPSecure = 'tls';
            break;        
        case 'none':
            //$phpmailer->SMTPSecure = '';
            break;
    }	
    $phpmailer->IsSMTP();
}

?>