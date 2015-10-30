<?php
require_once '../../inc/global.inc.php';
if (isset($_GET['page']) && $_GET['page'] != '') {
    $page = $_GET['page'];
    $limit = 12;
    ($page == 0)? $skip = 0 : $skip = ($page - 1) * $limit;
    $data = array();
    $image = new Image();
	$cursor = $image->Gridfind(array('filename' => new MongoRegex('/^thumb_/')))->skip($skip)->limit($limit);
    foreach ($cursor as $obj) {
	   $data[] = $obj->file['_id'];
	}
    echo json_encode($data);
}
?>