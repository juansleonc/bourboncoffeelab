(function ($) {
  "use strict";

	$(document).on('furnobShopPageInit', function () {
		furnobThemeModule.stickysidebar();
	});

	furnobThemeModule.stickysidebar = function() {
      const sticky = document.querySelectorAll( '.sticky' );

      if ( sticky !== null ) {
        for ( var i = 0; i < sticky.length; i++ ) {
          const self = sticky;

          $( self ).theiaStickySidebar({
            // Settings
            additionalMarginTop: 30
          });
        }
      }
	}
	
	$(document).ready(function() {
		furnobThemeModule.stickysidebar();
	});

})(jQuery);
