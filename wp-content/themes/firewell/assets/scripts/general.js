(function($) {
	
	'use strict';
	
	if ( $('.section-faq h3').size() && window.location.hash ) {
		
		var demo = new jQueryCollapse($("#demo"));
		
		var hash = window.location.hash,
			index = 0,
			$hash = $(hash);
		// hash.slice(1)	
		
		index = $hash.index() -1;
		
		var accordion = new jQueryCollapse($(".accordion"));
		accordion.toggle(index); // Toggle section
		
		//scroll to section
		$.smoothScroll({
			offset: -20,
			scrollTarget: hash,
		});
	}
	
	
})(jQuery);

