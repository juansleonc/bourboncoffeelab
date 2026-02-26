(function ($) {
  "use strict";

	$(window).scroll(function() {
		if ($(this).scrollTop() > 300) {
			$('.scrollToTop').addClass('button-show');
		} else {
			$('.scrollToTop').removeClass('button-show');
		}
	});
  
	$(document).ready(function() {	
		$(".scrollToTop").click(function () {
		   //1 second of animation time
		   //html works for FFX but not Chrome
		   //body works for Chrome but not FFX
		   //This strange selector seems to work universally
		   $("html, body").animate({scrollTop: 0}, 100);
		});
	});

}(jQuery));	

