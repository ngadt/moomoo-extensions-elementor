class WidgetHandlerClass extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
                firstSelector: '.moomoo-elementor-extension .mm-ext-navi-menu .wrap-menu a',
                secondSelector: '.moomoo-elementor-extension .mm-icon-close',
                thirdSelector: '.moomoo-elementor-extension li.menu-item-has-children'
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings('selectors');
        return {
            $firstSelector: this.$element.find(selectors.firstSelector),
            $secondSelector: this.$element.find(selectors.secondSelector),
            $thirdSelector: this.$element.find(selectors.thirdSelector)
        };
    }

    bindEvents() {
        this.elements.$firstSelector.on('click', this.onFirstSelectorClick.bind(this));
        this.elements.$secondSelector.on('click', this.onSecondSelectorClick.bind(this));
        this.elements.$thirdSelector.on('click', this.onThirdSelectorClick.bind(this));
    }

    onFirstSelectorClick(event) {
        event.preventDefault();
        this.elements.$firstSelector.parents('.mm-ext-navi-menu').toggleClass('open-menu');
        jQuery('html').toggleClass('remove-scroll');
    }
    onSecondSelectorClick(event) {
        this.elements.$secondSelector.parents('.mm-ext-navi-menu').removeClass('open-menu');
        jQuery('html').removeClass('remove-scroll');
    }
    onThirdSelectorClick(event){   

    	jQuery(event.target).find('ul.sub-menu').slideToggle();
    	if((event.target).tagName == 'A'){
    		jQuery(event.target).parent('li.menu-item-has-children').trigger('click');
    	}   	
    	
    }
};
jQuery(window).on('elementor/frontend/init', () => {
    const addHandler = ($element) => {
        elementorFrontend.elementsHandler.addHandler(WidgetHandlerClass, {
            $element
        });
    };

    elementorFrontend.hooks.addAction('frontend/element_ready/moomoo-menu.default', addHandler);
});

(function($){	 
	var is_safari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));
	var is_ie = /*@cc_on!@*/false || !!document.documentMode;
	
	//console.log('is_safari='+ is_safari);
	//console.log('is_ie='+is_ie);
	
	//if (is_safari  || is_ie){
		/*$('#form-field-datepicker').datepicker();
		$('#form-field-timepicker').timepicker();*/

	//}
	$('#back').on('click', function(e){
		e.preventDefault();
		window.history.back();
	})
})(jQuery);

