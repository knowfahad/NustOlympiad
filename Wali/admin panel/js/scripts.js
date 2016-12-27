// debouncing function from John Hann
// http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
(function($, sr) {
    var debounce = function(func, threshold, execAsap) {
        var timeout;
        return function debounced() {
            var obj = this,
                args = arguments;

            function delayed() {
                if (!execAsap) func.apply(obj, args);
                timeout = null;
            };
            if (timeout) clearTimeout(timeout);
            else if (execAsap) func.apply(obj, args);
            timeout = setTimeout(delayed, threshold || 100);
        };
    };
    // smartResize 
    $.fn[sr] = function(fn) {
        return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
    };
})($, 'smartResize');

$(document).ready(function() {
    // Toggle Left Menu
    $('.menu-list > a').click(function() {
        var parent = $(this).parent();
        var parent_position = parent.position();
        var sub = parent.find('> ul');
        if (!$('body').hasClass('left-side-collapsed')) {
            if (sub.is(':visible')) {
                sub.slideUp(200, function() {
                    parent.removeClass('nav-active');
                    parent.find('i.pull-right').removeClass('ion-ios7-arrow-up').addClass('ion-ios7-arrow-down');
                });
            } else {
                visibleSubMenuClose();
                parent.addClass('nav-active');
                parent.find('i.pull-right').removeClass('ion-ios7-arrow-down').addClass('ion-ios7-arrow-up');
                $(".left-side").scrollTop(parent_position.top);
                sub.slideDown(200, function() {});
            }
        }
        return false;
    });

    function visibleSubMenuClose() {
        $('.menu-list').each(function() {
            var t = $(this);
            if (t.hasClass('nav-active')) {
                t.find('> ul').slideUp(200, function() {
                    t.removeClass('nav-active');
                    t.find('i.pull-right').removeClass('ion-ios7-arrow-up').addClass('ion-ios7-arrow-down');
                });
            }
        });
    }
    
    //  class add mouse hover
    $('.custom-nav > li').hover(function() {
        $(this).addClass('nav-hover');
    }, function() {
        $(this).removeClass('nav-hover');
    });

    // Menu Toggle
    $('.toggle-btn').click(function(event) {
        event.stopPropagation();
        var body = $('body');
        if ($(window).width() > 992) {
            if (!body.hasClass('left-side-collapsed')) {
                body.addClass('left-side-collapsed');
                $('.custom-nav ul').attr('style', '');
                $(this).addClass('menu-collapsed');
            } else {
                body.removeClass('left-side-collapsed');
                $('.custom-nav li.active ul').css({
                    display: 'block'
                });
                $(this).removeClass('menu-collapsed');
            }
            if (body.hasClass('left-side-show')) {
                body.removeClass('left-side-show');
            }
        } else {
            if (body.hasClass('left-side-show')) {
                body.removeClass('left-side-show');
            } else {
                body.addClass('left-side-show');
            }
        }
        t();
    });

    $(window).smartResize(function() {
        var body = $('body');
        if ($(window).width() <= 992) {
            body.removeClass('left-side-collapsed');        
        } else {
            if (body.hasClass('left-side-show')) {
                body.removeClass('left-side-show');
            }
        }
    });


    //Back to top link
    function initBackToTop () {
        var backToTop = $('<a>', { id: 'back-to-top', href: '#top' });
        var icon = $('<i>', { class: 'fa fa-chevron-up' });

        backToTop.appendTo ('body');
        icon.appendTo (backToTop);
        
        backToTop.hide();

        $(window).scroll(function () {
                if ($(this).scrollTop() > 150) {
                        backToTop.fadeIn ();
                } else {
                        backToTop.fadeOut ();
                }
        })

        backToTop.click (function (e) {
            e.preventDefault ();

                $('body, html').animate({
                        scrollTop: 0
                }, 600);
        });
    }

    initBackToTop();


    // tool tips
    $('[data-toggle="tooltip"]').tooltip();
    

    // popovers
    $('[data-toggle="popover"]').popover();


    //add scrollbar
    $(".has-scroll").slimScroll({
        allowPageScroll: true,
        wheelStep: 15,
        alwaysVisible: false,
    });


    //Tabdrop
    $('.tab-drop, .pill-drop').tabdrop('layout');


    //plugin bootstrap minus and plus
    //http://jsfiddle.net/laelitenetwork/puJ6G/
    $('.btn-number').click(function(e){
        e.preventDefault();
        
        fieldName = $(this).attr('data-field');
        type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {
                
                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                } 
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {
        
        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());
        
        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });


    //tree view
    $('label.tree-toggler').click(function () {
        var icon = $(this).children(".fa");
            if(icon.hasClass("fa-folder-o")){
                icon.removeClass("fa-folder-o").addClass("fa-folder-open-o");
            }else{
                icon.removeClass("fa-folder-open-o").addClass("fa-folder-o");
            }                
            
        $(this).parent().children('ul.tree').toggle(300,function(){
            $(this).parent().toggleClass("open");
        });
    });
});