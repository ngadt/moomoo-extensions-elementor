(function($){
    $(window).on('elementor/frontend/init', () => {
    	
    	 function moomooMedia($element){   
	       	
	       	$('.moomoo-media .mm-tabbar ').on('click', 'li', function(event) {
	       		event.preventDefault();
	       		$('.moomoo-media .mm-tabbar li').removeClass('active');
	       		$(this).addClass('active');
	       		var classActive = $(this).data('tab');
	       		console.log(classActive);
	       		$('.mm-tabcontent .item-content').removeClass('active')
	       		$(classActive).addClass('active');
	       		/* Act on the event */
	       	});
		           
		 };
		  
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-media.default', moomooMedia);
    });
})(jQuery)

