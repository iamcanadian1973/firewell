jQuery(function($){

	'use strict';	
	
	$.fn.imagesLoaded = function () {
			
		// get all the images (excluding those with no src attribute)
		var $imgs = this.find('img[src!=""]');
		// if there's no images, just return an already resolved promise
		if (!$imgs.length) {return $.Deferred().resolve().promise();}
	
		// for each image, add a deferred object to the array which resolves when the image is loaded (or if loading fails)
		var dfds = [];  
		$imgs.each(function(){
	
			var dfd = $.Deferred();
			dfds.push(dfd);
			var img = new Image();
			img.onload = function(){dfd.resolve();};
			img.onerror = function(){dfd.resolve();};
			img.src = this.src;
	
		});
	
		// return a master promise object which will resolve when all the deferred objects have resolved
		// IE - when all the images are loaded
		return $.when.apply($,dfds);
	
	};
		
	var page = 2;
	var posts_per_page = beloadmore.posts_per_page;
	var show_load_more = beloadmore.show_load_more;
	var loading = false;
	var post_type = beloadmore.post_type; // posts or search
	
	if( show_load_more ) {
				
		$('.load-more-posts .more-posts').append( '<span class="load-more">Load More</span>' );
		var button = $('.more-posts .load-more');	
	}
	
	$('body').on('click', '.load-more', function(){
		if( ! loading ) {
			loading = true;
 			var data = {
				action: 'be_ajax_load_more',
				nonce: beloadmore.nonce,
				page: page,
				posts_per_page: posts_per_page,
				post_type: post_type,
				query: beloadmore.query,
			};
			
			console.log(beloadmore);
			$.post(beloadmore.url, data, function(res) {
				if( res.success) {
					// default
					$('.more-posts').append( res.data );
					console.log(res.data);
					// fadein
					//$(res.data).hide().appendTo('.post-listing').fadeIn("slow"); 
					// Wait for images
					/*$(res.data).imagesLoaded().then(function(){
						$(res.data).appendTo('.post-listing');
					});*/
					
					// remove load more
					button.remove();
					// if results were found att it back
					if( res.data != '' ) {
						$('.more-posts').append( button );
					}
					page = page + 1;
					loading = false;
				} else {
					 console.log(res);
				}
			}).fail(function(xhr, textStatus, e) {
				 console.log(xhr.responseText);
			});
		}
	});
		
});