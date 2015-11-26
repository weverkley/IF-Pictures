<?php
require_once '../../inc/global.inc.php';
if (isset($_GET['page']) && $_GET['page'] != '') {
    $limit = 12;
    ($_GET['page'] == 0)? $skip = 0 : $skip = ($_GET['page'] - 1) * $limit;
    $data = array();

	$images = new Image();
	$regex = new MongoRegex("/".$_GET['search']."/i");
	$cursor = $images->ImageFind(array('name' => $regex))->skip($skip)->limit($limit);
	$c = 0;
    foreach ($cursor as $obj) {
	   $data[$c]['hash'] = $obj['hash'];
	   $data[$c]['name'] = $obj['name'];
	   $data[$c]['timestamp'] = date('d-m-Y H:i:s', $obj['timestamp']->sec);
	   $c++;
	}
    echo json_encode($data);
}
?>