function text_and_bg_image_readmore_hover(a, e, _, t, d, g) {
	$("#text_background_image_" + d + g).removeClass(a), $("#text_background_image_" + d + g).removeClass(e), $("#text_background_image_" + d + g).addClass(_), $("#text_background_image_" + d + g).addClass(t)
}

function text_and_bg_image_readmore_hoverout(a, e, _, t, d, g) {
	$("#text_background_image_" + d + g).removeClass(_), $("#text_background_image_" + d + g).removeClass(t), $("#text_background_image_" + d + g).addClass(a), $("#text_background_image_" + d + g).addClass(e)
}
