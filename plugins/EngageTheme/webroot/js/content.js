$(document).ready(function(){
	
	
	custom_select_select2();
    slickFeatureCorausel();
    slickFourContents();
    slickBlogContent();
    animateContent();
	// inisialisi_paroller();
    videoModal();
	datetimepickerss();
    slickTestiContent();
    clickSoundVIdeo();
    fullWidthLastListMegaManu();
	cube_vendor_list();
	cube_vendor_list2();
	listView();
	gridView();
	// phone_mask();
});

function fullWidthLastListMegaManu(){
    $(".mega-menu-mobile li").each(function(idx,elem){
      if($(this).length > 0){
      if($(this).length%2==0)
          {
            // console.log("genap");
          } else
          {
            // console.log("ganjil");
             if(idx >= ($(".mega-menu-mobile li").length - 1)){
    
                    // $(this).css("width","100%");
    
                }
          }
      }
    });
}

function clickSoundVIdeo(){
  $('#iconplay').click(function() {
    $('.video-section').removeClass('bg-standtart');
    videoHomeSection();
    $(this).hide();

  });

  $('#iconmute').click(function() {
    $(".video-section").each(function(){
      var videoFind = $(this).find("video");
      if( videoFind.hasClass('videoonmute')){
        videoFind.removeClass("videoonmute");
        $('#iconmute').removeClass('soundoff');
        $(".video-section video").prop('muted', false);
        
      }else{
        videoFind.addClass("videoonmute");
        $('#iconmute').addClass('soundoff');
        $(".video-section video").prop('muted', true);
      }
     
    });
  });
 }
 
function videoHomeSection(){
    var urlPath = window.location;
    new $.fn.J_video_background({
        $el: $('.video-section'),
        muted: false,
        src: urlPath+'/video/wedding.mp4'
    });
    
}
  
  function initHoverTable(){
    if($('.add-to-cart-w').length > 0 ){
      $(".add-to-cart-w td").each(function(){
        var titleVar = $(this).find(".title");
        $(this).hover(function(){
         titleVar.show();
        });
        $(this).mouseout(function(){
          titleVar.hide();
         });
      });
    }
  }
  function slickTestiContent(){
    $('#testiContentW').slick({
        easing:'linear',
        arrows: false,
        dots: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 700,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 560,
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
        ]
    });
  }
  function slickFeatureCorausel(){
    $('#corauselIdHome').slick({
        easing:'linear',
        arrows: false,
        dots: true ,
        autoplay: true,
        autoplaySpeed: 2000
    });
  }
  function slickFourContents(){
    $('#slide-4-thumb').slick({
        easing:'linear',
        arrows: false,
        dots: false ,
        slidesToShow: 4,
        slidesToScroll: 4,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 3,
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
        ]
    });
  }
  function slickBlogContent(){
    $('#blogContentW').slick({
        easing:'linear',
        arrows: false,
        dots: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 900,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 560,
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
        ]
    });
  }

  function animateContent(){
    AOS.init();
  }

  // function inisialisi_paroller(){
  //   $('.paroller').paroller();
  // }
  
  function videoModal(){
    var $videoSrc;
    $('.video-btn').click(function() {
        $videoSrc = $(this).data( "src" );
    });
    // console.log("we"+$videoSrc);

    // when the modal is opened autoplay it
    $('#myModal').on('shown.bs.modal', function (e) {

    // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
    $("#video").attr('src',$videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" );
    })

    // stop playing the youtube video when I close the modal
    $('#myModal').on('hide.bs.modal', function (e) {
        // a poor man's stop video
        $("#video").attr('src',$videoSrc);
    })

  }
  
function cube_vendor_list(){
	$('#masnory-container').cubeportfolio({
        search: '#js-search-blog-posts',
        layoutMode: 'grid',
        defaultFilter: '*',
        animationType: 'flipOutDelay',
        gapHorizontal: 20,
        gapVertical: 20,
        gridAdjustment: 'responsive',
        mediaQueries: [{
            width: 1100,
            cols: 3
        }, {
            width: 800,
            cols: 3
        }, {
            width: 500,
            cols: 2
        }, {
            width: 320,
            cols: 1
        }],
        caption: 'overlayBottomAlong',
        displayType: 'bottomToTop',
        displayTypeSpeed: 100,

        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',
    });
}

function cube_vendor_list2(){
	$('#masnory-container-list').cubeportfolio({
        search: '#js-search-blog-posts',
        layoutMode: 'list',
        defaultFilter: '*',
        animationType: 'flipOutDelay',
        gapHorizontal: 20,
        gapVertical: 20,
        gridAdjustment: 'responsive',
        mediaQueries: [{
            width: 1100,
            cols: 1
        }, {
            width: 800,
            cols: 1
        }, {
            width: 500,
            cols: 1
        }, {
            width: 320,
            cols: 1
        }],
        caption: 'overlayBottomAlong',
        displayType: 'bottomToTop',
        displayTypeSpeed: 100,

        // lightbox
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',
    });
}

// List View
function listView() {
	// Get the elements with class="cbp-item"
	var elements = document.getElementsByClassName("cbp-item");

	// Declare a loop variable
	var i;
	
  for (i = 0; i < elements.length; i++) {
    elements[i].classList.add('w-100');
  }
}

// Grid View
function gridView() {
	// Get the elements with class="cbp-item"
	var elements = document.getElementsByClassName("cbp-item");

	// Declare a loop variable
	var i;
	
  for (i = 0; i < elements.length; i++) {
    elements[i].classList.remove('w-100')
  }
}

// function phone_mask(){
// 	 $('#phone').mask('(00) 0000-0000');
// }

function custom_select_select2()
{
	$('.select-vendor').select2();
}

function datetimepickerss(){
	
		
		var currentTime = new Date();
		
		var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() +1, 0);
		
		var eventDates = {};
        eventDates[ new Date( '07/07/2019' )] = new Date( '07/07/2019' ).toString();
        eventDates[ new Date( '07/17/2019' )] = new Date( '07/17/2019' ).toString();
        eventDates[ new Date( '07/28/2019' )] = new Date( '07/28/2019' ).toString();
        eventDates[ new Date( '07/27/2019' )] = new Date( '07/27/2019' ).toString();
		
		$( "#datepicker-brideme" ).datepicker({ 
			  inline: true,
			  // changeMonth: true,
			  minDate: "0",
			  // maxDate: maxDate,
				beforeShowDay: function(date) {
					var highlight = eventDates[date];
					if( highlight ) {
						return [true, "event ui-datepicker-unselectable ui-state-disabled", highlight];
					}else {
						return [true, "d_" + date.getFullYear() + '_' + (date.getMonth() + 1) + '_' + date.getDate()];
					}
					 
				}
		});

}

