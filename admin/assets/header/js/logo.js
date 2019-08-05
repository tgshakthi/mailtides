$(document).ready(function () {
	// Logo Preview
	$(function () {
		$('#logo').observe_field(1, function () {
			var image_url = $('#image_url').val();
			var httpUrl = $('#httpUrl').val();
			var res = this.value.replace(image_url, "");
			$("#logo").val(res);
			var res1 = res.replace(httpUrl + '/images/', "thumbs/");
			$('#image_preview').attr('src', image_url + res1).show();
			if (res1.length == 0) {
				$('#image_preview2').attr('src', image_url + 'images/no-logo.png');
			} else {
				$('#image_preview2').attr('src', image_url + res1);
			}
		});
	});

	// Remove logo
	$('#btn_ok').click(function () {
		var id = $('#website_id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'header/logo/remove_logo_image',
			data: {
				id: id
			},
			cache: false,
			success: function (data) {
				$('#logo').val("");
				$('#show_image1').hide();
				$('#show_image2').show();
				$('#logoRemove').hide();
				$('#confirm-delete').modal('hide');
				$('#image_preview2').attr('src', image_url + 'images/no-logo.png');
				if (data == 1) {
					new PNotify({
						title: 'Logo Deleted',
						text: 'Just to let you know, Logo Deleted Successfully.',
						type: 'info',
						styling: 'bootstrap3'
					});
				}
			}
		});
	});
});
