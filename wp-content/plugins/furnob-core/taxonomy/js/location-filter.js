(function ($) {
  "use strict";

	$(document).ready(function () {
 
      const container = document.querySelector( '.site-location' );
      const button = document.querySelectorAll( '.select-location' );
      const close = document.querySelector( '.site-location .site-location-close' );

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
		
		$('.site-location ul li a').on( 'click', function(e) {
		  $.cookie("location", $(this).data('value'));
		  location.reload(true);
		});
		
		  $('.site-location').on( 'click', function(e) {
			  e.preventDefault();
			  container.classList.remove( 'active' );
		  });
		
      }
	
	});

})(jQuery);
