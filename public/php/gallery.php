<?php
require_once '../../inc/global.inc.php';
if (isset($_GET['page']) && $_GET['page'] != '') {
    $limit = 12;
    ($_GET['page'] == 0)? $skip = 0 : $skip = ($_GET['page'] - 1) * $limit;
    $data = array();

	/*$conn = new MongoClient();
	$db = $conn->ifpi;*/
	$images = new Image();
	$cursor = $images->ImageFind()->skip($skip)->limit($limit);
	//$cursor = $image->ImageFind(array('owner' => $_SESSION['_id']))->skip($skip)->limit($limit);
	//var_dump($cursor);
    foreach ($cursor as $obj) {
	   $data[]['hash'] = $obj['hash'];
	   //$data[]['name'] = $obj['name'];
	   //$data[]['link'] = $obj['link'];
	   //$data[]['description'] = $obj['description'];
	}
    echo json_encode($data);
}
?>