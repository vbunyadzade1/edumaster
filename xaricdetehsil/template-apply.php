<?php

/* Template Name: Apply */
   
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if (isset($_POST))
{
	if (!empty($_POST['form_subject'])) return;
	
    if (!empty($_POST["apply_name"]) && !empty($_POST["apply_email"]) && !empty($_POST["apply_phone"]) && !empty($_POST["apply_country"]))
    {
		$main = "MIME-Version: 1.0" . "\r\n";
		$main .= "Content-type:text/html;charset=UTF-8" . "\r\n";		

		$main_user = "MIME-Version: 1.0" . "\r\n";
		$main_user .= "Content-type:text/html;charset=UTF-8" . "\r\n";	
		
        $apply_name = sanitize_text_field($_POST["apply_name"]);
        $apply_email = sanitize_email($_POST["apply_email"]);
        $apply_phone = sanitize_text_field($_POST["apply_phone"]);
        $apply_location = sanitize_text_field($_POST["apply_location"]);		
        $apply_country = sanitize_text_field($_POST["apply_country"]);
        $apply_year = sanitize_text_field($_POST["apply_year"]);
        $apply_type = sanitize_text_field($_POST["apply_type"]);		
        $apply_degree = sanitize_text_field($_POST["apply_degree"]);	
        $apply_message = sanitize_text_field($_POST["apply_message"]);	
		
        if (kavkaz_get_option('mail_from_email'))
        {
            $mail_to = sanitize_email(kavkaz_get_option('mail_from_email'));
        }
        else
        {
            $mail_to = sanitize_email(kavkaz_get_option('contact_form_email'));
        }

        $apply_form = "<div style='padding: 15px;background: #f67280;color: #fff;border-radius: 10px 10px 0 0;'>Xaricde Tehsil</div><div style='padding: 15px;background: #ffffff;box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);-webkit-box-shadow: 0px 8px 11px 4px rgba(158, 158, 158, 0.1);border-radius: 10px;'><hr><strong>Ad Soyad: </strong>" . $apply_name . "<hr><strong>Email: </strong>" . $apply_email . "<hr><strong>Telefon(Whatsapp): </strong>" . $apply_phone . "<hr><strong>Yaşadığınız bölgə: </strong>" . $apply_location . "<hr><strong>Təhsil almaq istediyiniz ölkə: </strong>" . $apply_country . "<hr><strong>Qəbul ili: </strong>" . $apply_year . "<hr><strong>Təhsil növü: </strong>" . $apply_type . "<hr><strong>Təhsil dərəcəsini seç: </strong>" . $apply_degree . "<hr><strong>Mesaj: </strong>" . $apply_message . "</div>";

        $main .= "From: " . $apply_name . " <" . $apply_email . ">";
        $main_user .= "From: Edumaster.Az <" . $mail_to . ">";
		
        wp_mail($mail_to, "Edumaster.Az - Müraciət Formu", $apply_form, $main);
        wp_mail($apply_email, "Edumaster.Az - Müraciət Formu", $apply_form, $main_user);
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
<section class="contact-area pt-100 pb-70">
   <div class="container">
      <div class="section-title">
         <span class="sub-title">XARİCDƏ TƏSİL ALMAQ FORMU</span>
         <h2>Arzularını Gerçəkləşdirmək öz əlindədir!</h2>
         <p>Xaricde tehsil almaq istədiyin ölkəni və öz məlumatlarını forma daxil edərək bizə müracət edə bilərsiniz. Müraciətinizə uyğun xaricdə təhsil mütəxəssisi sizinlə əlaqə saxlayacaq və arzularınızı gerçəkləşdirmək üçün yardımcınız olacaq. </p>
      </div>
      <div class="contact-form">
         <div class="form-messege"></div>
         <form id="applyForm" action="" method="post" autocomplete="off">
            <div class="row">
               <div class="gorsenme form-input">
               	<input type="text" id="form_subject" name="form_subject">
               </div>					
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="text" name="apply_name" id="apply_name" class="form-control" placeholder="Ad Soyad">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="email" name="apply_email" id="apply_email" class="form-control" placeholder="Email">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="number" name="apply_phone" id="apply_phone" class="form-control" placeholder="Nömrə (Whatsapp)">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="text" name="apply_location" id="apply_location" class="form-control" placeholder="Yaşadığınız bölgə">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="text" name="apply_country" id="apply_country" class="form-control" placeholder="Təhsil almaq istediyiniz ölkə">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <input type="text" name="apply_year" id="apply_year" class="form-control" placeholder="Qəbul ili">
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <label>Təhsil növü <span class="required">*</span></label>
                     <div class="select-box">
                        <select class="form-control" name="apply_type" id="apply_type">
                           <option value="Əyani">Əyani</option>
                           <option value="Qiyabi">Qiyabi</option>
                           <option value="Distant">Distant</option>
                           <option value="Hamısı">Hamısı</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                     <label>Təhsil dərəcəsini seç <span class="required">*</span></label>
                     <div class="select-box">
                        <select class="form-control" name="apply_degree" id="apply_degree">
                           <option value="Bakalavr">Bakalavr</option>
                           <option value="Magistatura">Magistatura</option>
                           <option value="PHD">PHD</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <div class="form-group">
                     <textarea name="apply_message" class="form-control" id="apply_message" cols="30" rows="5" placeholder="Əlavə qeydləriniz"></textarea>
                  </div>
               </div>
               <div class="col-lg-12 col-md-12">
                  <button type="submit" class="default-btn"><i class='bx bx-paper-plane icon-arrow before'></i><span class="label">Göndər</span><i class="bx bx-paper-plane icon-arrow after"></i></button>
                  <?php wp_nonce_field( 'aaplyForm_form_main', 'aaplyForm_form' ); ?>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div id="particles-js-circle-bubble-3"></div>
</section>
<?php get_footer(); ?>