$('#txgidoc-professional').owlCarousel({
    items: 3,
    itemsDesktop: [1e3, 3],
    itemsDesktopSmall: [900, 1],
    itemsTablet: [768, 2],
    itemsMobile: [480, 1],
    paginationSpeed: 1500,
    stopOnHover: !0,
    rewindSpeed: 2e3,
    slideTransition: "fade",
    navigation: false,
    afterAction: function (e) {
        this.$owlItems.removeClass("active"), this.$owlItems.eq(this.currentItem).addClass("active")
    }
})