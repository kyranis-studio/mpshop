/*
 *  jQuery OwlCarousel v1.3.3
 *
 *  Copyright (c) 2013 Bartosz Wojciechowski
 *  http://www.owlgraphic.com/owlcarousel/
 *
 *  Licensed under MIT
 *
 */

/*JS Lint helpers: */
/*global dragMove: false, dragEnd: false, $, jQuery, alert, window, document */
/*jslint nomen: true, continue:true */
    if (typeof Object.create !== "function") {
        Object.create = function (obj) {
            function F() {
            }
            F.prototype = obj;
            return new F();
        };
    }
    (function ($, window, document) {

        var Carousel = {

        };

        $.fn.owlCarousel = function (options) {
            return false
        };

        $.fn.owlCarousel.options = {
            items: 5,
            itemsCustom: false,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [979, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1],
            singleItem: false,
            itemsScaleUp: false,
            slideSpeed: 200,
            paginationSpeed: 800,
            rewindSpeed: 1000,
            autoPlay: false,
            stopOnHover: false,
            navigation: false,
            navigationText: ["prev", "next"],
            rewindNav: true,
            scrollPerPage: false,
            pagination: true,
            paginationNumbers: false,
            responsive: true,
            responsiveRefreshRate: 200,
            responsiveBaseWidth: window,
            baseClass: "owl-carousel",
            theme: "owl-theme",
            lazyLoad: false,
            lazyFollow: true,
            lazyEffect: "fade",
            autoHeight: false,
            jsonPath: false,
            jsonSuccess: false,
            dragBeforeAnimFinish: true,
            mouseDrag: true,
            touchDrag: true,
            addClassActive: false,
            transitionStyle: false,
            beforeUpdate: false,
            afterUpdate: false,
            beforeInit: false,
            afterInit: false,
            beforeMove: false,
            afterMove: false,
            afterAction: false,
            startDragging: false,
            afterLazyLoad: false
        };
    }(jQuery, window, document));