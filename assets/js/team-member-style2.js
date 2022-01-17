class teamMemberStyle2WidgetClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                firstSelector: '.mm-ext-team-member-widget .team-memeber.read-more'

            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $firstSelector: this.$element.find(selectors.firstSelector),         
        };
    }

    bindEvents() {
        this.elements.$firstSelector.on('click', this.onFirstSelectorClick.bind(this));
       
    }

    onFirstSelectorClick(event) {
        event.preventDefault();
       // this.elements.$firstSelector.parents('.mm-ext-navi-menu').toggleClass('open-menu');
        console.log('click: read-more');
        
        var parents_div_team = this.elements.$firstSelector.parents('.elementor-container.elementor-column-gap-default');
        jQuery('.team-memeber').not(this.elements.$firstSelector).removeClass('active');
	    jQuery('.member-description').hide();
	    this.elements.$firstSelector.toggleClass('active'); 
	    if (jQuery(window).width() <= 767){
		    
	        jQuery('.member-description').remove();
	         var parents_div_team  =  this.elements.$firstSelector.parents('.elementor-top-column'),
	             index  = parents_div_team.index();
	             console.log('index='+index);
	        if(index %2 == 0){
	            parents_div_team = parents_div_team.next();
	        }
	        
	     }
	    var member_desc_box = this.elements.$firstSelector.parents('section').find('.member-description');
		var member_desc_content = this.elements.$firstSelector.children('.description');  
		if(this.elements.$firstSelector.hasClass('active')){
			if(member_desc_box.length >=1){
				parents_div_team = this.elements.$firstSelector.parents('section');
			    parents_div_team.find('.member-description').html('<div class="wrap-content">'+member_desc_content.html()+'</div>');
			    parents_div_team.find('.member-description').show();
		  	}else{
		  		parents_div_team.after('<div class="member-description"><div class="wrap-content">'+member_desc_content.html()+'</div></div>');
			 
		  }
		  if (jQuery(window).width() <= 767){jQuery('html').animate({scrollTop:jQuery('.member-description').offset().top}, '500'); }
		 
		}
    }//event
    
};
(function($){
	$(window).on('elementor/frontend/init', () => {
		
		
		$('.mm-ext-team-member-widget').parents('section').attr('id','meet-our-team');
		$('.mm-ext-team-member-widget').parents('.elementor-row').addClass('moomoo-team');
		

		function teamMemberStyle2Widget($element){ 
		 elementorFrontend.elementsHandler.addHandler(teamMemberStyle2WidgetClass, {
            $element
        });  
		 $('.team-memeber>name').click(function(event) {
		 	$('.mm-ext-team-member-widget .team-memeber.read-more').trigger('click');
		 });
	       
	   };
		elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-team-member-style2.default', teamMemberStyle2Widget);
	});
} (jQuery));