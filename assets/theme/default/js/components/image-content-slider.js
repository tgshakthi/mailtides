// Image Content Slider
$(document).ready(function () {
	var e = $("#image_content_slider_row_count").val();
	$("#slide-demo").owlCarousel({
		items: e,
		itemsDesktop: [1e3, 2],
		itemsDesktopSmall: [900, 2],
		itemsTablet: [768, 2],
		itemsMobile: [480, 1],
		paginationSpeed: 2e3,
		stopOnHover: !0,
		rewindSpeed: 2e3,
		navigation: !0,
		slideSpeed: 300,
		pagination: !0,
		navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
	})
});
