<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if (isset($_POST))
{
	if (!empty($_POST['form_subject'])) return;
	
    if (!empty($_POST["user_name"]) && !empty($_POST["user_address"]) && !empty($_POST["user_email"]) && !empty($_POST["user_phone"]) && !empty($_POST["user_comment"]))
    {
		$main = "MIME-Version: 1.0" . "\r\n";
		$main .= "Content-type:text/html;charset=UTF-8" . "\r\n";		

		$main_user = "MIME-Version: 1.0" . "\r\n";
		$main_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";	

        $user_name = sanitize_text_field($_POST["user_name"]);
        $user_address = sanitize_text_field($_POST["user_address"]);
        $user_email = sanitize_email($_POST["user_email"]);
        $user_phone = sanitize_text_field($_POST["user_phone"]);
        $user_comment = sanitize_text_field($_POST["user_comment"]);
		
        if (kavkaz_get_option('mail_from_email'))
        {
            $mail_to = sanitize_email(kavkaz_get_option('mail_from_email'));
        }
        else
        {
            $mail_to = sanitize_email(kavkaz_get_option('contact_form_email'));
        }

        $contact_form = "<div style='padding: 15px;background: #ff1949;color: #fff;border-radius: 10px 10px 0 0;'>Xaricde Tehsil</div><div style='padding: 15px;background: #ffffff;box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);-webkit-box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);border-radius: 10px;'><hr><strong>" . __kavkaztext('Ad Soyad: ') .  "</strong>" . $user_name . "<hr><strong>" . __kavkaztext('Ünvan: ') .  "</strong>" . $user_address . "<hr><strong>" . __kavkaztext('Email: ') .  "</strong>" . $user_email . "<hr><strong>" . __kavkaztext('Telefon:') .  "</strong>" . $user_phone . "<hr><strong>" . __kavkaztext('Qeydlər: ') .  "</strong>" . $user_comment . "</div>";

        $main .= "From: " . $user_name . " <" . $user_email . ">";
        $main_user .= "From: Edumaster.Az <" . $mail_to . ">";	
		
        wp_mail($mail_to, "Edumaster.Az - Zəng Müraciət Formu", $contact_form, $main);
        wp_mail($user_email, "Edumaster.Az - Zəng Müraciət Formu", $contact_form, $main_user);
		
    }

}

?>
<section class="banner-wrapper">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-lg-6 col-md-12">
            <div class="wrapper-content">
               <h1>Xaricdə təhsil</h1>
			   <span class="as-h1">ilə daha fərqli gələcək!</span>
               <p>İstədiyin xarici ölkədə təhsil almanız üçün sizə yardımcı olaq. Xaricdə təhsil şirkəti olaraq peşəkar mütəxəssislər, rəsmi əməkdaşlıqlarla xidmətinizdəyik. Arzularınızı gerçəkləşdirməyin vaxtıdır!</p>
               <form action="<?php echo home_url('/'); ?>" method="get">
                  <input type="text" name="s" id="s" class="input-search" placeholder="Nəyi bilmək istərdin?" required>
                  <button type="submit">Axtar</button>
               </form>
            </div>
         </div>
         <div class="col-lg-6 col-md-12">
            <div class="banner-courses-category">
               <div class="students-feedback-form">
                  <h3>Zəng Müraciət Formu</h3>
				  <div class="form-messege"></div>
                  <form id="muraciet_formu" action="" method="post" autocomplete="off">
                     <div class="row">
                        <div class="gorsenme form-input">
                           <input type="text" id="form_subject" name="form_subject">
                        </div>						 
                        <div class="col-lg-6 col-md-6">
                           <div class="form-group">
                              <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Adınız*">
                              <span class="label-title"><i class='bx bx-user'></i></span>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="form-group">
                              <input type="text" name="user_address" id="user_address" class="form-control" placeholder="Ünvanınız (şəhər)*">
                              <span class="label-title"><i class='bx bx-home'></i></span>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="form-group">
                              <input type="email" name="user_email" id="user_email" class="form-control" placeholder="E-mailin*">
                              <span class="label-title"><i class='bx bx-envelope'></i></span>
                           </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <div class="form-group">
                              <input type="tel" name="user_phone" id="user_phone" class="form-control" placeholder="Nömrəniz*">
                              <span class="label-title"><i class='bx bx-phone'></i></span>
                           </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                           <div class="form-group">
                              <textarea cols="30" rows="5" name="user_comment" id="user_comment" class="form-control" placeholder="Təhsil arzuların haqqında qeydlər"></textarea>
                              <span class="label-title"><i class='bx bx-edit'></i></span>
                           </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                           <button type="submit" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">Müraciət et</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
						<?php wp_nonce_field( 'booking_form_main', 'booking_form' ); ?>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>