<?php
require_once '../../inc/global.inc.php';
$data = array();
if (isset($_POST) && !empty($_POST['post_text'])) {
    $post = new Posts();
    $data = $post->insertPost($_POST['post_text']);

    $post_comment_count_id =  $data['_id'].'_comment_count';
    $post_comment_count=0;
    $post_self_comment_id= $data['_id'].'_self_comment';
    $post_comment_text_box_id= $data['_id'].'_comment_text_box';
?> 
<div class="panel panel-default" id="<?php echo $data['_id']; ?>">
    <div class="panel-body">
        <p><?php echo $data['text']; ?></p>
        <br>
        <p >
            <span class="fa fa-comment indicator"> Comentários 
            <span id="<?php echo $post_comment_count_id; ?>"><?php echo $post_comment_count;?></span></span>
            <span class="pull-right"><?php echo date('d-m-Y H:i:s', $data['timestamp']->sec) ?></span>    
        </p>
    </div>
    <div class="panel-footer">
        <div class="media" id="<?php echo $post_self_comment_id; ?>">
            <div class="media-footer">
                <hr>
                <a class="pull-left" href="#">
                    <img class="media-object" width="50" src="<?= PUBLIC_DIR.'/img/panel/Android-Messages.png'; ?>" alt="">
                </a>
                <div id="media-body" class="media-body">
                    <textarea class="form-control" placeholder="Escrever um comentário..." id="<?php echo $post_comment_text_box_id; ?>" onKeyPress="return new_comment(this,event,'<?php echo $_SESSION['_id']; ?>')"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>