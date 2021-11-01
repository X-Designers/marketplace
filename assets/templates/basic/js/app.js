'use strict';

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

	$('.nice-select').niceSelect();

	new WOW().init();
	
	// lightcase plugin init
	$('a[data-rel^=lightcase]').lightcase();


// Show or hide the sticky footer button
$(window).on("scroll", function() {
	if ($(this).scrollTop() > 200) {
			$(".scroll-to-top").fadeIn(200);
	} else {
			$(".scroll-to-top").fadeOut(200);
	}
});

// Animate the scroll to top
$(".scroll-to-top").on("click", function(event) {
	event.preventDefault();
	$("html, body").animate({scrollTop: 0}, 300);
});


//preloader js code
$(".preloader").delay(300).animate({
	"opacity" : "0"
	}, 300, function() {
	$(".preloader").css("display","none");
});



$(".header-serch-btn").on('click', function(){
  //$(".header-top-search-area").toggleClass("open");
  if ($(this).hasClass('toggle-close')) {
      $(this).removeClass('toggle-close').addClass('toggle-open');
      $('.header-top-search-area').addClass('open');
  }
  else {
      $(this).removeClass('toggle-open').addClass('toggle-close');
      $('.header-top-search-area').removeClass('open');
  }
});

//close when click off of container
$(document).on('click touchstart', function (e){
  if (!$(e.target).is('.header-serch-btn, .header-serch-btn *, .header-top-search-area, .header-top-search-area *')) {
    $('.header-top-search-area').removeClass('open');
    $('.header-serch-btn').addClass('toggle-close');
  }
});

$('.select2-basic').select2();


// action-sidebar js 
const actionSidebar = $('.action-sidebar');
const actionSidebarOpenBtn = $('.action-sidebar-open');
const actionSidebarCloseBtn = $('.action-sidebar-close');

actionSidebarOpenBtn.on('click', function(){
  actionSidebar.addClass('active');
});
actionSidebarCloseBtn.on('click', function(){
  actionSidebar.removeClass('active');
});

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})


/* ==============================
					slider area
================================= */


$('.feature-product-slider').slick({
  dots: false,
  infinite: true,
  slidesToShow: 3,
  slidesToScroll: 1,
  arrows: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  responsive: [
    {
      breakpoint: 1650,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 1340,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 540,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

$('.product-two-slider').slick({
  dots: false,
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  arrows: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  responsive: [
    {
      breakpoint: 1550,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 1080,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 724,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});


// testimonial slider 
$('.testimonial-slider').slick({
  dots: true,
  infinite: true,
  autoplay: true,
  speed: 800,
  slidesToShow: 4,
  slidesToScroll: 1,
  arrows: false,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});


// more-product-slider js 
$('.more-product-slider').slick({
  dots: false,
  infinite: true,
  // autoplay: true,
  speed: 800,
  slidesToShow: 2,
  slidesToScroll: 1,
  arrows: true,
  prevArrow: '<div class="prev"><i class="las la-angle-left"></i></div>',
  nextArrow: '<div class="next"><i class="las la-angle-right"></i></div>',
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});

// top-author-slider 
$('.top-author-slider ').slick({
  dots: false,
  infinite: true,
  slidesToShow: 6,
  slidesToScroll: 1,
  arrows: false,
  responsive: [
    {
      breakpoint: 1400,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 1
      }
    }
    ,
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1
      }
    }
    ,
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    }
    ,
    {
      breakpoint: 380,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
  ]
});