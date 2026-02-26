(function ($) {
  "use strict";
	
	$(document).ready(function() {
		$("#menu-to-edit").on("click",".upload_image_button",function(e){
			var a=$(this);
			e.preventDefault();
			var r=wp.media({multiple:!1}).open().on("select",function(e){
				var t=r.state().get("selection").first().toJSON();
				if ( a.parent().find(".image-preview-wrapper .image-preview") ){
					a.parent().find(".image-preview").remove();
					a.parent().find(".image-preview-wrapper").append('<img class="image-preview" src="'+t.url+'" />');
				} else {
					a.parent().find(".image-preview-wrapper").append('<img class="image-preview" src="'+t.url+'" />');
				}
				a.parent().find(".image_attachment_id").val(t.id),
				a.parent().find(".remove_image_button").show()
			})
		}),
		
		$("#menu-to-edit").on("click",".remove_image_button",function(e){
			$(this).parent().find(".image-preview").remove(),
			$(this).parent().find(".image_attachment_id").val(""),
			$(this).hide()
		}),
		$(".remove_image_button").each(function(){
			""!=$(this).parent().find(".image_attachment_id").val()&&$(this).show()
		})
	});

})(jQuery);
