/*=====================================================
Template Name   : Electrow
Description     : Power And Electricity Services HTML5 Template
Author          : LunarTemp
Version         : 1.0
=======================================================*/


(function ($) {
    
    "use strict";

    // multi level dropdown menu
    $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
        }
        var $subMenu = $(this).next('.dropdown-menu');
        $subMenu.toggleClass('show');

        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
            $('.dropdown-submenu .show').removeClass('show');
        });
        return false;
    });


    // data-background    
    $(document).on('ready', function () {
        $("[data-background]").each(function () {
            $(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
        });
    });


    // navbar search 
    $('.search-btn').on('click', function() {
        $('.search-area').toggleClass('open');
    });


    // wow init
    new WOW().init();


    // hero slider
    $('.hero-slider').owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        margin: 0,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 5000,
        items: 1,
        navText: [
            "<i class='far fa-long-arrow-left'></i>",
            "<i class='far fa-long-arrow-right'></i>"
        ],

        onInitialized: function(event) {
        var $firstAnimatingElements = $('.owl-item').eq(event.item.index).find("[data-animation]");
        doAnimations($firstAnimatingElements);
        },

        onChanged: function(event){
        var $firstAnimatingElements = $('.owl-item').eq(event.item.index).find("[data-animation]");
        doAnimations($firstAnimatingElements);
        }
    });

    //hero slider do animations
    function doAnimations(elements) {
		var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
		elements.each(function () {
			var $this = $(this);
			var $animationDelay = $this.data('delay');
			var $animationDuration = $this.data('duration');
			var $animationType = 'animated ' + $this.data('animation');
			$this.css({
				'animation-delay': $animationDelay,
				'-webkit-animation-delay': $animationDelay,
                'animation-duration': $animationDuration,
                '-webkit-animation-duration': $animationDuration,
			});
			$this.addClass($animationType).one(animationEndEvents, function () {
				$this.removeClass($animationType);
			});
		});
	}


    // testimonial-slider
    $('.testimonial-slider').owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });


    // partner-slider
    $('.partner-slider').owlCarousel({
        loop: true,
        margin: 50,
        nav: false,
        dots: false,
        autoplay: true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 3
            },
            1000: {
                items: 6
            }
        }
    });


    // preloader
    $(window).on('load', function () {
        $(".preloader").fadeOut("slow");
    });


    // fun fact counter
    $('.counter').countTo();
    $('.counter-box').appear(function () {
        $('.counter').countTo();
    }, {
        accY: -100
    });


    // magnific popup init
    $(".popup-gallery").magnificPopup({
        delegate: '.popup-img',
        type: 'image',
        gallery: {
            enabled: true
        },
    });

    $(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });



    // scroll to top
    $(window).scroll(function () {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            $("#scroll-top").addClass('active');
        } else {
            $("#scroll-top").removeClass('active');
        }
    });

    $("#scroll-top").on('click', function () {
        $("html, body").animate({ scrollTop: 0 }, 1500);
        return false;
    });


    // navbar fixed top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass("fixed-top");
        } else {
            $('.navbar').removeClass("fixed-top");
        }
    });


    // project filter
    // $(window).on('load', function () {
    //     if ($(".filter-box").children().length > 0) {
    //         $(".filter-box").isotope({
    //             itemSelector: '.filter-item',
    //             masonry: {
    //                 columnWidth: 1
    //             },
    //         });

    //         $('.filter-btn').on('click', 'li', function () {
    //             var filterValue = $(this).attr('data-filter');
    //             $(".filter-box").isotope({ filter: filterValue });
    //         });

    //         $(".filter-btn li").each(function () {
    //             $(this).on("click", function () {
    //                 $(this).siblings("li.active").removeClass("active");
    //                 $(this).addClass("active");
    //             });
    //         });
    //     }
    // });

    $(document).ready(function () {
        function initializeIsotope() {
    
            $('.filter-btn').on('click', 'li', function () {    
                var $this = $(this);
                $this.addClass('active').siblings().removeClass('active');
                var filterValue = $this.attr('data-filter');
    
                if (filterValue === "*") {
                    $(".swiper-slide").remove();
                    $("#locationCode").empty();
                    $("#dateCode").empty();
                    getAllGallery();
                } else {
                    $(".swiper-slide").remove();
                    getByIdCategory(filterValue);
                }
    
            });
    
            $('.filter-btn li[data-filter="*"]').click();
            
        }
        
        function getAllGallery(){
            axios.get('allGallery')
            .then(function(response){
                // console.log(response);
                let data = response.data.data;
                let box = "";
                $.each(data, function(key, val){
                    box += `<div class="swiper-slide swiper-distance mt-0" style="opacity: 0; animation: fadeIn 0.5s ease forwards ${key * 0.1}s;>
                                <div class="row filter-box popup-gallery">
                                    <div class="filter-item ${val.categories[0].kode}">
                                        <div class="portfolio-item">
                                            <div class="portfolio-img">
                                                <img class="" style="height: 300px; object-fit:cover;"
                                                    src="${ val.image_url }" data-original-src="${ val.image_url }" alt="">
                                            </div>
                                            <div class="portfolio-content">
                                                <a class="popup-img portfolio-link" href="${ val.image_url }"><i
                                                        class="fal fa-plus"></i></a>
                                                <div class="portfolio-info">
                                                    <div class="portfolio-title-info">
                                                        <a class="popup-img" href="${ val.image_url }">
                                                            <h4 class="portfolio-title">${ val.title }</h4>
                                                        </a>
                                                        <h5 class="portfolio-subtitle">
                                                            ${ val.sub_title }
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
                $("#sliderGallery").html(box);
                new Swiper('.swiper-container', {
                    slidesPerView: 3,
                    slidesPerGroup: 2,
                    slidesPerColumn: 2,
                    spaceBetween: 30,
                    slidesPerColumnFill: 'column',
                    loop: false,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 1
                        },
                        700: {
                            slidesPerView: 1
                        },
                        900: {
                            slidesPerView: 2
                        }
                    }
                });
            })
            .catch(function(error){
                console.log("gagal ambil semua data gallery. " + error);
            })
        }

        function getByIdCategory(id){
            axios.get(`/categoryGallery/${id}`)
            .then(function(response){
                console.log(response.data);
                let category = response.data.kode;
                $("#locationCode").html(category.location + ", ");
                $("#dateCode").html( moment(category.date).format('DD MMMM YYYY') );
                let data = response.data.data;
                let box = "";
                $.each(data, function(key, val){
                    box += `<div class="swiper-slide swiper-distance mt-0" style="opacity: 0; animation: fadeIn 0.5s ease forwards ${key * 0.1}s;>
                                <div class="row filter-box popup-gallery">
                                    <div class="filter-item ${val.categories[0].kode}">
                                        <div class="portfolio-item">
                                            <div class="portfolio-img">
                                                <img class="" style="height: 300px; object-fit:cover;"
                                                    src="${ val.image_url }" data-original-src="${ val.image_url }" alt="">
                                            </div>
                                            <div class="portfolio-content">
                                                <a class="popup-img portfolio-link" href="${ val.image_url }"><i
                                                        class="fal fa-plus"></i></a>
                                                <div class="portfolio-info">
                                                    <div class="portfolio-title-info">
                                                        <a class="popup-img" href="${ val.image_url }">
                                                            <h4 class="portfolio-title">${ val.title }</h4>
                                                        </a>
                                                        <h5 class="portfolio-subtitle">
                                                            ${ val.sub_title }
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                });
                $("#sliderGallery").html(box);
                new Swiper('.swiper-container', {
                    slidesPerView: 3,
                    slidesPerGroup: 2,
                    slidesPerColumn: 2,
                    spaceBetween: 30,
                    slidesPerColumnFill: 'column',
                    loop: false,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        0: {
                            slidesPerView: 1
                        },
                        700: {
                            slidesPerView: 1
                        },
                        900: {
                            slidesPerView: 2
                        }
                    }
                });
            })
            .catch(function(error){
                console.log("gagal ambil data gallery per category. " + error);
            });
        }
    
        $(window).on('load', initializeIsotope);
    });
    


    // countdown
    if ($('#countdown').length) {
        $('#countdown').countdown('2035/01/30', function (event) {
            $(this).html(event.strftime('' + '<div class="row">' + '<div class="col countdown-single">' + '<h2 class="mb-0">%-D</h2>' + '<h5 class="mb-0">Day%!d</h5>' + '</div>' + '<div class="col countdown-single">' + '<h2 class="mb-0">%H</h2>' + '<h5 class="mb-0">Hours</h5>' + '</div>' + '<div class="col countdown-single">' + '<h2 class="mb-0">%M</h2>' + '<h5 class="mb-0">Minutes</h5>' + '</div>' + '<div class="col countdown-single">' + '<h2 class="mb-0">%S</h2>' + '<h5 class="mb-0">Seconds</h5>' + '</div>' + '</div>'));
        });
    }


    // copywrite date
    let date = new Date().getFullYear();
    $("#date").html(date);


})(jQuery);










