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
				$('#image_preview2').attr('src', image_url + 'images/no-logo.png');
			} else {
				$('#image_preview2').attr('src', image_url + res1);
			}
		});
	});

	// Remove logo
	$('#btn_ok').click(function () {
		var id = $('#text-image-id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'gallery/remove_image',
			data: {
				id: id
			},
			cache: false,
			success: function (data) {
				$('#image').val("");
				$('#show_image1').hide();
				$('#show_image2').show();
				$('#imageRemove').hide();
				$('#confirm-delete').modal('hide');
				$('#image_preview2').attr('src', image_url + 'images/no-logo.png');
				if (data == 1) {
					new PNotify({
						title: 'Image Deleted',
						text: 'Just to let you know, Logo Deleted Successfully.',
						type: 'info',
						styling: 'bootstrap3'
					});
				}
			}
		});
	});


	$('#category_name').blur(function () {
		$('#error').html('');
		var categoryName = $(this).val();
		var web_id = $('#website_id').val();
		var httpUrl = $('#base_url').val();
		if (categoryName.length != 0) {
			$.ajax({
				type: 'POST',
				url: httpUrl + 'gallery/check_category_name',
				data: {
					name: categoryName,
					web_id: web_id
				},
				success: function (data) {
					if (data == 0) {
						if (categoryName.length != 0) {
							$('#error').html('<p style="color:green">Category Name Available.</p>');
							$('input[id="btn"]').prop('disabled', false);
						}
					} else {
						$('#error').html('<p style="color:red">Category Name already exists.</p>');
						$('#category_name').focus();
						$('input[id="btn"]').prop('disabled', true);
					}
				}
			});
		}
	});

	var categoryid = $('#category_id').val();
	$.ajax({
		type: "POST",
		url: $('#base_url').val() + 'gallery/selected_category',
		data: {
			categoryid: categoryid
		},
		success: function (data) {
			$('#category').html(data);
		}
	});

	// Select dropdown for category
	$('#category').select2({
		arrow: false,
		allowClear: true,
		placeholder: {
			id: "",
			placeholder: ""
		},
		ajax: {
			url: $('#base_url').val() + 'gallery/select_gallery_category',
			dataType: 'json',
			data: function (params) {
				return {
					q: params.term || '',
					page: params.page || 1
				};
			},
			cache: true
		}
	});

});
