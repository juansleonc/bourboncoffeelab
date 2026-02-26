jQuery(document).ready(function($) {
	"use strict";

	$(".flex-control-thumbs").addClass("owl-carousel");
	
	$('.flex-control-thumbs').owlCarousel({
		items: $('.woocommerce-product-gallery.woocommerce-product-gallery--with-images').attr('data-columns'),
		margin:10,
		pagination: true,
		rewindNav: true,
		dots: false,
		responsive:{
			0:{
				items:4
			},
			600:{
				items:4
			},
			1300:{
				items:$('.woocommerce-product-gallery.woocommerce-product-gallery--with-images').attr('data-columns')
			}
		}

	});

});