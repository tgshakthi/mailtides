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
		var id = $('#blog_id').val();
		var image_url = $('#image_url').val();
		var siteUrl = image_url.replace('assets/', 'admin/');
		$.ajax({
			type: 'POST',
			url: siteUrl + 'blog/remove_image',
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

	//Choose Border
	$('#border').on('change', function () {
		if ($(this).prop("checked") == true) {
			$('#bordersizecolor').show();
		} else {
			$('#bordersizecolor').hide();
		}
	});

	//Choose Border
	$('#border_status').on('change', function () {
		if ($(this).prop("checked") == true) {
			$('#bordersizecolor').show();
		} else {
			$('#bordersizecolor').hide();
		}
	});

	$('#create_date').datetimepicker({
		format: 'mm-dd-yy'
	});

	$('#created_at').datetimepicker({
		format: 'MMM DD, YYYY'
	});

});

// Sortable
$(document).ready(function () {
	$('.lable_list_container').sortable({

		revert: true,
	});
});

// Show Blogs
$('#show_blog').on('change', function () {
	var blog = $(this).val();
	if (blog == 'blog') {
		$('#blog_nestable').show();
		$('#blog_category_nestable').hide();
	} else if (blog == 'blog_category') {
		$('#blog_nestable').hide();
		$('#blog_category_nestable').show();
	} else {
		$('#blog_nestable').hide();
		$('#blog_category_nestable').hide();
	}
});

//Developer Option
function customize_blog_title_content() {

	$('#customize_blog_title_content').slideToggle();
}

//Developer Option For blog Button
function customize_blog_button() {

	$('#customize_blog_button').slideToggle();
}

//Developer Option For blog Rating
function customize_rating_title() {

	$('#customize_rating_title').slideToggle();
}

//Developer Option For blog Rating Form
function customize_rating_form() {

	$('#customize_rating_form').slideToggle();
}

//Developer Option For blog Rating Form Button
function customize_rating_form_button() {

	$('#customize_rating_form_button').slideToggle();
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
			url: httpUrl + 'blog/check_category_name',
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

//  Contact Mail Configure


// Add To Address 

var choosemore = $("#count_to:last").val();
if (choosemore == undefined) {
	var choosemore = $('#select_options').val();
	var to = $('#field_selectoptions_' + choosemore).size();
} else {
	var to = parseInt(choosemore);
}
//var i = $('#result_field').size() - 1;
function add_moreto() {
	var data = '<div class="row" id="form_toid_' + to + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="carbon_copy" name="carbon_copy_to[]" placeholder="Add To Address" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldsto(' + to + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
	$('#result_fieldto').append(data);
	to++;
	return false;
}

function remove_from_fieldsto(id) {
	$("#form_toid_" + id).remove();
}

// Add CC 

var choosemore = $("#count_cc:last").val();
if (choosemore == undefined) {
	var choosemore = $('#select_options').val();
	var cc = $('#field_selectoptions_' + choosemore).size();
} else {
	var cc = parseInt(choosemore);
}
//var i = $('#result_field').size() - 1;
function add_morecc() {
	var data = '<div class="row" id="form_ccid_' + cc + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="carbon_copy" name="carbon_copy_cc[]" placeholder="Add CC" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldscc(' + cc + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
	$('#result_fieldcc').append(data);
	cc++;
	return false;
}

function remove_from_fieldscc(id) {
	$("#form_ccid_" + id).remove();
}

// Add BCC 

var choosemore = $("#count_bcc:last").val();

if (choosemore == undefined) {
	var choosemore = $('#select_options').val();
	var bcc = $('#field_selectoptions_' + choosemore).size();
} else {
	var bcc = parseInt(choosemore);
}
//var i = $('#result_field').size() - 1;
function add_morebcc() {
	var data = '<div class="row" id="form_bccid_' + bcc + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="blind_carbon_copy" name="carbon_copy_bcc[]" placeholder="Add BCC" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldsbcc(' + bcc + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
	$('#result_fieldbcc').append(data);
	bcc++;
	return false;
}

function remove_from_fieldsbcc(id) {
	$("#form_bccid_" + id).remove();
}

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
		maxCharCount: 280
	},

	// Remove the redundant buttons from toolbar groups defined above.
	removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});
