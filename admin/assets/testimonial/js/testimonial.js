$(document).ready(function () {

	// Logo Preview
	$(function () {
		$('#image').observe_field(1, function () {
			var image_url = $('#image_url').val();
			var httpUrl = $('#httpUrl').val();
			var res = this.value.replace(image_url, "");
			$("#image").val(res);
			var res1 = res.replace(httpUrl + '/images/', "thumbs/");
			$('#image_preview').attr('src', image_url + res1).show();
			if (res1.length == 0) {
				$('#image_preview2').attr('src', image_url + 'images/noimage.png');
			} else {
				$('#image_preview2').attr('src', image_url + res1);
			}
		});
	});

	// Remove logo
	$('#btn_ok').click(function () {
		var id = $('#testimonial_id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'testimonial/remove_image',
			data: {
				id: id
			},
			cache: false,
			success: function (data) {
				$('#image').val("");
				$('#show_image1').hide();
				$('#show_image2').show();
				$('#imageRemove').hide();
				$('#image-confirm-delete').modal('hide');
				$('#image_preview2').attr('src', image_url + 'images/noimage.png');
				if (data == 1) {
					new PNotify({
						title: 'Image Deleted',
						text: 'Just to let you know, Image Deleted Successfully.',
						type: 'info',
						styling: 'bootstrap3'
					});
				}
			}
		});
	});
});

// Image Options
function testimonial_image_option() {
	$('#testimonial_image_option').slideToggle();
}

//Choose Redirect
function redirectbtn() {
	if ($('#redirect').prop("checked") == true) {
		$('#redirect_url').show();
		$('#redirect').attr('required', 'required');
	} else {
		$('#redirect_url').hide();
		$('#redirect').removeAttr('required');
	}
}

//Developer Option For Redirect
function customize_testimonial() {
	$('#testimonial_developer').slideToggle();
}
