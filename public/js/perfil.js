function add(id){
    var data = new FormData();
    data.append('action', 'add');
    data.append('search', id);
    var xhr = new XMLHttpRequest();
    xhr.onload = function(e) {
        console.log(e.target.responseText);
        if (e.target.responseText == 1) {
            $('#add').addClass('disabled').val('Convite Enviado');
        }
    };
    xhr.open("POST", "public/php/friends.php");
    xhr.send(data);
}

function confirm(id){
    var data = new FormData();
    data.append('action', 'confirm');
    data.append('id', id);
    var xhr = new XMLHttpRequest();
    xhr.onload = function(e) {
        console.log(e.target.responseText);
        $('#countRequest').text(parseInt($('#countRequest').text())-1);
        $('#acptreq').text('Amigos ').append('<i class="fa fa-check"></i>');
    };
    xhr.open("POST", "public/php/friends.php");
    xhr.send(data);
}

function decline(id){
    var data = new FormData();
    data.append('action', 'decline');
    data.append('id', id);
    var xhr = new XMLHttpRequest();
    xhr.onload = function(e) {
        console.log(e.target.responseText);
        $('#countRequest').text(parseInt($('#countRequest').text())-1);
    };
    xhr.open("POST", "public/php/friends.php");
    xhr.send(data);
}

function unfriend(id){
    var data = new FormData();
    data.append('action', 'decline');
    data.append('id', id);
    var xhr = new XMLHttpRequest();
    xhr.onload = function(e) {
        console.log(e.target.responseText);
        $('#friends').text('Removido ').append('<i class="fa fa-check"></i>');
    };
    xhr.open("POST", "public/php/friends.php");
    xhr.send(data);
}

function confirmDropdown(id){
    var data = new FormData();
    data.append('action', 'confirm');
    data.append('id', id);
    var xhr = new XMLHttpRequest();
    xhr.onload = function(e) {
        console.log(e.target.responseText);
        if (e.target.responseText == 1) {
            $('#'+id).remove();
            $('#countRequest').text(parseInt($('#countRequest').text())-1);
        }
    };
    xhr.open("POST", "public/php/friends.php");
    xhr.send(data);
}

function declineDropdown(id){
    var data = new FormData();
    data.append('action', 'decline');
    data.append('id', id);
    var xhr = new XMLHttpRequest();
    xhr.onload = function(e) {
        console.log(e.target.responseText);
        if (e.target.responseText == 1) {
            $('#'+id).remove();
            $('#countRequest').text(parseInt($('#countRequest').text())-1);
        }
    };
    xhr.open("POST", "public/php/friends.php");
    xhr.send(data);
}

function new_post(user_session_id) {
    var new_post_text = $('#post_textarea').val();
    if (!$.trim(new_post_text)) {
        $.notify({
           icon: 'fa fa-remove',
           message: 'Você precisa digitar algo antes de criar uma postagem!'
        }, {
           type: 'danger',
           animate:{
               enter: 'animated bounceIn',
               exit: 'animated bounceOut'
           },
           placement:{
               from: "bottom",
               align: "right"
           }
        });
        return;
    } 
    $.post('public/php/insert_new_post.php', {
        user_id: user_session_id,
        post_text: new_post_text
    }, function(output) {   
        $('#post_stream').prepend(output);
        var new_post_id = $("#post_stream div:first-child").attr("id");
        $("#" + new_post_id).hide().slideDown();
        $('#post_textarea').val(null);
    });
}

function new_comment(comment_box_id, return_key_event, user_session_id) {
    if (return_key_event && return_key_event.keyCode == 13) {
        if (!$.trim($('#' + (comment_box_id.id)).val())) {
            $.notify({
               icon: 'fa fa-remove',
               message: 'Você precisa digitar algo antes de criar um comentário!'
            }, {
               type: 'danger',
               animate:{
                   enter: 'animated bounceIn',
                   exit: 'animated bounceOut'
               },
               placement:{
                   from: "bottom",
                   align: "right"
               }
            });
            return;
        }
        var new_comment_text = $('#' + (comment_box_id.id)).val();
        var post_id_of_comment = ((comment_box_id.id).split("_"))[0];
        var post_comment_count = post_id_of_comment + '_comment_count';
        $.post('public/php/new_comment.php', {
            post_id: post_id_of_comment,
            comment_text: new_comment_text,
            user_id: user_session_id
        }, function(output) {
            $('#' + post_id_of_comment + '_self_comment').before(output);
            $('#' + (post_comment_count)).html(parseInt($('#' + (post_comment_count)).html()) + 1);
            $('#' + (comment_box_id.id)).val(null);
        });
    }
};