<?php

/* Template Name: About */
   
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
   
?>
<div class="page-title-area item-bg2 jarallax" data-jarallax='{"speed": 0.3}'>
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
<section class="about-area ptb-100">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-lg-6 col-md-12">
            <div class="about-image">
               <img src="<?php bloginfo('template_directory'); ?>/assets/img/about/1.jpg" class="shadow" alt="image">
               <img src="<?php bloginfo('template_directory'); ?>/assets/img/about/2.jpg" class="shadow" alt="image">
            </div>
         </div>
         <div class="col-lg-6 col-md-12">
            <div class="about-content">
               <span class="sub-title">Haqqımızda daha çox</span>
               <h2>Xaricdə təhsil şirkəti</h2>
               <h6>Hər Bir ölkə üçün təhsil arzularınızı gerçəkləşdirməyə hazırıq</h6>
               <p>Xaricdə təhsil almaq üçün bizə müraciət edən +200 tələbəni qısa zamanda öz arzularına qovuşdurmaöa nail olmağımızla qürur duuyuruq. Siz də onların sırasında ola bilər və +20 ölkədə təhsil müraciətəini bizə həvalə edə bilərsiniz. </p>
               <p>Xaricde tehsil sirketi olaraq bunlar artıq sizin üçün daha rahatdır. </p>
               <div class="features-text">
                  <h5><i class='bx bx-planet'></i>Sənə nə etmək qalır?</h5>
                  <p>Ancaq bizə müraciət etmək və əməkdaşlarımızın tapşırığına uyğun oalraq sənədlərini toplamaq, bura xaricə getmək üçün çomadanda daxildir :) </p>
               </div>
            </div>
         </div>
      </div>
      <div class="about-inner-area">
         <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
               <div class="about-text">
                  <h3> +300 Müraciət edən tələbə</h3>
                  <p> 300 dən çox tələbə bizə güvənərək müraciət etdi və aşağıdakı ölkələrdə təhsillərini davam etdirirlər</p>
                  <ul class="features-list">
                     <li><i class='bx bx-check'></i> Türkiyədə</li>
                     <li><i class='bx bx-check'></i> İtalya</li>
                     <li><i class='bx bx-check'></i> Amerika</li>
                     <li><i class='bx bx-check'></i> Ukraniya</li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
               <div class="about-text">
                  <h3>Top Universitetlət</h3>
                  <p>Bu univesitetlərə qəbullar almışıq ki tələbələr tam razı və xoşbəxtdirlər</p>
                  <ul class="features-list">
                     <li><i class='bx bx-check'></i> Sapienza</li>
                     <li><i class='bx bx-check'></i> Harvard</li>
                     <li><i class='bx bx-check'></i> Atatürk universiteti</li>
                     <li><i class='bx bx-check'></i> Milano</li>
                  </ul>
               </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-0 offset-md-3 offset-sm-3">
               <div class="about-text">
                  <h3>Biz nəyi qarşılayırıq</h3>
                  <p>Real innovations and a positive customer experience are the heart of successful communication.</p>
                  <ul class="features-list">
                     <li><i class='bx bx-check'></i> Qəbul Prosesi </li><li><i class='bx bx-check'></i> Motivasiya məktubu</li>
                     <li><i class='bx bx-check'></i> Konsultasiya</li>
                     <li><i class='bx bx-check'></i> Qarşılanma</li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="mission-area ptb-100 jarallax" data-jarallax='{"speed": 0.3}'>
   <div class="container">
      <div class="mission-content">
         <div class="section-title text-left">
            <span class="sub-title">Bizim Misiyamız</span>
            <h2>Ən yaxşı xaricde tehsil sirketi olmaq</h2>
         </div>
         <div class="mission-slides owl-carousel owl-theme">
            <div>
               <h3>Bunun üçün nə edirik?</h3>
               <p>Hər tələbə üçün maksimum vaxt ayıraraq onun tələblərinə uyğun seçimləri edir və dəstək oluruq.</p>
               <p>İstədiyi ölkədə ən yaxşı universitet seçməsi və öz potensialına uyğun təhsilə nail olmasına zamin yaradırıq.</p>
               <a href="xaricdetehsil.org" class="default-btn"><i class='bx bx-user-pin icon-arrow before'></i><span class="label">Daha ətraflı</span><i class="bx bx-user-pin icon-arrow after"></i></a>
            </div>
            <div>
               <h3>Nəticələr necədir?</h3>
               <p>Aldığımız hər bir qəbul müraciət edən şəxsin istəklərinə uyğundur. </p>
               <p>Göndərdiyimiz müraciətlər tələbənin potensialəna uyğun ən yaxşı universitet tərəfindən müsbət dəyərləndirilir</p>
               <a href="xaricdetehsil.org" class="default-btn"><i class='bx bx-user-pin icon-arrow before'></i><span class="label">Daha çoxu</span><i class="bx bx-user-pin icon-arrow after"></i></a>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="story-area ptb-100">
   <div class="container">
      <div class="row">
         <div class="col-lg-4 col-md-12">
            <div class="section-title text-left">
               <h2>Xaricdə təhsil üçün hərşey burada</h2>
            </div>
         </div>
         <div class="col-lg-8 col-md-12">
            <div class="story-content">
               <h3>Bizim vədlərimiz</h3>
               <p>Bizə güvənib seçim edənlər keyfiyyət və rahatlığa da tam əmin olurlar. </p>
              
            </div>
         </div>
      </div>
   </div>
</section>
<section class="funfacts-area">
   <div class="container">
      <div class="funfacts-inner">
         <div class="row">
            <div class="col-lg-3 col-md-3 col-6">
               <div class="single-funfact">
                  <div class="icon">
                     <i class='bx bxs-group'></i>
                  </div>
                  <h3 class="odometer" data-count="10"></h3>
                  <p>Təhsil mütəxəssisi</p>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
               <div class="single-funfact">
                  <div class="icon">
                     <i class='bx bx-book-reader'></i>
                  </div>
                  <h3 class="odometer" data-count="1754">00</h3>
                  <p>Total Courses</p>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
               <div class="single-funfact">
                  <div class="icon">
                     <i class='bx bx-user-pin'></i>
                  </div>
                  <h3 class="odometer" data-count="8190">00</h3>
                  <p>Happy Students</p>
               </div>
            </div>
            <div class="col-lg-3 col-md-3 col-6">
               <div class="single-funfact">
                  <div class="icon">
                     <i class='bx bxl-deviantart'></i>
                  </div>
                  <h3 class="odometer" data-count="654">00</h3>
                  <p>Creative Events</p>
               </div>
            </div>
         </div>
         <div id="particles-js-circle-bubble"></div>
      </div>
   </div>
</section>
<section class="values-area ptb-100">
   <div class="container">
      <div class="row">
         <div class="col-lg-4 col-md-12">
            <div class="section-title text-left">
               <h2>Nəticələrimiz</h2>
            </div>
         </div>
         <div class="col-lg-8 col-md-12">
            <div class="values-content">
               <h3>Hekayemiz və qəbullarımız</h3>
               <p>Ən yaxşı nəticə ilə qəbul alan tələblərimizin siyahısı.
Nicat Əliyev
Rövşən Həsənov və s</p>
             
            </div>
         </div>
      </div>
   </div>
</section>
<?php get_footer(); ?>