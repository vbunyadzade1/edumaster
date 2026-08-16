<?php

/* Template Name: Contact */
   
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if (isset($_POST))
{
	if (!empty($_POST['form_subject'])) return;
	
    if (!empty($_POST["contact_name"]) && !empty($_POST["contact_email"]) && !empty($_POST["contact_phone"]) && !empty($_POST["contact_subject"]) && !empty($_POST["contact_message"]))
    {
		$main = "MIME-Version: 1.0" . "\r\n";
		$main .= "Content-type:text/html;charset=UTF-8" . "\r\n";		

		$main_user = "MIME-Version: 1.0" . "\r\n";
		$main_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $contact_name = sanitize_text_field($_POST["contact_name"]);
        $contact_email = sanitize_email($_POST["contact_email"]);
        $contact_phone = sanitize_text_field($_POST["contact_phone"]);
        $contact_subject = sanitize_text_field($_POST["contact_subject"]);		
        $contact_message = sanitize_text_field($_POST["contact_message"]);

        if (kavkaz_get_option('mail_from_email'))
        {
            $mail_to = sanitize_email(kavkaz_get_option('mail_from_email'));
        }
        else
        {
            $mail_to = sanitize_email(kavkaz_get_option('contact_form_email'));
        }

        $contact_form = "<div style='padding: 15px;background: #f67280;color: #fff;border-radius: 10px 10px 0 0;'>Xaricde Tehsil</div><div style='padding: 15px;background: #ffffff;box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);-webkit-box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);border-radius: 10px;'><hr><strong>Ad Soyad: </strong>" . $contact_name . "<hr><strong>Nömrə: </strong>" . $contact_phone . "<hr><strong>Mövzu: </strong>" . $contact_subject . "<hr><strong>Email: </strong>" . $contact_email . "<hr><strong>Mesaj: </strong>" . $contact_message . "</div>";

        $main .= "From: " . $contact_name . " <" . $contact_email . ">";
        $main_user .= "From: Edumaster.Az <" . $mail_to . ">";
		
        wp_mail($mail_to, "Edumaster.Az - Əlaqə Formu", $contact_form, $main);
        wp_mail($contact_email, "Edumaster.Az - Əlaqə Formu", $contact_form, $main_user);
		
    }

}
   
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
            <li><?php echo get_the_title(); ?></li>
         </ul>
         <h1><?php echo get_the_title(); ?></h1>
      </div>
   </div>
</div>
<section class="contact-info-area pt-100 pb-70">
   <div class="container">
      <div class="row">
         <?php if(kavkaz_get_option('display_contact_email')) { ?>	 
         <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="contact-info-box mb-30">
               <div class="icon">
                  <i class='bx bx-envelope'></i>
               </div>
               <h3>Bizə Yaz</h3>
               <p><a href="mailto:<?php echo kavkaz_get_option( 'contact_email' ); ?>"><?php echo kavkaz_get_option( 'contact_email' ); ?></a></p>
            </div>
         </div>
         <?php } ?>
         <?php if(kavkaz_get_option('display_contact_address')) { ?>	
         <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="contact-info-box mb-30">
               <div class="icon">
                  <i class='bx bx-map'></i>
               </div>
               <h3>Bizə Gəl</h3>
               <p><a href="#"><?php echo kavkaz_get_option( 'contact_address' ); ?></a></p>
            </div>
         </div>
         <?php } ?>
         <?php if(kavkaz_get_option('display_contact_number')) { ?>
         <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
            <div class="contact-info-box mb-30">
               <div class="icon">
                  <i class='bx bx-phone-call'></i>
               </div>
               <h3>Bizə Zəng Et</h3>
               <p><a href="tel:<?php echo kavkaz_get_option( 'contact_number' ); ?>"><?php echo kavkaz_get_option( 'contact_number' ); ?></a></p>
            </div>
         </div>
         <?php } ?>
      </div>
   </div>
   <div id="particles-js-circle-bubble-2"></div>
</section>
<section class="contact-area pb-100">
   <div class="container">
      <div class="section-title">
         <span class="sub-title">XARİCDƏ TƏSİL ALMAQ</span>
         <h2>HAMININ ARZUSUDUR</h2>
         <p>Xaricde tehsil elaqe vasitələri ilə bizə müraciət edə bilər və xəyallarınızdakı universitet, ölkədə təhsil ala bilərsiniz. </p>
      </div>
      <div class="contact-form">
		 <div class="form-messege"></div>
         <form id="contactForm" action="" method="post" autocomplete="off">
            <div class="row">
               <div class="gorsenme form-input">
                  <input type="text" id="form_subject" name="form_subject">
               </div>					
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="text" name="contact_name" id="contact_name" class="form-control" placeholder="Ad Soyad">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="email" name="contact_email" id="contact_email" class="form-control" placeholder="Email">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="text" name="contact_phone" id="contact_phone" class="form-control" placeholder="Nömrə">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="text" name="contact_subject" id="contact_subject" class="form-control" placeholder="Mövzu">
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <textarea name="contact_message" class="form-control" id="contact_message" cols="30" rows="5" placeholder="Mesaj"></textarea>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <button type="submit" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">Göndər</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
			     <?php wp_nonce_field( 'contactForm_form_main', 'contactForm_form' ); ?>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div id="particles-js-circle-bubble-3"></div>
</section>
<div id="map">
   <iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=baku&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</div>
<?php get_footer(); ?>