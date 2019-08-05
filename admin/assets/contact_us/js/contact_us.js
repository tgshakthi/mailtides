// JavaScript Document
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

// Sortable
$(document).ready(function () {
	$('.lable_list_container').sortable({

		revert: true,
	});
});


// Contact Customize

//Developer Option For Redirect
function customize_submit_button_developer() {
	$('#customize_submit_button_developer').slideToggle();
}

// Button type options
var icon_shape = document.getElementById('button_type');
if (icon_shape) {
	icon_shape.addEventListener('change', function () {
		var style = this.value != 'link' ? 'block' : 'none';
		document.getElementById('hidden_div').style.display = style;
	});
}

//Choose Redirect
function border_btn() {
	if ($('#border').prop("checked") == true) {
		$('#hidden_div_border').show();
		$('#border_size').attr('required', 'required');
	} else {
		$('#hidden_div_border').hide();
		$('#border_size').removeAttr('required');
	}
}

// Captcha
function captcha_btn() {

	if ($('#captcha').prop("checked") == true) {
		$('#hidden_div_captcha').show();
	} else {
		$('#hidden_div_captcha').hide();
	}
}

// Choose Captcha
function choose_captcha_btn() {

	if ($('#choose_captcha').val() == 'google_captcha') {
		$('#hidden_div_google_captcha').show();
		$('#hidden_div_image_captcha').hide();
	} else if ($('#choose_captcha').val() == 'image_captcha') {
		$('#hidden_div_google_captcha').hide();
		$('#hidden_div_image_captcha').show();
	}
}


// Contact Form Fields

// Form Fields
var label_names = $('#label_names').val();
var label_names = (label_names != undefined) ? label_names.split(',') : new Array();
for (var l = 0; l < label_names.length; l++) {
	$('#' + label_names[l] + 'ff').hide();
	$("#select_column option[value='" + label_names[l] + "']").hide();
}



var choosemore = $("input[name='id[]']:last").val();
if (choosemore == undefined) {
	var choosemore = $('#select_options').val();
	var i = $('#field_selectoptions_' + choosemore).size();
} else {
	//var i = parseInt(choosemore) + 1;
	var i = parseInt(choosemore);
}

function add_morefield() {
	var data = '<div class="row" id="form_id_' + i + '"><div class="form-group col-md-2 col-lg-2 col-sm-2 col-xs-12"><label>Label Name :</label><input type="text" class="form-control" id="label_name" name="label_name[]" placeholder="Label Name" required /><input type="hidden" class="form-control" id="old_label_name" value="" name="old_label_name[]" /><input type="hidden" class="form-control" id="is_deleted" value="0" name="is_deleted[]" /></div><div class="form-group col-md-2 col-lg-2 col-sm-2 col-xs-12"><label>Field Type :</label><select name="choosefield[]" id="choosefield_' + i + '" class="form-control" required onchange="choosefield(' + i + ');"><option value="">Select</option><option value="textbox">Text Box</option><option value="textarea">Text Area</option></select><br class="spacer" /><div id="option_result_' + i + '"><div id="field_selectoptions_' + i + '"></div><div id="field_checkoptions_' + i + '"></div><div id="field_radiooptions_' + i + '"></div></div></div><div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12"><label>Icon :</label><input type="text" class="form-control icp_' + i + ' icp-auto_' + i + '" onclick="icon_preview(' + i + ')" data-input-search="1" id="icon" name="icon[]" placeholder="Icon" /><br><p class="lead_' + i + '"><i class=" fa-3x picker-target"></i></p></div><div class="form-group col-md-2 col-lg-2 col-sm-2 col-xs-12"><label>Placeholder :</label><input type="text" class="form-control" id="placeholder" name="placeholder[]" placeholder="Placeholder" /></div><div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12"><label>Sort Order :</label><input type="text" class="form-control" id="sort_order" name="sort_order[]"/></div><div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12"><label>Validation :</label><select name="validation[]" id="validation_' + i + '" class="form-control"><option value="none">None</option><option value="number">Number</option><option value="email">Email</option></select></div><div class="form-group col-md-1 col-lg-1 col-sm-1 col-xs-12"><label>Required :</label><select name="required[]" id="required_' + i + '" class="form-control"><option value="1">Yes</option><option value="0">No</option></select></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12" style="padding-top:22px;"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fields(' + i + ');"><span class="glyphicon glyphicon-minus"></span></button></div><input type="hidden" value="' + i + '" name="hidden_dyid[]"></div>';
	$('#result_field').append(data);
	i++;
	return false;
}

function remove_from_fields(id) {
	var remove_name = $('#remove_form_fields_id_' + id).val();
	var website_id = $('#website_id').val();
	var base_url = $('#base_url').val();
	if (remove_name == undefined) {
		$("#form_id_" + id).remove();
	} else if (remove_name.length != 0) {
		var conf = confirm("Are you sure you wish to delete?");
		if (!conf) {
			return false;
		} else {
			$.ajax({
				type: "POST",
				url: base_url + 'contact_us/contact_field_remove',
				data: {
					website_id: website_id,
					remove_name: remove_name
				},
				success: function (data) {
					window.location = '';
				}
			});
			return true;
		}
	}
}

function choosefield(id) {
	var fieldtype = $("#choosefield_" + id).val();
	if (fieldtype == "dropdown") {
		$('#option_result_' + id).show();
		$('#field_checkoptions_' + id).remove();
		$('#field_radiooptions_' + id).remove();
		$('#field_selectoptions_' + id).remove();
		if ($('#field_selectoptions_' + id).length == 0) {
			var adddiv = '<div id="field_selectoptions_' + id + '"></div>'
			$('#option_result_' + id).html(adddiv);
		}
		var data = '<div class="form-group entry"><input type="text" name="options_' + id + '[]" class="form-control" placeholder="Dropdown option value"><span class="input-group-btn"><button class="btn btn-success btn-add" title="Add" type="button" onclick="add_moreselectopt(' + id + ')"><input type="hidden" id="select_options" name="select_options[]" value="' + id + '"><span class="glyphicon glyphicon-plus"></span></button></span></div>';
		$('#field_selectoptions_' + id).append(data);
	} else if (fieldtype == "checkbox") {
		$('#option_result_' + id).show();
		$('#field_checkoptions_' + id).remove();
		$('#field_radiooptions_' + id).remove();
		$('#field_selectoptions_' + id).remove();
		if ($('#field_checkoptions_' + id).length == 0) {
			var adddiv = '<div id="field_checkoptions_' + id + '"></div>'
			$('#option_result_' + id).html(adddiv);
		}
		var data = '<div class="form-group entry"><input type="text" name="chk_options_' + id + '[]" class="form-control" placeholder="Checkbox label"><span class="input-group-btn"><button class="btn btn-success btn-add" type="button" onclick="add_morechkoptions(' + id + ')"><input type="hidden" id="chk_options_hid" name="chk_options_hid[]" value="' + id + '"><span class="glyphicon glyphicon-plus"></span></button></span></div>';
		$('#field_checkoptions_' + id).append(data);
	} else if (fieldtype == "radio") {
		$('#option_result_' + id).show();
		$('#field_checkoptions_' + id).remove();
		$('#field_radiooptions_' + id).remove();
		$('#field_selectoptions_' + id).remove();
		if ($('#field_radiooptions_' + id).length == 0) {
			var adddiv = '<div id="field_radiooptions_' + id + '"></div>'
			$('#option_result_' + id).html(adddiv);
		}
		var data = '<div class="form-group entry"><input type="text" name="radio_options_' + id + '[]" class="form-control" placeholder="Radion label"><span class="input-group-btn"><button class="btn btn-success btn-add" type="button" onclick="add_moreradiooptions(' + id + ');"><input type="hidden" id="radio_option_hid" name="radio_option_hid[]" value="' + id + '"><span class="glyphicon glyphicon-plus"></span></button></span></div>';
		$('#field_radiooptions_' + id).append(data);
	} else {
		$('#option_result_' + id).hide();
	}
}

var selectoption_more = $("input[name='select_options[]']:last").val();
if (selectoption_more == undefined) {
	var selectoption_more = $('#select_options').val();
	var r = $('#field_selectoptions_' + selectoption_more).size() + 1;
} else {
	var r = selectoption_more + 1;
}

function add_moreselectopt(id) {
	var data = '<div class="form-group entry" id="remove_options_' + r + '"><input type="text" name="options_' + id + '[]" class="form-control" placeholder="Dropdown option value" /><span class="input-group-btn"><button class="btn btn-remove btn-danger" type="button" onclick="remove_selectopt(' + r + ')"><input type="hidden" name="select_options[]" id="select_options" value="' + id + '"><span class="glyphicon glyphicon-minus"></span></button></span></div>';
	$('#field_selectoptions_' + id).append(data);
	r++;
	return false;
}

function remove_selectopt(id) {
	$("#remove_options_" + id).remove();
}

var chk_more = $("input[name='chk_options_hid[]']:last").val();
if (chk_more == undefined) {
	var chk_more = $('#chk_options_hid').val();
	var chk = $('#field_checkoptions_' + chk_more).size() + 1;
} else {
	var chk = chk_more + 1;
}

function add_morechkoptions(id) {
	var data = '<div class="form-group entry" id="remove_chkoptions_' + chk + '"><input type="text" name="chk_options_' + id + '[]" class="form-control" placeholder="Checkbox Label" /><span class="input-group-btn"><button class="btn btn-remove btn-danger" type="button" onclick="remove_chkopt(' + chk + ')"><input type="hidden" id="chk_options_hid" name="chk_options_hid[]" value="' + id + '"><span class="glyphicon glyphicon-minus"></span></button></span></div>';
	$('#field_checkoptions_' + id).append(data);
	chk++;
	return false;
}

function remove_chkopt(id) {
	$("#remove_chkoptions_" + id).remove();
}

var rad_more = $("input[name='radio_option_hid[]']:last").val();
if (rad_more == undefined) {
	var rad_more = $('#radio_option_hid').val();
	var radi = $('#field_checkoptions_' + rad_more).size() + 1;
} else {
	var radi = rad_more + 1;
}

function add_moreradiooptions(id) {
	var data = '<div class="form-group entry" id="remove_radiooptions_' + radi + '"><input type="text" name="radio_options_' + id + '[]" class="form-control" placeholder="Radio Label" /><span class="input-group-btn"><button class="btn btn-remove btn-danger" type="button" onclick="remove_radioopt(' + radi + ')"><input type="hidden" id="radio_option_hid" name="radio_option_hid[]" value="' + id + '"><span class="glyphicon glyphicon-minus"></span></button></span></div>';
	$('#field_radiooptions_' + id).append(data);
	radi++;
	return false;
}

function remove_radioopt(id) {
	$("#remove_radiooptions_" + id).remove();
}

function icon_preview(id) {
	$('.icp-auto_' + id).iconpicker();
	$('.icp_' + id).on('iconpickerSelected', function (e) {
		$('.lead_' + id + ' .picker-target').get(0).className = 'picker-target fa-3x ' +
			e.iconpickerInstance.options.iconBaseClass + ' ' +
			e.iconpickerInstance.options.fullClassFormatter(e.iconpickerValue);
	});
}


// Contact Form Layout


// Form Layout
var morerow = $("input[name='select_row[]']:last").val();
if (morerow == undefined) {
	var j = 1;
} else {
	var j = morerow + 1;
}

function add_morerow() {
	var data = '<div class="form_totalorow" id="form_totalorow_' + j + '"><div class="form_row col-md-10 col-lg-10 col-sm-10 col-xs-12"><ul id="form_row_' + j + '"></ul></div><div class="row_button col-md-2 col-lg-2 col-sm-2 col-xs-12"><button name="opener" class="btn btn-success btn-add" type="button" id="add_morerowcolumn_' + j + '" data-toggle="modal" data-target="#myModal" title="Add" onclick="add_morerowcolumn(' + j + ')">Add Column <span class="glyphicon glyphicon-plus"></span></button><button class="btn btn-remove btn-danger space_padd" type="button" id="form_row_id_' + j + '" onclick="remove_form_row(' + j + ')"><input type="hidden" name="row_column_no[]" id="row_column_no_' + j + '" value=""><input type="hidden" name="row_no_' + j + '" id="row_no_' + j + '" value=""><input type="hidden" name="select_row[]" id="select_row" value="' + j + '"><span title="Remove Row"><i class="fa fa-trash-o" aria-hidden="true"></i></span></button></div></div>';
	$('#custom_form').append(data);
	var row = $("input[name^='select_row[]']").map(function (idx, elem) {
		return $(elem).val();
	}).get();
	var row1 = row + '';
	var result = row1.split(',');
	var row_count = result.length;
	$('#row').val(row_count);
	for (var r = 0; r < row_count; r++) {
		var value = parseInt(r) + 1;
		$('#row_no_' + result[r]).val(value);
	}
	j++;
	return false;
}

function remove_form_row(id) {
	var gethtml = $('#form_row_' + id).html();
	var gethtml = gethtml.trim();
	if (gethtml == "") {
		$("#form_totalorow_" + id).remove();
		var row = $("input[name^='select_row[]']").map(function (idx, elem) {
			return $(elem).val();
		}).get();
		var row1 = row + '';
		var result = row1.split(',');
		var row_count = result.length;
		$('#row').val(row_count);
		for (var r = 0; r < row_count; r++) {
			var value = parseInt(r) + 1;
			$('#row_no_' + result[r]).val(value);
		}
	} else {
		alert('First Remove Columns');
	}
}

function add_morerowcolumn(row_id) {
	$('#select_column').attr('onchange', 'add_morerowcolumn1(' + row_id + ')');
}

function add_morerowcolumn1(row_id) {
	var field_name = $('#select_column').val();
	var field_name1 = field_name.replace(/_/g, " ");
	var field_name1 = field_name1[0].toUpperCase() + field_name1.slice(1);
	$("#select_column option[value='" + field_name + "']").hide();
	var morecolumn = $("input[name='select_column_" + row_id + "[]']:last").val();
	if (morecolumn == undefined) {
		var c = 1;
		var column_count = 0;
	} else {
		var column = $("input[name^='select_row_column_" + row_id + "[]']").map(function (idx, elem) {
			return $(elem).val();
		}).get();
		var column1 = column + '';
		var result = column1.split(',');
		var column_count = 0;
		if (result != "") {
			var column_count = result.length;
		}
		var c = parseInt(morecolumn) + 1;
	}

	if (column_count != 0) {
		for (var i = 0; i < column_count; i++) {
			if (column_count == 1) {
				var size = "form_row_column col-md-6 col-lg-6 col-sm-6 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
			} else if (column_count == 2) {
				var size = "form_row_column col-md-4 col-lg-4 col-sm-4 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
			} else if (column_count == 3) {
				var size = "form_row_column col-md-3 col-lg-3 col-sm-3 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
				$('#add_morerowcolumn_' + row_id).attr('disabled', 'disabled');
			}
		}
	} else {
		var size = "form_row_column col-md-12 col-lg-12 col-sm-12 col-xs-12";
	}

	var data = '<li class="' + size + '" id="form_row_column_' + row_id + c + '"><div><label>' + field_name1 + '</label><button type="button" onclick="remove_form_row_column(' + row_id + c + ',' + row_id + ')"><input type="hidden" name="select_column_' + row_id + '[]" id="select_column_' + row_id + '" value="' + c + '"><input type="hidden" name="select_row_column_' + row_id + '[]" id="select_row_column_' + row_id + '" value="' + row_id + c + '"><input type="hidden" name="row_column_field_name' + row_id + c + '[]" id="row_column_field_name' + row_id + c + '" value="' + field_name + '"><i class="fa fa-times-circle" aria-hidden="true"></i></button></div></li>';
	$('#form_row_' + row_id).append(data);
	$('#' + field_name + 'ff').hide();
	var row = $("input[name^='select_column_" + row_id + "[]']").map(function (idx, elem) {
		return $(elem).val();
	}).get();
	var row1 = row + '';
	var result = row1.split(',');
	var row_count = result.length;
	var row_no = $('#row_no_' + row_id).val();
	var old_row_column_no = $('#row_column_no_' + row_id).val();
	var old_row_column_no = old_row_column_no.replace(row_no + 'r-', '');
	if (old_row_column_no != '') {
		var old_row_column_no = old_row_column_no + ',' + field_name;
	} else {
		var old_row_column_no = field_name;
	}
	$('#row_column_no_' + row_id).val(row_no + 'r-' + old_row_column_no);
	$('#closemodel').click();
	return false;
}

function remove_form_row_column(id, column_id) {

	var field_name = $("#row_column_field_name" + id).val();
	var field_name = field_name.toLowerCase().replace(/\b[a-z]/g, function (letter) {
		return letter.toUpperCase();
	});
	var row_no = $('#row_no_' + column_id).val();
	var old_row_column_no = $('#row_column_no_' + column_id).val();
	var old_row_column_no = old_row_column_no.replace(row_no + 'r-', '');
	var result = old_row_column_no.split(',');
	$('#row_column_no_' + column_id).val('');
	for (var c = 0; c < result.length; c++) {
		if (result[c] != field_name) {
			var old_row_column_no = $('#row_column_no_' + column_id).val();
			var old_row_column_no = old_row_column_no.replace(row_no + 'r-', '');
			if (old_row_column_no != '') {
				var old_row_column_no = old_row_column_no + ',' + result[c];
			} else {
				var old_row_column_no = result[c];
			}
			$('#row_column_no_' + column_id).val(row_no + 'r-' + old_row_column_no);
		}
	}
	$("#" + field_name + 'ff').show();
	$("#form_row_column_" + id).remove();
	$("#select_column option[value='" + field_name + "']").show();
	var row_column = $("input[name^='select_row_column_" + column_id + "[]']").map(function (idx, elem) {
		return $(elem).val();
	}).get();
	var row_column1 = row_column + '';
	var result = row_column1.split(',');
	var row_column_count = "";
	if (result != "") {
		var row_column_count = result.length;
	}

	if (row_column_count != "") {
		for (var i = 0; i < row_column_count; i++) {
			if (row_column_count == 1) {
				var size = "form_row_column col-md-12 col-lg-12 col-sm-12 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
			} else if (row_column_count == 2) {
				var size = "form_row_column col-md-6 col-lg-6 col-sm-6 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
			} else if (row_column_count == 3) {
				var size = "form_row_column col-md-4 col-lg-4 col-sm-4 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
				$('#add_morerowcolumn_' + column_id).removeAttr('disabled');
			}
		}
	}
}



// Contact Layout


// Form Layout
var morerow = $("input[name='select_row[]']:last").val();
if (morerow == undefined) {
	var j = 1;
} else {
	var j = morerow + 1;
}

function contact_add_morerow() {
	var data = '<div class="form_totalorow" id="form_totalorow_' + j + '"><div class="form_row col-md-10 col-lg-10 col-sm-10 col-xs-12"><ul id="form_row_' + j + '"></ul></div><div class="row_button col-md-2 col-lg-2 col-sm-2 col-xs-12"><button name="opener" class="btn btn-success btn-add" type="button" id="add_morerowcolumn_' + j + '" data-toggle="modal" data-target="#contact_myModal" title="Add" onclick="contact_add_morerowcolumn(' + j + ')">Add Column <span class="glyphicon glyphicon-plus"></span></button><button class="btn btn-remove btn-danger space_padd" type="button" id="form_row_id_' + j + '" onclick="contact_remove_form_row(' + j + ')"><input type="hidden" name="row_column_no[]" id="row_column_no_' + j + '" value=""><input type="hidden" name="row_no_' + j + '" id="row_no_' + j + '" value=""><input type="hidden" name="select_row[]" id="select_row" value="' + j + '"><span title="Remove Row"><i class="fa fa-trash-o" aria-hidden="true"></i></span></button></div></div>';
	$('#custom_form').append(data);
	var row = $("input[name^='select_row[]']").map(function (idx, elem) {
		return $(elem).val();
	}).get();
	var row1 = row + '';
	var result = row1.split(',');
	var row_count = result.length;
	$('#row').val(row_count);
	for (var r = 0; r < row_count; r++) {
		var value = parseInt(r) + 1;
		$('#row_no_' + result[r]).val(value);
	}
	j++;
	return false;
}

function contact_remove_form_row(id) {
	var gethtml = $('#form_row_' + id).html();
	var gethtml = gethtml.trim();
	if (gethtml == "") {
		$("#form_totalorow_" + id).remove();
		var row = $("input[name^='select_row[]']").map(function (idx, elem) {
			return $(elem).val();
		}).get();
		var row1 = row + '';
		var result = row1.split(',');
		var row_count = result.length;
		$('#row').val(row_count);
		for (var r = 0; r < row_count; r++) {
			var value = parseInt(r) + 1;
			$('#row_no_' + result[r]).val(value);
		}
	} else {
		alert('First Remove Columns');
	}
}

function contact_add_morerowcolumn(row_id) {
	$('#select_column').attr('onchange', 'contact_add_morerowcolumn1(' + row_id + ')');
}

function contact_add_morerowcolumn1(row_id) {
	var field_name = $('#select_column').val();
	var field_name1 = field_name.replace(/_/g, " ");
	var field_name1 = field_name1[0].toUpperCase() + field_name1.slice(1);
	$("#select_column option[value='" + field_name + "']").hide();
	var morecolumn = $("input[name='select_column_" + row_id + "[]']:last").val();
	if (morecolumn == undefined) {
		var c = 1;
		var column_count = 0;
	} else {
		var column = $("input[name^='select_row_column_" + row_id + "[]']").map(function (idx, elem) {
			return $(elem).val();
		}).get();
		var column1 = column + '';
		var result = column1.split(',');
		var column_count = 0;
		if (result != "") {
			var column_count = result.length;
		}
		var c = parseInt(morecolumn) + 1;
	}

	if (column_count != 0) {
		for (var i = 0; i < column_count; i++) {
			if (column_count == 1) {
				var size = "form_row_column col-md-6 col-lg-6 col-sm-6 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
				$('#add_morerowcolumn_' + row_id).attr('disabled', 'disabled');
			}
		}
	} else {
		var size = "form_row_column col-md-12 col-lg-12 col-sm-12 col-xs-12";
	}

	var data = '<li class="' + size + '" id="form_row_column_' + row_id + c + '"><div><label>' + field_name1 + '</label><button type="button" onclick="contact_remove_form_row_column(' + row_id + c + ',' + row_id + ')"><input type="hidden" name="select_column_' + row_id + '[]" id="select_column_' + row_id + '" value="' + c + '"><input type="hidden" name="select_row_column_' + row_id + '[]" id="select_row_column_' + row_id + '" value="' + row_id + c + '"><input type="hidden" name="row_column_field_name' + row_id + c + '[]" id="row_column_field_name' + row_id + c + '" value="' + field_name + '"><i class="fa fa-times-circle" aria-hidden="true"></i></button></div></li>';
	$('#form_row_' + row_id).append(data);
	$('#' + field_name + 'ff').hide();
	var row = $("input[name^='select_column_" + row_id + "[]']").map(function (idx, elem) {
		return $(elem).val();
	}).get();
	var row1 = row + '';
	var result = row1.split(',');
	var row_count = result.length;
	var row_no = $('#row_no_' + row_id).val();
	var old_row_column_no = $('#row_column_no_' + row_id).val();
	var old_row_column_no = old_row_column_no.replace(row_no + 'r-', '');
	if (old_row_column_no != '') {
		var old_row_column_no = old_row_column_no + ',' + field_name;
	} else {
		var old_row_column_no = field_name;
	}
	$('#row_column_no_' + row_id).val(row_no + 'r-' + old_row_column_no);
	$('#closemodel').click();
	return false;
}

function contact_remove_form_row_column(id, column_id) {

	var field_name = $("#row_column_field_name" + id).val();
	var row_no = $('#row_no_' + column_id).val();
	var old_row_column_no = $('#row_column_no_' + column_id).val();
	var old_row_column_no = old_row_column_no.replace(row_no + 'r-', '');
	var result = old_row_column_no.split(',');
	$('#row_column_no_' + column_id).val('');
	for (var c = 0; c < result.length; c++) {
		if (result[c] != field_name) {
			var old_row_column_no = $('#row_column_no_' + column_id).val();
			var old_row_column_no = old_row_column_no.replace(row_no + 'r-', '');
			if (old_row_column_no != '') {
				var old_row_column_no = old_row_column_no + ',' + result[c];
			} else {
				var old_row_column_no = result[c];
			}
			$('#row_column_no_' + column_id).val(row_no + 'r-' + old_row_column_no);
		}
	}
	$("#" + field_name + 'ff').show();
	$("#form_row_column_" + id).remove();
	$("#select_column option[value='" + field_name + "']").show();
	var row_column = $("input[name^='select_row_column_" + column_id + "[]']").map(function (idx, elem) {
		return $(elem).val();
	}).get();
	var row_column1 = row_column + '';
	var result = row_column1.split(',');
	var row_column_count = "";
	if (result != "") {
		var row_column_count = result.length;
	}

	if (row_column_count != "") {
		for (var i = 0; i < row_column_count; i++) {
			if (row_column_count == 1) {
				var size = "form_row_column col-md-12 col-lg-12 col-sm-12 col-xs-12";
				$('#form_row_column_' + result[i]).attr('class', size);
				$('#add_morerowcolumn_' + column_id).removeAttr('disabled');
			}
		}
	}
}




// Contact Separate Form Field

// Separate Form Field

var selectoption_more = $("input[name='select_options[]']:last").val();
if (selectoption_more == undefined) {
	var selectoption_more = $('#select_options').val();
	var s = $('#field_selectoptions_' + selectoption_more).size() + 1;
} else {
	var s = selectoption_more + 1;
}

function add_moreselectoptsep() {
	var data = '<div class="form-group entry" id="remove_options_' + s + '"><input type="text" name="options[]" class="form-control" placeholder="Dropdown option value" /><span class="input-group-btn"><button class="btn btn-remove btn-danger" type="button" onclick="remove_selectoptsep(' + s + ')"><input type="hidden" name="select_options[]" id="select_options" value="' + s + '"><span class="glyphicon glyphicon-minus"></span></button></span></div>';
	$('#field_selectoptions').append(data);
	s++;
	return false;
}

function remove_selectoptsep(id) {
	$("#remove_options_" + id).remove();
}

var chk_more = $("input[name='chk_options_hid[]']:last").val();
if (chk_more == undefined) {
	var chk_more = $('#chk_options_hid').val();
	var chk = $('#field_checkoptions_' + chk_more).size() + 1;
} else {
	var chk = chk_more + 1;
}

function add_morechkoptionssep() {
	var data = '<div class="form-group entry" id="remove_chkoptions_' + chk + '"><input type="text" name="chk_options[]" class="form-control" placeholder="Checkbox Label" /><span class="input-group-btn"><button class="btn btn-remove btn-danger" type="button" onclick="remove_chkopt(' + chk + ')"><input type="hidden" id="chk_options_hid" name="chk_options_hid[]" value="' + chk + '"><span class="glyphicon glyphicon-minus"></span></button></span></div>';
	$('#field_checkoptions').append(data);
	chk++;
	return false;
}

function remove_chkoptsep(id) {
	$("#remove_chkoptions_" + id).remove();
}

var rad_more = $("input[name='radio_option_hid[]']:last").val();
if (rad_more == undefined) {
	var rad_more = $('#radio_option_hid').val();
	var radi = $('#field_checkoptions_' + rad_more).size() + 1;
} else {
	var radi = rad_more + 1;
}

function add_moreradiooptionssep() {
	var data = '<div class="form-group entry" id="remove_radiooptions_' + radi + '"><input type="text" name="radio_options[]" class="form-control" placeholder="Radio Label" /><span class="input-group-btn"><button class="btn btn-remove btn-danger" type="button" onclick="remove_radioopt(' + radi + ')"><input type="hidden" id="radio_option_hid" name="radio_option_hid[]" value="' + radi + '"><span class="glyphicon glyphicon-minus"></span></button></span></div>';
	$('#field_radiooptions').append(data);
	radi++;
	return false;
}

function remove_radiooptsep(id) {
	$("#remove_radiooptions_" + id).remove();
}


// Contact Mail Configure


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


// $(function () {
// 	$('#demo-form2').submit(function () {
// 		var test = $('demo-form2').serializeJSON();
// 		console.log(test);
// 		return false;
// 	});
// });

// $('#demo-form2').submit(function () {

// 	var form_data = $(this).serializeArray();

// 	$.ajax({
// 		type: 'POST',
// 		url: 'contact_us/test',
// 		data: {
// 			test: form_data
// 		},
// 		success: function (data) {
// 			console.log(data);
// 		}
// 	});

// 	return false;
// });

// var test = $('').;
// console.log(test);


// $(document).ready(function () {
// 	$("#btn").click(function (e) {
// 		var jsonData = {};

// 		var formData = $("#demo-form2").serializeArray();
// 		// console.log(formData);

// 		$.each(formData, function () {
// 			if (jsonData[this.name]) {
// 				if (!jsonData[this.name].push) {
// 					jsonData[this.name] = [jsonData[this.name]];
// 				}
// 				jsonData[this.name].push(this.value || '');
// 			} else {
// 				jsonData[this.name] = this.value || '';
// 			}


// 		});
// 		console.log(jsonData);
// 		$.ajax({
// 			url: "contact_us/test",
// 			type: "POST",
// 			data: jsonData,

// 		});
// 		e.preventDefault();
// 	});
// });
