// Tab Script


// Text Image
function choosetemplate(id) {
	if (id == 1) {
		$("#image_sizediv").hide();
		$("#image_size").val("");
		$("#imagepostionwithbullet").show();
		$("#imagepostionwithoutbullet").hide();
		$("#image_position").val();
		$("#template").val(id);
		$('#textimagebullet').modal('hide');
		$("#templatetextimagebullet").attr('class', 'btn btn-success form-control col-md-7 col-xs-12');
		$("#templatetextimagewithoutbullet").attr('class', 'btn btn-danger form-control col-md-7 col-xs-12');

		var position = $('#image_position_bullet').val();
		if (position == 'img_part_center') {
			$("#imagesizewithbullet").show();
		}
	} else {
		$("#image_sizediv").show();
		$("#template").val(id);
		$("#imagepostionwithbullet").hide();
		$("#imagesizewithbullet").hide();
		$("#image_position_bullet").val();
		$("#imagepostionwithoutbullet").show();
		$('#textimagewithoutbullet').modal('hide');
		$("#templatetextimagebullet").attr('class', 'btn btn-danger form-control col-md-7 col-xs-12');
		$("#templatetextimagewithoutbullet").attr('class', 'btn btn-success form-control col-md-7 col-xs-12');
	}
}

//Chosse Readmore Button
function readmorebtn() {
	if ($('#readmore_btn').prop("checked") == true) {
		$('#readmoreurl').show();
		$('#readmore_url').attr('required', 'required');
	} else {
		$('#readmoreurl').hide();
		$('#readmore_url').removeAttr('required');
	}
}

//Developer Option For Readmore Button
function text_image_developer() {
	$('#text_image_developer').slideToggle();
}

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
		var id = $('#image_content_slider_id').val();
		var website_id = $('#website_id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'image_content_slider/remove_image',
			data: {
				id: id,
				website_id: website_id
			},
			cache: false,
			success: function (data) {
				$('#image').val("");
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

	$("#image_position_bullet").on('change', function () {
		var position = $(this).val();
		$("#image_pos").val(position);
		if (position == 'img_part_center') {
			$("#imagesizewithbullet").show();
		} else {
			$("#imagesizewithbullet").hide();
		}
	});

	$("#image_position").on('change', function () {
		$("#image_pos").val($(this).val());
	});

	$("#image_size_with_bullet").on('change', function () {
		$("#image_size").val($(this).val());
	});

	$("#image_size_without_bullet").on('change', function () {
		$("#image_size").val($(this).val());
	});

	//Choose Border
	$('#border_status').on('change', function () {
		if ($(this).prop("checked") == true) {
			$('#bordersizecolor').show();
		} else {
			$('#bordersizecolor').hide();
		}
	});

});


// Text Full Width
$(function () {
	// $("#sortable-row").sortable({
	// 	placeholder: "ui-state-highlight"
	// });
});



function customize_image_content_button() {
	$('#customize_image_content_button').slideToggle();
}
CKEDITOR.replace('text', {

	// Define the toolbar groups as it is a more accessible solution.
	toolbarGroups: [{
			"name": "basicstyles",
			"groups": ["basicstyles"]
		},
		{
			"name": "links",
			"groups": ["links"]
		},
		{
			"name": "paragraph",
			"groups": ["list", "blocks"]
		},
		{
			"name": "document",
			"groups": ["mode"]
		},
		{
			"name": "insert",
			"groups": ["insert"]
		},
		{
			"name": "styles",
			"groups": ["styles"]
		},
		{
			"name": "about",
			"groups": ["about"]
		}
	],
	extraPlugins: 'wordcount',
	wordcount: {
		showCharCount: true,
		showWordCount: true,

		// Maximum allowed Word Count
		//maxWordCount: 300,

		// Maximum allowed Char Count
		maxCharCount: 800
	},

	// Remove the redundant buttons from toolbar groups defined above.
	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});
CKEDITOR.replace('text2', {

	// Define the toolbar groups as it is a more accessible solution.
	toolbarGroups: [{
			"name": "basicstyles",
			"groups": ["basicstyles"]
		},
		{
			"name": "links",
			"groups": ["links"]
		},
		{
			"name": "paragraph",
			"groups": ["list", "blocks"]
		},
		{
			"name": "document",
			"groups": ["mode"]
		},
		{
			"name": "insert",
			"groups": ["insert"]
		},
		{
			"name": "styles",
			"groups": ["styles"]
		},
		{
			"name": "about",
			"groups": ["about"]
		}
	],
	extraPlugins: 'wordcount',
	wordcount: {
		showCharCount: true,
		showWordCount: true,

		// Maximum allowed Word Count
		//maxWordCount: 300,

		// Maximum allowed Char Count
		maxCharCount: 300
	},

	// Remove the redundant buttons from toolbar groups defined above.
	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});