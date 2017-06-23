var j = jQuery.noConflict();



/*---LEFT BAR ACCORDION----*/
j(function(){
    j('#nav-accordion').dcAccordion({
        eventType: 'click',
        autoClose: true,
        saveState: true,
        disableLink: true,
        speed: 'slow',
        showCount: false,
        autoExpand: true,
//        cookie: 'dcjq-accordion-1',
        classExpand: 'dcjq-current-parent'
    });
});

var Script = function () {


//    sidebar dropdown menu auto scrolling

    jQuery('#sidebar .sub-menu > a').click(function () {
        var o = (j(this).offset());
        diff = 250 - o.top;
        if(diff>0)
            j("#sidebar").scrollTo("-="+Math.abs(diff),500);
        else
            j("#sidebar").scrollTo("+="+Math.abs(diff),500);
    });



//    sidebar toggle

    j(function() {
        function responsiveView() {
            var wSize = j(window).width();
            if (wSize <= 768) {
                j('#container').addClass('sidebar-close');
                j('#sidebar > ul').hide();
            }

            if (wSize > 768) {
                j('#container').removeClass('sidebar-close');
                j('#sidebar > ul').show();
            }
        }
        j(window).on('load', responsiveView);
        j(window).on('resize', responsiveView);
    });

    j('.fa-bars').click(function () {
        if (j('#sidebar > ul').is(":visible") === true) {
            j('#main-content').css({
                'margin-left': '0px'
            });
            j('#sidebar').css({
                'margin-left': '-210px'
            });
            j('#sidebar > ul').hide();
            j("#container").addClass("sidebar-closed");
        } else {
            j('#main-content').css({
                'margin-left': '210px'
            });
            j('#sidebar > ul').show();
            j('#sidebar').css({
                'margin-left': '0'
            });
            j("#container").removeClass("sidebar-closed");
        }
    });
//
//    // custom scrollbar
//    j("#sidebar").niceScroll({styler:"fb",cursorcolor:"#4ECDC4", cursorwidth: '3', cursorborderradius: '10px', background: '#404040', spacebarenabled:false, cursorborder: ''});
//
//    j("html").niceScroll({styler:"fb",cursorcolor:"#4ECDC4", cursorwidth: '6', cursorborderradius: '10px', background: '#404040', spacebarenabled:false,  cursorborder: '', zindex: '1000'});
//
//    // widget tools
//
//    jQuery('.panel .tools .fa-chevron-down').click(function () {
//        var el = jQuery(this).parents(".panel").children(".panel-body");
//        if (jQuery(this).hasClass("fa-chevron-down")) {
//            jQuery(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
//            el.slideUp(200);
//        } else {
//            jQuery(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
//            el.slideDown(200);
//        }
//    });
//
//    jQuery('.panel .tools .fa-times').click(function () {
//        jQuery(this).parents(".panel").parent().remove();
//    });
//
//
////    tool tips
//
//    j('.tooltips').tooltip();
//
////    popovers
//
//    j('.popovers').popover();
//
//
//
//// custom bar chart
//
//    if (j(".custom-bar-chart")) {
//        j(".bar").each(function () {
//            var i = j(this).find(".value").html();
//            j(this).find(".value").html("");
//            j(this).find(".value").animate({
//                height: i
//            }, 2000)
//        })
//    }
//

}();