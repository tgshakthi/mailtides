$(document).ready(function () {

	// Image Preview
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
		
		$('#background-image').observe_field(1, function () {
			var image_url = $('#image_url').val();
			var httpUrl = $('#httpUrl').val();
			var res = this.value.replace(image_url, "");
			$("#background-image").val(res);
			var res1 = res.replace(httpUrl + '/images/', "thumbs/");
			$('#image_preview3').attr('src', image_url + res1).show();
			if (res1.length == 0) {
				$('#image_preview4').attr('src', image_url + 'images/noimage.png');
			} else {
				$('#image_preview4').attr('src', image_url + res1);
			}
		});
	});

	// Remove Image
	$('#btn_ok').click(function () {
		var id = $('#event_id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'event/remove_image',
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
				$('#image_preview2').attr('src', image_url + 'images/noimage.png');
				if (data == 1) {
					window.location = '';
				}
			}
		});
	});


	$('#create_date').datetimepicker({
        format: 'mm-dd-yy'
	});
	
	$('#created_at').datetimepicker({
        format: 'MMM DD, YYYY'
    });

});

//Developer Option
function customize_event_title_content() {

	$('#customize_event_title_content').slideToggle();
}

// Sortable
$(document).ready(function () {
	$('.lable_list_container').sortable({

		revert: true,
	});
});

// Show Events
$('#show_event').on('change', function () {
	var event = $(this).val();
	if (event == 'event') {
		$('#event_nestable').show();
		$('#event_category_nestable').hide();
	} else if (event == 'event_category') {
		$('#event_nestable').hide();
		$('#event_category_nestable').show();
	} else {
		$('#event_nestable').hide();
		$('#event_category_nestable').hide();
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
		url: $('#category_url').val(),
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

var categoryid = $('#category_id').val();
$.ajax({
	type: "POST",
	url: $('#category_select_url').val(),
	data: {
		categoryid: categoryid
	},
	success: function (data) {
		$('#category').html(data);
	}
});

$('#category_name').blur(function () {
	$('#error').html('');
	var categoryName = $(this).val();
	var web_id = $('#website_id').val();
	var httpUrl = $('#base_url').val();
	if (categoryName.length != 0) {
		$.ajax({
			type: 'POST',
			url: httpUrl + 'event/check_category_name',
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
					$('#error').html('<p style="color:red">Category Name Already Exists.</p>');
					$('#category_name').focus();
					$('input[id="btn"]').prop('disabled', true);
				}
			}
		});
	}
});


CKEDITOR.replace("text2", {
	toolbar: [{
	name: "basicstyles",
	groups: ["basicstyles", "cleanup"],
	items: ["Bold", "Italic", "Underline", "Strike", "Subscript", "Superscript", "-"]
	}, {
	name: "paragraph",
	groups: ["list", "indent", "blocks", "align", "bidi"],
	items: ["NumberedList", "BulletedList", "-", "Outdent", "Indent", "-", "Blockquote", "-", "JustifyLeft", "JustifyCenter", "JustifyRight", "JustifyBlock", "-", "BidiLtr", "BidiRtl", "Language"]
	}, {
	name: "links",
	items: ["Link", "Unlink", "Anchor"]
	}, {
	name: "insert",
	items: ["Image", "Table", "HorizontalRule", "PageBreak", "Iframe"]
	}, {
	name: "styles",
	items: ["Styles", "Format", "Font", "FontSize"]
	}, {
	name: "about",
	items: ["About"]
	}],
	extraPlugins: "wordcount",
	wordcount: {
	showCharCount: !0,
	showWordCount: !0
	//maxCharCount: 600
	},
	removeButtons: "Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar"
	});
