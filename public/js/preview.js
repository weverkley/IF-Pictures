function new_comment(comment_box_id, return_key_event, user_session_id) {
    if (return_key_event && return_key_event.keyCode == 13) {
        if (!$('#'+comment_box_id.id).val()) {
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
        var new_comment_text = $('#'+comment_box_id.id).val();
        var post_id_of_comment = $('#'+comment_box_id.id).attr('id');
        var post_comment_count = post_id_of_comment + '_comments';
        $.post('public/php/image_comment.php', {
            id: post_id_of_comment,
            comment_text: new_comment_text,
            user_id: user_session_id
        }, function(output) {
            //console.log(output);
            $('#comment-list').prepend(output);
            $('#comment-list').hide().slideDown();
            $('#' + (post_comment_count)).html(parseInt($('#' + (post_comment_count)).html()) + 1);
            $('#' + (comment_box_id.id)).val(null);
        });
    }
};