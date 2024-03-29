"use strict";
//Wrapping all JavaScript code into a IIFE function for prevent global variables creation
(function(){

var $body = jQuery('body');
var $window = jQuery(window);

//hidding menu elements that do not fit in menu width
//processing center logo
function menuHideExtraElements() {

	//cleaneng changed elements
	jQuery('.sf-more-li, .sf-logo-li').remove();
	var windowWidth = jQuery('body').innerWidth();

	jQuery('.sf-menu').each(function(){
		var $thisMenu = jQuery(this);
		var $menuWraper = $thisMenu.closest('.mainmenu_wrapper');
		$menuWraper.attr('style', '');
		if (windowWidth > 991) {
			//grab all main menu first level items
			var $menuLis = $menuWraper.find('.sf-menu > li');
			$menuLis.removeClass('sf-md-hidden');

			var $headerLogoCenter = $thisMenu.closest('.header_logo_center');
			var logoWidth = 0;
			var summaryLiWidth = 0;

			if ( $headerLogoCenter.length ) {
				var $logo = $headerLogoCenter.find('.logo');
				// 30/2 - left and right margins
				logoWidth = $logo.outerWidth(true) + 70;
			}

			// var wrapperWidth = jQuery('.sf-menu').width();
			var wrapperWidth = $menuWraper.outerWidth(true);
			$menuLis.each(function(index) {
				var elementWidth = jQuery(this).outerWidth();
				summaryLiWidth += elementWidth;
				if(summaryLiWidth >= (wrapperWidth-logoWidth)) {
					var $newLi = jQuery('<li class="sf-more-li"><a>...</a><ul></ul></li>');
					jQuery($menuLis[index - 1 ]).before($newLi);
					var newLiWidth = jQuery($newLi).outerWidth(true);
					var $extraLiElements = $menuLis.filter(':gt('+ ( index - 2 ) +')');
					$extraLiElements.clone().appendTo($newLi.find('ul'));
					$extraLiElements.addClass('sf-md-hidden');
					return false;
				}
			});

			if ( $headerLogoCenter.length ) {
				var $menuLisVisible = $headerLogoCenter.find('.sf-menu > li:not(.sf-md-hidden)');
				var menuLength = $menuLisVisible.length;
				var summaryLiVisibleWidth = 0;
				$menuLisVisible.each(function(){
					summaryLiVisibleWidth += jQuery(this).outerWidth();
				});

				var centerLi = Math.floor( menuLength / 2 );
				if ( (menuLength % 2 === 0) ) {
					centerLi--;
				}
				var $liLeftFromLogo = $menuLisVisible.eq(centerLi);
				$liLeftFromLogo.after('<li class="sf-logo-li"></li>');
				$headerLogoCenter.find('.sf-logo-li').width(logoWidth);
				var liLeftRightDotX = $liLeftFromLogo.offset().left + $liLeftFromLogo.outerWidth();
				var logoLeftDotX = windowWidth/2 - logoWidth/2;
				var menuLeftOffset = liLeftRightDotX - logoLeftDotX;
				$menuWraper.css({'left': -menuLeftOffset})
			}

		}// > 991
	}); //sf-menu each
} //menuHideExtraElements

function initMegaMenu() {
	var $megaMenu = jQuery('.mainmenu_wrapper .mega-menu');
	if($megaMenu.length) {
		var windowWidth = jQuery('body').innerWidth();
		if (windowWidth > 991) {
			$megaMenu.each(function(){
				var $thisMegaMenu = jQuery(this);
				//temporary showing mega menu to propper size calc
				$thisMegaMenu.css({'display': 'block', 'left': 'auto'});
				var thisWidth = $thisMegaMenu.outerWidth();
				var thisOffset = $thisMegaMenu.offset().left;
				var thisLeft = (thisOffset + (thisWidth/2)) - windowWidth/2;
				$thisMegaMenu.css({'left' : -thisLeft, 'display': 'none'});
				if(!$thisMegaMenu.closest('ul').hasClass('nav')) {
					$thisMegaMenu.css('left', '');
				}
			});
		}
	}
}


//wrap select element in select-group
function wrapSelect() {
	jQuery('.wrap-select-group, .cryptonatorwidget select').each(function() {
		var $select = jQuery( this );
		if ( $select.hasClass('select2-hidden-accessible') ) {
			return;
		}
		$select.wrap('<div class="form-group select-group"></div>').after('<i class="fa fa-angle-down theme_button color2 no_bg_button" aria-hidden="true"></i>');
		if ( $select.hasClass('wrap-select-group') ) {
			$select.addClass('empty choice');
		}
	})
}

function galleryItemsRender(gal, filter) {
	var $gallery = gal ? gal : jQuery('.filterable_gallery');
	var galFilter = filter ? filter : false;

	if ( !$gallery.length ) {
		return;
	}

	var itemsData = $gallery[0].dataset.items;

	var projects = JSON.parse(itemsData).projects;
	if (galFilter) {
		projects = projects.filter(function(item) {
			return item.categorySlug.split(' ').includes(galFilter);
		});
	}

	var itemsNumber = (projects.length >= 6) ? 6 : projects.length;
	var loadedImgCounter = 0;
	var elements = [];
	var itemLayoutRegular = ['col-lg-3', 'col-md-4', 'col-sm-6'];
	var itemLayoutWide = ['col-lg-6', 'col-md-8', 'col-sm-6'];
	var itemLayoutHigh = ['col-lg-3', 'col-md-4', 'col-sm-6', 'high-item'];
	var itemLayout = itemLayoutRegular;

	projects.forEach(function(elem, index) {
		if (index < 6) {
			if (index === 2) {
				itemLayout = itemLayoutHigh;
			} else if (index === 4) {
				itemLayout = itemLayoutWide;
			} else {
				itemLayout = itemLayoutRegular;
			}

			var curElement = document.createElement('div');
			curElement.classList.add('isotope-item');
			DOMTokenList.prototype.add.apply(curElement.classList, elem.categorySlug.split(' '));
			DOMTokenList.prototype.add.apply(curElement.classList, itemLayout);
			var categoriesList = '';
			elem.categorySlug.split(' ').forEach(function(slug){
				categoriesList += "<span>" + slug +"</span>";
			});
			var itemTitle = ( elem.projectLink ) ? "<a href=\"" +  elem.projectLink + "\">" + elem.title + "</a>" : elem.title;


			curElement.innerHTML = "<div class=\"vertical-item gallery-item content-absolute vertical-center hover-content text-center cs transp_bg\">\
					<div class=\"item-media\"></div>\
					<div class=\"item-content transp_color4_bg\">\
						<h3 class=\"entry-title thin margin_0\">" + itemTitle + "</h3>\
						<p class=\"categories-links\">\
							<span>" + categoriesList + "</span>\
						</p>\
						<p class=\"topmargin_20\">\
							<a href=\"" + elem.imgSrc + "\" class=\"theme_button inverse prettyPhoto\" data-gal=\"prettyPhoto[gal]\">view</a>\
						</p>\
					</div>\
				</div>";

			var elemImage = new Image();
			elemImage.onload = function() {
				jQuery( curElement ).find('.item-media').append(elemImage);
				elements.push(curElement);
				loadedImgCounter += 1;
				if ( loadedImgCounter === itemsNumber ) {
					$gallery.isotope( 'remove', $gallery.find('.isotope-item') );
					$gallery.append(elements).isotope( 'appended', elements ).isotope('layout');
					//reinit prettyPhoto in filtered items
					if (jQuery().prettyPhoto) {
						$gallery.find("a[data-gal^='prettyPhoto']").prettyPhoto({
							hook: 'data-gal',
							theme: 'facebook',
							social_tools: false
						});
					}
				}
			};
			elemImage.alt = elem.altText;
			elemImage.src = elem.imgSrc;
		}
	});
}

function galleryFiltersProcessing() {
	jQuery('.filterable_gallery_filters').find('a').on('click', function(e) {
		e.preventDefault();
		var selectedCategory = e.currentTarget.dataset.filter.slice(1);
		var relatedGalleryId = "#" + e.currentTarget.closest('.filterable_gallery_filters').dataset.gallery;
		var $relatedGallery = jQuery(relatedGalleryId);
		galleryItemsRender($relatedGallery, selectedCategory);
	})
}

//function that initiating template plugins on window.load event
function windowLoadInit() {

	////////////
	//mainmenu//
	////////////
	if (jQuery().scrollbar) {
		jQuery('[class*="scrollbar-"]').scrollbar();
	}
	if (jQuery().superfish) {
		jQuery('ul.sf-menu').superfish({
			popUpSelector: 'ul:not(.mega-menu ul), .mega-menu ',
			delay:       700,
			animation:   {opacity:'show', marginTop: 0},
			animationOut: {opacity: 'hide',  marginTop: 5},
			speed:       200,
			speedOut:    200,
			disableHI:   false,
			cssArrows:   true,
			autoArrows:  true

		});
		jQuery('ul.sf-menu-side').superfish({
			popUpSelector: 'ul:not(.mega-menu ul), .mega-menu ',
			delay:       500,
			animation:   {opacity:'show', height: 100 +'%'},
			animationOut: {opacity: 'hide',  height: 0},
			speed:       400,
			speedOut:    300,
			disableHI:   false,
			cssArrows:   true,
			autoArrows:  true
		});
	}


	//toggle mobile menu
	jQuery('.toggle_menu').on('click', function(){
		jQuery(this)
			.toggleClass('mobile-active')
				.closest('.page_header')
				.toggleClass('mobile-active')
				.end()
				.closest('.page_toplogo')
				.next()
				.find('.page_header')
				.toggleClass('mobile-active');
	});

	jQuery('.mainmenu a').on('click', function(){
		var $this = jQuery(this);
		//If this is a local link or item with sumbenu - not toggling menu
		if (($this.hasClass('sf-with-ul')) || !($this.attr('href').charAt(0) === '#')) {
			return;
		}
		$this
		.closest('.page_header')
		.toggleClass('mobile-active')
		.find('.toggle_menu')
		.toggleClass('mobile-active');
	});

	//side header processing
	var $sideHeader = jQuery('.page_header_side');
	// toggle sub-menus visibility on menu-click
	jQuery('ul.menu-side-click').find('li').each(function(){
		var $thisLi = jQuery(this);
		//toggle submenu only for menu items with submenu
		if ($thisLi.find('ul').length)  {
			$thisLi
				.append('<span class="activate_submenu"></span>')
				//adding anchor
				.find('.activate_submenu, > a')
				.on('click', function(e) {
					var $thisSpanOrA = jQuery(this);
					//if this is a link and it is already opened - going to link
					if (($thisSpanOrA.attr('href') === '#') || !($thisSpanOrA.parent().hasClass('active-submenu'))) {
						e.preventDefault();
					}
					if ($thisSpanOrA.parent().hasClass('active-submenu')) {
						$thisSpanOrA.parent().removeClass('active-submenu');
						return;
					}
					$thisLi.addClass('active-submenu').siblings().removeClass('active-submenu');
				});
		} //eof sumbenu check
	});
	if ($sideHeader.length) {
		jQuery('.toggle_menu_side').on('click', function(){
			var $thisToggler = jQuery(this);
			if ($thisToggler.hasClass('header-slide')) {
				$sideHeader.toggleClass('active-slide-side-header');
			} else {
				if($thisToggler.parent().hasClass('header_side_right')) {
					$body.toggleClass('active-side-header slide-right');
				} else {
					$body.toggleClass('active-side-header');
				}
			}
		});
		//hidding side header on click outside header
		$body.on('click', function( e ) {
			if ( !(jQuery(e.target).closest('.page_header_side').length) && !($sideHeader.hasClass('page_header_side_sticked')) ) {
				$sideHeader.removeClass('active-slide-side-header');
				$body.removeClass('active-side-header slide-right');
			}
		});
	} //sideHeader check

	//1 and 2/3/4th level mainmenu offscreen fix
	var MainWindowWidth = jQuery(window).width();
	var boxWrapperWidth = jQuery('#box_wrapper').width();
	jQuery(window).on('resize', function(){
		MainWindowWidth = jQuery(window).width();
		boxWrapperWidth = jQuery('#box_wrapper').width();
	});
	//2/3/4 levels
	jQuery('.mainmenu_wrapper .sf-menu').on('mouseover', 'ul li', function(){
	// jQuery('.mainmenu').on('mouseover', 'ul li', function(){
		if(MainWindowWidth > 991) {
			var $this = jQuery(this);
			// checks if third level menu exist
			var subMenuExist = $this.find('ul').length;
			if( subMenuExist > 0){
				var subMenuWidth = $this.find('ul, div').first().width();
				var subMenuOffset = $this.find('ul, div').first().parent().offset().left + subMenuWidth;
				// if sub menu is off screen, give new position
				if((subMenuOffset + subMenuWidth) > boxWrapperWidth){
					var newSubMenuPosition = subMenuWidth + 0;
					$this.find('ul, div').first().css({
						left: -newSubMenuPosition,
					});
				} else {
					$this.find('ul, div').first().css({
						left: '100%',
					});
				}
			}
		}
	//1st level
	}).on('mouseover', '> li', function(){
		if(MainWindowWidth > 991) {
			var $this = jQuery(this);
			var subMenuExist = $this.find('ul').length;
			if( subMenuExist > 0){
				var subMenuWidth = $this.find('ul').width();
				var subMenuOffset = $this.find('ul').parent().offset().left - (jQuery(window).width() / 2 - boxWrapperWidth / 2);
				// if sub menu is off screen, give new position
				if((subMenuOffset + subMenuWidth) > boxWrapperWidth){
					var newSubMenuPosition = boxWrapperWidth - (subMenuOffset + subMenuWidth);
					$this.find('ul').first().css({
						left: newSubMenuPosition,
					});
				}
			}
		}
	});

	/////////////////////////////////////////
	//single page localscroll and scrollspy//
	/////////////////////////////////////////
	var navHeight = jQuery('.page_header').outerHeight(true);
	//if sidebar nav exists - binding to it. Else - to main horizontal nav
	if (jQuery('.mainmenu_side_wrapper').length) {
		$body.scrollspy({
			target: '.mainmenu_side_wrapper',
			offset: navHeight
		});
	} else if (jQuery('.mainmenu_wrapper').length) {
		$body.scrollspy({
			target: '.mainmenu_wrapper',
			offset: navHeight
		})
	}
	if (jQuery().localScroll) {
		jQuery('.mainmenu_wrapper > ul, .mainmenu_side_wrapper > ul, #land, .scroll_button_wrap, .intro-layer').localScroll({
			duration:900,
			easing:'easeInOutQuart',
			offset: -navHeight+40
		});
	}

	//background image teaser and secitons with half image bg
	//put this before prettyPhoto init because image may be wrapped in prettyPhoto link
	jQuery(".bg_teaser, .image_cover").each(function(){
		var $teaser = jQuery(this);
		var $image = $teaser.find("img").first();
		if (!$image.length) {
			$image = $teaser.parent().find("img").first();
		}
		if (!$image.length) {
			return;
		}
		var imagePath = $image.attr("src");
		$teaser.css("background-image", "url(" + imagePath + ")");
		var $imageParent = $image.parent();
		//if image inside link - adding this link, removing gallery to preserve duplicating gallery items
		if ($imageParent.is('a')) {
			$teaser.prepend($image.parent().clone().html(''));
			$imageParent.attr('data-gal', '');
		}
	});

	//toTop
	if (jQuery().UItoTop) {
		jQuery().UItoTop({ easingType: 'easeInOutQuart' });
	}

	//parallax
	if (jQuery().parallax) {
		jQuery('.parallax').parallax("50%", 0.01);
	}

	//prettyPhoto
	if (jQuery().prettyPhoto) {
		jQuery("a[data-gal^='prettyPhoto']").prettyPhoto({
			hook: 'data-gal',
			theme: 'facebook', /* light_rounded / dark_rounded / light_square / dark_square / facebook / pp_default*/
			social_tools: false,
			default_width: 1170,
			default_height: 780
		});
	}

	////////////////////////////////////////
	//init Bootstrap JS components//
	////////////////////////////////////////
	//bootstrap carousel
	if (jQuery().carousel) {
		jQuery('.carousel').carousel();
	}
	//bootstrap tab - show first tab
	jQuery('.nav-tabs').each(function() {
		jQuery(this).find('a').first().tab('show');
	});
	jQuery('.tab-content').each(function() {
		jQuery(this).find('.tab-pane').first().addClass('fade in');
	});
	//bootstrap collapse - show first tab
	jQuery('.panel-group').each(function() {
		jQuery(this).find('a').first().filter('.collapsed').trigger('click');
	});
	//tooltip
	if (jQuery().tooltip) {
		jQuery('[data-toggle="tooltip"]').tooltip();
	}



	//comingsoon counter
	if (jQuery().countdown) {
		//today date plus month for demo purpose
		var demoDate = new Date();
		demoDate.setMonth(demoDate.getMonth()+1);
		jQuery('#comingsoon-countdown').countdown({until: demoDate});
	}

	/////////////////////////////////////////////////
	//PHP widgets - contact form, search, MailChimp//
	/////////////////////////////////////////////////

	//contact form processing
	jQuery('form.contact-form').on('submit', function( e ){
		e.preventDefault();
		var $form = jQuery(this);
		jQuery($form).find('span.contact-form-respond').remove();

		//checking on empty values
		jQuery($form).find('[aria-required="true"], [required]').each(function(index) {
			var $thisRequired = jQuery(this);
			if (!$thisRequired.val().length) {
				$thisRequired
					.addClass('invalid')
					.on('focus', function(){
						$thisRequired
							.removeClass('invalid');
					});
			}
		});
		//if one of form fields is empty - exit
		if ($form.find('[aria-required="true"], [required]').hasClass('invalid')) {
			return;
		}

		//sending form data to PHP server if fields are not empty
		var request = $form.serialize();
		var ajax = jQuery.post( "contact-form.php", request )
		.done(function( data ) {
			jQuery($form).find('[type="submit"]').attr('disabled', false).parent().append('<span class="contact-form-respond highlight">'+data+'</span>');
			//cleaning form
			var $formErrors = $form.find('.form-errors');
			if ( !$formErrors.length ) {
				$form[0].reset();
			}
		})
		.fail(function( data ) {
			jQuery($form).find('[type="submit"]').attr('disabled', false).parent().append('<span class="contact-form-respond highlight">Mail cannot be sent. You need PHP server to send mail.</span>');
		})
	});


	//search modal
	jQuery(".search_modal_button").on('click', function(e){
		e.preventDefault();
		jQuery('#search_modal').modal('show').find('input').first().focus();
	});
	//search form processing
	jQuery('form.searchform').on('submit', function( e ){

		e.preventDefault();
		var $form = jQuery(this);
		var $searchModal = jQuery('#search_modal');
		$searchModal.find('div.searchform-respond').remove();

		//checking on empty values
		jQuery($form).find('[type="text"]').each(function(index) {
			var $thisField = jQuery(this);
			if (!$thisField.val().length) {
				$thisField
					.addClass('invalid')
					.on('focus', function(){
						$thisField.removeClass('invalid')
					});
			}
		});
		//if one of form fields is empty - exit
		if ($form.find('[type="text"]').hasClass('invalid')) {
			return;
		}

		$searchModal.modal('show');
		//sending form data to PHP server if fields are not empty
		var request = $form.serialize();
		var ajax = jQuery.post( "search.php", request )
		.done(function( data ) {
			$searchModal.append('<div class="searchform-respond">'+data+'</div>');
		})
		.fail(function( data ) {
			$searchModal.append('<div class="searchform-respond">Search cannot be done. You need PHP server to search.</div>');

		})
	});

	//MailChimp subscribe form processing
	jQuery('.signup').on('submit', function( e ) {
		e.preventDefault();
		var $form = jQuery(this);
		// update user interface
		$form.find('.response').html('Adding email address...');
		// Prepare query string and send AJAX request
		jQuery.ajax({
			url: 'mailchimp/store-address.php',
			data: 'ajax=true&email=' + escape($form.find('.mailchimp_email').val()) + '&fullname=' + escape($form.find('.mailchimp_fullname').val()),
			success: function(msg) {
				$form.find('.response').html(msg);
			}
		});
	});

	//twitter
	if (jQuery().tweet) {
		jQuery('.twitter').tweet({
			modpath: "./twitter/",
			count: 1,
			avatar_size: 48,
			loading_text: 'loading twitter feed...',
			join_text: 'auto',
			username: 'michaeljackson',
			template: "<span class=\"tweet_text\">{tweet_text}</span><span class=\"greylinks\"> / {time}</span>"
		});
	}


	//adding CSS classes for elements that needs different styles depending on they widht width
	//see 'plugins.js' file
	jQuery('#mainteasers .col-lg-4').addWidthClass({
		breakpoints: [500, 600]
	});

	// init timetable
	var $timetable = jQuery('#timetable');
	if ($timetable.length) {
		// bind filter click
		jQuery('#timetable_filter').on( 'click', 'a', function( e ) {
			e.preventDefault();
			e.stopPropagation();
			var $thisA = jQuery(this);
			if ( $thisA.hasClass('selected') ) {
				// return false;
				return;
			}
			var selector = $thisA.attr('data-filter');
			$timetable
				.find('tbody td')
				.removeClass('current')
				.end()
				.find(selector)
				.closest('td')
				.addClass('current');
			$thisA.closest('ul').find('a').removeClass('selected');
			$thisA.addClass('selected');
	  });
	}

	/////////
	//SHOP///
	/////////
	jQuery('#toggle_shop_view').on('click', function( e ) {
		e.preventDefault();
		jQuery(this).toggleClass('grid-view');
		jQuery('#products').toggleClass('grid-view list-view');
	});
	//zoom image
	if (jQuery().elevateZoom) {
		jQuery('#product-image').elevateZoom({
			gallery: 'product-image-gallery',
			cursor: 'pointer',
			galleryActiveClass: 'active',
			responsive:true,
			loadingIcon: 'img/AjaxLoader.gif'
		});
	}

	//add review button
	jQuery('.review-link').on('click', function( e ) {
		var $thisLink = jQuery(this);
		var reviewTabLink = jQuery('a[href="#reviews_tab"]');
		//show tab only if it's hidden
		if (!reviewTabLink.parent().hasClass('active')) {
			reviewTabLink
			.tab('show')
			.on('shown.bs.tab', function (e) {
				$window.scrollTo($thisLink.attr('href'), 400);
			})
		}
		$window.scrollTo($thisLink.attr('href'), 400);
	});

	//product counter
	jQuery('.plus, .minus').on('click', function( e ) {
		var numberField = jQuery(this).parent().find('[type="number"]');
		var currentVal = numberField.val();
		var sign = jQuery(this).val();
		if (sign === '-') {
			if (currentVal > 1) {
				numberField.val(parseFloat(currentVal) - 1);
			}
		} else {
			numberField.val(parseFloat(currentVal) + 1);
		}
	});

	//remove product from cart
	jQuery('a.remove').on('click', function( e ) {
		e.preventDefault();
		jQuery(this).closest('tr, .media').remove();
	});

	//price filter - only for HTML
	if (jQuery().slider) {
		var $rangeSlider = jQuery(".slider-range-price");
		if ($rangeSlider.length) {
			var $priceMin = jQuery(".price_from");
			var $priceMax = jQuery(".price_to");
			$rangeSlider.slider({
				range: true,
				min: 0,
				max: 200,
				values: [ 30, 100 ],
				slide: function( event, ui ) {
					$priceMin.html( '$' + ui.values[ 0 ] );
					$priceMax.html( '$' + ui.values[ 1 ] );
				}
			});
			$priceMin.html('$' + $rangeSlider.slider("values", 0));
			$priceMax.html('$' + $rangeSlider.slider("values", 1));
		}
	}

	//color filter
	jQuery(".color-filters").find("a[data-background-color]").each(function() {
		jQuery(this).css({"background-color" : jQuery(this).data("background-color")});
	}); // end of SHOP
	///eof docready

	//////////////
	//flexslider//
	//////////////
	if (jQuery().flexslider) {
		var $introSlider = jQuery(".intro_section .flexslider");
		$introSlider.each(function(index){
			var $currentSlider = jQuery(this);
			var data = $currentSlider.data();
			var nav = (data.nav !== 'undefined') ? data.nav : true;
			var dots = (data.dots !== 'undefined') ? data.dots : true;

			$currentSlider.flexslider({
				animation: "fade",
				pauseOnHover: true,
				useCSS: true,
				controlNav: dots,
				directionNav: nav,
				prevText: "",
				nextText: "",
				smoothHeight: false,
				slideshowSpeed:10000,
				animationSpeed:600,
				start: function( slider ) {
					slider.find('.slide_description').children().css({'visibility': 'hidden'});
					slider.find('.flex-active-slide .slide_description').children().each(function(index){
						var self = jQuery(this);
						var animationClass = !self.data('animation') ? 'fadeInRight' : self.data('animation');
						setTimeout(function(){
							self.addClass("animated "+animationClass);
						}, index*200);
					});
					slider.find('.flex-control-nav').find('a').each(function() {
						jQuery( this ).html('0' + jQuery( this ).html());
					})
				},
				after: function( slider ){
					slider.find('.flex-active-slide .slide_description').children().each(function(index){
						var self = jQuery(this);
						var animationClass = !self.data('animation') ? 'fadeInRight' : self.data('animation');
						setTimeout(function(){
							self.addClass("animated "+animationClass);
						}, index*200);
					});
				},
				end :function( slider ){
					slider.find('.slide_description').children().each(function() {
						var self = jQuery(this);
						var animationClass = !self.data('animation') ? 'fadeInRight' : self.data('animation');
						self.removeClass('animated ' + animationClass).css({'visibility': 'hidden'});
							// jQuery(this).attr('class', '');
					});
				},

			})
			//wrapping nav with container - uncomment if need
			.find('.flex-control-nav')
			.wrap('<div class="container-fluid nav-container"/>')
		}); //intro_section flex slider

		var $testimonialsSlider = jQuery(".page_testimonials .flexslider");

		$testimonialsSlider.each(function(index){
			var $currentSlider = jQuery(this);
			//exit if intro slider already activated
			if ($currentSlider.find('.flex-active-slide').length) {
				return;
			}

			var data = $currentSlider.data();
			var nav = (data.nav !== 'undefined') ? data.nav : true;
			var dots = (data.dots !== 'undefined') ? data.dots : true;
			var autoplay = (data.autoplay !== 'undefined') ? data.autoplay : true;
			$currentSlider.flexslider({
				animation: "slide",
				useCSS: true,
				controlNav: dots,
				directionNav: nav,
				prevText: "",
				nextText: "",
				smoothHeight: false,
				slideshow: autoplay,
				slideshowSpeed:10000,
				animationSpeed:400,
				start: function( slider ) {
					slider.find('.flex-control-nav').find('a').each(function() {
						jQuery( this ).html('0' + jQuery( this ).html());
					})
				},
			})
			.find('.flex-control-nav')
			.wrap('<div class="container-fluid nav-container"/>')
		}); //intro_section flex slider

		jQuery(".flexslider").each(function(index){
			var $currentSlider = jQuery(this);
			//exit if intro slider already activated
			if ($currentSlider.find('.flex-active-slide').length) {
				return;
			}

			var data = $currentSlider.data();
			var nav = (data.nav !== 'undefined') ? data.nav : true;
			var dots = (data.dots !== 'undefined') ? data.dots : true;
			var autoplay = (data.autoplay !== 'undefined') ? data.autoplay : true;
			$currentSlider.flexslider({
				animation: "fade",
				useCSS: true,
				controlNav: dots,
				directionNav: nav,
				prevText: "",
				nextText: "",
				smoothHeight: false,
				slideshow: autoplay,
				slideshowSpeed:5000,
				animationSpeed:400,
				start: function( slider ) {
					slider.find('.flex-control-nav').find('a').each(function() {
						jQuery( this ).html('0' + jQuery( this ).html());
					})
				},
			})
			.find('.flex-control-nav')
			.wrap('<div class="container-fluid nav-container"/>')
		});
	}

	////////////////////
	//header processing/
	////////////////////
	//stick header to top
	//wrap header with div for smooth sticking
	var $header = jQuery('.page_header').first();
	var boxed = $header.closest('.boxed').length;
	if ($header.length) {
		//hiding main menu 1st levele elements that do not fit width
		menuHideExtraElements();
		//mega menu
		initMegaMenu();
		//wrap header for smooth stick and unstick
		var headerHeight = $header.outerHeight();
		$header.wrap('<div class="page_header_wrapper"></div>');
		var $headerWrapper = $header.parent();
		if (!boxed) {
			$headerWrapper.css({height: $header.outerHeight()});
		}

		//headerWrapper background
		if( $header.hasClass('header_white') ) {
			$headerWrapper.addClass('header_white');
		} else if ( $header.hasClass('header_darkgrey') ) {
			$headerWrapper.addClass('header_darkgrey');
			if ( $header.hasClass('bs') ) {
				$headerWrapper.addClass('bs');
			}

		} else if ( $header.hasClass('header_gradient') ) {
			$headerWrapper.addClass('header_gradient');
		}

		if ( $header.hasClass('header_transparent') ) {
			$headerWrapper.addClass('header_transparent_wrap')
		}

		//get offset
		var headerOffset = 0;
		//check for sticked template headers
		if (!boxed && !($headerWrapper.css('position') === 'fixed')) {
			headerOffset = $header.offset().top;

			if ($header.css('padding-top') === '65px') {
				headerOffset += 65;
			}
		}

		//for boxed layout - show or hide main menu elements if width has been changed on affix
		jQuery($header).on('affixed-top.bs.affix affixed.bs.affix affixed-bottom.bs.affix', function ( e ) {
			if( $header.hasClass('affix-top') ) {
				$headerWrapper.removeClass('affix-wrapper affix-bottom-wrapper').addClass('affix-top-wrapper');
			} else if ( $header.hasClass('affix') ) {
				$headerWrapper.removeClass('affix-top-wrapper affix-bottom-wrapper').addClass('affix-wrapper');
			} else if ( $header.hasClass('affix-bottom') ) {
				$headerWrapper.removeClass('affix-wrapper affix-top-wrapper').addClass('affix-bottom-wrapper');
			} else {
				$headerWrapper.removeClass('affix-wrapper affix-top-wrapper affix-bottom-wrapper');
			}
			menuHideExtraElements();
			initMegaMenu();
		});

		//if header has different height on afixed and affixed-top positions - correcting wrapper height
		jQuery($header).on('affixed-top.bs.affix', function () {
			// $headerWrapper.css({height: $header.outerHeight()});
		});

		jQuery($header).affix({
			offset: {
				top: headerOffset,
				bottom: 0
			}
		});

	}


	//aside affix
	affixSidebarInit();

	$body.scrollspy('refresh');

	//appear plugin is used to elements animation, counter, pieChart, bootstrap progressbar
	if (jQuery().appear) {
		//animation to elements on scroll
		jQuery('.to_animate').appear();

		jQuery('.to_animate').filter(':appeared').each(function(index){
			initAnimateElement(jQuery(this), index);
		});

		$body.on('appear', '.to_animate', function(e, $affected ) {
			jQuery($affected).each(function(index){
				initAnimateElement(jQuery(this), index);
			});
		});

		//counters init on scroll
		if (jQuery().countTo) {
			jQuery('.counter').appear();

			jQuery('.counter').filter(':appeared').each(function(){
				initCounter(jQuery(this));
			});
			$body.on('appear', '.counter', function(e, $affected ) {
				jQuery($affected).each(function(){
					initCounter(jQuery(this));
				});
			});
		}

		//bootstrap animated progressbar
		if (jQuery().progressbar) {
			jQuery('.progress .progress-bar').appear();

			jQuery('.progress .progress-bar').filter(':appeared').each(function(){
				initProgressbar(jQuery(this));
			});
			$body.on('appear', '.progress .progress-bar', function(e, $affected ) {
				jQuery($affected).each(function(){
					initProgressbar(jQuery(this));
				});
			});
			//animate progress bar inside bootstrap tab
			jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
				initProgressbar(jQuery(jQuery(e.target).attr('href')).find('.progress .progress-bar'));
			});
			//animate progress bar inside bootstrap dropdown
			jQuery('.dropdown').on('shown.bs.dropdown', function(e) {
				initProgressbar(jQuery(this).find('.progress .progress-bar'));
			});
		}

		//circle progress bar
		if (jQuery().easyPieChart) {

			jQuery('.chart').appear();

			jQuery('.chart').filter(':appeared').each(function(){
				initChart(jQuery(this));
			});
			$body.on('appear', '.chart', function(e, $affected ) {
				jQuery($affected).each(function(){
					initChart(jQuery(this));
				});
			});

		}

	} //appear check

	//Flickr widget
	// use http://idgettr.com/ to find your ID
	if (jQuery().jflickrfeed) {
		var $flickr = jQuery("#flickr, .flickr_ul");
		if ( $flickr.length ) {
			if ( ! ( $flickr.hasClass('flickr_loaded') ) ) {
				$flickr.jflickrfeed({
					flickrbase: "http://api.flickr.com/services/feeds/",
					limit: 4,
					qstrings: {
						id: "131791558@N04"
					},
					itemTemplate: '<a href="{{image_b}}" data-gal="prettyPhoto[pp_gal]"><li><img alt="{{title}}" src="{{image_m}}" /></li></a>'
				}, function(data) {
					$flickr.find('a').prettyPhoto({
						hook: 'data-gal',
						theme: 'facebook'
					});
				}).addClass('flickr_loaded');
			}
		}
	}

	// Instagram widget
	if(jQuery().spectragram) {
		var Spectra = {
			instaToken: '3905738328.60c782d.b65ed3f058d64e6ab32c110c6ac12d9b',
			instaID: '60c782dfecaf4050b59ff4c159246641',

			init: function () {
				jQuery.fn.spectragram.accessData = {
					accessToken: this.instaToken,
					clientID: this.instaID
				};

				//available methods: getUserFeed, getRecentTagged
				jQuery('.instafeed').each(function(){
					var $this = jQuery(this);
					if ($this.find('img').length) {
						return;
					}
					$this.spectragram('getRecentTagged',{
						max: 4,
						//pass username if you are using getUserFeed method
						query: 'grey',
						wrapEachWith: '<div class="photo">'
					});
				});
			}
		}

		Spectra.init();
	}

	//video images preview - from WP
	jQuery('.embed-placeholder').each(function(){
		jQuery(this).on('click', function(e) {
			var $thisLink = jQuery(this);
			// if prettyPhoto popup with YouTube - return
			if ($thisLink.attr('data-gal')) {
				return;
			}
			e.preventDefault();
			if ($thisLink.attr('href') === '' || $thisLink.attr('href') === '#') {
				$thisLink.replaceWith($thisLink.data('iframe').replace(/&amp/g, '&').replace(/$lt;/g, '<').replace(/&gt;/g, '>').replace(/$quot;/g, '"')).trigger('click');
			} else {
				$thisLink.replaceWith('<iframe class="embed-responsive-item" src="'+ $thisLink.attr('href') + '?rel=0&autoplay=1'+ '"></iframe>');
			}
		});
	});

	// init Isotope
	jQuery('.isotope_container').each(function(index) {
		var $container = jQuery(this);
		var layoutMode = ($container.hasClass('masonry-layout')) ? 'masonry' : 'fitRows';
		var columnWidth = ($container.find('.col-lg-20').length) ? '.col-lg-20' : '';
		$container.isotope({
			percentPosition: true,
			layoutMode: layoutMode,
			masonry: {
				//for big first element in grid - giving smaller element to use as grid
				columnWidth: columnWidth
			}
		});

		var $filters = jQuery(this).attr('data-filters') ? jQuery(jQuery(this).attr('data-filters')) : $container.prev().find('.filters');
		// bind filter click
		if ($filters.length) {
			$filters.on( 'click', 'a', function( e ) {
				e.preventDefault();
				var $thisA = jQuery(this);
				var filterValue = $thisA.attr('data-filter');
				$container.isotope({ filter: filterValue });
				$thisA.siblings().removeClass('selected active');
				$thisA.addClass('selected active');
			});
			//for works on select
			$filters.on( 'change', 'select', function( e ) {
				e.preventDefault();
				var filterValue = jQuery(this).val();
				$container.isotope({ filter: filterValue });
			});
		}
	});

	//Unyson or other messages modal
	var $messagesModal = jQuery('#messages_modal');
	if ($messagesModal.find('ul').length) {
		$messagesModal.modal('show');
	}

	//page preloader
	jQuery(".preloaderimg").fadeOut(150);
	jQuery(".preloader").fadeOut(350).delay(200, function(){
		jQuery(this).remove();
	});

	// prevent search form trigger from scrolling to top
	jQuery('.search_form_trigger').on( 'click', function($e) {
	    $e.preventDefault();
	});

	//prevent default action of # links
	jQuery("[href='#0']").on( 'click', function($e) {
		$e.preventDefault();
	});

	//wrap select elements in .select-group
	wrapSelect();

	//isotope gallery

	galleryItemsRender();
	galleryFiltersProcessing();

}//eof windowLoadInit

$window.on('load', function(){
	windowLoadInit();

	//Google Map script
	var $googleMaps = jQuery('#map, .page_map');
	if ( $googleMaps.length ) {
		$googleMaps.each(function() {
			var $map = jQuery(this);

			var lat;
			var lng;
			var map;

			//map styles. You can grab different styles on https://snazzymaps.com/
			var styles = [{"featureType": "administrative","elementType": "all","stylers": [{"visibility": "on"},{"lightness": 33}]},{"featureType": "landscape","elementType": "all","stylers": [{"color": "#f2e5d4"}]},{"featureType": "poi.park","elementType": "geometry","stylers": [{"color": "#c5dac6"}]},{"featureType": "poi.park","elementType": "labels","stylers": [{"visibility": "on"},{"lightness": 20}]},{"featureType": "road","elementType": "all","stylers": [{"lightness": 20}]},{"featureType": "road.highway","elementType": "geometry","stylers": [{"color": "#c5c6c6"}]},{"featureType": "road.arterial","elementType": "geometry","stylers": [{"color": "#e4d7c6"}]},{"featureType": "road.local","elementType": "geometry","stylers": [{"color": "#fbfaf7"}]},{"featureType": "water","elementType": "all","stylers": [{"visibility": "on"},{"color": "#acbcc9"}]}];

			//map settings
			var address = $map.data('address') ? $map.data('address') : 'london, baker street, 221b';
			var markerDescription = $map.find('.map_marker_description').prop('outerHTML');

			//if you do not provide map title inside #map (.page_map) section inside H3 tag - default titile (Map Title) goes here:
			var markerTitle = $map.find('h3').first().text() ? $map.find('h3').first().text() : 'Map Title';
			var markerIconSrc = $map.find('.map_marker_icon').first().attr('src');

			var geocoder = new google.maps.Geocoder();

			//type your address after "address="
			geocoder.geocode({
	            address: address
	        }, function(data){

				lat = data[0].geometry.location.lat();
				lng = data[0].geometry.location.lng();

				var center = new google.maps.LatLng(lat, lng);
				var settings = {
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					zoom: 15,
					draggable: false,
					scrollwheel: false,
					center: center,
					styles: styles
				};
				map = new google.maps.Map($map[0], settings);

				var marker = new google.maps.Marker({
					position: center,
					title: markerTitle,
					map: map,
					icon: markerIconSrc,
				});

				var infoWindows = [];

				var infowindow = new google.maps.InfoWindow({
					content: markerDescription
				});

				infoWindows.push(infowindow);

				google.maps.event.addListener(marker, 'click', function() {
					for (var i=0;i<infoWindows.length;i++) {
						infoWindows[i].close();
					}
					infowindow.open(map,marker);
				});

				if($map.data('markers')) {

					jQuery($map.data('markers')).each(function(index) {

						var markerObj = this;

						var markerDescription = '';
						markerDescription += markerObj.markerTitle ? '<h3>' + markerObj.markerTitle + '</h3>' : '';
						markerDescription += markerObj.markerDescription ? '<p>' + markerObj.markerDescription + '</p>' : '';
						if(markerDescription) {
							markerDescription = '<div class="map_marker_description">' + markerDescription + '</div>';
						}

						geocoder.geocode({
				            address: this.markerAddress
				        }, function(data){

							var lat = data[0].geometry.location.lat();
							var lng = data[0].geometry.location.lng();

							var center = new google.maps.LatLng(lat, lng);

							var marker = new google.maps.Marker({
								position: center,
								title: markerObj.markerTitle,
								map: map,
								icon: markerObj.markerIconSrc ? markerObj.markerIconSrc : '',
							});

							var infowindow = new google.maps.InfoWindow({
								content: markerDescription
							});

							infoWindows.push(infowindow);

							google.maps.event.addListener(marker, 'click', function() {
								for (var i=0;i<infoWindows.length;i++) {
									infoWindows[i].close();
								}
								infowindow.open(map,marker);
							});

						});
					});
				}
			});
		}); //each
	}//google map length

	// color for placeholder of select elements
	jQuery(".choice").on('change', function () {
		if(jQuery(this).val() === "") jQuery(this).addClass("empty");
		else jQuery(this).removeClass("empty")
	});

}); //end of "window load" event


//end of IIFE function

})();
