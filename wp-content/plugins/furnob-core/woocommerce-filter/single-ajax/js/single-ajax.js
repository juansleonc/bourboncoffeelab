(function ($) {
  "use strict";

	$(document).on('furnobSinglePageInit', function () {
		woocommerceSingleAjax();
	});

	function woocommerceSingleAjax() {
		$("form.cart").addClass("single-ajax");
		
		// AJax single add to cart
		$('.product:not(.product-type-external) form.cart').on('submit', function(e) {
			e.preventDefault();

			var form = $(this);
			$('form.cart button').append('<svg class="loader-image preloader added" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg>')

			var formData = new FormData(form[0]);
			formData.append('add-to-cart', form.find('[name=add-to-cart]').val() );

			// Ajax action.
			$.ajax({
				url: wc_add_to_cart_params.wc_ajax_url.toString().replace( '%%endpoint%%', 'furnob_add_to_cart' ),
				data: formData,
				type: 'POST',
				processData: false,
				contentType: false,
				complete: function( response ) {
					response = response.responseJSON;

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

					var $thisbutton = form.find('.single_add_to_cart_button'); //
					$thisbutton = null; // uncomment this if you don't want the 'View cart' button

					// Trigger event so themes can refresh other areas.
					$( document.body ).trigger( 'added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ] );

					// Remove existing notices
					$( '.woocommerce-error, .woocommerce-message, .woocommerce-info' ).remove();

					// Add new notices
					form.closest('.single-product').before(response.fragments.notices_html)

					$('.product form.cart.single-ajax button svg').remove();
				}
			});
		});
	}
	
	$(document).ready(function() {
		woocommerceSingleAjax();
	});
	
}(jQuery));