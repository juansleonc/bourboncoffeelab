(function ($) {
  "use strict";

	$(document).on('furnobShopPageInit', function () {
		furnobThemeModule.sitescroll();
	});

	furnobThemeModule.sitescroll = function() {
      const container = document.querySelectorAll( '.site-scroll' );

      for( var i = 0; i < container.length; i++ ) {
        const ps = new PerfectScrollbar( container[i], {
          suppressScrollX: true,
          wheelPropagation: true
        });

        ps.update();
      }
	}
	
	$(document).ready(function() {
		furnobThemeModule.sitescroll();
	});

})(jQuery);
