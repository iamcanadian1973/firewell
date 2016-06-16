(function($) {
	'use strict';	
	
	
	
	var royalSlider, nav;
	
	var opts = {
		transitionType: 'fade',
		controlNavigation:'bullets',
		imageScaleMode: 'fill',
		imageAlignCenter:true,
		arrowsNav: true,
		arrowsNavAutoHide: true,
		sliderTouch: true,
		sliderDrag:false,
		arrowsNavHideOnTouch: false,
		fullscreen: false,
		loop: true,
		autoScaleSlider: true, 
		autoScaleSliderWidth: 1300,     
		autoScaleSliderHeight: 682,
		slidesSpacing: 0,
		keyboardNavEnabled: false,
		navigateByClick: false,
		fadeinLoadedSlide: true,
		globalCaption:true,
		imgWidth: 1300,
		imgHeight: 682,
		
		autoPlay: {
				// autoplay options go gere
				enabled: true,
				pauseOnHover: false,
				delay: 5000
			}
	  };
	
   	$('.royalSlider').royalSlider(opts);
	
	// Show captions after slider init. Captions like to blink on load, so we fix this.
	$(".royalSlider").removeClass("preload");
		
	royalSlider = $(".royalSlider");
  
   // hide single slider nav
	nav = royalSlider.find('.rsNav'); 
	if (nav.length && royalSlider.data('royalSlider').numSlides <= 1) { 
		nav.hide();
	}
		
	
})(jQuery);
