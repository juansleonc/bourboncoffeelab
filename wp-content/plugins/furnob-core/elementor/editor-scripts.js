jQuery.noConflict();
!(function ($) {
	"use strict";
	
	function updatePageSettings ( newValue ) {
		elementor.saver.saveEditor({
			status: elementor.settings.page.model.get('post_status'),
			onSuccess: () => {
				elementor.reloadPreview();
			}
		});
	}

	$(document).ready(function(){
		elementor.settings.page.addChangeCallback( 'furnob_elementor_hide_page_header', updatePageSettings );
		elementor.settings.page.addChangeCallback( 'furnob_elementor_page_header_type', updatePageSettings );
		elementor.settings.page.addChangeCallback( 'furnob_elementor_page_header_style', updatePageSettings );
		elementor.settings.page.addChangeCallback( 'furnob_elementor_hide_page_footer', updatePageSettings );
		elementor.settings.page.addChangeCallback( 'furnob_elementor_page_footer_type', updatePageSettings );
		elementor.settings.page.addChangeCallback( 'furnob_elementor_footer_instagram', updatePageSettings );
		elementor.settings.page.addChangeCallback( 'furnob_elementor_logo', updatePageSettings );
		elementor.settings.page.addChangeCallback( 'furnob_elementor_enable_sidebar_collapse', updatePageSettings );
	});
	

})(jQuery);
