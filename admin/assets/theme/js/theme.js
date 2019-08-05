
// Install Theme
function bs_input_file() {
	$(".input-file").before(
		function() {
			if ( ! $(this).prev().hasClass('input-ghost') ) {
				var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
				element.attr("name",$(this).attr("name"));
				element.change(function(){
					element.next(element).find('input').val((element.val()).split('\\').pop());
				});
				$(this).find("button.btn-choose").click(function(){
					element.click();
				});
				$(this).find("button.btn-reset").click(function(){
					element.val(null);
					$(this).parents(".input-file").find('input').val('');
				});
				$(this).find('input').css("cursor","pointer");
				$(this).find('input').mousedown(function() {
					$(this).parents('.input-file').prev().click();
					return false;
				});
				return element;
			}
		}
	);
}
$(function() {
	bs_input_file();
});

$(document).ready(function() {
    $('#demo-form2').submit(function(e) {
      var component_name = $('#fupload').val();
      var comp_name = component_name.replace('C:\\fakepath\\', "");
      var newString = comp_name.split('.', 1)[0];
	
        if($('#fupload').val()) {
            e.preventDefault();
            $('#btn').hide();
          	$('.spinner').css('display','block');
            $('#progress-div').show();
            $(this).ajaxSubmit({
                beforeSubmit: function() {
                    $("#progress-bar").width('0%');
                },
                uploadProgress: function (event, position, total, percentComplete){
                    $("#progress-bar").width(percentComplete + '%');
                    $("#progress-bar").html('<div id="progress-status">' + newString + ' - ' + percentComplete +' %</div>')
                },
                success:function (data){
					$('#loader-icon').hide();
				   	$('#progress-div').hide();
					window.location = '../theme';
					/*if(data == 0)
					{
						$('.alert-warning').show();
						$('.alert-success').hide();
						$('#warning').html(newString+' Component is Already Installed');
					}
					else if(data == 2)
					{
						$('.alert-success').show();
						$('.alert-warning').hide();
						$('#success').html(newString+' Successfully Installed');
					}
					else if(data == 1)
					{
						$('.alert-success').hide();
						$('.alert-warning').show();
						$('#warning').html(newString+' is Something Wrong');
					}
					else
					{
						$('.alert-success').hide();
						$('.alert-warning').show();
						$('#warning').html(newString+' is Some Errors Occur');
					}*/
                },
                resetForm: true
            });
            return true;
        }
    });
});