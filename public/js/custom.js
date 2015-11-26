with((window && window.console && window.console._commandLineAPI) || {}) {
        (function() {
            var _z = console;
            Object.defineProperty(window, "console", {
                get: function() {
                    if (_z._commandLineAPI) {
                        throw "Sorry, Can't execute scripts!";
                    }
                    return _z;
                },
                set: function(val) {
                    _z = val;
                }
            });
        })();
    }
    //jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    if (document.getElementById("#nav")) {
        if ($(".navbar").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    }
});
//jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1000, 'easeInOutExpo');
        event.preventDefault();
    });
});
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("active"),
        $("#user-picture").toggleClass('disabled');
});

function logout() {
    $.ajax({
        url: 'public/php/logout.php?action=logout',
        cache: false,
        success: function(data) {
            location.reload();
            //window.location.href = data;
        }
    });
}
//logout usuário
$("#logout").click(function() {
    //alert( "Handler for .click() called." );
    logout();
});

// EDIÇÃO DENTRO DO SOBRE
$(document).ready(function() {
    $(".editlink").on("click", function(e) {
        e.preventDefault();
        var dataset = $(this).prev(".datainfo");
        var savebtn = $(this).next(".savebtn");
        var theid = dataset.attr("id");
        var newid = theid + "-form";
        var currval = dataset.text();
        dataset.empty();
        $('<input type="text" name="' + newid + '" id="' + newid + '" value="' + currval + '" class="input-edit">').appendTo(dataset);
        $(this).css("display", "none");
        savebtn.css("display", "block");
    });
    $(".savebtn").on("click", function(e) {
        e.preventDefault();
        var elink = $(this).prev(".editlink");
        var dataset = elink.prev(".datainfo");
        var newid = dataset.attr("id");
        var cinput = "#" + newid + "-form";
        var einput = $(cinput);
        var newval = einput.attr("value");
        $(this).css("display", "none");
        einput.remove();
        dataset.html(newval);
        elink.css("display", "block");
    });
});

if (localStorage.remember && localStorage.remember != '') {
    $('#login').val(localStorage.login);
    $('#password').val(localStorage.password);
} else {
    $('#login').val('');
    $('#password').val('');
}

$('#checkbox').on('click', function(e){
    if ($("#checkbox").val() == 1){
        $("#checkbox").attr("checked",false);
        $('#checkbox').val(0);
    } else {
        $("#checkbox").attr("checked",true);
        $('#checkbox').val(1);
    }
});

$('#login-btn').on('click', function(e){
    if ($("#checkbox").val() == 1){
        localStorage.login = $('#login').val();
        localStorage.password = $('#password').val();
        localStorage.remember = 'remember';
    }
});