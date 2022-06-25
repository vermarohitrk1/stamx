// sticky effect
	$(window).on('scroll', function () {
		var menu_area = $('.navbar');
		if ($(window).scrollTop() > 150) {
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
$(document).ready(function(){
	

	});


// slider
$('.forslider').slick({
  dots: true,
  arrow:false,
  infinite: false,
  speed: 300,
  slidesToShow: 4,
  slidesToScroll: 4,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
         prevArrow: false,
    nextArrow: false,
        dots: true
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
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