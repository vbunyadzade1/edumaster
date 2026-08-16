jQuery(function($) {
    'use strict';
    $('.mean-menu').meanmenu({
        meanScreenWidth: "991"
    });
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 120) {
            $('.header-sticky').addClass("is-sticky");
        } else {
            $('.header-sticky').removeClass("is-sticky");
        }
    });
    var c, currentScrollTop = 0,
        navbar = $('.header-sticky');
    $(window).scroll(function() {
        var a = $(window).scrollTop();
        var b = navbar.height();
        currentScrollTop = a;
        if (c < currentScrollTop && a > b + b) {
            navbar.addClass("scrollUp");
        } else if (c > currentScrollTop && !(a <= b)) {
            navbar.removeClass("scrollUp");
        }
        c = currentScrollTop;
    });
    $(".others-option .search-box i").on("click", function() {
        $(".search-overlay").toggleClass("search-overlay-active");
    });
    $(".search-overlay-close").on("click", function() {
        $(".search-overlay").removeClass("search-overlay-active");
    });

    var swiper = new Swiper('.country-courcel', {
        slidesPerColumnFill: 'row',
        paginationClickable: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        slidesPerView: 4,
        slidesPerColumn: 2,
        spaceBetween: 30,
        preloadImages: false,
        lazy: true,
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window width is >= 640px
            640: {
                slidesPerView: 4,
                spaceBetween: 20
            }
        }
    });

    var swiper = new Swiper('.unversity-courcel', {
        slidesPerColumnFill: 'row',
        paginationClickable: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        preloadImages: false,
        lazy: true,
        slidesPerView: 3,
        slidesPerColumn: 2,
        spaceBetween: 30,
        // Responsive breakpoints
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 480px
            480: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 640px
            640: {
                slidesPerView: 3,
                spaceBetween: 20
            }
        }
    });

    $('.single-courses-category a span').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });

    $('.single-courses-box .courses-content').matchHeight({
        byRow: true,
        property: 'height',
        target: null,
        remove: false
    });

    if ($('#muraciet_formu').length > 0) {

        $('#muraciet_formu').submit(function(e) {

            var user_name = $('#user_name').val();
            var user_address = $('#user_address').val();		
            var user_email = $('#user_email').val();			
            var user_phone = $('#user_phone').val();
            var user_comment = $('#user_comment').val();

            if (user_name == '') {

                $('.students-feedback-form .form-messege').html('<div class="alert alert-danger" role="alert">Ad hissəsi boşdu!</div>').fadeIn();

                $('.students-feedback-form .form-messege').delay(2000).fadeOut();
                $('#user_name').focus();

            } else if (user_address == '') {

                $('.students-feedback-form .form-messege').html('<div class="alert alert-danger" role="alert">Ünvan hissəsi boşdu!</div>').fadeIn();

                $('.students-feedback-form .form-messege').delay(2000).fadeOut();
                $('#user_address').focus();

            } else if (user_email == '') {

                $('.students-feedback-form .form-messege').html('<div class="alert alert-danger" role="alert">Email hissəsi boşdu!</div>').fadeIn();

                $('.students-feedback-form .form-messege').delay(2000).fadeOut();
                $('#user_email').focus();

            } else if (user_phone == '') {

                $('.students-feedback-form .form-messege').html('<div class="alert alert-danger" role="alert">Telefon hissəsi boşdu!</div>').fadeIn();

                $('.students-feedback-form .form-messege').delay(2000).fadeOut();
                $('#user_phone').focus();
				
            } else if (user_comment == '') {

                $('.students-feedback-form .form-messege').html('<div class="alert alert-danger" role="alert">Qeydlər hissəsi boşdu!').fadeIn();

                $('.students-feedback-form .form-messege').delay(2000).fadeOut();
                $('#user_comment').focus();
				
            } else {

                var form = $('#muraciet_formu');					
                var  form_data;

                e.preventDefault();

                form_data = $(this).serialize();

				$.ajax({
						type: 'POST',
						url: form.attr('action'),
						data: form_data,
						success: function (data) {
							$('.students-feedback-form .form-messege').removeClass('d-none').html('<div class="alert alert-success" role="alert">Göndərmə uğurlu oldu.</div>').fadeIn();
							$('.students-feedback-form .form-messege').delay(5000).fadeOut();
							form.find('input:not([type="submit"]), textarea').val('');
							window.location.href = "thank-you";
						},
						error: function (data) {
							$('.students-feedback-form .form-messege').removeClass('d-none').html('<div class="alert alert-danger" role="alert">Xəta baş verdi.</div>').fadeIn();
							$('.students-feedback-form .form-messege').delay(5000).fadeOut();
							form.find('input:not([type="submit"]), textarea').val('');
							window.location.reload();
						}					
					});

            }

            return false;

        });

    }

    if ($('#contactForm').length > 0) {

        $('#contactForm').submit(function(e) {

            var contact_name = $('#contact_name').val();
            var contact_email = $('#contact_email').val();		
            var contact_phone = $('#contact_phone').val();			
            var contact_subject = $('#contact_subject').val();
            var contact_message = $('#contact_message').val();

            if (contact_name == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Ad hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#contact_name').focus();

            } else if (contact_email == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Email hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#contact_email').focus();

            } else if (contact_phone == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Nömrə hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#contact_phone').focus();

            } else if (contact_subject == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Mövzu hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#contact_subject').focus();
				
            } else if (contact_message == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Mesaj hissəsi boşdu!').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#contact_message').focus();
				
            } else {

                var form = $('#contactForm');		
                var form_data;

                e.preventDefault();

                form_data = $(this).serialize();

				$.ajax({
						type: 'POST',
						url: form.attr('action'),
						data: form_data,
						success: function (data) {
							$('.contact-form .form-messege').removeClass('d-none').html('<div class="alert alert-success" role="alert">Göndərmə uğurlu oldu.</div>').fadeIn();
							$('.contact-form .form-messege').delay(5000).fadeOut();
							form.find('input:not([type="submit"]), textarea').val('');
						},
						error: function (data) {
							$('.contact-form .form-messege').removeClass('d-none').html('<div class="alert alert-danger" role="alert">Xəta baş verdi.</div>').fadeIn();
							$('.contact-form .form-messege').delay(5000).fadeOut();
							form.find('input:not([type="submit"]), textarea').val('');
						}					
					});

            }

            return false;

        });

    }	
	
	
    if ($('#applyForm').length > 0) {

        $('#applyForm').submit(function(e) {

            var apply_name = $('#apply_name').val();
            var apply_email = $('#apply_email').val();		
            var apply_phone = $('#apply_phone').val();			
            var apply_country = $('#apply_country').val();

            if (apply_name == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Ad hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#apply_name').focus();

            } else if (apply_email == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Email hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#apply_email').focus();

            } else if (apply_phone == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Nömrə hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#apply_phone').focus();

            } else if (apply_country == '') {

                $('.contact-form .form-messege').html('<div class="alert alert-danger" role="alert">Ölkə hissəsi boşdu!</div>').fadeIn();

                $('.contact-form .form-messege').delay(2000).fadeOut();
                $('#apply_country').focus();
				
            } else {

                var form = $('#applyForm');		
                var form_data;

                e.preventDefault();

                form_data = $(this).serialize();

				$.ajax({
						type: 'POST',
						url: form.attr('action'),
						data: form_data,
						success: function (data) {
							$('.contact-form .form-messege').removeClass('d-none').html('<div class="alert alert-success" role="alert">Göndərmə uğurlu oldu.</div>').fadeIn();
							$('.contact-form .form-messege').delay(5000).fadeOut();
							form.find('input:not([type="submit"]), textarea').val('');
							window.location.href = "thank-you";
						},
						error: function (data) {
							$('.contact-form .form-messege').removeClass('d-none').html('<div class="alert alert-danger" role="alert">Xəta baş verdi.</div>').fadeIn();
							$('.contact-form .form-messege').delay(5000).fadeOut();
							form.find('input:not([type="submit"]), textarea').val('');
							window.location.reload();
						}					
					});

            }

            return false;

        });

    }	
	
	
    $('.home-slides').owlCarousel({
        loop: true,
        nav: true,
        dots: true,
        autoplayHoverPause: true,
        autoplay: true,
        items: 1,
        autoHeight: true,
        navText: ["<i class='bx bx-chevron-left'></i>", "<i class='bx bx-chevron-right'></i>"]
    });
    $(".home-slides").on("translate.owl.carousel", function() {
        $(".main-banner-content .sub-title").removeClass("animated fadeInDown").css("opacity", "0");
        $(".main-banner-content h1").removeClass("animated fadeInUp").css("opacity", "0");
        $(".main-banner-content p").removeClass("animated fadeInUp").css("opacity", "0");
        $(".main-banner-content .default-btn").removeClass("animated fadeInLeft").css("opacity", "0");
        $(".main-banner-content .optional-btn, .main-banner-content .video-btn").removeClass("animated fadeInUp").css("opacity", "0");
    });
    $(".home-slides").on("translated.owl.carousel", function() {
        $(".main-banner-content .sub-title").addClass("animated fadeInDown").css("opacity", "1");
        $(".main-banner-content h1").addClass("animated fadeInUp").css("opacity", "1");
        $(".main-banner-content p").addClass("animated fadeInUp").css("opacity", "1");
        $(".main-banner-content .default-btn").addClass("animated fadeInLeft").css("opacity", "1");
        $(".main-banner-content .optional-btn, .main-banner-content .video-btn").addClass("animated fadeInUp").css("opacity", "1");
    });
    $('.courses-categories-slides').owlCarousel({
        loop: false,
        lazyLoad: true,
        nav: true,
        dots: false,
        autoplayHoverPause: true,
        autoplay: true,
        navRewind: false,
        margin: 30,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            768: {
                items: 3,
            },
            1200: {
                items: 4,
            }
        }
    });
    $('.shorting').mixItUp();
    $('.partner-slides').owlCarousel({
        loop: true,
        lazyLoad: true,
        nav: false,
        dots: false,
        autoplayHoverPause: true,
        autoplay: true,
        margin: 30,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
        responsive: {
            0: {
                items: 2,
            },
            576: {
                items: 3,
            },
            768: {
                items: 4,
            },
            1200: {
                items: 6,
            }
        }
    });
    $('.courses-slides').owlCarousel({
        loop: false,
        nav: true,
        dots: true,
        autoplayHoverPause: true,
        autoplay: true,
        navRewind: false,
        margin: 30,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });
    $('.blog-slides').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        autoplayHoverPause: true,
        autoplay: true,
        margin: 30,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            768: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });
    $('.team-slides').owlCarousel({
        loop: false,
        lazyLoad: true,
        nav: true,
        dots: false,
        autoplayHoverPause: true,
        autoplay: true,
        navRewind: false,
        margin: 30,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            768: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });
    $('.mission-slides').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        autoplayHoverPause: true,
        autoplay: true,
        items: 1,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
    });
    $('.testimonials-slides').owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        autoplayHoverPause: true,
        autoplay: true,
        center: true,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            768: {
                items: 2,
            },
            1200: {
                items: 3,
            }
        }
    });
    $('.odometer').appear(function(e) {
        var odo = $(".odometer");
        odo.each(function() {
            var countNumber = $(this).attr("data-count");
            $(this).html(countNumber);
        });
    });

    function makeTimer() {
        var endTime = new Date("September 20, 2025 17:00:00 PDT");
        var endTime = (Date.parse(endTime)) / 1000;
        var now = new Date();
        var now = (Date.parse(now) / 1000);
        var timeLeft = endTime - now;
        var days = Math.floor(timeLeft / 86400);
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
        if (hours < "10") {
            hours = "0" + hours;
        }
        if (minutes < "10") {
            minutes = "0" + minutes;
        }
        if (seconds < "10") {
            seconds = "0" + seconds;
        }
        $("#days").html(days + "<span>Days</span>");
        $("#hours").html(hours + "<span>Hours</span>");
        $("#minutes").html(minutes + "<span>Minutes</span>");
        $("#seconds").html(seconds + "<span>Seconds</span>");
    }
    setInterval(function() {
        makeTimer();
    }, 0);
    if (document.getElementById("particles-js-circle-bubble")) particlesJS("particles-js-circle-bubble", {
        "particles": {
            "number": {
                "value": 300,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": "#ffffff"
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 1,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 1,
                    "opacity_min": 0,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 4,
                    "size_min": 0.3,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": false,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1,
                "direction": "none",
                "random": true,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 600
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "bubble"
                },
                "onclick": {
                    "enable": true,
                    "mode": "repulse"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 250,
                    "size": 0,
                    "duration": 2,
                    "opacity": 0,
                    "speed": 3
                },
                "repulse": {
                    "distance": 400,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
    if (document.getElementById("particles-js-circle-bubble-2")) particlesJS("particles-js-circle-bubble-2", {
        "particles": {
            "number": {
                "value": 100,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"]
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 1,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 1,
                    "opacity_min": 0,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 4,
                    "size_min": 0.3,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": false,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1,
                "direction": "none",
                "random": true,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 600
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "bubble"
                },
                "onclick": {
                    "enable": true,
                    "mode": "repulse"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 250,
                    "size": 0,
                    "duration": 2,
                    "opacity": 0,
                    "speed": 3
                },
                "repulse": {
                    "distance": 400,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
    if (document.getElementById("particles-js-circle-bubble-3")) particlesJS("particles-js-circle-bubble-3", {
        "particles": {
            "number": {
                "value": 100,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"]
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 1,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 1,
                    "opacity_min": 0,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 4,
                    "size_min": 0.3,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": false,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1,
                "direction": "none",
                "random": true,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 600
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "bubble"
                },
                "onclick": {
                    "enable": true,
                    "mode": "repulse"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 250,
                    "size": 0,
                    "duration": 2,
                    "opacity": 0,
                    "speed": 3
                },
                "repulse": {
                    "distance": 400,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
    if (document.getElementById("particles-js-circle-bubble-4")) particlesJS("particles-js-circle-bubble-4", {
        "particles": {
            "number": {
                "value": 100,
                "density": {
                    "enable": true,
                    "value_area": 800
                }
            },
            "color": {
                "value": ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"]
            },
            "shape": {
                "type": "circle",
                "stroke": {
                    "width": 0,
                    "color": "#000000"
                },
                "polygon": {
                    "nb_sides": 5
                },
                "image": {
                    "src": "img/github.svg",
                    "width": 100,
                    "height": 100
                }
            },
            "opacity": {
                "value": 1,
                "random": true,
                "anim": {
                    "enable": true,
                    "speed": 1,
                    "opacity_min": 0,
                    "sync": false
                }
            },
            "size": {
                "value": 3,
                "random": true,
                "anim": {
                    "enable": false,
                    "speed": 4,
                    "size_min": 0.3,
                    "sync": false
                }
            },
            "line_linked": {
                "enable": false,
                "distance": 150,
                "color": "#ffffff",
                "opacity": 0.4,
                "width": 1
            },
            "move": {
                "enable": true,
                "speed": 1,
                "direction": "none",
                "random": true,
                "straight": false,
                "out_mode": "out",
                "bounce": false,
                "attract": {
                    "enable": false,
                    "rotateX": 600,
                    "rotateY": 600
                }
            }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": {
                "onhover": {
                    "enable": true,
                    "mode": "bubble"
                },
                "onclick": {
                    "enable": true,
                    "mode": "repulse"
                },
                "resize": true
            },
            "modes": {
                "grab": {
                    "distance": 400,
                    "line_linked": {
                        "opacity": 1
                    }
                },
                "bubble": {
                    "distance": 250,
                    "size": 0,
                    "duration": 2,
                    "opacity": 0,
                    "speed": 3
                },
                "repulse": {
                    "distance": 400,
                    "duration": 0.4
                },
                "push": {
                    "particles_nb": 4
                },
                "remove": {
                    "particles_nb": 2
                }
            }
        },
        "retina_detect": true
    });
    var console = window.console || {
        log: function() {}
    };
    var $images = $('.gallery-area');
    var options = {
        url: 'data-original',
        ready: function(e) {
            console.log(e.type);
        },
        show: function(e) {
            console.log(e.type);
        },
        shown: function(e) {
            console.log(e.type);
        },
        hide: function(e) {
            console.log(e.type);
        },
        hidden: function(e) {
            console.log(e.type);
        },
        view: function(e) {
            console.log(e.type);
        },
        viewed: function(e) {
            console.log(e.type);
        }
    };
    $images.on({
        ready: function(e) {
            console.log(e.type);
        },
        show: function(e) {
            console.log(e.type);
        },
        shown: function(e) {
            console.log(e.type);
        },
        hide: function(e) {
            console.log(e.type);
        },
        hidden: function(e) {
            console.log(e.type);
        },
        view: function(e) {
            console.log(e.type);
        },
        viewed: function(e) {
            console.log(e.type);
        }
    }).viewer(options);
    var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 90000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };
    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];
        if (this.isDeleting) {
            this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
            this.txt = fullTxt.substring(0, this.txt.length + 1);
        }
        this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';
        var that = this;
        var delta = 200 - Math.random() * 100;
        if (this.isDeleting) {
            delta /= 2;
        }
        if (!this.isDeleting && this.txt === fullTxt) {
            delta = this.period;
            this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
            this.isDeleting = false;
            this.loopNum++;
            delta = 500;
        }
        setTimeout(function() {
            that.tick();
        }, delta);
    };
    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i = 0; i < elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
                new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 4px solid #000000}";
        document.body.appendChild(css);
    };
    $('.slideshow-slides').owlCarousel({
        loop: true,
        nav: false,
        dots: false,
        animateOut: 'fadeOut',
        autoplayHoverPause: false,
        autoplay: true,
        smartSpeed: 400,
        mouseDrag: false,
        autoHeight: true,
        items: 1,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
    });
    $('.feedback-slides').owlCarousel({
        loop: true,
        lazyLoad: true,
        nav: true,
        dots: false,
        animateOut: 'fadeOut',
        autoplayHoverPause: true,
        autoplay: true,
        mouseDrag: false,
        items: 1,
        navText: ["<i class='bx bx-left-arrow-alt'></i>", "<i class='bx bx-right-arrow-alt'></i>"],
    });
    $('.popup-youtube').magnificPopup({
        disableOn: 320,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });
    $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
    $('.tab ul.tabs li a').on('click', function(g) {
        var tab = $(this).closest('.tab'),
            index = $(this).closest('li').index();
        tab.find('ul.tabs > li').removeClass('current');
        $(this).closest('li').addClass('current');
        tab.find('.tab-content').find('div.tabs-item').not('div.tabs-item:eq(' + index + ')').slideUp();
        tab.find('.tab-content').find('div.tabs-item:eq(' + index + ')').slideDown();
        g.preventDefault();
    });
    $('.input-counter').each(function() {
        var spinner = jQuery(this),
            input = spinner.find('input[type="text"]'),
            btnUp = spinner.find('.plus-btn'),
            btnDown = spinner.find('.minus-btn'),
            min = input.attr('min'),
            max = input.attr('max');
        btnUp.on('click', function() {
            var oldValue = parseFloat(input.val());
            if (oldValue >= max) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue + 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });
        btnDown.on('click', function() {
            var oldValue = parseFloat(input.val());
            if (oldValue <= min) {
                var newVal = oldValue;
            } else {
                var newVal = oldValue - 1;
            }
            spinner.find("input").val(newVal);
            spinner.find("input").trigger("change");
        });
    });
    $('.accordion').find('.accordion-title').on('click', function() {
        $(this).toggleClass('active');
        $(this).next().slideToggle('fast');
        $('.accordion-content').not($(this).next()).slideUp('fast');
        $('.accordion-title').not($(this)).removeClass('active');
    });

    $(window).on('scroll', function() {
        var scrolled = $(window).scrollTop();
        if (scrolled > 300) $('.go-top').addClass('active');
        if (scrolled < 300) $('.go-top').removeClass('active');
    });
    $('.go-top').on('click', function() {
        $("html, body").animate({
            scrollTop: "0"
        }, 500);
    });
    $('.health-coaching-banner-slides').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        autoplayHoverPause: true,
        autoplay: true,
        items: 1,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        navText: ["<i class='flaticon-arrows'></i>", "<i class='flaticon-right-arrow'></i>"],
    });
    $('.feedback-slides-two').owlCarousel({
        loop: true,
        nav: false,
        dots: true,
        autoplayHoverPause: true,
        autoplay: true,
        animateOut: 'fadeOut',
        autoHeight: true,
        items: 1,
        navText: ["<i class='flaticon-arrows'></i>", "<i class='flaticon-right-arrow'></i>"],
    });
    $('.gym-home-slides').owlCarousel({
        loop: true,
        nav: true,
        dots: true,
        autoplayHoverPause: true,
        autoplay: true,
        items: 1,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        autoHeight: true,
        navText: ["<i class='flaticon-arrows'></i>", "<i class='flaticon-right-arrow'></i>"]
    });
    $(".gym-home-slides").on("translate.owl.carousel", function() {
        $(".gym-banner-content .sub-title").removeClass("animated fadeInDown").css("opacity", "0");
        $(".gym-banner-content h1").removeClass("animated fadeInUp").css("opacity", "0");
        $(".gym-banner-content p").removeClass("animated fadeInUp").css("opacity", "0");
        $(".gym-banner-content .default-btn").removeClass("animated fadeInLeft").css("opacity", "0");
    });
    $(".gym-home-slides").on("translated.owl.carousel", function() {
        $(".gym-banner-content .sub-title").addClass("animated fadeInDown").css("opacity", "1");
        $(".gym-banner-content h1").addClass("animated fadeInUp").css("opacity", "1");
        $(".gym-banner-content p").addClass("animated fadeInUp").css("opacity", "1");
        $(".gym-banner-content .default-btn").addClass("animated fadeInLeft").css("opacity", "1");
    });
    $(window).on('load', function() {
        $('.preloader').addClass('preloader-deactivate');
    });
	
    $('[data-bg-image]').each(function() {
        var $this = $(this),
            $image = $this.data('bg-image');
        	$this.css('background-image', 'url(' + $image + ')');
    });
    $('[data-bg-color]').each(function() {
        var $this = $(this),
            $color = $this.data('bg-color');
        	$this.css('background-color', $color);
    });	
    $('[data-bg-video]').each(function() {
        var $this = $(this),
            $src = $this.data('bg-video');
			$this.attr("src", $src);
			$this.removeAttr('data-bg-video');
    });
	
}(jQuery));