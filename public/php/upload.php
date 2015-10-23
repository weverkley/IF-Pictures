<?php
require_once '../../inc/global.inc.php';;
	if (isset($_FILES['upload'])) {
		$image = new Image();
    	$image->upload($_FILES['upload']);
	}
?>