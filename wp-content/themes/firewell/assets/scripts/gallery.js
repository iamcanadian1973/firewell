(function($) {
	
	'use strict';
	
	var $grid = $('.gallery-grid');
	// initialize
	$grid.isotope({
		layoutMode: 'packery',
		packery: {
			//gutter: '.gutter-sizer'
		},
		itemSelector: '.gallery-img-wrapper',
		percentPosition: true
	});
	$grid.imagesLoaded().progress( function() {
	  $grid.isotope({
			layoutMode: 'packery',
			packery: {
				//gutter: '.gutter-sizer'
			},
			itemSelector: '.gallery-img-wrapper',
			percentPosition: true
		});
	});
	
	
	
})(jQuery);

