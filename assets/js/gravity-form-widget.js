(function($){
    $(window).on('elementor/frontend/init', () => {
       
       function gravityFormWidget($element){        
           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-gravity-form.default', gravityFormWidget);
    });
})(jQuery)

