$(function() {
    $('.editable').inlineEdit({
        save: function(event, hash, widget) {
            widget._debug('save callback', 'value: ' + hash.value + "\n", 'id: ' + this.id);
            var data = new FormData();
            data.append(this.id, hash.value);
            var xhr = new XMLHttpRequest();
            xhr.addEventListener("load", editComplete, false);
            xhr.open("POST", "public/php/editprofile.php");
            xhr.send(data);
        },
        cancel: function(event, hash, widget) {
            widget._debug('cancel callback', 'value: ' + hash.value + "\n", 'id: ' + this.id);
        },
        change: function(event, widget) {
            widget._debug('change callback', 'id: ' + this.id);
        },
        mutate: function(event, widget) {
            widget._debug('mutate callback', 'id: ' + this.id);
        },
        debug: false
    });
});
function editComplete(data) {
    console.log(data.target.responseText);
}
/*$(document).ready(function() {
    //$('[data-toggle="tooltip"]').tooltip(); 
    $('[data-toggle="tooltip"]').mouseenter(function() {
        var that = $(this)
        that.tooltip('show');
        setTimeout(function() {
            that.tooltip('hide');
        }, 2000);
    });
    $('[data-toggle="tooltip"]').mouseleave(function() {
        $(this).tooltip('hide');
    });
});*/

$(document).ready(function() {
    /* Uploading Profile BackGround Image */
    $('body').on('change', '#bgphotoimg', function() {
        $("#bgimageform").ajaxForm({
            target: '#timelineBackground',
            beforeSubmit: function() {},
            success: function() {
                $("#timelineShade").hide();
                $("#bgimageform").hide();
                $("#bgImage").css({'display': 'none'});
            },
            error: function() {}
        }).submit();
    });
    /* Banner position drag */
    $("body").on('mouseover', '.headerimage', function() {
        var y1 = $('#timelineBackground').height();
        var y2 = $('.headerimage').height();
        $(this).draggable({
            scroll: false,
            axis: "y",
            drag: function(event, ui) {
                if (ui.position.top >= 0) {
                    ui.position.top = 0;
                } else if (ui.position.top <= y1 - y2) {
                    ui.position.top = y1 - y2;
                }
            },
            stop: function(event, ui) {}
        });
    });
    /* Bannert Position Save*/
    $("body").on('click', '.bgSave', function() {
        var id = $(this).attr("id");
        var p = $("#timelineBGload").attr("style");
        var Y = p.split("top:");
        var Z = Y[1].split(";");
        var dataString = 'position=' + Z[0];
        $.ajax({
            type: "POST",
            url: "public/php/savecover.php",
            data: dataString,
            cache: false,
            beforeSend: function() {},
            success: function(html) {
                if (html) {
                    $(".bgImage").fadeOut('slow');
                    $(".bgSave").fadeOut('slow');
                    $("#timelineShade").fadeIn("slow");
                    $("#timelineBGload").removeClass("headerimage");
                    $("#timelineBGload").css({
                        'margin-top': html
                    });
                    $("#timelineBGload").css({'position': ''});
                    return false;
                }
            }
        });
        return false;
    });
});

$('#imageProfile').bind('change', function(r) {
    $("#profilemodal").attr( 'src', 'public/img/panel/spinners.gif');
    var data = new FormData();
    data.append('imageProfile', r.target.files[0]);
    var xhr = new XMLHttpRequest();
    xhr.onload = function(e) {
        result = JSON.parse(e.target.responseText);
            $('#resultImageProfile').html(result.text);
            $("#profilepicture").attr( 'src', result.imgURL);
            $("#profilemodal").attr( 'src', result.imgURL);
    };
    xhr.open("POST", "public/php/profileimage.php");
    xhr.send(data);

});