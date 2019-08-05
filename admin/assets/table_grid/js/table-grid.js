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
});

function create_table() {
	var table_container = document.getElementById("table-container");
	table_container.style.display = "block";
	// Get values from input
	var get_row = document.getElementById('form_table_row').value;
	var get_col = document.getElementById('form_table_col').value;

	// Check for empty data
	if (get_row.length > 0 && get_col.length > 0) {
		var table_display = document.getElementById('table-display');

		var table_content = "<table id='mt' class='table'>";

		for (var i = 0; i < get_row; i++) {
			// Create Table Head
			if (i == 0) {
				table_content += "<thead>";
				table_content += "<tr>";
				for (var j = 0; j < get_col; j++) {
					table_content += "<th></th>";
				}
				table_content += "</tr>";
				table_content += "</thead>";
				// Table body
				table_content += "<tbody>";
			} else {

				table_content += "<tr>";

				for (var j = 0; j < get_col; j++) {
					table_content += "<td></td>";
				}

				table_content += "</tr>";

			}
		}

		table_content += "</tbody>";
		table_content += "</table>";

		table_display.innerHTML = table_content;
		colEdit();
	}
}

function colEdit() {
	$('td, th').on({
		'click': function () {
			$(this).prop('contenteditable', true);
		},
		'blur': function () {
			$(this).removeAttr('contenteditable');
		}
	});
}

colEdit();

function saveTable() {
	var table_content = $("#table-display").html();
	var no_of_rows = $("#form_table_row").val();
	var no_of_cols = $("#form_table_col").val();
	var http_url = $('#httpUrl').val();
	var page_id = $('#page_id').val();
	var id = $('#id').val();

	$.ajax({
		type: "POST",
		url: http_url + 'table_grid/create_table',
		data: {
			table_data: table_content,
			no_of_cols: no_of_cols,
			no_of_rows: no_of_rows,
			page_id: page_id,
			id: id
		},
		success: function (data) {
			window.location = http_url + "table_grid/table_grid_index/" + page_id;
		}
	});
}
