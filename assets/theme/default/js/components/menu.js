$(document).ready(function () {

	$(".dm-list-submenu").click(function () {
		var answerid = $(this).attr('id');
		var id_name = ".submenu_content_" + answerid;
		var menu_bg = ".menu_black_bg_" + answerid;

		if ($('*').hasClass("1sttime")) {
			if ($(id_name).attr('id') == 'active') {

				if ($(id_name).hasClass("menupanelopen1")) {
					$(id_name).removeClass("menupanelopen1");
					$(menu_bg).delay(200).removeClass("menu_black_bg_on1", 1000);
				} else {
					$(id_name).removeClass("menupanelopen2");
					$(menu_bg).delay(200).removeClass("menu_black_bg_on2", 1000);
				}
				$(id_name).removeAttr('id');
				$(id_name).removeClass("menupanelclose2");

				$('.mainmenu_sub').removeClass("1sttime");

			} else {
				for (i = 0; i < 7; i++) {
					if (i != answerid) {
						var new_id_name = ".submenu_content_" + i;
						var new_menu_bg = ".menu_black_bg_" + i;

						$(new_id_name).removeClass("menupanelopen1", 1000);
						$(new_id_name).removeClass("menupanelopen2", 1000);
						$(new_id_name).addClass("menupanelclose2", 1000);
						$(new_menu_bg).delay(200).removeClass("menu_black_bg_on1", 1000);
						$(new_menu_bg).delay(200).removeClass("menu_black_bg_on2", 1000);
						$(new_id_name).removeAttr('id');
					}

				}
				$(menu_bg).delay(200).addClass("menu_black_bg_on2", 1000);
				$(id_name).removeClass("menupanelclose2", 1000);
				$(id_name).toggleClass("menupanelopen2", 1000);
				$(id_name).attr('id', 'active');

				$(".login_black_bg").hide();

			}

		} else {
			$(id_name).removeClass("menupanelclose2", 1000);
			$('.mainmenu_sub').addClass("1sttime");
			$(id_name).toggleClass("menupanelopen1", 1000);
			$(menu_bg).delay(200).addClass("menu_black_bg_on1", 1000);
			$(id_name).attr('id', 'active');
			$(".login_black_bg").hide();
		}
	});

});


/* desktop drop down tab list menu*/
$(function () {
	$('#dl-menu').dlmenu();
});
