(function ($) {
  "use strict";

	$(document).on('furnobShopPageInit', function () {
		furnobThemeModule.woocommercePriceSlider();
	});

	furnobThemeModule.woocommercePriceSlider = function() {
		$('.widget_klb_product_categories ul.children').closest('li').addClass("cat-parent");
		$(".widget_klb_product_categories ul > li.cat-parent").append('<span class="subDropdown plus"></span>');
		$('.widget_klb_product_categories ul.children input[checked]').closest('li.cat-parent').addClass("current-cat");

		$(".subDropdown")[0] && $(".subDropdown").on("click", function() {
			$(this).toggleClass("plus"), $(this).toggleClass("minus"), $(this).parent().find("> ul").slideToggle();
		});
	}
	
	$(document).ready(function() {
		furnobThemeModule.woocommercePriceSlider();
	});

})(jQuery);
