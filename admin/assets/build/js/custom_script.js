$(document).ready(function () {
	// Auto close alert
	$("#success-alert").fadeTo(3000, 500).slideUp(500, function () {
		$("#success-alert").slideUp(500);
	});
	$("#warning-alert").fadeTo(3000, 500).slideUp(500, function () {
		$("#warning-alert").slideUp(500);
	});

	// Delete Selected record
	$('#delete_selected_record').click(function () {
		$('#confirm-delete').modal('show');
		$('#delete_btn_ok').click(function () {
			$('#form_selected_record').submit();
		});
	});

	// hide button

	//$('.last').html('<span>Not Authorized User</span>');

	// Choose Background
	$('#component-background').on('change', function () {
		var bg = $(this).val();
		if (bg.length > 0) {
			if (bg == 'image') {
				$('#component-bg-color').hide();
				$('#component-bg-image').show();
			} else {
				$('#component-bg-image').hide();
				$('#component-bg-color').show();
			}
		} else {
			$('#component-bg-image').hide();
			$('#component-bg-color').hide();
		}
	});

});

// Delete record
function delete_record(id, site_url) {
	$('#confirm-delete').modal('show');
	$('#delete_btn_ok').click(function () {
		$.ajax({
			type: 'POST',
			url: site_url,
			data: {
				id: id
			},
			cache: false,
			success: function (data) {
				$('#confirm-delete').modal('hide');
				window.location = '';
			}
		});
	});
	return false;
}
