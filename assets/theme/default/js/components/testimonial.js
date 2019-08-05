//testimonials
$(document).ready(function () {
	var testimonial_per_row = $('#testimonial_per_row').val();
	var owl = $("#testimonial");
	owl.owlCarousel({
		items: testimonial_per_row, //10 items above 1000px browser width
		itemsDesktop: [1000, 2], //5 items between 1000px and 901px
		itemsDesktopSmall: [900, 1], // 3 items betweem 900px and 601px
		itemsTablet: [768, 1], //2 items between 600 and 0;
		itemsMobile: [480, 1], // itemsMobile disabled - inherit from itemsTablet option
		paginationSpeed: 1000,
		slideBy:1,
		pagination: true,
		stopOnHover: true,
		navigation: false,
		navigationText: [
"<i class='fa fa-angle-double-left' title='Previuos'></i>",
"<i class='fa fa-angle-double-right' title='Next'></i>"
],
		rewindSpeed: 1000,
	
	});

});

testimonial_grid_hover = (bgColor, bgHoverColor, authorColor, authorHoverColor, contentTitleColor, contentTitleHoverColor, contentColor, contentHoverColor, designationColor, designationHoverColor, pageId, id) => {

	

}

$(document).ready(function(){

    var highestBox = 0;
        $('.before_after').each(function(){  
                if($(this).height() > highestBox){  
                highestBox = $(this).height();  
        }
    });    
    $('.before_after').height(highestBox);

});

