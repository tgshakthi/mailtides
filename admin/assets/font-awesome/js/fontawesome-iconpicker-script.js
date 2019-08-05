$(function () {

	// Live binding of buttons
	$(document).on('click', '.action-placement', function (e) {
		$('.action-placement').removeClass('active');
		$(this).addClass('active');
		$('.icp-opts').data('iconpicker').updatePlacement($(this).text());
		e.preventDefault();
		return false;
	});

	$('.icp-auto').iconpicker({
		placement: 'bottom'
	});

	$('.icp-dd').iconpicker({
		//title: 'Dropdown with picker',
		//component:'.btn > i'
	});

	// This event is only triggered when the actual input value is changed
	// by user interaction

	$('.icp').on('iconpickerSelected', function (e) {
		$('.lead .picker-target').get(0).className = 'picker-target fa-3x ' +
			e.iconpickerInstance.options.iconBaseClass + ' ' +
			e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
	});

	$('.icp1').on('iconpickerSelected', function (e) {
		$('.lead1 .picker-target').get(0).className = 'picker-target fa-3x ' +
			e.iconpickerInstance.options.iconBaseClass + ' ' +
			e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
	});

	$('.icp2').on('iconpickerSelected', function (e) {
		$('.lead2 .picker-target').get(0).className = 'picker-target fa-3x ' +
			e.iconpickerInstance.options.iconBaseClass + ' ' +
			e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
	});
});
