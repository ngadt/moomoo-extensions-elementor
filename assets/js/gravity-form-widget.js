(function($){
    $(window).on('elementor/frontend/init', () => {
       
       function gravityFormWidget($element){  
      
         $('form .gform_body select').wrap('<span class="uael-gf-select-custom"></span>')
           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-gravity-form.default', gravityFormWidget);
    });
})(jQuery)

