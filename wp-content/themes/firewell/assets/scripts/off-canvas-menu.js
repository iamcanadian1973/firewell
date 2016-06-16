jQuery( document ).ready(function( $ ) {
	
	var pushy            = $('.pushy'), //menu css class
		body             = $('body'),
		header			 = $('.site-header'),
		container        = $('.site-container'), //container css class
		siteOverlay		 = $('.site-overlay'), // site-overlay div
		push             = $('.push'), //css class to add pushy capability
		pushyClass       = 'pushy-left pushy-open', //menu position & menu open class
		pushyActiveClass = 'pushy-active', //css class to toggle site overlay
		containerClass   = 'container-push', //container open class
		pushClass        = 'push-push', //css class to add pushy capability
		menuBtn          = $('.menu-btn, .pushy a'), //css classes to toggle the menu
		closeBtn         = $('.close-btn'),
		menuSpeed        = 200, //jQuery fallback menu speed
		menuWidth        = pushy.width() + 'px'; //jQuery fallback menu width

	function togglePushy() {
		console.log("togglePushy");
		body.toggleClass(pushyActiveClass); //toggle site overlay
		pushy.toggleClass(pushyClass);
		//container.toggleClass(containerClass);
		push.toggleClass(pushClass); //css class to add pushy capability
	}

	function openPushyFallback() {
		console.log("openPushyFallback");
		body.addClass(pushyActiveClass);
		header.addClass(pushClass);
		pushy.addClass(pushyClass);
		container.addClass(pushClass);
		// body.animate({right: "260px"}, menuSpeed); //animate the elements with the push class
	}

	function closePushyFallback() {
		console.log("closePushyFallback");
		body.removeClass(pushyActiveClass);
		header.removeClass(pushClass);
		pushy.removeClass("pushy-open");
		container.removeClass(pushClass);
	}

	if ( Modernizr.csstransforms3d ) {
		//toggle menu
		menuBtn.click(function() {
			togglePushy();
		});
		//close menu when clicking site overlay
		siteOverlay.click(function() {
			togglePushy();
		});
	} else {
		//jQuery fallback
		container.css({"overflow-x": "hidden"}); //fixes IE scrollbar issue

		//keep track of menu state (open/close)
		var state = true;

		//toggle menu
		menuBtn.click(function() {
			if (state) {
				openPushyFallback();
				state = false;
			} else {
				closePushyFallback();
				state = true;
			}
		});

		// close menu when clicking site overlay
		siteOverlay.click(function() {
			if (state) {
				openPushyFallback();
				state = false;
			} else {
				closePushyFallback();
				state = true;
			}
		});

		//close menu when clicking close button
		closeBtn.click(function() {
			closePushyFallback();
			state = true;
		});
	}


	$( '.menu-btn, .close-btn' ).on( 'click', function( e ) {
		e.preventDefault();
	});
});