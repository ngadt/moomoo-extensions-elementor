(function($){
    $(window).on('elementor/frontend/init', () => {
    	
    	function moomooIconList($element){ 
	    	$('.moomoo-enable-popup-yes ul.elementor-icon-list-items li .item-icon-list').click(function(event) {
	    		$('ul.elementor-icon-list-items li .item-popup').hide();				
	    		$(this).next('.item-popup').show();
	    	});
	    	$('.moomoo-enable-popup-yes ul.elementor-icon-list-items li .close').click(function(event) {	
	    		stop_video();					
	    		$(this).parents('.item-popup').hide();				
	    	});
			
			function stop_video(){
				$('.moomoo-enable-popup-yes .moomoo-icon-list iframe').each(function(){					
					var iframe = $(this)[0].contentWindow;
    				iframe.postMessage('{"method":"pause"}', '*');
				  });
			}
			
	    	$(document).mouseup(function(e) 
			{
			    var container = $(".moomoo-enable-popup-yes .item-popup .align-center-content");
			    // if the target of the click isn't the container nor a descendant of the container
			    if (!container.is(e.target) && container.has(e.target).length === 0) 
			    {
			        $(".moomoo-enable-popup-yes .item-popup").hide();					
					stop_video();
					
			    }
			});

	   };
	  

       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-icon-list.default', moomooIconList);
    });
})(jQuery)

