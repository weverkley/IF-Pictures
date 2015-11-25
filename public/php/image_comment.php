<?php 
require_once '../../inc/global.inc.php';
if (isset($_POST) && !empty($_POST['comment_text'])) {
	$image = new Image();
    $data = $image->insertComment(new MongoId($_POST['id']), $_SESSION['_id'], $_POST['comment_text']);											
?>
<div class="comment" id="<?php echo $data['_id']; ?>">
	<a class="pull-left" href="#">
	    <img width="50px" class="media-object" src="<?php echo $_SESSION['profilepicture']; ?>" alt="profile">
	</a>
	<div class="media-body" style="padding-left: 5px;">
	    <h4 class="media-heading"><?php echo $_SESSION['name']; ?>
	    	<small class="pull-right"><?php echo date('d-m-Y H:i:s', $data['timestamp']->sec); ?></small>
	    </h4>
	    <p><?php echo $data['text']; ?></p>
	</div>
</div>
<?php } ?>