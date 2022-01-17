(function($){
    $(window).on('elementor/frontend/init', () => {
        
       function projectsWidget($element){         
          
           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-projects', projectsWidget);
    });
})(jQuery)

