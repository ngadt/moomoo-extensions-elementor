jQuery(window).on('elementor/frontend/init', () => {
    
    function postsWidget(){     

      if(jQuery('.moomoo-slider').length>=1){
             jQuery(".moomoo-slider").not('.slick-initialized').slick({
              dots: false,
              infinite: true,
              speed: 300,
              slidesToShow: 4,
              slidesToScroll:1,
              nextArrow : '<spa1n class="arrow next-arrow"><i></i></span>',
              prevArrow:  '<span class="arrow prev-arrow"><i></i></span>',
              responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
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
      }
       
   };
   
    elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-posts.default', postsWidget);
});
