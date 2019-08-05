// Text and Image Slider
$(document).ready(function () {
	$("#text_image_slider").owlCarousel({
		items: 1,
		itemsDesktop: [1e3, 2],
		itemsDesktopSmall: [900, 1],
		itemsTablet: [768, 1],
		itemsMobile: [480, 1],
		paginationSpeed: 1500,
		stopOnHover: !0,
		rewindSpeed: 2e3,
		slideTransition: "fade"
	})
});
