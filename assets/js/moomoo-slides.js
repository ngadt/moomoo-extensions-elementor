(function($){
    $(window).on('elementor/frontend/init', () => {
       
       function moomooSlidesWidget($element){  
       /*	console.log(direction);
       	console.log(ndt);*/
       
       	var dataSetting = $.parseJSON($('.moomoo-swiper-container').attr('data-settings'));       
       	var autoplay_speed = dataSetting.autoplay_speed; 
       	var pause_on_hover = (dataSetting.pause_on_hover =='yes') ? true : false;
       	var autoplay = (dataSetting.autoplay =='yes') ? true : false;

      
       		const swiper = new Swiper('.moomoo-swiper-container', {
				  // Optional parameters
				  direction: 'horizontal',
				  loop: true,
				  speed: dataSetting.transition_speed,
				  grabCursor: true,
				  effect: dataSetting.transition,
				  //watchOverflow: pause_on_hover,
				  // If we need pagination
				  /*pagination: {
				    el: '.moomoo-swiper-pagination',
				  },*/
				  pagination: {
				    el: '.moomoo-swiper-pagination',
				    type: 'bullets',
				    clickable: true
				  },
				  autoplay: {
					   delay: dataSetting.autoplay_speed,
					   pauseOnMouseEnter: pause_on_hover
				  },
				  //autoplay: dataSetting.autoplay,
				  // Navigation arrows
				  navigation: {
				    nextEl: '.moomoo-swiper-button-next',
				    prevEl: '.moomoo-swiper-button-prev',
				  },
				 // edgeSwipeDetection:true
				  // And if we need scrollbar
				 /* scrollbar: {
				    el: '.swiper-scrollbar',
				  },*/
				});
           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-slides.default', moomooSlidesWidget);
    });
})(jQuery)

