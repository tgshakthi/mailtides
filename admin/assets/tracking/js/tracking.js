// Mail Configure


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
	var data = '<div class="row" id="form_toid_' + to + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="carbon_copy" name="to_address[]" placeholder="Add To Address" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldsto(' + to + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
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
	var data = '<div class="row" id="form_ccid_' + cc + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="carbon_copy" name="carbon_copy[]" placeholder="Add CC" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldscc(' + cc + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
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
	var data = '<div class="row" id="form_bccid_' + bcc + '"><div class="form-group col-md-10 col-lg-10 col-sm-10 col-xs-12"><input type="text" class="form-control" id="blind_carbon_copy" name="blind_carbon_copy[]" placeholder="Add BCC" required /></div><div class="col-md-2 col-lg-2 col-sm-2 col-xs-12"><button class="btn btn-remove btn-danger" type="button" title="Remove" onclick="remove_from_fieldsbcc(' + bcc + ');"><span class="glyphicon glyphicon-minus"></span></button></div></div>';
	$('#result_fieldbcc').append(data);
	bcc++;
	return false;
}

function remove_from_fieldsbcc(id) {
	$("#form_bccid_" + id).remove();
}