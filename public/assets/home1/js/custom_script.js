// sticky effect
	$(window).on('scroll', function () {
		var menu_area = $('.navbar');
		if ($(window).scrollTop() > 10) {
			menu_area.addClass('sticky_navigation');
		} else {
			menu_area.removeClass('sticky_navigation');
		}
	});

	// sticky effect end

	// menu-icon change to cross 
$(document).ready(function(){
		$('.fa-bars').click(function(){
			$(this).hide() && $('.fa-times').show();
		});
		$('.fa-times').click(function(){
			$(this).hide() && $('.fa-bars').show();
		});
	});
	// menu-icon change to end 






$('.logos-slider').slick({
  dots: false,
  arrow:false,
  infinite: true,
  autoplay:true,
  speed: 400,
  slidesToShow: 6,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 5,
        slidesToScroll: 3,
        infinite: true,
         prevArrow: false,
        nextArrow: false,
        dots: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});


// testimonal slider 
// slider
$('#testimonal-sliderrr').slick({
  dots: true,
  arrow:false,
  infinite: true,
  speed: 300,
  slidesToShow: 2,
  margin:30,
  slidesToScroll: 1,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
         prevArrow: false,
    nextArrow: false,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]
});





$('').owlCarousel({
    loop:true,
    dots:true,
    items:2,
    margin:30,
    responsiveClass:true,
     nav: false,
  dots: true,
    responsive:{
        0:{
            items:1,
            nav:true
        },
        1100:{
            items:2,
            nav:true
        }
    }
});

// $(document).ready(function(){
//     $("#testimonial-slider").owlCarousel({
//         items:2,
//         itemsDesktop:[1100,1],
//         itemsDesktopSmall:[979,1],
//         itemsTablet:[768,1],
//         pagination:true,
//         navigation:true,
//         // navigationText:["",""],
//         slideSpeed:1000,
//         autoPlay:true,
//         dots:true
//     });
// });


$(document).ready(function(){
    $("#testimonial-slider").owlCarousel({
        items:3,
        itemsDesktop:[1199,2],
        itemsDesktopSmall:[979,2],
        itemsTablet:[768,2],
        itemsMobile:[600,1],
        pagination:true,
        navigation:false,
        navigationText:["",""],
        slideSpeed:1000,
        autoPlay:true
    });
});