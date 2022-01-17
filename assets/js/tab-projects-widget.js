(function($){
    $(window).on('elementor/frontend/init', () => {
       
       function tabProjectsWidget($element){  
      
          $('ul.tab-bar').on('click','li',function(event) {

	        event.preventDefault();
	        current_tab = $(this).attr('data-id');
	        console.log(current_tab);
	        $(this).addClass('active');
	        $('ul.tab-bar li').not(this).removeClass('active');
	        $('.tab-content .elementor-column').removeAttr('style');
	        console.log($('.tab-content .elementor-column').hasClass(current_tab));
	        $('.tab-content .elementor-column').not('.'+current_tab).hide('800');
	        $('.tab-bar-box .tab-selected').text($(this).text());
	        if($(window).width()<=767){
	        	$('.tab-bar-box ul.tab-bar').slideUp('fast');
	        }
	       
	        //$('.tab-content .' + current_tab).addClass('active');
	    });

         $('.tab-bar-box .tab-selected').click(function(event) {
         	$('.tab-bar-box ul.tab-bar').slideDown('fast');
         });

           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-tab-projects.default', tabProjectsWidget);
    });
})(jQuery)

