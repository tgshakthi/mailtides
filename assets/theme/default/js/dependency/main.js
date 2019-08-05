// scroll Animation

$(document).ready(function () {
	AOS.init({
		duration: 3000,
		 // startEvent: 'load',
	})
});
$(window).on('load', function() {
    AOS.refresh();
});


