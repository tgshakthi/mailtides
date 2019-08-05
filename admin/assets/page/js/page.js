// Multi Select
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
});

// Sortable
$(function () {
	$("#sortable-row").sortable({
		placeholder: "ui-state-highlight"
	});
});

// Content Order
function content_order() {
	var selectedLanguage = new Array();
	$('ul#sortable-row li').each(function () {
		selectedLanguage.push($(this).attr("id"));
	});
	document.getElementById("row_order").value = selectedLanguage;
	return true;
}

// Check Duplicate URL

function check_url() {
	var page_url = $("#page-url").val();
	var url = $("#http_url").val();
	if (page_url.length > 4) {
		$.ajax({
			type: "POST",
			url: url + '/check_url',
			data: {
				page_url: page_url
			},
			success: function (data) {
				if (data == '1') {
					$("#check-url-result").html('URL Already exists').css('color', 'red');
					$(".btn-success").attr("disabled", "disabled");
				} else {
					$("#check-url-result").html('URL Available').css('color', 'green');;
					$(".btn-success").removeAttr("disabled");
				}
			}
		});
	}
}

// Page Clone
$('#page_clone').on('change', function () {

	var page_clone = $(this).val();
	if (page_clone == 1) {
		$('#clone_page_div').show();
		$('#page_components_div').hide();
		$('#common_components_div').hide();
		$('#clone_page').attr('required', 'required');
		$('#components').removeAttr('required');
	} else if (page_clone == 0) {
		$('#page_components_div').show();
		$('#common_components_div').show();
		$('#clone_page_div').hide();
		$('#components').attr('required', 'required');
		$('#clone_page').removeAttr('required');
	} else {
		$('#clone_page_div').hide();
		$('#page_components_div').hide();
		$('#common_components_div').hide();
		$('#components').removeAttr('required');
		$('#clone_page').removeAttr('required');
	}

});

// Menu Image
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

		$('#image1').observe_field(1, function () {
			var image_url = $('#image_url').val();
			var httpUrl = $('#httpUrl').val();
			var res = this.value.replace(image_url, "");
			$("#image1").val(res);
			var res1 = res.replace(httpUrl + '/images/', "thumbs/");
			$('#image_preview').attr('src', image_url + res1).show();
			if (res1.length == 0) {
				$('#image_preview2').attr('src', image_url + 'images/noimage.png');
			} else {
				$('#image_preview2').attr('src', image_url + res1);
			}
		});
	});

});

$(document).ready(function () {
	$('#publish-multiple-pages').click(function () {
		var url = $("#http_url").val();
		var page_ids = new Array();
		$("input[name='table_records[]']:checked").each(function () {
			page_ids.push($(this).val());
		});

		$.ajax({
			type: 'POST',
			url: url + 'publish_all',
			data: {
				page_id: page_ids
			},
			beforeSend: function () {
				$("#loader").show();
			},
			success: function (data) {

				$("#loader").hide();

				if (data == 1) {
					$('#alert-box').html('<div class="alert alert-success alert-dismissible fade in text-center" id="success-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Success! </strong>Published Successfully.</div>');
				} else if (data == 2) {
					$('#alert-box').html('<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Something Went Wrong</div>');
				} else if (data == 3) {
					$('#alert-box').html('<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Page Status is not active.</div>');
				} else if (data == 4) {
					$('#alert-box').html('<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>Page not found.</div>');
				} else {
					$('#alert-box').html('<div class="alert alert-warning alert-dismissible fade in text-center" id="warning-alert" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><strong>You must select at least one row!</div>');
				}

				setTimeout(function () {
					window.location = "";
				}, 2000);
			}
		});
	});
});