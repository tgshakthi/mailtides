function textAndImageReadMoreHover(e, o, a, r, s, v) {
	
    $("#text_image_hover_" + s + v).removeClass(e), $("#text_image_hover_" + s + v).removeClass(o), $("#text_image_hover_" + s + v).addClass(a), $("#text_image_hover_" + s + v).addClass(r)
}

function textAndImageReadMoreHoverOut(e, o, a, r, s, v) {
    $("#text_image_hover_" + s + v).addClass(e), $("#text_image_hover_" + s + v).addClass(o), $("#text_image_hover_" + s + v).removeClass(a), $("#text_image_hover_" + s + v).removeClass(r)
}
	