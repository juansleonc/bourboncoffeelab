'use strict';

window.furnob = {};

(
function(furnob, $) {
    furnob = furnob || {};

    $.extend(furnob, {
        Swatches: {
            init: function() {
                var $term = $('.klbtheme-term'),
                $active_term = $('.klbtheme-term:not(.klbtheme-disabled)');

                // load default value
                $term.each(function() {
                    var $this       = $(this),
                        term        = $this.attr('data-term'),
                        attr        = $this.closest('.klbtheme-terms').attr('data-attribute'),
                        $select_box = $this.closest('.klbtheme-terms').parent().find('select#' + attr),
                        val         = $select_box.val();

                    if ( val != '' && term == val ) {
                        $(this).addClass('klbtheme-selected').find('input[type="radio"]').prop('checked', true);
								
						
                    }
                });

				
                $active_term.unbind('click touch').on('click touch', function(e) {
                    var $this       = $(this),
                        term        = $this.attr('data-term'),
                        title       = $this.attr('title'),
                        attr        = $this.closest('.klbtheme-terms').attr('data-attribute'),
                        $select_box = $this.closest('.klbtheme-terms').parent().find('select#' + attr);

                    if ( $this.hasClass('klbtheme-disabled') ) {
                        return false;
                    }

                    if ( !$this.hasClass('klbtheme-selected') ) {
                        $select_box.val(term).trigger('change');

                        $this.closest('.klbtheme-terms').find('.klbtheme-selected').removeClass('klbtheme-selected').find('input[type="radio"]').prop('checked', false);

                        $this.addClass('klbtheme-selected').find('input[type="radio"]').prop('checked', true);

                        $(document).trigger('klbtheme_selected', [attr, term, title]);
                    }

                    e.preventDefault();
                });

                $(document).on('woocommerce_update_variation_values', function(e) {
                    $(e['target']).find('select').each(function() {
                        var $this = $(this);
                        var $terms = $this.parent().parent().find('.klbtheme-terms');

                        $terms.find('.klbtheme-term').removeClass('klbtheme-enabled').addClass('klbtheme-disabled');

                        $this.find('option.enabled').each(function() {
                            var val = $(this).val();

                            $terms.find('.klbtheme-term[data-term="' + val + '"]').removeClass('klbtheme-disabled').addClass('klbtheme-enabled');
                        });
                    });
                });
				
				
				$('table.variations tr').each(function() {
					if($(this).find('.klbtheme-selected').length !== 0){
						$(this).find('label').append('<span class="selected-value">: '+ $(this).find('.klbtheme-selected').html() +'</span>');
					}
				});
				
				$(document).on('klbtheme_selected', function(e) {
					$('span.selected-value').remove();
					$('table.variations tr').each(function() {
						if($(this).find('.klbtheme-selected').length !== 0){
							$(this).find('label').append('<span class="selected-value">: '+ $(this).find('.klbtheme-selected').html() +'</span>');
						}
					});
				});
				
				
                $(document).on('reset_data', function(e) {
                    $(document).trigger('klbtheme_reset');
                    var $this = $(e['target']);
					
					$('span.selected-value').remove();
					
                    $this.find('.klbtheme-selected').removeClass('klbtheme-selected').find('input[type="radio"]').prop('checked', false);

                    $this.find('select').each(function() {
                        var attr = $(this).attr('id');
                        var title = $(this).find('option:selected').text();
                        var term = $(this).val();

                        if ( term != '' ) {
                            $(this).parent().parent().
                            find('.klbtheme-term[data-term="' + term + '"]').
                            addClass('klbtheme-selected').find('input[type="radio"]').
                            prop('checked', true);

                            $(document).trigger('klbtheme_reset', [attr, term, title]);
                        }
                    });
                });
            }
        }
    });

}).apply(this, [window.furnob, jQuery]);

(
function(furnob, $) {

    $(document).on('wc_variation_form', function() {
        if ( typeof furnob.Swatches !== 'undefined' ) {
            furnob.Swatches.init();
        }
    });
    $(document.body).on('klbtheme_variations_init', function() {
        if ( typeof furnob.Swatches !== 'undefined' ) {
            furnob.Swatches.init();
        }
        $('.klbtheme-products-wrapper .variations_form').each(function () {
            $(this).wc_variation_form();
        });
    });

    $(document).on('found_variation', function(e, t) {
        if ( $(e['target']).closest('.klbtheme-loop-swatches').length ) {
            var $product  = $(e['target']).closest('.klbtheme-product'),
                $atc      = $product.find('.add_to_cart_button'),
                $image    = $product.find('.attachment-woocommerce_thumbnail'),
                $price    = $product.find('.price');

            if ( $atc.length ) {
                $atc.addClass('klbtheme_add_to_cart').attr('data-variation_id', t['variation_id']).attr('data-product_sku', t['sku']);

                if ( !t['is_purchasable'] || !t['is_in_stock'] ) {
                    $atc.addClass('disabled wc-variation-is-unavailable');
                } else {
                    $atc.removeClass('disabled wc-variation-is-unavailable');
                }

                $atc.removeClass('added error loading');
            }

            $product.find('a.added_to_cart').remove();

            // add to cart button text
            if ( $atc.length ) {
                $atc.text(klbtheme_vars.strings.button.add_to_cart);
            }

            // product image
            if ( $image.length ) {

                if ( $image.attr('data-src') == undefined ) {
                    $image.attr('data-src', $image.attr('src'));
                }

                if ( $image.attr('data-srcset') == undefined ) {
                    $image.attr('data-srcset', $image.attr('srcset'));
                }

                if ( $image.attr('data-sizes') == undefined ) {
                    $image.attr('data-sizes', $image.attr('sizes'));
                }

                if ( t['image']['src'] != undefined && t['image']['src'] != '' ) {
                    $image.attr('src', t['image']['src']);
                }

                if ( t['image']['srcset'] != undefined && t['image']['srcset'] != '' ) {
                    $image.attr('srcset', t['image']['srcset']);
                } else {
                    $image.attr('srcset', '');
                }

                if ( t['image']['sizes'] != undefined && t['image']['sizes'] != '' ) {
                    $image.attr('sizes', t['image']['sizes']);
                } else {
                    $image.attr('sizes', '');
                }
            }

            // product price
            if ( $price.length ) {
                if ( $price.attr('data-price') == undefined ) {
                    $price.attr('data-price', $price.html());
                }

                if ( t['price_html'] ) {
                    $price.html( t['price_html'] );
                }
            }

            $(document).trigger('klbtheme_archive_found_variation', [t]);
        }
    });

    $(document).on('reset_data', function(e) {
        if ( $(e['target']).closest('.klbtheme-loop-swatches').length ) {
            var $product  = $(e['target']).closest('.klbtheme-product'),
                $atc      = $product.find('.add_to_cart_button'),
                $image    = $product.find('.attachment-woocommerce_thumbnail'),
                $price    = $product.find('.price');

            if ( $atc.length ) {
                $atc.removeClass('klbtheme_add_to_cart disabled wc-variation-is-unavailable').attr('data-variation_id', '0').attr('data-product_sku', '');
                    $atc.removeClass('added error loading');
                }

                $product.find('a.added_to_cart').remove();

                // add to cart button text
                if ( $atc.length ) {
                    $atc.text(klbtheme_vars.strings.button.select_options);
                }

                // product image
                if ( $image.length ) {
                    $image.attr('src', $image.attr('data-src'));
                    $image.attr('srcset', $image.attr('data-srcset'));
                    $image.attr('sizes', $image.attr('data-sizes'));
                }

                // product price
                if ( $price.length ) {
                    $price.html($price.attr('data-price'));
                }

                $(document).trigger('klbtheme_archive_reset_data');
            }
        });

        $(document).on('click touch', '.klbtheme_add_to_cart', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $product = $this.closest('.klbtheme-product');
            var attributes = {};

            $this.removeClass('added error').addClass('loading');

            if ($product.length) {
                $product.find('a.added_to_cart').remove();

                $product.find('[name^="attribute"]').each(function() {
                    attributes[$(this).attr('data-attribute_name')] = $(this).val();
                });

                var data = {
                    action       : 'product_attribute_add_to_cart',
                    nonce        : klbtheme_vars.security,
                    product_id   : $this.attr('data-product_id'),
                    variation_id : $this.attr('data-variation_id'),
                    quantity     : $this.attr('data-quantity'),
                    attributes   : JSON.stringify(attributes),
                };

                $.post(klbtheme_vars.ajax_url, data, function(response) {
                    if (response) {
                        $this.removeClass('loading').addClass('added');
                        $(document.body).trigger('added_to_cart').trigger('wc_fragment_refresh');
                    } else {
                        $this.removeClass('loading').addClass('error');
                    }
                });
            }
        });
		
		
	

    }
).apply(this, [window.furnob, jQuery]);
