// Image Card
// Includes :
// Button Hover Effects
// Image Card Hover Effects (title, short desc title, short desc, desc title, desc)

function imageCardReadMoreHover(e, s, a, d, _, r) {
	$("#hover_" + _ + r).removeClass(e), $("#hover_" + _ + r).removeClass(s), $("#hover_" + _ + r).addClass(a), $("#hover_" + _ + r).addClass(d)
}

function imageCardReadMoreHoverOut(e, s, a, d, _, r) {
	$("#hover_" + _ + r).addClass(e), $("#hover_" + _ + r).addClass(s), $("#hover_" + _ + r).removeClass(a), $("#hover_" + _ + r).removeClass(d)
}
