/* global woodmart_settings */
(function($) {
	furnobThemeModule.$document.on(' furnobShopPageInit', function () {
		furnobThemeModule.woocommercePriceSlider1();
	});

	furnobThemeModule.woocommercePriceSlider1 = function() {
		
		// Price Slider 2
		$( document.body ).on( 'price_slider_create price_slider_slide', function( event, min, max ) {

			$( '.price_slider_amount span.from' ).html( accounting.formatMoney( min, {
				symbol:    woocommerce_price_slider_params.currency_format_symbol,
				decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
				thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
				precision: woocommerce_price_slider_params.currency_format_num_decimals,
				format:    woocommerce_price_slider_params.currency_format
			} ) );

			$( '.price_slider_amount span.to' ).html( accounting.formatMoney( max, {
				symbol:    woocommerce_price_slider_params.currency_format_symbol,
				decimal:   woocommerce_price_slider_params.currency_format_decimal_sep,
				thousand:  woocommerce_price_slider_params.currency_format_thousand_sep,
				precision: woocommerce_price_slider_params.currency_format_num_decimals,
				format:    woocommerce_price_slider_params.currency_format
			} ) );

			$( document.body ).trigger( 'price_slider_updated', [ min, max ] );
		});

		function init_price_filter() {
			$( 'input#min_price, input#max_price' ).hide();
			$( '.price_slider, .price_label' ).show();

			var min_price         = $( '.price_slider_amount #min_price' ).data( 'min' ),
				max_price         = $( '.price_slider_amount #max_price' ).data( 'max' ),
				step              = $( '.price_slider_amount' ).data( 'step' ) || 1,
				current_min_price = $( '.price_slider_amount #min_price' ).val(),
				current_max_price = $( '.price_slider_amount #max_price' ).val();

			$( '.price_slider:not(.ui-slider)' ).slider({
				range: true,
				animate: true,
				min: min_price,
				max: max_price,
				step: step,
				values: [ current_min_price, current_max_price ],
				create: function() {

					$( '.price_slider_amount #min_price' ).val( current_min_price );
					$( '.price_slider_amount #max_price' ).val( current_max_price );

					$( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
				},
				slide: function( event, ui ) {

					$( 'input#min_price' ).val( ui.values[0] );
					$( 'input#max_price' ).val( ui.values[1] );

					$( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
				},
				change: function( event, ui ) {

					$( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
				}
			});
		}

		init_price_filter();
		$( document.body ).on( 'init_price_filter', init_price_filter );

		var hasSelectiveRefresh = (
			'undefined' !== typeof wp &&
			wp.customize &&
			wp.customize.selectiveRefresh &&
			wp.customize.widgetsPreview &&
			wp.customize.widgetsPreview.WidgetPartial
		);
		if ( hasSelectiveRefresh ) {
			wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function() {
				init_price_filter();
			} );
		}
		
		// Price Slider 1
		var $min_price = $('.price_slider_amount #min_price');
		var $max_price = $('.price_slider_amount #max_price');
		var $products = $('.products');

		if (typeof woocommerce_price_slider_params === 'undefined' || $min_price.length < 1 || !$.fn.slider) {
			return false;
		}

		var $slider = $('.price_slider');

		if ($slider.slider('instance') !== undefined) {
			return;
		}

		// Get markup ready for slider
		$('input#min_price, input#max_price').hide();
		$('.price_slider, .price_label').show();

		// Price slider uses $ ui
		var min_price         = $min_price.data('min'),
		    max_price         = $max_price.data('max'),
		    current_min_price = parseInt(min_price, 10),
		    current_max_price = parseInt(max_price, 10);

		if ($products.attr('data-min_price') && $products.attr('data-min_price').length > 0) {
			current_min_price = parseInt($products.attr('data-min_price'), 10);
		}

		if ($products.attr('data-max_price') && $products.attr('data-max_price').length > 0) {
			current_max_price = parseInt($products.attr('data-max_price'), 10);
		}

		$slider.slider({
			range  : true,
			animate: true,
			min    : min_price,
			max    : max_price,
			values : [
				current_min_price,
				current_max_price
			],
			create : function() {
				$min_price.val(current_min_price);
				$max_price.val(current_max_price);

				furnobThemeModule.$body.trigger('price_slider_create', [
					current_min_price,
					current_max_price
				]);
			},
			slide  : function(event, ui) {
				$('input#min_price').val(ui.values[0]);
				$('input#max_price').val(ui.values[1]);

				furnobThemeModule.$body.trigger('price_slider_slide', [
					ui.values[0],
					ui.values[1]
				]);
			},
			change : function(event, ui) {
				furnobThemeModule.$body.trigger('price_slider_change', [
					ui.values[0],
					ui.values[1]
				]);
			}
		});

		setTimeout(function() {
			furnobThemeModule.$body.trigger('price_slider_create', [
				current_min_price,
				current_max_price
			]);

			if ($slider.find('.ui-slider-range').length > 1) {
				$slider.find('.ui-slider-range').first().remove();
			}
		}, 10);
	};

})(jQuery);
