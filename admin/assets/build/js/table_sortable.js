// Table Sortable
$('#table_row_sortable').sortable({
	revert:true,
	update : function () { 
			
		var values = $("input[id='row_sort_order']").map(function(){
			return $(this).val();
	  	}).get(); 
		var sort_id = $('#sort_id').val();
		var sort_url = $('#sort_url').val();
		
		$.ajax({
			type : "POST",
			url  : sort_url,
			data : {sort_id:sort_id,row_sort_order:values},
			success: function(data)
			{
			}
		}); 
  	},
	helper: fixWidthHelper
}).disableSelection();

function fixWidthHelper(e, ui) {
	ui.children().each(function() {
		$(this).width($(this).width());
	});
	return ui;
}