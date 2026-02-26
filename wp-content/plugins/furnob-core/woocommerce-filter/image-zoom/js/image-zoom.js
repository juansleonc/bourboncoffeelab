(function ($) {
  "use strict";

	$(document).ready(function() {
		
		$("a.woocommerce-product-gallery__trigger").appendTo(".flex-viewport");
		
		$('.woocommerce-product-gallery__image').zoom();
		
	});
	
}(jQuery));