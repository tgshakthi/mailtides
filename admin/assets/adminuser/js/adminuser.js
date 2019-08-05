$(document).ready(function () {
	$(function () {
		$('select[multiple="multiple"]').multiselect({
			columns: 4,
			placeholder: 'Select Options',
			search: true,
			searchOptions: {
				'default': 'Search Options'
			},
			selectAll: true
		});
	});

	// Change Profile Image
	$('#change-profile-img').click(function () {
		document.querySelector('.profile-container').removeAttribute('style');
		document.querySelector('#show_image1').style.display = 'none';
		document.querySelector('#profile-img').value = "";
		$('#change-profile-img').hide();
	});
});