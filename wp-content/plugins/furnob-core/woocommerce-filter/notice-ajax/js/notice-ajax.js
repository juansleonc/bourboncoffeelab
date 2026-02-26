(function ($) {
  "use strict";

	$(document).on('furnobNoticeAjaxInit', function () {
		woocommerceNoticeAjax();
	});

	function woocommerceNoticeAjax() {
		
		// Klb Notice
		$('body').append('<div class="klb-notice-ajax"></div>');
		
		// AJax single add to cart
		$(document).on('click', 'a.ajax_add_to_cart', function(e){
			e.preventDefault();

			var $thisbutton = $(this);

			var formData = new FormData();
			formData.append('add-to-cart', $thisbutton.attr( 'data-product_id' ));

			// Trigger event.
			$( document.body ).trigger( 'adding_to_cart', [ $thisbutton, formData ] );

			// Ajax action.
			$.ajax({
				url: wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'furnob_add_to_cart' ),
				data: formData,
				type: 'POST',
				processData: false,
				contentType: false,
				success: function( response ) {
					if ( ! response ) {
						return;
					}

					if ( response.error && response.product_url ) {
						window.location = response.product_url;
						return;
					}

					// Redirect to cart option
					if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
						window.location = wc_add_to_cart_params.cart_url;
						return;
					}
					
					// Trigger event so themes can refresh other areas.
					$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );
					
					$(response.fragments.notices_html).appendTo('.klb-notice-ajax').delay(3000).fadeOut(300, function(){ $(this).remove(); });

					//Close icon
					$('.woocommerce-message, .woocommerce-error').append('<div class="klb-notice-close"><i class="klbth-icon-x"></i></div>');
					$('.klb-notice-close').on('click', function(){
						$(this).closest('.woocommerce-message, .woocommerce-error').remove();
					});
					
					if (response.fragments.notices_html.indexOf('woocommerce-error') > -1){
					  window.stop();
					}

				},
				dataType: 'json'

			});
			

		});
	}
	
	$(document).ready(function() {
		woocommerceNoticeAjax();
	});
	
}(jQuery));