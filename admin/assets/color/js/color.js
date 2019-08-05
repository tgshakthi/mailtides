// JavaScript Document
function showcolor(slideid)
{
	$('#'+slideid).slideToggle('slow');
}

function choosecolor(id,slideid,selected,colorid,hid,color_name,selected1)
{
	var palette = $('#'+hid+'a'+id).val();
	var color = $('#'+color_name+'a'+id).val();
	$('#'+colorid).val(palette);
	$('#'+selected).val(color);
	$('#'+selected1+' i').attr('class',palette);
	$('.close').click();
	$('#demo-form2').submit(true);
}

function search_colors(id)
{
    var value = $('#search_color'+id).val().toLowerCase();
    $("#color_palette"+id+" li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
}

// Edit Color
function edit_color(id, name, class_name, code)
{
	var color_id = id;
	$('#color_popup').modal('show');
	$('#myModalLabel').text('Update Color');
	$('#clear').show();
	$('#color_id').val(color_id);
	$('#color_name').val(name);
	$('#color_class').val(class_name);
	$('#color_code').val(code);
	$('#btn').val('Update');	
}

// Search color
function search_color_go()
{
	var search_text = $('#search').val();
	$.ajax({
		type : 'POST',
		url : 'color/search_color',
		data : {search_text: search_text},
		success: function(data){
			$('.c_color_panel').html(data);
		}
	});
}

// Clear form
function clear_btn()
{
	$('#clear').hide();
	$('#color_id').val('');
	$('#myModalLabel').text('Add Color');
	$('#btn').val('Add');	
}