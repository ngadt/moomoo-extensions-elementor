(function($){
    $(window).on('elementor/frontend/init', () => {
       
       function gravityFormWidget($element){  
      
         $('form .gform_body select').wrap('<span class="uael-gf-select-custom"></span>');
         /*$( ".elementor-widget-moomoo-gravity-form .gform_body .gfield" ).each(function( index ) {
         	if($(this).children('.gfield_description').lenght >0)
		  	$(this).children('.gfield_label').wrap( $(this).children('.gfield_description'));
		});
         $('').wrap('<span class="uael-gf-select-custom"></span>');*/
           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-gravity-form.default', gravityFormWidget);
    });
})(jQuery)

