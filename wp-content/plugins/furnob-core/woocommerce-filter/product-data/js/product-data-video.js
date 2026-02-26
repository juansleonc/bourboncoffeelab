(function ($) {
  "use strict";

	$(document).ready(function() {
		
		$(".klb-single-video").appendTo(".flex-viewport");
		
		$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,

			fixedContentPos: false
		});
		
	});
	
}(jQuery));