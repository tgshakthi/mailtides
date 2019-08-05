 $(document).ready(function () {
 	$('.center-tab-ul').tabs();

 	$('#center_tab a').click(function () {
 		$('#center_tab a').removeClass("active");
 		$(this).addClass("active");
 	});
 });



 function center_tab_text_color(text_color, text_onclick_color, bg_tab_color, bg_onclick_color, id) {

 	if ($('#center_tab a').not(".active")) {
 		$('#center_tab a').removeClass(text_onclick_color);
 		$('#center_tab a').addClass(text_color);
 		$('#center_tab a').removeClass(bg_onclick_color);
 		$('#center_tab a').addClass(bg_tab_color);
 	}

 	$('.center-tab-' + id).removeClass(text_color);
 	$('.center-tab-' + id).addClass(text_onclick_color);
 	$('.center-tab-' + id).removeClass(bg_tab_color);
 	$('.center-tab-' + id).addClass(bg_onclick_color);

 }

 function center_tab_read_more_hover(bg_color, hover_bgcolor, text_color, hover_text_color, tab_id) {
 	$('#center_tab_hover_' + tab_id).removeClass(bg_color);
 	$('#center_tab_hover_' + tab_id).removeClass(text_color);
 	$('#center_tab_hover_' + tab_id).addClass(hover_bgcolor);
 	$('#center_tab_hover_' + tab_id).addClass(hover_text_color);
 }

 function center_tab_read_more_hoverout(bg_color, hover_bgcolor, text_color, hover_text_color, tab_id) {
 	$('#center_tab_hover_' + tab_id).addClass(bg_color);
 	$('#center_tab_hover_' + tab_id).addClass(text_color);
 	$('#center_tab_hover_' + tab_id).removeClass(hover_bgcolor);
 	$('#center_tab_hover_' + tab_id).removeClass(hover_text_color);
 }
 $(document).ready(function(){
    $('.tooltipped').tooltip();
  });