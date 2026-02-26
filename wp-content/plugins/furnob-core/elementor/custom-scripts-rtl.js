/* KLB Addons for Elementor v1.0 */

jQuery.noConflict();
!(function ($) {
	"use strict";
	
	/* CAROUSEL*/
	function klb_carousel($scope, $) {
		
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
	  
	}
	
	/* COUNTER */
	function klb_counter($scope, $) {
      const countdown = document.querySelectorAll( '.countdown' );

      if ( countdown !== null ) {
        for ( var i = 0; i < countdown.length; i++ ) {
          const self = countdown[i];

          const countDate = self.dataset.date;
          const expired = self.dataset.text;
          let countDownDate = new Date( countDate ).getTime();

          const d = self.querySelector( '.days' );
          const h = self.querySelector( '.hours' );
          const m = self.querySelector( '.minutes' );
          const s = self.querySelector( '.second' );

          var x = setInterval(function() {

            var now = new Date().getTime();
  
            var distance = countDownDate - now;
  
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            d.innerHTML = ( '0' + days ).slice(-2);
            h.innerHTML = ( '0' + hours ).slice(-2);
            m.innerHTML = ( '0' + minutes ).slice(-2);
            s.innerHTML = ( '0' + seconds ).slice(-2);
  
            if (distance < 0) {
              clearInterval(x);
              console.log( 'expired' );
              self.innerHTML = '<div class="expired">' + expired + '</div>'
              /* document.getElementById("demo").innerHTML = expired; */
            }
          }, 1000);
        }
      }
	}
	
	



    jQuery(window).on('elementor/frontend/init', function () {

        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-home-slider.default', klb_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-banner-slider.default', klb_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-product-categories.default', klb_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-product-carousel.default', klb_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-counter-box.default', klb_counter);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-counter-box2.default', klb_counter);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-banner-carousel.default', klb_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-client-carousel.default', klb_carousel);
        elementorFrontend.hooks.addAction('frontend/element_ready/furnob-testimonial-carousel.default', klb_carousel);

    });

})(jQuery);
