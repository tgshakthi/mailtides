// Tab
function tabReadMoreHover(a,e,o,s,t){$("#tab_hover_"+t).removeClass(a),$("#tab_hover_"+t).removeClass(o),$("#tab_hover_"+t).addClass(e),$("#tab_hover_"+t).addClass(s)}function tabReadMoreHoverOut(a,e,o,s,t){$("#tab_hover_"+t).addClass(a),$("#tab_hover_"+t).addClass(o),$("#tab_hover_"+t).removeClass(e),$("#tab_hover_"+t).removeClass(s)}$(document).ready(function(){$("#tab-tabs").tabs({})});