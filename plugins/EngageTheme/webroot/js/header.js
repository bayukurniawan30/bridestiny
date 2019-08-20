(function($){
  $(document).ready(function(){
    // init_headernav_scroll_event();
    init_headernav_mobile();
    init_search_form_menu_item();
	slick_slider_homepage();
  });

  function init_search_form_menu_item(){
    $('.search-menu-item a').click(function(e){
      e.preventDefault();
      $(this).parent().toggleClass('active');
    });

    $('.header--nav ul li').mouseenter(function(){
      if($(this).hasClass('search-menu-item')==false){
        $('.header--nav ul li.search-menu-item').removeClass('active');
      }
    });
  }

  function init_headernav_scroll_event(){
    $(window).scroll(function(){
      var h1 = $('.header--top').outerHeight();
      var h2 = $('.header--bottom').outerHeight();
      var scTop = $(window).scrollTop();
      if(scTop>=(h1+h2)){
        $('body').addClass('fixed-nav');
      }else{
        $('body').removeClass('fixed-nav');
      }
    });
  }

  function init_headernav_mobile(){
    $('.header--mobile-menu ul.navmenu > li').each(function(){
      if($(this).find('ul').length>0){
        $(this).addClass('withsubmenu');
      }
    });

    $('.header--mobile-menu .withsubmenu a').click(function(e){
      e.preventDefault();
      var parent = $(this).parent();
      parent.find('>ul').toggle();
      parent.toggleClass('active');
    });

    $('.mobile-nav-toggle').click(function(e){
      e.preventDefault();
      $(window).scrollTop(0);

      /*
      $('body').toggleClass('mobile-menu-active');
      $(this).toggleClass('active');
      $('.header--mobile-menu').toggleClass('active');
      */

      $('.header--mobile-menu').addClass('visible');
      $('.header--mobile-menu').addClass('active');
    });

    $('.header--mobile-menu').on('click', '.close-this', function(e){
      e.preventDefault();
      $('.header--mobile-menu').removeClass('active');
      setTimeout(function(){
        $('.header--mobile-menu').removeClass('visible');
      },400);
    });
  }
  
  function slick_slider_homepage(){
	  $('.fullscreen-slideshow').slick({
		   dots: true,
		   autoplay:true,
		   slidesToScroll: 1,
		   autoplaySpeed:5000,
		   speed:600,
		   fade:true
	  });
	  
	  $('.carousel-offer').slick({
		  centerMode: true,
		  centerPadding: '60px',
		  slidesToShow: 3,
		  dots: false,
		  arrows: false,
		  autoplay: true,
		  autoplaySpeed: 2000,
		  responsive: [
			{
			  breakpoint: 768,
			  settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 3
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				arrows: false,
				centerMode: true,
				centerPadding: '40px',
				slidesToShow: 1
			  }
			}
		  ]
	  })
	  
	  $('.carousel-testimonial').slick({
		  infinite: true,
		  slidesToShow:2,
		  slidesToScroll: 1,
		  dots: true,
		  autoplay: true,
		  autoplaySpeed: 4000,
		  responsive: [
			{
			  breakpoint: 768,
			  settings: {
				arrows: false,
				slidesToShow: 3
			  }
			},
			{
			  breakpoint: 480,
			  settings: {
				arrows: false,
				slidesToShow: 1
			  }
			}
		  ]
	  });
	  
	  $('.carousel-vendor').slick({
		  infinite: true,
		  slidesToShow:4,
		  slidesToScroll: 1,
		  autoplay: true,
		  autoplaySpeed: 4000,
	  });
  }
}(jQuery));
