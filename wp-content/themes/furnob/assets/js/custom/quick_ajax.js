jQuery(document).ready(function($) {
	"use strict";

	$(document).on('click', 'a.detail-bnt', function(event){
		event.preventDefault(); 
        var data = {
			cache: false,
            action: 'quick_view',
			beforeSend: function() {
				$('body').append('<svg class="loader-image preloader quick-view" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg"><circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle></svg></div>');
			},
			'id': $(this).attr('href'),
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		$.post(MyAjax.ajaxurl, data, function(response) {
            $.magnificPopup.open({
                type: 'inline',
                items: {
                    src: response
                }
            })

			  const slider = document.querySelectorAll( '.site-slider' );

			  if ( slider !== null ) {
				for( var i = 0; i < slider.length; i++ ) {
				  const self = slider[i];

				  /* options */
				  const desktop = parseInt( self.dataset.desktop );
				  const tablet = parseInt( self.dataset.tablet );
				  const mobile = parseInt( self.dataset.mobile );
				  const speed = parseInt( self.dataset.speed );
				  const loop = self.dataset.loop === 'true' ? true : false;
				  const gutter = parseInt( self.dataset.gutter );

				  const autoplay = self.dataset.autoplay === 'true' ? true : false;
				  const autospeed = parseInt( self.dataset.autospeed );
				  const autostop = self.dataset.autostop === 'true' ? true : false;

				  const nav = self.dataset.nav === 'true' ? true : false;
				  const dots = self.dataset.dots === 'true' ? true : false;
				  const dotsData = self.dataset.dotsdata === 'true' ? true : false;

				  $( self ).owlCarousel({
					loop: loop,
					dots: dots,
					dotsData: dotsData,
					nav: nav,
					smartSpeed: speed,
					margin: gutter,
					responsiveClass:true,
					autoplay: autoplay,
					autoplayTimeout: autospeed,
					autoplayHoverPause: autostop,
					navText: ['<i class="klbth-icon-left-open-big"></i>','<i class="klbth-icon-right-open-big"></i>'],
					responsive : {
					  0 : {
						items: mobile,
						nav:false
					  },
					  480 : {
						items: mobile,
						nav:false
					  },
					  768 : {
						items: tablet
					  },
					  1024 : {
						items: tablet
					  },
					  1200 : {
						items: desktop
					  }
					}
				  });

				  if ( nav === true ) {
					const images = self.querySelectorAll( 'img' );

					imagesLoaded( images, () => {
					  self.classList.add( 'images-loaded' );

					  for( var i = 0; i < images.length; i++ ) {
						const img = images[i];
						const imageHeight = img.clientHeight;

						const prevButton = self.querySelector( '.owl-prev' );
						const nextButton = self.querySelector( '.owl-next' );

						prevButton.style.top = `${imageHeight / 2 - 12}px`;
						nextButton.style.top = `${imageHeight / 2 - 12}px`;
					  }
					});
				  }
				}
			  }
			  
			  function qty() {
				var container = $( '.quantity:not(.ajax-quantity)' );
				container.each( function() {
				  var self = $( this );
				  var buttons = $( this ).find( '.quantity-button' );
				  buttons.each( function() {
					$(this).on( 'click', function(event) {
					  var qty_input = self.find( '.input-text.qty' );
					  if ( $(qty_input).prop('disabled') ) return;
					  var qty_step = parseFloat($(qty_input).attr('step'));
					  var qty_min = parseFloat($(qty_input).attr('min'));
					  var qty_max = parseFloat($(qty_input).attr('max'));


					  if ( $(this).hasClass('minus') ){
						var vl = parseFloat($(qty_input).val());
						vl = ( (vl - qty_step) < qty_min ) ? qty_min : (vl - qty_step);
						$(qty_input).val(vl);
					  } else if ( $(this).hasClass('plus') ) {
						var vl = parseFloat($(qty_input).val());
						vl = ( (vl + qty_step) > qty_max ) ? qty_max : (vl + qty_step);
						$(qty_input).val(vl);
					  }

					  qty_input.trigger( 'change' );
					});
				  });
				});
			  }

			  qty();
			  $('body').on( 'updated_cart_totals', qty );

			  function sizechart() {
				  const container = document.querySelector( '.size-holder' );
				  const button = document.querySelectorAll( '.size-button' );
				  const close = document.querySelector( '.size-holder .size-holder-close' );

				  if ( container !== null && button !== null ) {
					for ( var i = 0; i < button.length; i++ ) {

					  button[i].addEventListener( 'click', ( e ) => {
						e.preventDefault();
						container.classList.add( 'active' );
					  }, false);
					}

					close.addEventListener( 'click', ( e ) => {
					  e.preventDefault();
					  container.classList.remove( 'active' );
					}, false);
					
					$('.size-holder').on( 'click', function(e) {
						e.preventDefault();
						container.classList.remove( 'active' );
					});
					  
				  }
			  }
			  sizechart();

			  
			$("form.cart.grouped_form .input-text.qty").attr("value", "0");

			$( document.body ).trigger( 'furnobSinglePageInit' );

			$(".loader-image").remove();
        });
    });	

});