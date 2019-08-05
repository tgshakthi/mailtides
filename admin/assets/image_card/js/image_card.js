CKEDITOR.replace('text3', {
	toolbarGroups: [{
			name: 'basicstyles',
			groups: ['basicstyles']
		},
		{
			name: 'styles',
			groups: ['styles']
		},
		{
			name: 'about',
			groups: ['about']
		}
	],
	extraPlugins: 'wordcount',
	wordcount: {
		showCharCount: !0,
		showWordCount: !0
	},
	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});

$(document).ready(function () {
	// Logo Preview
	$(function () {
		$('#image').observe_field(1, function () {
			var image_url = $('#image_url').val();
			var httpUrl = $('#httpUrl').val();
			var res = this.value.replace(image_url, '');
			$('#image').val(res);
			var res1 = res.replace(httpUrl + '/images/', 'thumbs/');
			$('#image_preview')
				.attr('src', image_url + res1)
				.show();
			if (res1.length == 0) {
				$('#image_preview2').attr('src', image_url + 'images/noimage.png');
			} else {
				$('#image_preview2').attr('src', image_url + res1);
			}
		});
	});

	// Remove logo
	$('#btn_ok').click(function () {
		var id = $('#image_card_id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'image_card/remove_image',
			data: {
				id: id
			},
			cache: false,
			success: function (data) {
				$('#image').val('');
				$('#show_image1').hide();
				$('#show_image2').show();
				$('#imageRemove').hide();
				$('#confirm-delete').modal('hide');
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

	//Choose Border
	$('#border_status').on('change', function () {
		if ($(this).prop('checked') == true) {
			$('#bordersizecolor').show();
		} else {
			$('#bordersizecolor').hide();
		}
	});
});

//Developer Option For Customize Image Card Title & Contents
function customize_image_card_title_content() {
	$('#customize_image_card_title_content').slideToggle();
}

//Chosse Readmore Button
function readmorebtn() {
	if ($('#readmore_btn').prop('checked') == true) {
		$('#readmoreurl').show();
		$('#readmore_url').attr('required', 'required');
	} else {
		$('#readmoreurl').hide();
		$('#readmore_url').removeAttr('required');
	}
}

//Developer Option For Customize Image Card Readmore Button
function customize_image_card_button() {
	$('#customize_image_card_button').slideToggle();
}

CKEDITOR.replace('text2', {
	toolbarGroups: [{
			name: 'basicstyles',
			groups: ['basicstyles']
		},
		{
			name: 'styles',
			groups: ['styles']
		},
		{
			name: 'about',
			groups: ['about']
		}
	],
	extraPlugins: 'wordcount',
	wordcount: {
		showCharCount: !0,
		showWordCount: !0
	},
	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});
