<?php
require_once '../../inc/global.inc.php';
if (isset($_GET['id']) && $_GET['id'] != '') {

    $data = array();
    $image = new Image();
	$obj = $image->GridfindOne(array('_id' => new MongoId($_GET['id'])));
	echo $obj->file['main'];
}
?>