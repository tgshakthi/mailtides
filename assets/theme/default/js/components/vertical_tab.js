function verticalTabTextColor(a,e,t,l,s){$(".tabs #vertical-tab-li a").not(".active")&&($("#vertical-tab-li a").removeClass(e),$("#vertical-tab-li a").removeClass(l),$("#vertical-tab-li a").addClass(a),$("#vertical-tab-li a").addClass(t)),$(".tab-"+s).removeClass(a),$(".tab-"+s).removeClass(t),$(".tab-"+s).addClass(e),$(".tab-"+s).addClass(l)}function verticalTabReadMoreHover(a,e,t,l,s){$("#vertical_tab_hover_"+s).removeClass(a),$("#vertical_tab_hover_"+s).removeClass(e),$("#vertical_tab_hover_"+s).addClass(t),$("#vertical_tab_hover_"+s).addClass(l)}function verticalTabReadMoreHoverOut(a,e,t,l,s){$("#vertical_tab_hover_"+s).removeClass(t),$("#vertical_tab_hover_"+s).removeClass(l),$("#vertical_tab_hover_"+s).addClass(a),$("#vertical_tab_hover_"+s).addClass(e)}$(document).ready(function(){$(".tabs").tabs(),$(".tabs #vertical-tab-li a").click(function(){$("#vertical-tab-li a").removeClass("vertical-active"),$(this).addClass("vertical-active")})}),$(document).ready(function(){$(".tab-container").easytabs({animationSpeed:300,tabActiveClass:"selected-tab",panelActiveClass:"displayed",updateHash:!1})});