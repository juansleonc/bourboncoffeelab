(function ($) {
  "use strict";
	
	$(document).ready(function() {
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
	});

})(jQuery);
