<?php
require_once '../../inc/global.inc.php';
	if (isset($_FILES['upload'])) {
        if ($_FILES['upload'] != 0) {
    		$image = new Image();
        	$file = $image->upload($_FILES['upload']);
        	if (is_array($file)) {
        		//echo $file['hash'];
        		$mongo = new MongoClient();
        		$db = $mongo->ifpi;
        		$feed = $mongo->selectCollection($db, 'feed');
        		$data = array('userid' => $_SESSION['_id'], 'hash' => $file['hash'], 'name' => $file['name'], 'timestamp' => $file['timestamp']);
        		$feed->insert($data);
        	}
        }
	}
?>