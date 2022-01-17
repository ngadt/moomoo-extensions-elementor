/*(function($){
	 $(window).load(function() {
	      	alert('ac1');
	      	$('input.my-color-field').wpColorPicker();
	      });
    $(window).on('elementor/frontend/init', () => {
       
       function MoomooGradientBackgroundControls(elementor){  
      
	      $(window).load(function() {
	      	alert('ac0');
	      	$('.my-color-field').wpColorPicker();
	      });
      	
         
           
       };
       // moomoo-team-memeber-map-light-hight get from get_name
        elementor.addControlView('mmbackgroundgradient', MoomooGradientBackgroundControls);
   });
})(jQuery)*/
(function($){
	jQuery(window).on("elementor:init", function () {

		var ControlBackgroundGradient = elementor.modules.controls.BaseMultiple;

		//var _colorPicker = _interopRequireDefault(__webpack_require__(/*! ../utils/color-picker */ "../assets/dev/js/editor/utils/color-picker.js"));
		var MoomooGradientBackgroundControls = elementor.modules.controls.BaseMultiple.extend({
			ui: function ui() {
			    var ui = ControlBackgroundGradient.prototype.ui.apply(this, arguments);
			   
			    ui.moomooColorPinker = '.moomoo-color-picker';
			 //   ui.colorPickerPlaceholder = '.elementor-color-picker-placeholder';
			    return ui;
			 },
			 
			  initColors: function initColors() {
			  	console.log('initColors 123');
			  	this.ui.moomooColorPinker.wpColorPicker({
					    // you can declare a default color here,
					    // or in the data-default-color attribute on the input
					    defaultColor: true,
					    // a callback to fire whenever the color changes to a valid color
					    change: function(event, ui){console.log('changing...')},
					    // a callback to fire when the input is emptied or an invalid color
					    clear: function() {console.log('clear...')},
					    // hide the color picker controls on load
					    hide: true,
					    // show a group of common colors beneath the square
					    // or, supply an array of colors to customize further
					    palettes: true
					});
			  	/*	this.ui.colorPickerPlaceholder.iris({
					// or in the data-default-color attribute on the input
					defaultColor: true,
					// a callback to fire whenever the color changes to a valid color
					change: function(event, ui){console.log('change')},
					// a callback to fire when the input is emptied or an invalid color
					clear: function() {console.log('clear')},
					// hide the color picker controls on load
					hide: false,
					// show a group of common colors beneath the square
					palettes: true
					});*/
			  },
			  initColorsE: function initColorsE() {
				    var _this2 = this;

				    this.colorPicker = new _colorPicker.default({
				      picker: {
				        el: this.ui.colorPickerPlaceholder[0],
				        default: this.getControlValue('color')
				      },
				      onChange: function onChange() {
				        _this2.setValue('color', _this2.colorPicker.getColor());
				      },
				      onClear: function onClear() {
				        _this2.setValue('color', '');
				      }
				    });
				  },
			 onReady: function onReady() {
	         	console.log('abc MoomooGradientBackgroundControls');
	         	//$('.my-color-field').wpColorPicker();
	            this.initColors();
	           // this.initColorsE();
	        },
	         onBeforeDestroy: function onBeforeDestroy() {
			   // this.colorPicker.destroy();
			  }
		})

		/*function MoomooGradientBackgroundControls(){
			//console.log('working fine ...');
			$('input.my-color-field').wpColorPicker();
		}*/

		elementor.addControlView("mmbackgroundgradient",MoomooGradientBackgroundControls );

	})
	/*var MoomooGradientBackgroundControls = elementor.modules.controls.BaseData.extend({
	    onReady: function () {
	       $(window).load(function() {
		      	alert('ac0');
		      	$('.my-color-field').wpColorPicker();
		      });

	    },

	    saveValue: function () {
	        this.setValue(this.ui.textarea[0].emojioneArea.getText());
	    },

	    onBeforeDestroy: function () {
	        this.saveValue();
	        this.ui.textarea[0].emojioneArea.off();
	    }
	    
	});*/

})(jQuery)