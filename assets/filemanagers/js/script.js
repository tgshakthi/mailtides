// JavaScript Document

function grid_view()
{
	$('#grid_view').show();
	$('#list_view').hide();
}

function list_view()
{
	$('#list_view').show();
	$('#grid_view').hide();
}

// Go Forward
function goForward() 
{
    window.history.forward();
}

// Go Back
function goBack() 
{
    window.history.back();
}

//Refresh
function refresh()
{
	location.reload();
}

// Files Upload
$('#upload_file_btn').on('click',function(e){
	
	e.preventDefault();
	$.ajax({
		url: "ajax_calls.php",
		type: "POST",
		data:  new FormData($('#form')[0]),
		contentType: false,
		cache: false,
		processData:false,
		success: function(data)
		{
			$('#image_preview').html(data);
			$('#output').empty();
			$('input[name="upload_file1[]"]').remove();
			$('#output').hide();
			$('#cancel').hide();
			$('#upload_file_btn').hide();
			window.location = '';
		},
		error: function(){} 	        
	});
});

// Choosed Files List
$('#upload_file_list').on('click',function(){
	
	var y = $('#count_file').val();
	$('#upload_file'+[y]+'').on('change',function(event){

		$("#upload_file"+[y]+"").attr('name','upload_file1[]');
		$("#upload_file"+[y]+"").hide();
		var z=parseInt(y) + parseInt(1);
		var x=parseInt(y) + parseInt(1);
		while(x <= z)
		{
			var file_name = $("#upload_file"+[y]+"").val();
			var total_file = document.getElementById("upload_file"+[y]+"").files.length;
			for(var i=0;i<total_file;i++)
			{
				$('#output').show();
				$('#output').append("<li id='previewimg"+[x]+[i]+"' ><img class='preview' src='"+URL.createObjectURL(event.target.files[i])+"'><a href='javascript:void(0);' id='previewimg"+[x]+[i]+"' onclick='previewdele(this)' >x</a><input type='hidden' id='previewimg"+[x]+[i]+"' name='filename[]' value='"+event.target.files[i]['name']+"' /></li>");
			}
			$('#upload_file_list_div').append("<input class='fileup' type='file' id='upload_file"+[x]+"' name='upload_file2[]' multiple/>");
			x++;
		}
		$('#upload_file_btn').show();
		$('#cancel').show();
		y++;
		$('#count_file').val(y);
	});
});

// Preview File Delete
function previewdele(e){
	var id=e.id;
	$('#'+id).remove();

	var outval=$('#output').html();
	if(outval == ''){
		$('#cancel').hide();
		$('#upload_file_btn').hide();
	}
}

// Cancel Upload
function cancelupload()
{
	$('input[name="upload_file1[]"]').remove();
	$('#output').empty();
	$('#cancel').hide();
	$('#upload_file_btn').hide();
}

// Rename Folder Popup
function change_folder_name(path, thumb_path, folder, extension)
{
	$('#folder_path').val(path);
	$('#thumb_path').val(thumb_path);
	$('#old_folder_name').val(folder);
	$('#new_folder_name').val(folder);
	$('#extension').val(extension);
	
	var modal = document.getElementById('myfolder');
	var span = document.getElementsByClassName("close")[0];
	modal.style.display = "block";
	
	span.onclick = function() {
		modal.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

// Files Upload
$('#rename_submit').on('click',function(e){
	
	e.preventDefault();
	$.ajax({
		url: "ajax_calls.php",
		type: "POST",
		data:  $('#rename_form').serialize(),
		success: function(data)
		{
			window.location = '';
		},
		error: function(){} 	        
	});
});

// Erase Folder Popup
function erase_folder(path, thumb_path, folder, extension)
{
	$('#confirm_delete_path').val(path);
	$('#confirm_delete_thumb_path').val(thumb_path);
	$('#confirm_delete_folder').val(folder);
	$('#confirm_delete_extention').val(extension);

	var content = (extension != '') ? 'Are you sure you want to delete this file?': 'Are you sure to delete the folder and all the elements in it?';
	$('#confirm_delete_content').html(content);
	
	var modal = document.getElementById('confirm_delete');
	var span = document.getElementsByClassName("confirm_delete_close")[0];
	modal.style.display = "block";
	
	span.onclick = function() {
		modal.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

// Files Upload
$('#confirm_delete_ok').on('click',function(e){
	
	e.preventDefault();
	$.ajax({
		url: "ajax_calls.php",
		type: "POST",
		data:  $('#confirm_delete_form').serialize(),
		success: function(data)
		{
			window.location = '';
		},
		error: function(){} 	        
	});
});

// View Image
function view_image(img_path)
{
	$('#original_image_view').attr('src', img_path);
	
	var modal = document.getElementById('view_image');
	var span = document.getElementsByClassName("view_image_close")[0];
	modal.style.display = "block";
	
	span.onclick = function() {
		modal.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

// View Image
function create_folder(folder_path)
{
	$('#create_folder_path').val(folder_path);
	
	var modal = document.getElementById('create_folder');
	var span = document.getElementsByClassName("create_folder_close")[0];
	modal.style.display = "block";
	
	span.onclick = function() {
		modal.style.display = "none";
	}
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
}

// Files Upload
$('#create_folder_submit').on('click',function(e){
	
	e.preventDefault();
	$.ajax({
		url: "ajax_calls.php",
		type: "POST",
		data:  $('#create_folder_form').serialize(),
		success: function(data)
		{
			window.location = '';
		},
		error: function(){} 	        
	});
});

// Search Name
function search_name()
{
	var value = $('#search_name').val().toLowerCase();
    $("#grid_view .grid_list_details").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
	
	$("#list_view tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
}

$(document).ready(function(){
    $(".file_icon").click(function(){
        $(".mobile_dropdown").slideToggle("slow");
    });
});

$( ".file_manager_refresh" ).click(function() {
    location.reload();
});

function getvalue(id, image)
{
	$('.close', parent.document.body).click();
	$('#'+id, parent.document.body).val($('#base_url').val()+image)
}