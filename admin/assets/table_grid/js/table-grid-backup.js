$(document).ready(function () {
	var number_of_rows = $('#no_of_row').val();
	var number_of_cols = $('#no_of_col').val();

	if (number_of_rows != '' && number_of_cols != '') {
		create_table(number_of_rows, number_of_cols);
	}
});

function generate_table() {
	var number_of_rows = $('#no_of_row').val();
	var number_of_cols = $('#no_of_col').val();
	var http_url = $('#httpUrl').val();
	var page_id = $('#page_id').val();
	var id = $('#id').val();

	$.ajax({
		type: 'POST',
		url: http_url + 'table_grid/create_table',
		data: {
			no_of_rows: number_of_rows,
			no_of_cols: number_of_cols,
			page_id: page_id,
			id: id
		},
		success: function (data) {
			create_table(number_of_rows, number_of_cols);
		}
	});
}

function create_table(number_of_rows, number_of_cols) {
	var table_body = '<table border="1">';

	for (var i = 0; i < number_of_rows; i++) {
		table_body += '<tr id="' + i + '">';

		for (var j = 0; j < number_of_cols; j++) {
			table_body += '<td class="table-col dropbtn" id="' + i + j + '" onclick="edit_cell(' + i + j + ')">';
			//table_body += "<div contenteditable>I'm editable</div>";
			table_body += "I'm editable";
			//table_body += '<textarea id="test_' + i + j + '">Im editable</textarea>';
			table_body += '</td>';
		}

		table_body += '</tr>';
	}

	table_body += '</table>';

	$('#table-preview').html(table_body);
}

function edit_cell(id) {
	//alert(id);
	//document.getElementById("myDropdown").classList.toggle("show");
	//CKEDITOR.replace('test_' + id);
	//CKEDITOR.add
}

// Close the dropdown if the user clicks outside of it

window.onclick = function (event) {

	if (!event.target.matches('.dropbtn')) {

		var dropdowns = document.getElementsByClassName("dropdown-content");
		var i;
		for (i = 0; i < dropdowns.length; i++) {
			var openDropdown = dropdowns[i];
			if (openDropdown.classList.contains('show')) {
				openDropdown.classList.remove('show');
			}
		}
		
	}

}
