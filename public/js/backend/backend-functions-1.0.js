/**
 * Created by chrissmits on 23/05/14.
 */

$(document).ready(function() {
    $(window).load(function() {
        resizeComponents();
    });

    $(window).resize(function() {
        resizeComponents();
    });

    function resizeComponents() {
        var usableHeight = $(window).height() - ($('.header').height());
        $('.max-height').css('height', usableHeight);
    }
});