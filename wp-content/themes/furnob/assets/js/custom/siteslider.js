(function ($) {
  "use strict";

	$(document).on('furnobShopPageInit', function () {
		furnobThemeModule.siteslider();
	});

	furnobThemeModule.siteslider = function() {
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
	
	$(document).ready(function() {
		furnobThemeModule.siteslider();
	});

})(jQuery);
