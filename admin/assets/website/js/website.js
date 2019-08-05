$(document).ready(function () {
	// Check or Uncheck All checkboxes
	$("#component-select-all").change(function () {
		var checked = $(this).is(':checked');
		if (checked) {
			$(".icheckbox_flat-green").each(function () {
				if (!$(this).hasClass("checked")) {
					$(this).addClass('checked');
					$('input:checkbox').prop('checked', true);
				}
			});
		} else {
			$(".icheckbox_flat-green").each(function () {
				if ($(this).hasClass("checked")) {
					$(this).removeClass('checked');
					$('input:checkbox').removeAttr('checked');
				}
			});
		}
	});

	// Change Favicon
	$('#change-favicon').click(function () {
		document.querySelector('.favicon-container').removeAttribute('style');
		document.querySelector('#show_image1').style.display = 'none';
		document.querySelector('#favicon-img').value = "";
		$('#change-favicon').hide();
	});

	// Change Logo
	$('#change-logo').click(function () {
		document.querySelector('.logo-container').removeAttribute('style');
		document.querySelector('#show_image2').style.display = 'none';
		document.querySelector('#logo-img').value = "";
		$('#change-logo').hide();
	});
});
