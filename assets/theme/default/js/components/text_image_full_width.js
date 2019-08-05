// Text and Image 
// Read More Button Hover Effects
function text_image_full_width_read_more_hover(btn_bg_color,label_color,btn_hover_color,text_hover,id,page_id)

{
	$('#text_image_hover_' + id + page_id).removeClass(btn_bg_color);
	$('#text_image_hover_' + id + page_id).addClass(btn_hover_color);

	$('#text_image_hover_' + id + page_id).removeClass(label_color);
	$('#text_image_hover_' + id + page_id).addClass(text_hover);

}

function text_image_full_width_read_more_hoverout(btn_bg_color,label_color,btn_hover_color,text_hover,id,page_id)
{
	$('#text_image_hover_' + id + page_id).removeClass(btn_hover_color);
	$('#text_image_hover_' + id + page_id).addClass(btn_bg_color);

	$('#text_image_hover_' + id + page_id).removeClass(text_hover);
	$('#text_image_hover_' + id + page_id).addClass(label_color);

}
