'use strict';

$(document).ready(function () {
    Waves.init();
    Waves.attach('.flat-icon', ['waves-circle']);
    Waves.attach('.button', ['waves-button', 'waves-float']);

    $('#btn-mobile').click(function(event) {
        $('.overlay-mobile').fadeIn('fast');
    });

    $('.overlay-mobile').click(function(){
        $(this).fadeOut('fast');
        $('body').removeClass('active');
        $('#btn-mobile .material-icon').removeClass('arrow')
        $('#btn-mobile .material-icon').addClass('hamburger');
    });


    $('form .form-control').each(function () {
        if ($(this).val() !== '') $(this).parents('.form-group').addClass('active');
    });
    $('.trigger').trigger('click');
    $('form .form-control').focus(function () {
        $(this).parents('.form-group').addClass('active');
    });
    $('form .form-control').blur(function () {
        if ($(this).val() === '') {
            $(this).parents('.form-group').removeClass('active');
        }
    });

    $('.menu .dropdown a').click(function () {
        $(this).siblings('ul').slideToggle('fast');
    });

    $('.search').click(function () {
        $(this).siblings('form').toggleClass('active');
        setTimeout(function () {
            $('.form-search.active input').focus();
        }, 500);
    });
    $('.material-grid').click(function () {
        $('body').toggleClass('active');
    });

    $("section.material-green").mouseup(function () {
        if ($(".material-green div.material-icon").hasClass("hamburger")) {
            $(".material-green div.material-icon").removeClass("hamburger").addClass("arrow");
        } else {
            $(".material-green div.material-icon").removeClass("arrow").addClass("hamburger");
        }
    });
    $('.selectpicker').on('loaded.bs.select', function (e) {
        $('form .bootstrap-select').click(function () {
            $(this).parents('.form-group').addClass('active');
        });
    });
    $('.selectpicker').on('hidden.bs.select', function (e) {
        $(this).parents('.form-group').removeClass('active');
    });
    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    function notify() {
        Notification.requestPermission(function() {
            var notification = new Notification("Título", {
                icon: 'http://i.stack.imgur.com/dmHl0.png',
                body: "Texto da notificação"
            });
            notification.onclick = function() {
                window.open("http://stackoverflow.com");
            }
        });
    } 
});



//checkbox

var ripples = {
    init : function(withRipple) {
        "use strict";

        // Cross browser matches function
        function matchesSelector(dom_element, selector) {
            var matches = dom_element.matches || dom_element.matchesSelector || dom_element.webkitMatchesSelector || dom_element.mozMatchesSelector || dom_element.msMatchesSelector || dom_element.oMatchesSelector;
            return matches.call(dom_element, selector);
        }

        // animations time
        var rippleOutTime = 100,
            rippleStartTime = 500;

        // Helper to bind events on dynamically created elements
        var bind = function(event, selector, callback) {
            document.addEventListener(event, function(e) {
                var target = (typeof e.detail !== "number") ? e.detail : e.target;

                if (matchesSelector(target, selector)) {
                    callback(e, target);
                }
            });
        };

        var rippleStart = function(e, target) {

            // Init variables
            var $rippleWrapper  = target,
                $el             = $rippleWrapper.parentNode,
                $ripple         = document.createElement("div"),
                elPos           = $el.getBoundingClientRect(),
                mousePos        = {x: e.clientX - elPos.left, y: e.clientY - elPos.top},
                scale           = "transform:scale(" + Math.round($rippleWrapper.offsetWidth / 5) + ")",
                rippleEnd       = new CustomEvent("rippleEnd", {detail: $ripple}),
                refreshElementStyle;

            $ripplecache = $ripple;

            // Set ripple class
            $ripple.className = "ripple";

            // Move ripple to the mouse position
            $ripple.setAttribute("style", "left:" + mousePos.x + "px; top:" + mousePos.y + "px;");

            // Insert new ripple into ripple wrapper
            $rippleWrapper.appendChild($ripple);

            // Make sure the ripple has the class applied (ugly hack but it works)
            refreshElementStyle = window.getComputedStyle($ripple).opacity;

            // Let other funtions know that this element is animating
            $ripple.dataset.animating = 1;

            // Set scale value to ripple and animate it
            $ripple.className = "ripple ripple-on";
            $ripple.setAttribute("style", $ripple.getAttribute("style") + ["-ms-" + scale,"-moz-" + scale,"-webkit-" + scale,scale].join(";"));

            // This function is called when the animation is finished
            setTimeout(function() {

                // Let know to other functions that this element has finished the animation
                $ripple.dataset.animating = 0;
                document.dispatchEvent(rippleEnd);

            }, rippleStartTime);

        };

        var rippleOut = function($ripple) {
            // Clear previous animation
            $ripple.className = "ripple ripple-on ripple-out";

            // Let ripple fade out (with CSS)
            setTimeout(function() {
                $ripple.remove();
            }, rippleOutTime);
        };

        // Helper, need to know if mouse is up or down
        var mouseDown = false;
        document.body.onmousedown = function() {
            mouseDown = true;
        };
        document.body.onmouseup = function() {
            mouseDown = false;
        };

        // Append ripple wrapper if not exists already
        var rippleInit = function(e, target) {

            if (target.getElementsByClassName("ripple-wrapper").length === 0) {
                target.className += " withripple";
                var $rippleWrapper = document.createElement("div");
                $rippleWrapper.className = "ripple-wrapper";
                target.appendChild($rippleWrapper);
            }

        };


        var $ripplecache;

        // Events handler
        // init RippleJS and start ripple effect on mousedown
        bind("mouseover", withRipple, rippleInit);

        // start ripple effect on mousedown
        bind("mousedown", ".ripple-wrapper", rippleStart);
        // if animation ends and user is not holding mouse then destroy the ripple
        bind("rippleEnd", ".ripple-wrapper .ripple", function(e, $ripple) {
            if (!mouseDown) {
                rippleOut($ripple);
            }
        });
        // Destroy ripple when mouse is not holded anymore if the ripple still exists
        bind("mouseup", ".ripple-wrapper", function() {
            var $ripple = $ripplecache;
            if ($ripple.dataset.animating != 1) {
                rippleOut($ripple);
            }
        });

    }
};
/* globals ripples */

$(function (){

    if (ripples) {
        ripples.init(".btn:not(.btn-link), .navbar a, .nav-tabs a, .withripple");
    }

    var initInputs = function() {
        // Add fake-checkbox to material checkboxes
        $(".checkbox > label > input").not(".bs-material").addClass("bs-material").after("<span class=check></span>");

        // Add fake-radio to material radios
        $(".radio > label > input").not(".bs-material").addClass("bs-material").after("<span class=circle></span><span class=check></span>");

        // Add elements for material inputs
        $("input.form-control, textarea.form-control, select.form-control").not(".bs-material").each( function() {
            if ($(this).is(".bs-material")) { return; }
            $(this).wrap("<div class=form-control-wrapper></div>");
            $(this).after("<span class=material-input></span>");
            if ($(this).hasClass("floating-label")) {
                var placeholder = $(this).attr("placeholder");
                $(this).attr("placeholder", null).removeClass("floating-label");
                $(this).after("<div class=floating-label>" + placeholder + "</div>");
            }
            if ($(this).is(":empty") || $(this).val() === null || $(this).val() == "undefined" || $(this).val() === "") {
                $(this).addClass("empty");
            }

            if ($(this).parent().next().is("[type=file]")) {
                $(this).parent().addClass("fileinput");
                var $input = $(this).parent().next().detach();
                $(this).after($input);
            }
        });

    };
    initInputs();

    // Support for "arrive.js" to dynamically detect creation of elements
    // include it before this script to take advantage of this feature
    // https://github.com/uzairfarooq/arrive/
    if (document.arrive) {
        document.arrive("input, textarea, select", function() {
            initInputs();
        });
    }

    $(document).on("change", ".checkbox input", function() {
        $(this).blur();
    });

    $(document).on("keyup change", ".form-control", function() {
        var self = $(this);
        setTimeout(function() {
            if (self.val() === "") {
                self.addClass("empty");
            } else {
                self.removeClass("empty");
            }
        }, 1);
    });
    $(document)
    .on("focus", ".form-control-wrapper.fileinput", function() {
        $(this).find("input").addClass("focus");
    })
    .on("blur", ".form-control-wrapper.fileinput", function() {
        $(this).find("input").removeClass("focus");
    })
    .on("change", ".form-control-wrapper.fileinput [type=file]", function() {
        var value = "";
        $.each($(this)[0].files, function(i, file) {
            value += file.name + ", ";
        });
        value = value.substring(0, value.length - 2);
        if (value) {
            $(this).prev().removeClass("empty");
        } else {
            $(this).prev().addClass("empty");
        }
        $(this).prev().val(value);
    });
}); 



$(window).load(function() {
    setTimeout(function(){
     $("#loading").fadeOut('slow');
    }, 500);
});

//# sourceMappingURL=main.js.map
