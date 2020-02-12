(function($){

    $('.main-content .owl-carousel').owlCarousel({
      items: 4,
      margin: 30,
      nav:true,
      navText: [
        '<i class="fa fa-angle-left" aria-hidden="false"></i>',
        '<i class="fa fa-angle-right" aria-hidden="false"></i>'
      ],
      navContainer: '.main-content .custom-nav',
      video:true,
      responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:4
        }
    }
    });

})(jQuery);
