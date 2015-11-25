<?php
require_once '../../inc/global.inc.php';

if(isset($_POST['position']) && isset($_SESSION['_id'])){
	$user = new User();
	if($user->saveCover($_POST['position'])) echo $_POST['position'];
}
?>