jQuery.noConflict();
(function($) {
    "use strict";

jQuery(document).ready(function($){
	
/*----------------------------------------------------------------------------------*/
/*	Display post format meta boxes as needed
/*----------------------------------------------------------------------------------*/
	
	function checkFormat(){
		var format = $('#post-format-selector-0').val();

				
		//only run on the posts page
		if(typeof format != 'undefined'){
			
			$('#editor div[id^=klb-blogmeta-]').hide();
			$('#editor #klb-blogmeta-'+format+'').stop(true,true).fadeIn(500);
	
		}
	
	}

    $(document).on("change", "#post-format-selector-0", function() {
        checkFormat();
    });


	checkFormat();
	


});

})(jQuery); // End of use strict