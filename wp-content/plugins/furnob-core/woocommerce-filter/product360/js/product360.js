(function($) {

	$(document).ready(function() {
		
		$(".klb-product360-btn").appendTo(".flex-viewport");

		$('.klb-product360-btn a').on('click', function(e) {
			e.preventDefault();
			init($('.klb-360-view.klb-product-360'));
		});

		$('.klb-product360-btn a').magnificPopup({
			type: 'inline',
			mainClass: 'mfp-fade',
			removalDelay: 300,
			preloader: false,
			fixedContentPos: false,
			closeBtnInside: true,
		});


		function init($this) {
			var data = $this.data('args');

			if (!data || $this.hasClass('klb-360-view-inited')) {
				return false;
			}

			$this.ThreeSixty({
				totalFrames : data.frames_count,
				endFrame    : data.frames_count,
				currentFrame: 1,
				imgList     : '.klb-360-view-images',
				progress    : '.spinner',
				imgArray    : data.images,
				height      : data.height,
				width       : data.width,
				responsive  : true,
				navigation  : true,

			});

			$this.addClass('klb-360-view-inited');
		}
	});

})(jQuery);
