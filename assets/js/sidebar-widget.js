jQuery(window).on('elementor/frontend/init', () => {
    
    function sidebarWidget(){    
   
   
       var height_admin_bar = jQuery('div#wpadminbar').height();
        if(jQuery('div#wpadminbar').length <1){
          height_admin_bar = 0;
        }
        var bottomStop = jQuery('.elementor-location-footer').outerHeight(true) + jQuery(".explore-topics").outerHeight(true) +45;
          if(jQuery('.mm-ext-sidebar-widget').length>=1){

            jQuery('.mm-ext-sidebar-widget').sticky( {topSpacing: height_admin_bar,bottomSpacing: bottomStop} );

          }
  
   };
   
    elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-sidebar.default', sidebarWidget);
});
