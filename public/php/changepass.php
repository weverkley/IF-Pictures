<?php
require_once '../../inc/global.inc.php';
$data = 0;
$user = new User();
if ($_POST['opassword'] && $_POST['password'] && $_POST['rpassword']) {
	$where = array('_id' => $_SESSION['_id'], 'password' => md5($_POST['opassword']));
	if(!$user->SelectOne($where)){
		$data = 1; // dados invalidos
	}
}

if ($data == 0) {
	$data = array('$set' => array('password' => md5($_POST['password'])));
	if($user->Update(array('_id' => $_SESSION['_id']), $data)){
		echo 2; //atualizou
	}
} else echo $data;

?>